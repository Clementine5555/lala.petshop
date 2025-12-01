<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('services')->insert([
            [
                'service_name' => 'Basic Bath & Dry',
                'description' => 'Wash, shampoo, dry and light brushing.',
                'price' => 75000,
                'duration_minutes' => 45,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Full Grooming',
                'description' => 'Complete grooming: bath, trim, nail trim, ear cleaning.',
                'price' => 150000,
                'duration_minutes' => 90,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'service_name' => 'Nail Trim',
                'description' => 'Quick nail trimming and paw care.',
                'price' => 40000,
                'duration_minutes' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
