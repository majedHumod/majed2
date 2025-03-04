<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create a trainer user
        User::factory()->create([
            'name' => 'Trainer User',
            'email' => 'trainer@example.com',
            'role' => 'trainer',
        ]);

        // Create a subscriber user
        User::factory()->create([
            'name' => 'Subscriber User',
            'email' => 'subscriber@example.com',
            'role' => 'subscriber',
        ]);

        // Create additional users if needed
        User::factory(3)->trainer()->create();
        User::factory(10)->subscriber()->create();
    }
}