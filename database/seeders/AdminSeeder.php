<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Barangay Admin',
            'email' => 'admin@barangayspot.com',
            'password' => Hash::make('admin123'), // Change this to a secure password
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        $this->command->info('Admin user created successfully!');
    }
}