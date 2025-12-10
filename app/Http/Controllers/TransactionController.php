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
    // ... method history, show, showCheckoutPage biarkan sama ...
    public function history()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('transactionDetails.product')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('transactions.history', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('transaction_id', $id)
            ->with('transactionDetails.product')
            ->firstOrFail();
        return view('transactions.show', compact('transaction'));
    }

    public function showCheckoutPage()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('products.shop')->with('error', 'Keranjang kosong.');
        }
        $total = $cartItems->sum(function($item) { return $item->product->price * $item->quantity; });
        return view('transactions.checkout', compact('cartItems', 'total'));
    }

    // UPDATE PENTING DI BAWAH INI
    public function processCheckout(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'address'    => 'required|string',
            'phone'      => 'required|numeric',
            'city'       => 'required|string',
            'postal_code'=> 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

            if ($cartItems->isEmpty()) {
                return back()->with('error', 'Keranjang kosong.');
            }

            $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->postal_code;

            // 1. Buat Transaksi
            $transaction = Transaction::create([
                'user_id'          => Auth::id(),
                'status'           => 'pending',
                'total_price'      => 0,
                'receiver_name'    => $request->first_name . ' ' . $request->last_name,
                'receiver_address' => $fullAddress,
                'receiver_phone'   => $request->phone,
                // payment_id otomatis null, aman sesuai migrasi awal
            ]);

            $totalAmount = 0;

            foreach ($cartItems as $item) {
                $currentProduct = Product::where('product_id', $item->product_id)->first();

                if ($item->quantity > $currentProduct->stock) {
                    throw new \Exception("Stok produk {$currentProduct->name} tidak mencukupi (Sisa: {$currentProduct->stock}).");
                }

                $subtotal = $currentProduct->price * $item->quantity;
                $totalAmount += $subtotal;

                // 2. Buat Detail (Perbaikan di transaction_id)
                TransactionDetail::create([
                    'transaction_id' => $transaction->transaction_id,
                    'product_id'     => $item->product_id,
                    'quantity'       => $item->quantity,
                    'price'          => $currentProduct->price,
                ]);

                Product::where('product_id', $item->product_id)
                    ->decrement('stock', $item->quantity);
            }

            $grandTotal = $totalAmount + 15000;
            $transaction->update(['total_price' => $grandTotal]);

            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            // 3. Redirect membawa transaction_id
            return redirect()->route('payment.show', ['id' => $transaction->transaction_id]);

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }

    public function success($id)
    {
        return view('transactions.success');
    }
}
