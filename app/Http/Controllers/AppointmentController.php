<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Appointment_Detail;
use App\Models\Pet;
use App\Models\Service;
use App\Models\Groomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * menampilkan riwayat appointment user
     */
    public function history()
    {
        $appointmentDetails = Appointment_Detail::where('user_id', Auth::id())
                                                 ->with('appointments.service', 'groomer', 'pet')
                                                 ->orderBy('created_at', 'desc')
                                                 ->get();

        return view('appointments.history', compact('appointmentDetails'));
    }

    /**
     *  menampilkan form booking appointment
     */
    public function create(Service $service)
    {
        $pets = Pet::where('user_id', Auth::id())->get();
        $groomers = Groomer::all();

        return view('appointments.create', compact('service', 'pets', 'groomers'));
    }

    /**
     * menyimpan appointment baru
     */
    public function store(Request $request, Service $service)
    {
        $request->validate([
            'pet_id' => 'required|exists:pet,pet_id',
            'groomer_id' => 'required|exists:groomer,groomer_id',
            'appointment_date' => 'required|date|after:today',
            'notes' => 'nullable|string|max:500',
        ]);

        // membuat appointment detail record
        $appointmentDetail = Appointment_Detail::create([
            'user_id' => Auth::id(),
            'groomer_id' => $request->groomer_id,
            'pet_id' => $request->pet_id,
            'status' => 'pending',
            'total_appointments_completed' => 0,
        ]);

        // membuat appointment record
        $appointment = Appointment::create([
            'groomer_id' => $request->groomer_id,
            'appointment_detail_id' => $appointmentDetail->appointment_detail_id,
            'service_id' => $service->service_id,
            'date' => $request->appointment_date,
            'status' => 'pending',
        ]);

        return redirect()->route('appointments.history')
                         ->with('success', 'Appointment booked successfully! We will confirm your booking shortly.');
    }

    /**
     * menampilkan detail appointment
     */
    public function show($id)
    {
        $appointmentDetail = Appointment_Detail::where('user_id', Auth::id())
                                                ->with('appointments.service', 'groomer', 'pet')
                                                ->findOrFail($id);

        return view('appointments.show', compact('appointmentDetail'));
    }

    /**
     * menbatalkan appointment
     */
    public function cancel($id)
    {
        $appointmentDetail = Appointment_Detail::where('user_id', Auth::id())
                                                ->findOrFail($id);

        if ($appointmentDetail->status === 'completed') {
            return redirect()->back()->with('error', 'Cannot cancel a completed appointment.');
        }

        // Update appointment detail status
        $appointmentDetail->update(['status' => 'cancelled']);

        // melakukan update pada appointment 
        Appointment::where('appointment_detail_id', $id)
                   ->update(['status' => 'cancelled']);

        return redirect()->route('appointments.history')
                         ->with('success', 'Appointment cancelled successfully.');
    }
}
