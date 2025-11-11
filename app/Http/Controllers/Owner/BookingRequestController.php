<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingRequestController extends Controller
{
    /**
     * Display a listing of the resource - Show pending booking requests
     */
    public function index()
    {
        $ownerId = Auth::user()->user_id;
        
        // Get all bookings for owner's rooms
        $bookings = Booking::whereHas('room', function($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->with(['user', 'room', 'room.images'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Get statistics
        $stats = [
            'total' => Booking::whereHas('room', function($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })->count(),
            'pending' => Booking::whereHas('room', function($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })->where('status', 'pending')->count(),
            'confirmed' => Booking::whereHas('room', function($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })->where('status', 'confirmed')->count(),
            'cancelled' => Booking::whereHas('room', function($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })->where('status', 'cancelled')->count(),
        ];
        
        return view('owner.booking-requests', compact('bookings', 'stats'));
    }
    
    /**
     * Confirm offline payment booking
     */
    public function confirmBooking(Request $request, $id)
    {
        $ownerId = Auth::user()->user_id;
        
        $booking = Booking::whereHas('room', function($query) use ($ownerId) {
                $query->where('owner_id', $ownerId);
            })
            ->where('booking_id', $id)
            ->firstOrFail();
        
        if ($booking->status !== 'pending' || $booking->payment_type !== 'offline') {
            return redirect()->back()->with('error', 'Cannot confirm this booking');
        }
        
        // Update booking status
        $booking->status = 'confirmed';
        $booking->payment_status = 'paid';
        $booking->save();
        
        // Update room status to booked
        $room = Room::find($booking->room_id);
        $room->status = 'booked';
        $room->save();
        
        return redirect()->back()->with('success', 'Booking confirmed successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
