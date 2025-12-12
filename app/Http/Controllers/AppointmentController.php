<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\AppointmentDetail;
use App\Models\Service;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * [PENTING] Fungsi ini yang hilang sebelumnya.
     * Menampilkan Form Booking.
     */
    public function create()
    {
        // 1. Ambil Services
        $services = Service::all();

        // 2. Ambil Hewan milik User yang sedang login
        $pets = Pet::where('user_id', Auth::user()->user_id)->get();

        // 3. Ambil Groomer dari tabel USERS
        $groomers = User::where('role', 'groomer')->get();

        return view('appointment.create', compact('services', 'pets', 'groomers'));
    }

    /**
     * Proses Simpan Data Booking (Versi Fix Database Sederhana)
     */
    public function store(Request $request)
    {
        // 1. VALIDASI
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'pet_id' => 'required',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'service_id' => 'required|exists:services,service_id',
            'groomer_id' => 'required|exists:users,user_id',
            'payment_method' => 'required',
            'pet_name' => 'required_if:pet_id,new',
            'pet_type' => 'required_if:pet_id,new',
            'pet_weight' => 'required_if:pet_id,new',
            'pet_gender' => 'required_if:pet_id,new',
            'pet_breed' => 'required_if:pet_id,new',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Matikan FK Check sementara (Agar aman simpan ID User sebagai groomer & Payment ID 0)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::beginTransaction();

        try {
            // 2. HANDLE PET
            if ($request->pet_id === 'new') {
                $ageInMonths = ($request->pet_age_years * 12) + $request->pet_age_months;
                $pet = Pet::create([
                    'user_id' => Auth::user()->user_id,
                    'name' => $request->pet_name,
                    'type' => $request->pet_type,
                    'breed' => $request->pet_breed,
                    'gender' => $request->pet_gender,
                    'weight' => $request->pet_weight,
                    'age' => $ageInMonths,
                ]);
                $petId = $pet->pet_id;
            } else {
                $pet = Pet::findOrFail($request->pet_id);
                $petId = $pet->pet_id;
            }

            $service = Service::findOrFail($request->service_id);

            // 3. BUAT APPOINTMENT DETAIL (Simpan detail teknis di sini)
            $detail = AppointmentDetail::create([
                'appointment_id' => null,
                'service_id' => $service->service_id,
                'user_id' => Auth::user()->user_id,
                'groomer_id' => $request->groomer_id,
                'pet_id' => $petId,
                'date' => $request->appointment_date,
                'time' => $request->appointment_time,
                'note' => $request->notes,
                'status' => 'pending',
                'total_appointments_completed' => 0
            ]);

            // 4. BUAT APPOINTMENT UTAMA (Simpan Snapshot Data)
            $appointment = Appointment::create([
                'payment_id' => 0, // Isi 0 karena struktur DB mengharuskan isi
                'status' => 'pending',
                'customer_name' => Auth::user()->name,
                'pet_name' => $pet->name,
                'pet_type' => $pet->type,
                'pet_gender' => $pet->gender,
                'pet_weight' => $pet->weight,
                'service_type' => $service->service_name,
                'notes' => $request->notes,
                'duration' => $service->duration ?? '60 min',
                // HAPUS kolom yang tidak ada di tabel appointments (groomer_id, dll)
            ]);

            // 5. UPDATE RELASI BALIK
            $detail->update(['appointment_id' => $appointment->appointment_id]);

            DB::commit();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Nyalakan lagi cek FK

            return redirect()->route('appointment.index')->with('appointment', [
                'pet_name' => $pet->name,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'services' => $service->service_name,
                'total_price' => $service->price
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            // Jika masih error, tampilkan detailnya
            dd("GAGAL MENYIMPAN: " . $e->getMessage());
        }
    }

    /**
     * Halaman Sukses
     */
    public function index()
    {
        return view('appointment.index');
    }

    public function myAppointments()
    {
        $userId = \Illuminate\Support\Facades\Auth::id();

        // PERBAIKAN: Gunakan Nested Eager Loading (detail.service, detail.groomer)
        // Artinya: Ambil Appointment -> Ambil Detail-nya -> Dari Detail, ambil Service & Groomer
        $appointments = \App\Models\Appointment::with(['detail.service', 'detail.groomer'])
            ->whereHas('detail', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $appointmentsForJs = $appointments->map(function($apt) {
            // Kita ambil objek detail dulu biar kodenya rapi
            $detail = $apt->detail;

            return [
                'id' => 'APT-' . $apt->appointment_id,
                'raw_id' => $apt->appointment_id,

                // Ambil tanggal dari detail
                'date' => $detail && $detail->date ? \Carbon\Carbon::parse($detail->date)->format('d M Y') : $apt->created_at->format('d M Y'),
                'time' => $detail->time ?? '-',

                // Data Snapshot (Teks langsung dari tabel appointments)
                'pet_name' => $apt->pet_name,
                'pet_type' => $apt->pet_type,

                // Ambil Nama Service dari Relasi (lewat detail)
                // Jika relasi null, ambil dari snapshot 'service_type'
                'service' => ($detail && $detail->service) ? $detail->service->service_name : $apt->service_type,

                // Ambil Nama Groomer dari Relasi (lewat detail)
                'groomer' => ($detail && $detail->groomer) ? $detail->groomer->name : 'Menunggu Konfirmasi',

                'status' => $apt->status,
                'notes' => $apt->notes,

                // Ambil Harga dari Relasi Service (lewat detail)
                'price' => ($detail && $detail->service) ? $detail->service->price : 0,
            ];
        });

        return view('user.appointments', compact('appointmentsForJs'));
    }
}
