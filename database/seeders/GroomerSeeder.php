<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroomerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('groomers')->insert([
            [
                'name' => 'Ayu Grooming',
                'email' => 'ayu@grooming.local',
                'phone_number' => '081234567890',
                'address' => 'Jl. Mawar No. 1',
                'total_appointments_completed' => 120,
                'total_hours_worked' => 800,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Groomers',
                'email' => 'budi@groomers.local',
                'phone_number' => '081987654321',
                'address' => 'Jl. Melati No. 2',
                'total_appointments_completed' => 95,
                'total_hours_worked' => 650,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
