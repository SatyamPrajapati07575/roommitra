<?php

namespace Database\Seeders;

use App\Models\Complaint;
use App\Models\Room;
use App\Models\RoomAmenity;
use App\Models\RoomImage;
use App\Models\Testimonial;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,  // Create admin accounts first
            UserSeeder::class,   // Then create users
        ]);

        // Testimonial::factory()->count(10)->create();
    }
}
