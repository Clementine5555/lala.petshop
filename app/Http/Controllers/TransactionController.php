<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Ambil transaksi milik user, lengkap dengan detail produk, pembayaran, dan pengiriman
        $transactions = Transaction::with([
            'transactionDetails.product',
            'payment',
            'delivery.courier' // Ambil data kurir juga untuk tombol "Hubungi Kurir"
        ])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Format Data untuk JS (Mirip CourierController tapi disesuaikan untuk User)
        $ordersForJs = $transactions->map(function($t) {

            // Siapkan Item List
            $items = $t->transactionDetails->map(function($detail) {
                return [
                    'name' => $detail->product->name ?? 'Produk',
                    'qty' => $detail->quantity,
                    'price' => $detail->price
                ];
            });

            // Tentukan Status untuk Tampilan
            // Priority: Delivery Status -> Transaction Status
            $status = $t->status; // waiting_confirmation, confirmed, etc.

            // Jika sudah ada pengiriman, pakailah status pengiriman
            if ($t->delivery) {
                if ($t->delivery->status == 'shipped') $status = 'shipped'; // Sedang dikirim
                if ($t->delivery->status == 'delivered') $status = 'delivered'; // Selesai
            }

            // Ambil Info Kurir (jika ada)
            $courierName = '-';
            $courierPhone = '';
            if ($t->delivery && $t->delivery->courier) {
                $courierName = $t->delivery->courier->name;
                $courierPhone = $t->delivery->courier->phone;
            }

            return [
                'id' => 'TRX-' . $t->transaction_id,
                'raw_id' => $t->transaction_id,
                'date' => $t->created_at->format('d M Y, H:i'),
                'total' => $t->total_price,
                'status' => $status,
                'items' => $items,
                'address' => $t->receiver_address,
                'payment_method' => $t->payment ? $t->payment->payment_method : 'Transfer',
                'payment_status' => $t->payment ? $t->payment->status : 'Unpaid',
                'courier_name' => $courierName,
                'courier_phone' => $courierPhone,
                'notes' => $t->delivery ? $t->delivery->description : '-'
            ];
        });

        return view('user.orders', compact('ordersForJs'));
    }

    // (Optional) Fungsi detail, history, dll bisa ditambahkan di sini
    public function history() {
        return redirect()->route('user.orders');
    }

    public function show($id) {
        // Logic show detail jika tidak pakai modal
    }

    public function showCheckoutPage() {
        // Logic checkout (jika sebelumnya ada di controller lain, pindahkan kesini atau biarkan)
        return view('checkout');
    }

    public function processCheckout(Request $request) {
        // Logic proses checkout
    }

    public function success($id) {
        return view('checkout.success', compact('id'));
    }
}
