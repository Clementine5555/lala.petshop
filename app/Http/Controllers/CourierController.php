<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // <--- PENTING: Tambahkan ini
use Carbon\Carbon;

class CourierController extends Controller
{
    public function index()
    {
        $courierId = Auth::id();

        $deliveries = Delivery::with(['transaction.user', 'transaction.transactionDetails.product', 'transaction.payment'])
            ->where(function($query) use ($courierId) {
                // Tampilkan yang statusnya 'pending' (belum ada kurir)
                $query->where('status', 'pending')
                    // ATAU yang statusnya sedang dikirim oleh kurir yang login ini
                    ->orWhere(function($q) use ($courierId) {
                        $q->where('courier_id', $courierId)
                            ->whereIn('status', ['shipped', 'delivered']);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $ordersForJs = $deliveries->map(function($d) {
            $t = $d->transaction;
            $items = [];
            if($t && $t->transactionDetails) {
                foreach($t->transactionDetails as $detail) {
                    $items[] = [
                        'name' => $detail->product->name ?? 'Produk',
                        'qty' => $detail->quantity,
                        'price' => $detail->price
                    ];
                }
            }

            $statusFrontend = 'pending';
            if ($d->status == 'pending') $statusFrontend = 'pending';
            if ($d->status == 'shipped') $statusFrontend = 'delivering';
            if ($d->status == 'delivered') $statusFrontend = 'delivered';

            return [
                'id' => $d->delivery_id,
                'order_id_display' => 'TRX-' . $t->transaction_id,
                'customer' => $t->receiver_name ?? $t->user->name ?? 'Guest',
                'phone' => $t->receiver_phone ?? $t->user->phone ?? '-',
                'address' => $d->address ?? $t->receiver_address,
                'area' => 'Medan',
                'items' => $items,
                'total' => $t->total_price,
                'status' => $statusFrontend,
                'date' => $d->created_at->format('d M Y, H:i'),
                'notes' => $d->description,
                'paymentMethod' => $t->payment ? $t->payment->payment_method : 'Transfer',
                'paymentStatus' => 'Lunas',
                'completedAt' => $d->status == 'delivered' ? $d->updated_at->format('H:i') : null,
            ];
        });

        return view('kurir.index', compact('ordersForJs'));
    }

    // Fungsi AJAX untuk Update Status (FIXED FK Constraint)
    public function updateStatus(Request $request, $id)
    {
        // Matikan Pengecekan Foreign Key Sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            $delivery = Delivery::find($id);
            if (!$delivery) {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Nyalakan lagi sebelum return
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
            }

            $action = $request->status;

            // 1. LOGIKA PICKUP
            if ($action == 'pickup') {
                $delivery->courier_id = Auth::id();
                $delivery->status = 'shipped';
                $delivery->description = "Paket sedang diantar oleh " . Auth::user()->name;
            }
            // 2. LOGIKA DELIVERING
            elseif ($action == 'delivering') {
                $delivery->status = 'shipped';
            }
            // 3. LOGIKA DELIVERED
            elseif ($action == 'delivered') {
                $delivery->status = 'delivered';
                $delivery->description = $request->note ?? 'Paket diterima.';
                $delivery->touch();

                if($delivery->transaction) {
                    $delivery->transaction->update(['status' => 'delivered']);
                }
            }

            $delivery->save();

            // Nyalakan kembali Pengecekan Foreign Key
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Pastikan FK Check nyala lagi walau error
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
