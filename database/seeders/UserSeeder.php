<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Note: We don't truncate users table to preserve existing users
        // Only create if they don't exist
        
        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@clinify.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('test1234'),
                'role' => Role::ADMIN,
                'email_verified_at' => now(),
            ]
        );

        // Create Clinician User
        User::firstOrCreate(
            ['email' => 'clinician@clinify.com'],
            [
                'name' => 'Clinician User',
                'password' => Hash::make('test1234'),
                'role' => Role::CLINICIAN,
                'email_verified_at' => now(),
            ]
        );
    }
}
