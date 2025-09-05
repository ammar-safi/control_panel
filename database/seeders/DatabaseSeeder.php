<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the admin user if it doesn't exist
        \App\Models\User::firstOrCreate(
            ['email' => 'ammar.ahmed.safi@gmail.com'],
            [
                'first_name' => 'Ammar',
                'last_name' => 'safi',
                'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
                'email_verified_at' => now(),
                'type' => 'admin',
                'department_id' => null,
                'phone_number' => '0988845619',
                'public_key' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        \App\Models\User::factory(10)->create();
        \App\Models\Department::factory(5)->create();
    }
}
