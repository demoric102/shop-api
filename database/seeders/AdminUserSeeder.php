<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@watchtowr.com'], // Ensure unique admin
            [
                'name' => 'WatchTowr Admin',
                'email' => 'admin@watchtowr.com',
                'password' => Hash::make('password123'), // Change this to a secure password
                'role' => 'admin',
            ]
        );
    }
}