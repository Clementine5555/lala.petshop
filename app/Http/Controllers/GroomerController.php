<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AppointmentDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Dashboard Groomer
     */
    public function index(Request $request)
    {
        $currentGroomerId = Auth::id();

        // 1. DATA GROOMER (Opsional)
        $query = User::where('role', 'groomer');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('name', 'like', "%{$s}%");
        }
        $groomers = $query->orderBy('name')->paginate(12);

        // 2. LOGIKA DASHBOARD
        $today = Carbon::today()->toDateString();

        $appointmentQuery = AppointmentDetail::with(['user', 'pet', 'groomer', 'service'])
            ->where('groomer_id', $currentGroomerId);

        $appointments = (clone $appointmentQuery)
            ->whereDate('date', $today)
            ->orderBy('time')
            ->get();

        if ($appointments->isEmpty()) {
            $appointments = (clone $appointmentQuery)
                ->whereDate('date', '>=', $today)
                ->whereDate('date', '<=', Carbon::today()->addDays(7)->toDateString())
                ->orderBy('date')
                ->orderBy('time')
                ->get();
        }

        $appointmentsForJs = $appointments->map(function($d) {
            $rawTime = $d->time ?? null;
            $time = '';
            if ($rawTime) {
                $time = date('h:i A', strtotime($rawTime));
            }

            $petWeight = optional($d->pet)->weight;

            return [
                'id' => $d->appointment_detail_id,
                'time' => $time,
                'customer' => optional($d->user)->name ?: 'Guest',
                'payment' => '',
                'petName' => optional($d->pet)->name ?: '-',
                'petType' => optional($d->pet)->type ?: '-',
                'weight' => $petWeight ? ($petWeight . ' kg') : '-',
                'gender' => optional($d->pet)->gender ?: '-',
                'petIcon' => (optional($d->pet)->type && stripos(optional($d->pet)->type, 'dog') !== false) ? '🐕' : '🐱',
                'service' => optional($d->service)->name ?: '-',
                'notes' => $d->note ?: '',
                'status' => $d->status ?: 'pending',
            ];
        });

        $todayCount = $appointments->count();
        $pendingCount = $appointments->where('status', 'pending')->count();
        $inprogressCount = $appointments->where('status', 'inprogress')->count();
        $completedCount = $appointments->where('status', 'completed')->count();

        return view('groomer.index', compact('groomers', 'appointments', 'appointmentsForJs', 'todayCount', 'pendingCount', 'inprogressCount', 'completedCount'));
    }

    /**
     * Menampilkan Detail Groomer (Profile)
     */
    public function show(User $groomer)
    {
        if ($groomer->role !== 'groomer') abort(404);
        return view('groomer.show', compact('groomer'));
    }

    /**
     * [BARU] AJAX Handler untuk Update Status
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,inprogress,completed',
        ]);

        $appointment = AppointmentDetail::find($id);

        if (!$appointment) {
            return response()->json(['success' => false, 'message' => 'Appointment not found'], 404);
        }

        // Update status di database
        $appointment->status = $request->status;

        // Jika status completed, kita update 'updated_at' sebagai penanda waktu selesai
        if ($request->status === 'completed') {
            $appointment->touch();
        }

        $appointment->save();

        return response()->json(['success' => true]);
    }
}
