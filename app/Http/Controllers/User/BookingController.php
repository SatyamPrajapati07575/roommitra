<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all bookings for the logged-in user with relationships
        $bookings = Booking::where('user_id', FacadesAuth::user()->user_id)
            ->with(['room', 'room.images', 'room.owner', 'payment'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.bookings-list', compact('bookings'));
    }
    public function checkout($slugOrId)
    {
        // Try to find by slug first, if not found then by ID
        $room = Room::where('slug', $slugOrId)
            ->orWhere('room_id', $slugOrId)
            ->with(['images', 'amenities', 'owner'])
            ->firstOrFail();
            
        $room->sharing_prices = json_decode($room->sharing_prices, true);
        return view('user.checkout-modern', compact('room'));
    }

    public function pay(Request $request, $room)
    {
        $Room = Room::where('room_id', $room)->with('images', 'amenities', 'owner')->firstOrFail();
        
        // Check if room is available for booking
        if ($Room->status !== 'available') {
            return redirect()->back()->with('error', 'Sorry! This room is no longer available for booking.');
        }
        
        // Parse dates
        try {
            $checkin = \Carbon\Carbon::parse($request->checkin_date)->format('Y-m-d');
            $checkout = \Carbon\Carbon::parse($request->checkout_date)->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid date format');
        }

        // Determine payment status based on payment type
        $paymentType = $request->payment_type ?? 'online';
        $paymentFreq = $request->payment_frequency ?? 'full';
        
        if ($paymentType === 'offline') {
            // Offline payment - pending until owner confirms
            $paymentStatus = 'pending';
            $bookingStatus = 'pending';
            $paymentMethod = 'offline';
            $transactionId = null;
            // Don't change room status for offline payment - owner will confirm
        } else {
            // Online payment - simulate success (in real app, integrate payment gateway)
            $paymentSuccess = true; // Replace with actual payment gateway response
            $paymentStatus = $paymentSuccess ? 'paid' : 'failed';
            $bookingStatus = $paymentSuccess ? 'confirmed' : 'pending';
            $paymentMethod = 'online';
            $transactionId = 'TXN' . strtoupper(uniqid());
            
            // Update room status to booked if payment successful
            if ($paymentSuccess) {
                $Room->status = 'booked';
                $Room->save();
            }
        }

        // Create booking
        Booking::create([
            'user_id' => FacadesAuth::user()->user_id,
            'owner_id' => $Room->owner_id,
            'room_id' => $Room->room_id,
            'check_in_date' => $checkin,
            'check_out_date' => $checkout,
            'total_amount' => $request->total,
            'status' => $bookingStatus,
            'payment_status' => $paymentStatus,
            'payment_method' => $paymentMethod,
            'transaction_id' => $transactionId,
            'payment_frequency' => $paymentFreq,
            'payment_type' => $paymentType,
            'monthly_amount' => $request->monthly_amount ?? null,
            'duration_months' => $request->months ?? 1,
            'occupancy' => $request->occupancy ?? 1,
        ]);

        // Redirect based on payment type
        if ($paymentType === 'offline') {
            return redirect()->route('user.booking.success')
                ->with('message', 'Booking request sent! Owner will confirm after payment verification.');
        }
        
        return $paymentStatus === 'paid'
            ? redirect()->route('user.booking.success')
            : redirect()->route('user.booking.fail');
    }

    public function success()
    {
        return view('user.booking-status', ['status' => 'success']);
    }

    public function fail()
    {
        return view('user.booking-status', ['status' => 'fail']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $room = Room::where('room_id', $id)->with('images', 'amenities', 'owner')->firstOrFail();
        $room->sharing_prices = json_decode($room->sharing_prices, true);

        return view('user.invoice', compact('room'));
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
