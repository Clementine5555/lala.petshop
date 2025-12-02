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
    // ... (keep create method as is) ...
    public function create(Request $request)
    {
        // ... (your existing create logic) ...
        $serviceId = $request->query('service_id');
        $selectedService = null;
        if($serviceId) {
            $selectedService = Service::find($serviceId);
        }
        $pets = Pet::where('user_id', Auth::id())->get();
        $groomers = Groomer::all();
        $services = Service::all(); 
        return view('appointment.create', compact('selectedService', 'services', 'pets', 'groomers'));
    }

    public function store(Request $request)
    {
        // 1. Validate
        $request->validate([
            'service_id' => 'required|exists:services,service_id', 
            'pet_id' => 'required|exists:pet,pet_id',
            'groomer_id' => 'required|exists:groomer,groomer_id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'payment_method' => 'required',
        ]);

        // 2. Create Detail
        $detail = Appointment_Detail::create([
            'user_id' => Auth::id(),
            'groomer_id' => $request->groomer_id,
            'pet_id' => $request->pet_id,
            'status' => 'pending',
            'total_appointments_completed' => 0,
        ]);

        // 3. Create Appointment
        $datetime = $request->appointment_date . ' ' . $request->appointment_time;
        
        Appointment::create([
            'groomer_id' => $request->groomer_id,
            'appointment_detail_id' => $detail->appointment_detail_id,
            'service_id' => $request->service_id,
            'date' => $datetime,
            'status' => 'pending',
        ]);

        // 4. Prepare Data for Confirmation Page
        $service = Service::find($request->service_id);
        $pet = Pet::find($request->pet_id);

        $appointmentData = [
            'pet_name' => $pet->pet_name,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'services' => $service->service_name,
            'total_price' => $service->price
        ];

        // 5. Redirect to Confirmation Page with Data
        return redirect()->back()->with('success', 'Booking berhasil! Mohon tunggu konfirmasi admin.');
    }

    public function confirmation()
    {
        if (!session()->has('appointment')) {
            return redirect()->route('dashboard'); // Prevent accessing directly without booking
        }
        return view('appointment.confirmation');
    }

    public function history()
    {
        // ...
         $appointmentDetails = Appointment_Detail::where('user_id', Auth::id())
            ->with(['appointments.service', 'groomer', 'pet'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('appointments.history', compact('appointmentDetails'));
    }
}