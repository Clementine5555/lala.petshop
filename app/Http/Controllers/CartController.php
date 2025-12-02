<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 1. TAMPILKAN CART USER
    public function index() {
        $cartItems = Cart::where('user_id', auth()->id())
                         ->with('product')
                         ->get();
        
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    // 2. TAMBAH ITEM KE CART
    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Validasi Stok
        if ($request->quantity > $product->stock) {
            return response()->json([
                'success' => false,
                'message' => "Jumlah melebihi stok ({$product->stock})!"
            ], 400);
        }

        // Cek barang di cart
        $cartItem = Cart::where('user_id', auth()->id())
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;

            // Validasi Stok lagi buat update
            if ($newQty > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => "Total di keranjang melebihi stok ({$product->stock})!"
                ], 400);
            }

            $cartItem->update(['quantity' => $newQty]);
        } 
        else {
            Cart::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->product_id,
                'quantity'   => $request->quantity,
                'status'     => 'active',
            ]);
        }

        // Ambil jumlah terbaru buat update badge
        $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart_count' => $cartCount // Ini dipake sama JS buat update badge real-time
        ]);
    }

    // 3. UPDATE JUMLAH (Saat di halaman Cart)
    public function update(Request $request, $id) {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('user_id', auth()->id())
                        ->where('cart_id', $id)
                        ->firstOrFail();

        $product = Product::findOrFail($cartItem->product_id);

        if ($request->quantity > $product->stock) {
            return back()->with('error', "Stok produk '{$product->name}' hanya {$product->stock}!");
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah produk diperbaharui!');
    }

    // 4. HAPUS ITEM
    public function destroy($id) {
        $cartItem = Cart::where('user_id', auth()->id())
                        ->where('cart_id', $id)
                        ->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Produk telah dihapus dari keranjang!');
    }

    // 5. HITUNG BADGE CART (API)
    // Ini dipanggil sama Javascript "updateCartCount()" di footer/navbar
    public function count() {
        if (auth()->check()) {
            $count = Cart::where('user_id', auth()->id())->sum('quantity');
            return response()->json(['count' => $count]);
        }
        return response()->json(['count' => 0]);
    }
}