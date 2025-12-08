<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

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

    $isAjax = $request->ajax() || $request->wantsJson() || $request->expectsJson();

    $product = Product::findOrFail($request->product_id);

    // Validasi stok
    if ($request->quantity > $product->stock) {
        if ($isAjax) {
            return response()->json([
                'success' => false,
                'message' => "Jumlah melebihi stok ({$product->stock})!"
            ], 400);
        }

        return back()->with('error', "Jumlah melebihi stok ({$product->stock})!");
    }

    // Use transaction to avoid race condition when two requests try to insert same cart concurrently
    try {
        DB::transaction(function () use ($request, $product) {
            $cartItem = Cart::where('user_id', auth()->id())
                        ->where('product_id', $request->product_id)
                        ->where('status', 'active')
                        ->lockForUpdate()
                        ->first();

            if ($cartItem) {
                $newQty = $cartItem->quantity + $request->quantity;

                if ($newQty > $product->stock) {
                    throw new \Exception("Total in cart exceeds available stock ({$product->stock})");
                }

                $cartItem->update(['quantity' => $newQty]);
            } else {
                Cart::create([
                    'user_id'    => auth()->id(),
                    'product_id' => $product->product_id,
                    'quantity'   => $request->quantity,
                    'status'     => 'active',
                ]);
            }
        });
    } catch (QueryException $e) {
        // Handle duplicate unique key (race) by finding existing row and updating quantity
        if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
            $cartItem = Cart::where('user_id', auth()->id())
                            ->where('product_id', $request->product_id)
                            ->where('status', 'active')
                            ->first();

            if ($cartItem) {
                $newQty = $cartItem->quantity + $request->quantity;
                if ($newQty > $product->stock) {
                    if ($isAjax) {
                        return response()->json([
                            'success' => false,
                            'message' => "Total di keranjang melebihi stok ({$product->stock})!"
                        ], 400);
                    }

                    return back()->with('error', "Total di keranjang melebihi stok ({$product->stock})!");
                }
                $cartItem->update(['quantity' => $newQty]);
            }
        } else {
            throw $e; // rethrow other DB exceptions
        }
    } catch (\Exception $e) {
        if ($isAjax) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }

        return back()->with('error', $e->getMessage());
    }

    $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');

    if ($isAjax) {
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang!',
            'cart_count' => $cartCount
        ]);
    }

    return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
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