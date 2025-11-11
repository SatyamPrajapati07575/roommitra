<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin - Main Administrator
        Admin::updateOrCreate(
            ['username' => 'superadmin'], // <-- Match by username (unique)
            [
                'full_name'  => 'Super Admin',
                'email'      => 'superadmin@roommitra.com',
                'phone'      => '9999999999',
                'password'   => Hash::make('Admin@123'),
            ]
        );

        // Secondary Admin
        Admin::updateOrCreate(
            ['username' => 'superadmin2'], // <-- Match by username (unique)
            [
                'full_name'  => 'Satyam Prajapati',
                'email'      => 'developersp741@gmail.com',
                'phone'      => '8303209673',
                'password'   => Hash::make('Roomitra@#12'),
            ]
        );

        $this->command->info('✅ Admin accounts created or updated successfully!');
        $this->command->info('📧 Super Admin: superadmin@roommitra.com | Password: Admin@123');
        $this->command->info('📧 Super Admin2: developersp741@gmail.com | Password: Roomitra@#12');
    }
}
