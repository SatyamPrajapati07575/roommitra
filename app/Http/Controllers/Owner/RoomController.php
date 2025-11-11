<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomValidation;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Models\State;
use App\Models\City;
use App\Models\AmenityMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Room::where('owner_id', $user->user_id)
            ->with(['images', 'amenities', 'bookings']);

        if ($request->filled('search')) {
            $query->where('room_title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $rooms = $query->latest()->paginate(10)->withQueryString();
        
        // Get statistics
        $stats = [
            'total' => Room::where('owner_id', $user->user_id)->count(),
            'pending' => Room::where('owner_id', $user->user_id)->where('status', 'pending')->count(),
            'available' => Room::where('owner_id', $user->user_id)->where('status', 'available')->count(),
            'booked' => Room::where('owner_id', $user->user_id)->where('status', 'booked')->count(),
        ];

        return view('owner.my-rooms', compact('rooms', 'stats'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::where('is_active', true)->orderBy('state_name')->get();
        $cities = City::where('is_active', true)->orderBy('city_name')->get();
        $amenities = AmenityMaster::active()->ordered()->get();
        
        return view('owner.create-room', compact('states', 'cities', 'amenities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'room_title' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:50',
            'room_description' => 'required|string',
            'room_price' => 'required|numeric|min:500',
            'security_deposit' => 'required|numeric|min:0',
            'min_stay_months' => 'required|integer|min:1|max:24',
            'total_beds' => 'required|integer|min:1',
            'room_capacity' => 'required|integer|min:1',
            'floor' => 'nullable|integer|min:0',
            'bathroom_type' => 'required|in:attached,common',
            'kitchen_type' => 'required|in:private,shared,none',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'locality' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|digits:6',
            'nearby_landmarks' => 'nullable|string',
            'room_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check room number duplicate
        if ($request->room_number && Room::where('owner_id', Auth::user()->user_id)->where('room_number', $request->room_number)->exists()) {
            return back()->withInput()->with('error', 'Room Number already exists for your account');
        }

        // Create room
        $room = new Room();
        $room->owner_id = Auth::user()->user_id;
        $room->room_number = $request->room_number;
        $room->room_title = $request->room_title;
        $room->room_description = $request->room_description;
        $room->room_price = $request->room_price;
        $room->security_deposit = $request->security_deposit;
        $room->min_stay_months = $request->min_stay_months;
        $room->sharing_prices = null; // Can be added later if needed
        $room->floor = $request->floor;
        $room->room_capacity = $request->room_capacity;
        $room->total_beds = $request->total_beds;
        $room->room_size = $request->room_size;
        
        // Amenities (stored in rooms table)
        $room->ac = $request->has('ac') ? 1 : 0;
        $room->lift = $request->has('lift') ? 1 : 0;
        $room->parking = $request->has('parking') ? 1 : 0;
        $room->kitchen = $request->kitchen_type != 'none' ? 1 : 0;
        $room->kitchen_type = $request->kitchen_type;
        $room->bathroom_type = $request->bathroom_type;
        
        // Location
        $room->address_line1 = $request->address_line1;
        $room->address_line2 = $request->address_line2;
        $room->city = $request->city;
        $room->state = $request->state;
        $room->pincode = $request->pincode;
        $room->locality = $request->locality;
        $room->nearby_landmarks = $request->nearby_landmarks;
        
        // Status - Pending for admin approval
        $room->is_verified = false;
        $room->status = 'pending';
        
        $room->save();

        // Store amenities dynamically from database
        $allAmenities = AmenityMaster::active()->get();
        
        foreach ($allAmenities as $amenity) {
            if ($request->has($amenity->amenity_key)) {
                $room->amenities()->create([
                    'amenity_name' => $amenity->amenity_name,
                    'status' => 'free',
                    'price' => null,
                ]);
            }
        }

        // Handle image uploads
        if ($request->hasFile('room_images')) {
            $ownerId = $room->owner_id;
            $roomId = $room->room_id;

            foreach ($request->file('room_images') as $index => $image) {
                // Unique file name generate
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Path banaye
                $destinationPath = public_path("uploads/owners/{$ownerId}/rooms/{$roomId}");

                // Folder agar nahi bana ho to bana do
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Move image to that path
                $image->move($destinationPath, $imageName);

                // Save record in DB
                $room->images()->create([
                    'image_url' => "uploads/owners/{$ownerId}/rooms/{$roomId}/{$imageName}",
                    'image_type' => 'room',
                    'is_featured' => $index === 0 ? 1 : 0, // First image is featured
                ]);
            }
        }

        return redirect()->route('owner.rooms.index')->with('success', 'Room submitted successfully! It will be reviewed by admin for approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $ownerId = Auth::user()->user_id;
    
        $room = Room::where('owner_id', $ownerId)
                    ->where('slug', $slug)
                    ->with('images', 'amenities', 'bookings')
                    ->firstOrFail();
    
        $room->sharing_prices = json_decode($room->sharing_prices, true);
    
        return view('owner.view-room', compact('room'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $ownerId = Auth::user()->user_id;
        
        $room = Room::where('owner_id', $ownerId)
                    ->where('slug', $slug)
                    ->with(['images', 'amenities'])
                    ->firstOrFail();
        $room->sharing_prices = json_decode($room->sharing_prices, true);
        
        // Get all amenities
        $amenities = AmenityMaster::active()->ordered()->get();
        
        // Get selected amenity keys from room_amenities table
        $selectedAmenities = $room->amenities->pluck('amenity_name')->toArray();
        
        return view('owner.room-edit', compact('room', 'amenities', 'selectedAmenities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, string $slug)
    {
        $ownerId = Auth::user()->user_id;
        
        // Find room by slug and verify ownership
        $room = Room::where('owner_id', $ownerId)
                    ->where('slug', $slug)
                    ->firstOrFail();

        // Update basic room details
        $room->room_number = $request->room_number;
        $room->room_title = $request->room_title; // Slug will auto-update via model boot method
        $room->room_description = $request->room_description;
        $room->room_price = $request->room_price;
        $room->security_deposit = $request->security_deposit;
        $room->min_stay_months = $request->min_stay_months;
        $room->sharing_prices = null;
        $room->floor = $request->floor;
        $room->room_capacity = $request->room_capacity;
        $room->total_beds = $request->total_beds;
        $room->room_size = $request->room_size;
        
        // Amenities in rooms table
        $room->ac = $request->has('ac') ? 1 : 0;
        $room->lift = $request->has('lift') ? 1 : 0;
        $room->parking = $request->has('parking') ? 1 : 0;
        $room->kitchen = $request->kitchen_type != 'none' ? 1 : 0;
        $room->kitchen_type = $request->kitchen_type;
        $room->bathroom_type = $request->bathroom_type;
        
        // Location
        $room->address_line1 = $request->address_line1;
        $room->address_line2 = $request->address_line2;
        $room->city = $request->city;
        $room->state = $request->state;
        $room->pincode = $request->pincode;
        $room->locality = $request->locality;
        $room->nearby_landmarks = $request->nearby_landmarks;
        
        // Optional fields
        $room->entry_time = $request->entry_time;
        $room->exit_time = $request->exit_time;
        $room->restrictions = $request->restrictions;
        
        $room->save();

        // Update amenities dynamically (from room_amenities table)
        $room->amenities()->delete();
        
        $allAmenities = AmenityMaster::active()->get();
        foreach ($allAmenities as $amenity) {
            if ($request->has($amenity->amenity_key)) {
                $room->amenities()->create([
                    'amenity_name' => $amenity->amenity_name,
                    'status' => 'free',
                    'price' => null,
                ]);
            }
        }

        // Handle new image uploads
        if ($request->hasFile('room_images')) {
            $roomId = $room->room_id;

            foreach ($request->file('room_images') as $index => $image) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path("uploads/owners/{$ownerId}/rooms/{$roomId}");

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $image->move($destinationPath, $imageName);

                $room->images()->create([
                    'image_url' => "uploads/owners/{$ownerId}/rooms/{$roomId}/{$imageName}",
                    'image_type' => 'room',
                    'is_featured' => $index === 0 && $room->images()->count() === 0, // First image is featured if no images exist
                ]);
            }
        }

        // Refresh the room to get updated slug
        $room->refresh();

        return redirect()->route('owner.rooms.index')->with('success', 'Room updated successfully!');
    }

    /**
     * Update room status
     */
    public function updateStatus(Request $request, string $slug)
    {
        $request->validate([
            'status' => 'required|in:available,booked,pending,inactive'
        ]);

        $ownerId = Auth::user()->user_id;
        
        $room = Room::where('owner_id', $ownerId)
                    ->where('slug', $slug)
                    ->firstOrFail();
        
        $room->status = $request->status;
        $room->save();

        return redirect()->back()->with('success', 'Room status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $ownerId = Auth::user()->user_id;
        
        // Find room by slug and verify ownership
        $room = Room::where('owner_id', $ownerId)
                    ->where('slug', $slug)
                    ->firstOrFail();
        
        // Delete associated images from filesystem
        foreach ($room->images as $image) {
            $imagePath = public_path($image->image_url);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Delete room (cascade will delete images and amenities)
        $room->delete();
        
        return redirect()->route('owner.rooms.index')->with('success', 'Room deleted successfully!');
    }
}
