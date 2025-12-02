<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat atau update admin user
        User::updateOrCreate(
            ['email' => 'admin@petshop.com'],
            [
                'name' => 'Admin Petshop',
                'email' => 'admin@petshop.com',
                'password' => Hash::make('admin@123456'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );

        echo "✅ Admin user created/updated: admin@petshop.com\n";
    }
}
