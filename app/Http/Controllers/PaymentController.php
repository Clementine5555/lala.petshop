<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function show($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('transaction_id', $id)
            ->firstOrFail();

        if ($transaction->status !== 'pending') {
            return redirect()->route('checkout.success', ['id' => $transaction->transaction_id]);
        }

        return view('transactions.payment', compact('transaction'));
    }

    public function process(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,bank_transfer,e_wallet',
            // Jika BUKAN cash, maka WAJIB upload gambar
            'proof_of_payment' => 'required_unless:payment_method,cash|image|max:2048',
        ]);

        $transaction = Transaction::where('user_id', Auth::id())
            ->where('transaction_id', $id)
            ->firstOrFail();

        $dataToUpdate = [
            'status' => 'waiting_confirmation',
            'payment_method' => $request->payment_method,
        ];

        // Proses Upload Gambar
        if ($request->hasFile('proof_of_payment')) {
            // Simpan ke folder: storage/app/public/payments
            $path = $request->file('proof_of_payment')->store('payments', 'public');
            $dataToUpdate['proof_of_payment'] = $path;
        }

        $transaction->update($dataToUpdate);

        return redirect()->route('checkout.success', ['id' => $transaction->transaction_id]);
    }
}
