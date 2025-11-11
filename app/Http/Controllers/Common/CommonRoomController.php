<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class CommonRoomController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Room::query()
            ->where('is_verified', true)
            ->where('status', 'available')
            ->with(['images', 'amenities', 'owner']);
    
        // Apply filters
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }
    
        if ($request->filled('min_price')) {
            $query->where('room_price', '>=', $request->min_price);
        }
    
        if ($request->filled('max_price')) {
            $query->where('room_price', '<=', $request->max_price);
        }
    
        if ($request->filled('capacity')) {
            $query->where('room_capacity', $request->capacity);
        }
    
        $rooms = $query->orderBy('created_at', 'desc')->paginate(6);
    
        return view('common.room-list', compact('rooms'));
    }
    
    public function show(string $slug)
    {
        $room = Room::where('slug', $slug)
            ->where('is_verified', true)
            ->where('status', 'available')
            ->with(['images', 'amenities', 'owner'])
            ->whereHas('owner')
            ->firstOrFail();
        $room->sharing_prices = json_decode($room->sharing_prices, true);
        
        // Check if room is in user's wishlist
        $isInWishlist = false;
        if (auth()->check()) {
            $isInWishlist = \App\Models\Wishlist::where('user_id', auth()->id())
                ->where('room_id', $room->room_id)
                ->exists();
        }
        
        // Get similar rooms
        $similarRooms = Room::where('slug', '!=', $slug)
            ->where('is_verified', true)
            ->where('status', 'available')
            ->where('city', $room->city)
            ->with(['images', 'amenities'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
        
        return view('common.room-detail', compact('room', 'similarRooms', 'isInWishlist'));
    }
}
