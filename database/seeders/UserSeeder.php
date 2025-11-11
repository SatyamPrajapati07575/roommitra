<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Student User
        User::create([
            'full_name' => 'Student Demo',
            'email' => 'student@roommitra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('student123'),
            'phone' => '9876543211',
            'role' => 'user',
            'is_verified' => true,
            'is_blocked' => false,
            'profile_completed' => true,
        ]);

        // Room Owner
        User::create([
            'full_name' => 'Room Owner Demo',
            'email' => 'owner@roommitra.com',
            'email_verified_at' => now(),
            'password' => Hash::make('owner123'),
            'phone' => '9876543212',
            'role' => 'room_owner',
            'is_verified' => true,
            'is_blocked' => false,
            'profile_completed' => true,
        ]);

        // Additional Student Users
        User::create([
            'full_name' => 'Rahul Sharma',
            'email' => 'rahul@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'phone' => '9876543213',
            'role' => 'user',
            'is_verified' => true,
            'is_blocked' => false,
            'profile_completed' => true,
        ]);

        User::create([
            'full_name' => 'Priya Singh',
            'email' => 'priya@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'phone' => '9876543214',
            'role' => 'user',
            'is_verified' => true,
            'is_blocked' => false,
            'profile_completed' => true,
        ]);

        // Additional Room Owners
        User::create([
            'full_name' => 'Amit Kumar',
            'email' => 'amit.owner@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'phone' => '9876543215',
            'role' => 'room_owner',
            'is_verified' => true,
            'is_blocked' => false,
            'profile_completed' => true,
        ]);

        User::create([
            'full_name' => 'Sneha Verma',
            'email' => 'sneha.owner@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'phone' => '9876543216',
            'role' => 'room_owner',
            'is_verified' => true,
            'is_blocked' => false,
            'profile_completed' => true,
        ]);

        $this->command->info('✅ Users seeded successfully!');
        $this->command->info('📧 Student: student@roommitra.com | Password: student123');
        $this->command->info('📧 Owner: owner@roommitra.com | Password: owner123');
        $this->command->info('📧 Other Students: rahul@example.com, priya@example.com | Password: password123');
        $this->command->info('📧 Other Owners: amit.owner@example.com, sneha.owner@example.com | Password: password123');
    }
}
