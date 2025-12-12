<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Delivery;
use App\Models\Appointment;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // =================================================================
    // 1. DASHBOARD UTAMA
    // =================================================================
    public function index()
    {
        // Hitung Statistik
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        $totalOrders = Transaction::count();

        // Hitung Pendapatan (Hanya yang statusnya sukses/proses)
        $totalRevenue = Transaction::whereNotIn('status', ['pending', 'cancelled'])
            ->sum('total_price');

        return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalOrders', 'totalRevenue'));
    }

    // =================================================================
    // 2. MANAJEMEN ORDER / TRANSAKSI
    // =================================================================
    public function orders()
    {
        // Ambil transaksi yang statusnya 'waiting_confirmation'
        $orders = Transaction::with(['user', 'payment', 'transactionDetails'])
            ->where('status', 'waiting_confirmation')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function approveOrder($id)
    {
        DB::beginTransaction();
        try {
            $transaction = Transaction::findOrFail($id);

            // 1. Ubah status Transaksi jadi 'confirmed'
            $transaction->update(['status' => 'confirmed']);

            // 2. Buat data PENGIRIMAN (Delivery) agar muncul di Dashboard Kurir
            Delivery::create([
                'transaction_id' => $transaction->transaction_id,
                'status' => 'pending', // Status awal pengiriman
                'address' => $transaction->receiver_address ?? 'Alamat tidak tersedia',
                // courier_id biarkan NULL dulu, nanti kurir yang "Ambil Pesanan"
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan disetujui & diteruskan ke Kurir.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // =================================================================
    // 3. MANAJEMEN APPOINTMENT (BARU)
    // =================================================================
    public function appointments()
    {
        // Ambil data appointment beserta detail tanggal & groomer
        // Diurutkan dari yang terbaru
        $appointments = Appointment::with(['detail', 'detail.groomer'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.appointments.index', compact('appointments'));
    }

    public function updateAppointmentStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string'
        ]);

        $appointment = Appointment::findOrFail($id);

        // Update Status Utama
        $appointment->status = $request->status;

        // Jika ada catatan tambahan, update
        if ($request->filled('notes')) {
            $appointment->notes = $request->notes;
        }

        // Logika tambahan: Jika status completed, isi timestamp
        if ($request->status == 'completed') {
            $appointment->completed_at = now();
        }

        $appointment->save();

        // Update juga status di tabel Detail agar sinkron
        if ($appointment->detail) {
            $appointment->detail->update(['status' => $request->status]);
        }

        return redirect()->back()->with('success', 'Status appointment berhasil diperbarui.');
    }

    public function messages()
    {
        // Get messages ordered by newest first
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.messages.index', compact('messages'));
    }

    public function deleteMessage($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }
}
