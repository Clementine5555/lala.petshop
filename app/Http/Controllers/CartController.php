<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // menampilkan semua item di keranjang belanja user
    public function index() {
        $cartItems = Cart::where('user_id', auth()->id())
                            ->with('product')
                            ->get();
        
        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    // menambahkan item ke keranjang belanja
    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity' => 'required|integer|min:1',
        ]);

        // cek apakah item sudah ada di keranjang
        $cartItem = Cart::where('user_id', auth()->id())
                        ->where('product_id', $request->product_id)
                        ->first();
        
        if ($cartItem) {
            // update jumlah jika sudah ada
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        }
        else {
            // menambahkan item baru
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke dalam keranjang!');
    }

    // update jumlah item di keranjang belanja
    public function update(Request $request, $id) {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = Cart::where('user_id', auth()->id())->where('cart_id', $id)->firstOrFail();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Jumlah produk diperbaharui!');
    }

    // hapus item dari keranjang belanja
    public function destroy($id) {
        $cartItem = Cart::where('user_id', auth()->id())->where('cart_id', $id)->firstOrFail();
        $cartItem->delete();

        return redirect()->back()->with('success', 'Produk telah dihapus dari keranjang!');
    }
}
