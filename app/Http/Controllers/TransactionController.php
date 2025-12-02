<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // 1. HALAMAN HISTORY TRANSAKSI
    public function history()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('transactionDetails.product')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transactions.history', compact('transactions'));
    }

    // 2. DETAIL TRANSAKSI
    public function show($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('transaction_id', $id) // Pastikan nama kolom primary key di tabel transaction benar
            ->with('transactionDetails.product')
            ->firstOrFail();
            
        return view('transactions.show', compact('transaction'));
    }

    // 3. HALAMAN CHECKOUT (Form)
    public function showCheckoutPage()
    {       
        $cartItems = Cart::where('user_id', Auth::id())
                        ->with('product')
                        ->get();
        
        // Cek kalau kosong
        if ($cartItems->isEmpty()) {
            return redirect()->route('products.shop')
                ->with('error', 'Keranjang belanja kosong, silakan belanja dulu.');
        }

        // Hitung total bayar
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });
        
        return view('transactions.checkout', compact('cartItems', 'total')); 
    }

    // 4. PROSES CHECKOUT (Simpan ke DB)
    public function processCheckout(Request $request)
    {
        // Validasi Input User
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'address'    => 'required|string',
            'phone'      => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // 1. Ambil Data Cart dari DATABASE
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Keranjang kosong.');
            }

            // 2. Buat Record Transaksi Utama
            $transaction = Transaction::create([
                'user_id'          => Auth::id(),
                'transaction_date' => now(),
                'status'           => 'pending',
                'total_amount'     => 0, 
                'receiver_name'    => $request->first_name . ' ' . $request->last_name,
                'receiver_address' => $request->address,
                'receiver_phone'   => $request->phone,
            ]);

            $totalAmount = 0;

            // 3. Pindahkan Item Cart ke Transaction Detail
            foreach ($cartItems as $item) {
                // Cek stok lagi biar aman
                if ($item->quantity > $item->product->stock) {
                    throw new \Exception("Stok produk {$item->product->name} tidak mencukupi.");
                }

                $subtotal = $item->product->price * $item->quantity;
                $totalAmount += $subtotal;

                TransactionDetail::create([
                    'transaction_id' => $transaction->transaction_id, // Sesuaikan primary key
                    'product_id'     => $item->product_id,
                    'quantity'       => $item->quantity,
                    'price'          => $item->product->price, // Simpan harga saat transaksi terjadi
                ]);
                
                $item->product->decrement('stock', $item->quantity);
            }

            // Update Total Harga di Tabel Transaksi
            $transaction->update(['total_amount' => $totalAmount]);

            // 4. Hapus Keranjang Belanja User (Database)
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            // Redirect ke halaman detail transaksi atau history
            return redirect()->route('transactions.history')
                ->with('success', 'Checkout berhasil! Pesanan sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }
}
