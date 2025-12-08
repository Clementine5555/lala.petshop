<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Appointment_Detail;
use App\Models\Pet;
use App\Models\Service;
use App\Models\Groomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'pet_id' => 'nullable', // we'll handle 'new' and existence checks below
            'pet_name' => 'nullable|string|max:150',
            'pet_type' => 'nullable|string',
            'pet_breed' => 'nullable|string',
            'pet_age_years' => 'nullable|integer|min:0',
            'pet_age_months' => 'nullable|integer|min:0|max:11',
            'pet_weight' => 'nullable|numeric',
            'pet_gender' => 'nullable|in:male,female',
            'groomer_id' => 'required|exists:groomers,groomer_id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'payment_method' => 'required',
        ]);

        // Normalize pet_id: treat 'new' as null and ensure existing pet_id exists
        $petIdRaw = $request->input('pet_id');
        if ($petIdRaw === 'new' || $petIdRaw === '') {
            $petId = null;
        } else {
            $petId = $petIdRaw;
        }

        // If creating a new pet, ensure pet_name is provided and is a string
        if (empty($petId)) {
            $petName = $request->input('pet_name');
            if (!is_string($petName) || trim($petName) === '') {
                return back()->withErrors(['pet_name' => 'Please enter a valid pet name when adding a new pet.'])->withInput();
            }
        } else {
            // if petId provided, ensure it exists in DB
            if (!is_null($petId) && !ctype_digit((string)$petId)) {
                // not a numeric id, reject
                return back()->withErrors(['pet_id' => 'Invalid pet selection.'])->withInput();
            }
            if (!is_null($petId) && !\App\Models\Pet::where('pet_id', $petId)->exists()) {
                return back()->withErrors(['pet_id' => 'Selected pet does not exist.'])->withInput();
            }
        }

        // If pet_id not provided, create a new Pet from provided pet_* fields
        $petId = $request->input('pet_id');
        if (empty($petId)) {
            $petData = [
                'user_id' => Auth::id(),
                'name' => $request->input('pet_name'),
                'type' => $request->input('pet_type') ?? null,
                'race' => $request->input('pet_breed') ?? null,
                'age' => $request->input('pet_age_years') ? intval($request->input('pet_age_years')) : null,
                'weight' => $request->input('pet_weight') ? floatval($request->input('pet_weight')) : null,
                'gender' => $request->input('pet_gender') ?? null,
            ];

            $pet = Pet::create($petData);
            $petId = $pet->pet_id;
        }

        // 2. Create Appointment first (so appointment_id exists for the detail)
        $datetime = $request->appointment_date . ' ' . $request->appointment_time;

        // Create a Payment record first because `appointments.payment_id` is NOT NULL
        $paymentData = [
            'method' => $request->payment_method ?? 'cash',
            'status' => 'pending',
            // `evidence` may be NOT NULL depending on migrations; provide an empty string when not uploading
            'evidence' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $paymentId = DB::table('payments')->insertGetId($paymentData);

        $appointmentId = DB::table('appointments')->insertGetId([
            'payment_id' => $paymentId,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Create Appointment Detail with appointment_id and include service/date/time
        $detail = Appointment_Detail::create([
            'appointment_id' => $appointmentId,
            'service_id' => $request->service_id,
            'user_id' => Auth::id(),
            'groomer_id' => $request->groomer_id,
            'pet_id' => $petId,
            'date' => $request->appointment_date,
            'time' => $request->appointment_time,
            'note' => $request->notes ?? $request->input('notes'),
            'status' => 'pending',
            'total_appointments_completed' => 0,
        ]);

        // 4. Prepare Data for Confirmation Page
        $service = Service::find($request->service_id);
        $pet = Pet::find($petId);

        $appointmentData = [
            'pet_name' => $pet->name ?? ($pet->pet_name ?? '-'),
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'services' => $service->service_name ?? ($service->name ?? '-'),
            'total_price' => $service->price ?? 0
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