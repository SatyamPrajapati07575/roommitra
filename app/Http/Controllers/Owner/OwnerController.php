<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $ownerId = Auth::user()->user_id;
        
        // Room Stats
        $total_rooms = Room::where('owner_id', $ownerId)->count();
        $available_rooms = Room::where('owner_id', $ownerId)->where('status', 'available')->count();
        $pending_rooms = Room::where('owner_id', $ownerId)->where('status', 'pending')->count();
        $booked_rooms = Room::where('owner_id', $ownerId)->where('status', 'booked')->count();
        
        // Booking Stats
        $total_bookings = Booking::where('owner_id', $ownerId)->count();
        $pending_bookings = Booking::where('owner_id', $ownerId)->where('status', 'pending')->count();
        $confirmed_bookings = Booking::where('owner_id', $ownerId)->where('status', 'confirmed')->count();
        $completed_bookings = Booking::where('owner_id', $ownerId)->where('status', 'completed')->count();
        
        // Payment/Earnings Stats
        $total_earnings = Payment::whereHas('booking', function($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->where('status', 'success')->sum('amount');
        
        $this_month_earnings = Payment::whereHas('booking', function($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })
        ->where('status', 'success')
        ->whereMonth('created_at', now()->month)
        ->sum('amount');
        
        // Complaint Stats
        $pending_complaints = Complaint::where('user_id', $ownerId)
            ->where('status', 'pending')
            ->count();
        
        // Recent Data
        $recent_rooms = Room::where('owner_id', $ownerId)
            ->latest()
            ->take(5)
            ->get();
            
        $recent_bookings = Booking::where('owner_id', $ownerId)
            ->with(['user:user_id,full_name', 'room:room_id,room_title'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('owner.dashboard', compact(
            'total_rooms', 'available_rooms', 'pending_rooms', 'booked_rooms',
            'total_bookings', 'pending_bookings', 'confirmed_bookings', 'completed_bookings',
            'total_earnings', 'this_month_earnings', 'pending_complaints',
            'recent_rooms', 'recent_bookings'
        ));
    }
}
