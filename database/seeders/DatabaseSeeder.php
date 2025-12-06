<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Ensure test user exists (idempotent) to avoid duplicate errors when seeding repeatedly
        \App\Models\User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User']
        );

        // seed products, groomers and services
        $this->call([
            \Database\Seeders\ProductSeeder::class,
            \Database\Seeders\GroomerSeeder::class,
            \Database\Seeders\ServiceSeeder::class,
        ]);
    }
}
