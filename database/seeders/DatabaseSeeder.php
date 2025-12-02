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

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // seed products, groomers and services
        $this->call([
            \Database\Seeders\ProductSeeder::class,
            \Database\Seeders\GroomerSeeder::class,
            \Database\Seeders\ServiceSeeder::class,
        ]);
    }
}
