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

    // 2. TAMBAH ITEM KE CART (VERSI FINAL ANTI-DUPLIKAT)
    public function store(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $isAjax = $request->ajax() || $request->wantsJson() || $request->expectsJson();
        $product = Product::findOrFail($request->product_id);

        try {
            // LANGKAH 1: Coba Insert Baru
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->product_id,
                'quantity'   => $request->quantity,
                'status'     => 'active',
            ]);

            $message = 'Produk berhasil ditambahkan!';

        } catch (QueryException $e) {
            // LANGKAH 2: Tangkap Error Duplikat (Data Sudah Ada)
            $errorCode = $e->errorInfo[1] ?? 0;

            if ($errorCode == 1062) {
                // Cari data yang duplikat (termasuk yang di tong sampah)
                $query = Cart::withoutGlobalScopes()
                    ->where('user_id', Auth::id())
                    ->where('product_id', $product->product_id)
                    ->where('status', 'active');

                if (method_exists(new Cart(), 'withTrashed')) {
                    $query->withTrashed();
                }

                $existingCart = $query->first();

                if ($existingCart) {
                    // LOGIKA PERBAIKAN DI SINI:

                    // Cek apakah item ini bekas dihapus (Soft Deleted)?
                    $wasTrashed = method_exists($existingCart, 'trashed') && $existingCart->trashed();

                    if ($wasTrashed) {
                        // KASUS 1: BARANG BEKAS HAPUS
                        // Restore datanya
                        $existingCart->restore();

                        // FIX: JANGAN ditambah dengan quantity lama. Tapi diganti baru.
                        // Karena user menganggap dia baru nambahin barang ini lagi.
                        $newQuantity = $request->quantity;

                        $message = 'Produk ditambahkan kembali ke keranjang!';
                    } else {
                        // KASUS 2: BARANG MASIH ADA DI CART (AKTIF)
                        // Kalau statusnya aktif, berarti user mau nambah jumlahnya
                        $newQuantity = $existingCart->quantity + $request->quantity;

                        $message = 'Jumlah produk diperbarui!';
                    }

                    // Cek Stok
                    if ($newQuantity > $product->stock) {
                        $msg = "Stok penuh! Total permintaan melebihi stok tersedia ({$product->stock}).";
                        if ($isAjax) return response()->json(['success' => false, 'message' => $msg], 400);
                        return back()->with('error', $msg);
                    }

                    // Simpan
                    $existingCart->quantity = $newQuantity;
                    $existingCart->save();

                } else {
                    return back()->with('error', 'Terjadi kesalahan sinkronisasi data.');
                }
            } else {
                throw $e;
            }
        }

        // Response
        $cartCount = Cart::where('user_id', Auth::id())
            ->where('status', 'active')
            ->sum('quantity');

        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => $message ?? 'Berhasil',
                'cart_count' => $cartCount
            ]);
        }

        return back()->with('success', $message ?? 'Berhasil');
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
    public function count() {
        if (auth()->check()) {
            $count = Cart::where('user_id', auth()->id())->sum('quantity');
            return response()->json(['count' => $count]);
        }
        return response()->json(['count' => 0]);
    }
}
