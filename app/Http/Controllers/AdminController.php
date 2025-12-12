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
use Barryvdh\DomPDF\Facade\Pdf; // Pastikan baris ini ada

class AdminController extends Controller
{
    // =================================================================
    // 1. DASHBOARD UTAMA
    // =================================================================
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        $totalOrders = Transaction::count();
        $totalRevenue = Transaction::whereNotIn('status', ['pending', 'cancelled'])->sum('total_price');

        return view('admin.dashboard', compact('totalUsers', 'totalProducts', 'totalOrders', 'totalRevenue'));
    }

    // =================================================================
    // 2. MANAJEMEN ORDER / TRANSAKSI
    // =================================================================
    public function orders()
    {
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
            $transaction->update(['status' => 'confirmed']);

            Delivery::create([
                'transaction_id' => $transaction->transaction_id,
                'status' => 'pending',
                'address' => $transaction->receiver_address ?? 'Alamat tidak tersedia',
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pesanan disetujui & diteruskan ke Kurir.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // =================================================================
    // 3. MANAJEMEN APPOINTMENT
    // =================================================================
    public function appointments()
    {
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
        $appointment->status = $request->status;

        if ($request->filled('notes')) {
            $appointment->notes = $request->notes;
        }

        if ($request->status == 'completed') {
            $appointment->completed_at = now();
        }

        $appointment->save();

        if ($appointment->detail) {
            $appointment->detail->update(['status' => $request->status]);
        }

        return redirect()->back()->with('success', 'Status appointment berhasil diperbarui.');
    }

    // =================================================================
    // 4. MANAJEMEN PESAN (CONTACT US)
    // =================================================================
    public function messages()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.messages.index', compact('messages'));
    }

    public function deleteMessage($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();
        return redirect()->back()->with('success', 'Pesan berhasil dihapus.');
    }

    // =================================================================
    // 5. LAPORAN PENDAPATAN (REPORT & PDF)
    // =================================================================
    public function reports(Request $request)
    {
        // PERBAIKAN: Tambahkan (int) agar tidak error di Carbon
        $month = (int) $request->input('month', date('m'));
        $year = (int) $request->input('year', date('Y'));

        $transactions = Transaction::with(['transactionDetails', 'user'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', ['confirmed', 'shipped', 'delivered', 'completed'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalRevenue = $transactions->sum('total_price');

        return view('admin.reports.index', compact('transactions', 'totalRevenue', 'month', 'year'));
    }

    public function exportPdf(Request $request)
    {
        // PERBAIKAN: Tambahkan (int) di sini juga
        $month = (int) $request->input('month', date('m'));
        $year = (int) $request->input('year', date('Y'));

        $transactions = Transaction::with(['transactionDetails', 'user'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereIn('status', ['confirmed', 'shipped', 'delivered', 'completed'])
            ->orderBy('created_at', 'asc')
            ->get();

        $totalRevenue = $transactions->sum('total_price');

        // Carbon butuh integer, bukan string
        $monthName = \Carbon\Carbon::create()->month($month)->format('F');

        $pdf = Pdf::loadView('admin.reports.pdf', compact('transactions', 'totalRevenue', 'monthName', 'year'));

        return $pdf->download('Laporan-Bulanan-Petshop-'.$monthName.'-'.$year.'.pdf');
    }
}
