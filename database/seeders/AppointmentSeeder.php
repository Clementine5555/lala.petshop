<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil ID salah satu Groomer yang sudah dibuat tadi
        // Biar datanya terhubung (Relasi Foreign Key aman)
        $groomer = DB::table('groomers')->first();
        $groomerId = $groomer ? $groomer->groomer_id : null;

        // Data 1: Status PENDING (Pagi ini)
        Appointment::create([
            'groomer_id' => $groomerId,
            'appointment_date' => Carbon::today()->setHour(9)->setMinute(0),
            'status' => 'pending',

            // Detail Grooming
            'customer_name' => 'Rizky Pengunjung',
            'pet_name' => 'Molly',
            'pet_type' => 'Golden Retriever',
            'pet_gender' => 'Male',
            'pet_weight' => '15 kg',
            'service_type' => 'Full Grooming',
            'notes' => 'Tolong hati-hati di bagian telinga',

            // Kolom ID lain (set null dulu biar gak error jika tabel lain kosong)
            'payment_id' => null,
            'service_id' => null,
            'appointment_detail_id' => null,
        ]);

        // Data 2: Status IN PROGRESS (Sedang dikerjakan)
        Appointment::create([
            'groomer_id' => $groomerId,
            'appointment_date' => Carbon::today()->setHour(10)->setMinute(30),
            'status' => 'inprogress',

            'customer_name' => 'Siti Aminah',
            'pet_name' => 'Oyen',
            'pet_type' => 'Cat Persian',
            'pet_gender' => 'Female',
            'pet_weight' => '4 kg',
            'service_type' => 'Bath Only',
            'notes' => 'Kucingnya agak galak',

            'payment_id' => null,
            'service_id' => null,
            'appointment_detail_id' => null,
        ]);

        // Data 3: Status COMPLETED (Sudah selesai)
        Appointment::create([
            'groomer_id' => $groomerId,
            'appointment_date' => Carbon::today()->setHour(8)->setMinute(0),
            'status' => 'completed',

            'customer_name' => 'Pak Budi',
            'pet_name' => 'Bruno',
            'pet_type' => 'Bulldog',
            'pet_gender' => 'Male',
            'pet_weight' => '12 kg',
            'service_type' => 'Full Grooming',
            'notes' => '',

            'completed_at' => Carbon::today()->setHour(9)->setMinute(15),
            'duration' => '01:15', // 1 jam 15 menit

            'payment_id' => null,
            'service_id' => null,
            'appointment_detail_id' => null,
        ]);
    }
}
