<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomVerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Optimize query - only load necessary relationships and select specific columns
        $rooms = Room::with(['owner:user_id,full_name'])
            ->select('room_id', 'owner_id', 'room_title', 'room_price', 'city', 'status', 'is_verified', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $total = Room::count();
        $pending = Room::where('status', 'pending')->count();
        $approved = Room::where('status', 'available')->count();
        $rejected = Room::where('status', 'inactive')->count();
        
        return view('admin.rooms', compact('rooms', 'total', 'pending', 'approved', 'rejected'));
    }

    public function approve($id)
    {
        $room = Room::where('room_id', $id)->firstOrFail();
        $room->is_verified = true;
        $room->status = 'available';
        $room->save();

        return response()->json([
            'success' => true,
            'message' => 'Room approved and made available successfully'
        ]);
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
        $room = Room::where('room_id', $id)
            ->with(['images', 'amenities', 'owner', 'bookings', 'reviews', 'wishlists'])
            ->firstOrFail();
        
        return view('admin.room-details', compact('room'));
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
