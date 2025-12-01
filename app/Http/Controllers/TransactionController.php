<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Transaction_Detail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // CHECKOUT PROSES

    public function checkout(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,product_id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // menghitung total harga
        $total = 0;
        foreach ($request->products as $item) {
            $product = Product::find($item['id']);
            $total += $product->price * $item['quantity'];
        }

        // menyimpan transaksi utama
        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'total_price' => $total,
            'status' => 'pending',
        ]);

        // menyimpan item transaksi 
        foreach ($request->products as $item) {
            $product = Product::find($item['id']);

            Transaction_Detail::create([
                'transaction_id' => $transaction->transaction_id,
                'product_id' => $product->product_id,
                'quantity' => $item['quantity'],
                'price_at_purchase' => $product->price,
            ]);
        }
        return redirect()->route('transactions.history')
                         ->with('success', 'Checkout berhasil!');
    }


    // RIWAYAT TRANSAKSI USER

    public function history()
    {
        $transactions = Transaction::where('user_id', Auth::id())
                                   ->with('transactionDetails.product')
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        return view('transactions.history', compact('transactions'));
    }

    // DETAIL TRANSAKSI
    public function show($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())
                                    ->with('transactionDetails.product')
                                    ->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }
}
