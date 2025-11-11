<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Complaint;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminPanelSeeder extends Seeder
{
    public function run()
    {
        // Get existing users or skip if already exist
        $students = User::where('role', 'user')->limit(10)->get();
        $owners = User::where('role', 'room_owner')->limit(5)->get();
        
        // If no users exist, return message
        if ($students->count() === 0 || $owners->count() === 0) {
            echo "⚠️ Please run UserSeeder first to create users!\n";
            return;
        }

        // Create Rooms
        $rooms = [];
        $bathroomTypes = ['attached', 'common'];
        $kitchenTypes = ['private', 'shared', 'none'];
        $statuses = ['pending', 'available', 'booked', 'inactive'];
        
        foreach ($owners as $index => $owner) {
            for ($j = 1; $j <= 3; $j++) {
                $kitchenType = $kitchenTypes[array_rand($kitchenTypes)];
                
                $rooms[] = Room::create([
                    'owner_id' => $owner->user_id,
                    'room_number' => "R-" . ($index + 1) . "0$j",
                    'room_title' => "Comfortable Room in Area " . chr(65 + $index),
                    'room_description' => "This is a comfortable room with all basic amenities, perfect for students and working professionals.",
                    'room_price' => rand(5000, 15000),
                    'security_deposit' => rand(2000, 5000),
                    'min_stay_months' => rand(1, 6),
                    'sharing_prices' => json_encode(['single' => rand(7000, 12000), 'double' => rand(5000, 8000)]),
                    'room_capacity' => rand(1, 3),
                    'total_beds' => rand(1, 4),
                    'floor' => (string)rand(1, 5),
                    'ac' => (bool)rand(0, 1),
                    'lift' => (bool)rand(0, 1),
                    'parking' => (bool)rand(0, 1),
                    'bathroom_type' => $bathroomTypes[array_rand($bathroomTypes)],
                    'kitchen' => $kitchenType != 'none' ? 1 : 0,
                    'kitchen_type' => $kitchenType,
                    'address_line1' => "Street $j, Building " . chr(65 + $index),
                    'locality' => "Area " . chr(65 + $index),
                    'city' => 'Delhi',
                    'state' => 'Delhi',
                    'pincode' => '1100' . str_pad($j, 2, '0', STR_PAD_LEFT),
                    'nearby_landmarks' => "Metro Station, Shopping Mall",
                    'status' => $statuses[array_rand($statuses)],
                    'is_verified' => rand(0, 1) ? true : false,
                    'created_at' => Carbon::now()->subDays(rand(1, 30)),
                ]);
            }
        }

        // Create Bookings
        $bookingStatuses = ['pending', 'confirmed', 'cancelled', 'completed'];
        $paymentStatuses = ['pending', 'paid', 'failed'];
        
        for ($i = 0; $i < 20; $i++) {
            $student = $students->random();
            $room = $rooms[array_rand($rooms)];
            $startDate = Carbon::now()->addDays(rand(1, 60));
            $months = rand(1, 6);
            
            Booking::create([
                'user_id' => $student->user_id,
                'room_id' => $room->room_id,
                'owner_id' => $room->owner_id,
                'check_in_date' => $startDate,
                'check_out_date' => $startDate->copy()->addMonths($months),
                'total_amount' => $room->room_price * $months,
                'status' => $bookingStatuses[array_rand($bookingStatuses)],
                'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                'created_at' => Carbon::now()->subDays(rand(1, 20)),
            ]);
        }

        // Create Payments
        $paymentMethods = ['UPI', 'Credit Card', 'Debit Card', 'Net Banking'];
        $paymentStatuses = ['pending', 'success', 'failed'];
        
        $bookings = Booking::all();
        foreach ($bookings as $booking) {
            Payment::create([
                'user_id' => $booking->user_id,
                'booking_id' => $booking->booking_id,
                'amount' => $booking->total_amount,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'transaction_id' => 'TXN' . strtoupper(uniqid()),
                'status' => $paymentStatuses[array_rand($paymentStatuses)],
                'payment_date' => $booking->created_at->addMinutes(rand(5, 60)),
                'created_at' => $booking->created_at->addMinutes(rand(5, 60)),
            ]);
        }

        // Create Complaints
        $complaintStatuses = ['pending', 'in_progress', 'resolved'];
        $categories = ['Room Issue', 'Payment Issue', 'Booking Problem', 'General Query', 'Technical Support'];
        
        for ($i = 1; $i <= 15; $i++) {
            $user = rand(0, 1) ? $students->random() : $owners->random();
            
            Complaint::create([
                'user_id' => $user->user_id,
                'name' => $user->full_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'user_type' => $user->role,
                'category' => $categories[array_rand($categories)],
                'subject' => "Complaint Subject $i",
                'description' => "This is a detailed description of complaint number $i. Need immediate attention.",
                'status' => $complaintStatuses[array_rand($complaintStatuses)],
                'created_at' => Carbon::now()->subDays(rand(1, 15)),
            ]);
        }

        $this->command->info('Admin Panel dummy data created successfully!');
    }
}
