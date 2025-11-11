<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingManagementController extends Controller
{
    public function index()
    {
        // Optimize query - only load necessary data
        $bookings = Booking::with(['user:user_id,full_name', 'room:room_id,room_title'])
            ->select('booking_id', 'user_id', 'room_id', 'check_in_date', 'check_out_date', 'total_amount', 'status', 'payment_status', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $total = Booking::count();
        $pending = Booking::where('status', 'pending')->count();
        $confirmed = Booking::where('status', 'confirmed')->count();
        $cancelled = Booking::where('status', 'cancelled')->count();
        
        return view('admin.bookings', compact('bookings', 'total', 'pending', 'confirmed', 'cancelled'));
    }
}
