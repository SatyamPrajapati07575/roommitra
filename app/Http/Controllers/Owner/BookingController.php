<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $ownerId = Auth::user()->user_id;
        
        $bookings = Booking::where('owner_id', $ownerId)
            ->with(['user:user_id,full_name', 'room:room_id,room_title'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $total = Booking::where('owner_id', $ownerId)->count();
        $pending = Booking::where('owner_id', $ownerId)->where('status', 'pending')->count();
        $confirmed = Booking::where('owner_id', $ownerId)->where('status', 'confirmed')->count();
        $cancelled = Booking::where('owner_id', $ownerId)->where('status', 'cancelled')->count();
        
        return view('owner.bookings', compact('bookings', 'total', 'pending', 'confirmed', 'cancelled'));
    }
}
