<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\VirtualTour;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VirtualTourManagementController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $owner = Auth::user();
        $virtualTours = VirtualTour::with('room')
            ->whereHas('room', function($query) use ($owner) {
                $query->where('owner_id', $owner->user_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('owner.virtual-tours.index', compact('virtualTours'));
    }

    public function create()
    {
        $owner = Auth::user();
        $rooms = Room::where('owner_id', $owner->user_id)
            ->where('is_verified', true)
            ->get();

        return view('owner.virtual-tours.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,room_id',
            'tour_title' => 'required|string|max:255',
            'tour_description' => 'nullable|string|max:1000',
            'duration_minutes' => 'required|integer|min:1|max:120',
            'highlights' => 'nullable|array',
            'highlights.*' => 'string|max:255',
            'tour_images' => 'required|array|min:3',
            'tour_images.*' => 'image|mimes:jpeg,png,jpg|max:5120',
            'tour_videos' => 'nullable|array',
            'tour_videos.*' => 'mimes:mp4,avi,mov|max:51200',
        ]);

        $owner = Auth::user();
        $room = Room::where('room_id', $request->room_id)
            ->where('owner_id', $owner->user_id)
            ->firstOrFail();

        // Check if virtual tour already exists for this room
        if ($room->virtualTour) {
            return back()->with('error', 'Virtual tour already exists for this room. Please edit the existing one.');
        }

        // Handle image uploads
        $tourImages = [];
        if ($request->hasFile('tour_images')) {
            foreach ($request->file('tour_images') as $index => $image) {
                $path = $image->store('virtual-tours/images', 'public');
                $tourImages[] = [
                    'url' => Storage::url($path),
                    'description' => $request->input("image_descriptions.{$index}", ''),
                    'order' => $index + 1
                ];
            }
        }

        // Handle video uploads
        $tourVideos = [];
        if ($request->hasFile('tour_videos')) {
            foreach ($request->file('tour_videos') as $index => $video) {
                $path = $video->store('virtual-tours/videos', 'public');
                $tourVideos[] = [
                    'url' => Storage::url($path),
                    'description' => $request->input("video_descriptions.{$index}", ''),
                    'order' => $index + 1
                ];
            }
        }

        VirtualTour::create([
            'room_id' => $request->room_id,
            'tour_title' => $request->tour_title,
            'tour_description' => $request->tour_description,
            'tour_images' => $tourImages,
            'tour_videos' => $tourVideos,
            'duration_minutes' => $request->duration_minutes,
            'highlights' => $request->highlights ? array_filter($request->highlights) : [],
            'is_active' => true,
        ]);

        return redirect()->route('owner.virtual-tours.index')
            ->with('success', 'Virtual tour created successfully!');
    }

    public function show(VirtualTour $virtualTour)
    {
        // Check if owner can view this virtual tour (owns the room)
        if (Auth::user()->user_id !== $virtualTour->room->owner_id) {
            abort(403, 'Unauthorized access to this virtual tour.');
        }
        
        $virtualTour->load('room');
        
        return view('owner.virtual-tours.show', compact('virtualTour'));
    }

    public function edit(VirtualTour $virtualTour)
    {
        // Check if owner can edit this virtual tour (owns the room)
        if (Auth::user()->user_id !== $virtualTour->room->owner_id) {
            abort(403, 'Unauthorized access to this virtual tour.');
        }
        
        $virtualTour->load('room');
        
        return view('owner.virtual-tours.edit', compact('virtualTour'));
    }

    public function update(Request $request, VirtualTour $virtualTour)
    {
        // Check if owner can update this virtual tour (owns the room)
        if (Auth::user()->user_id !== $virtualTour->room->owner_id) {
            abort(403, 'Unauthorized access to this virtual tour.');
        }

        $request->validate([
            'tour_title' => 'required|string|max:255',
            'tour_description' => 'nullable|string|max:1000',
            'duration_minutes' => 'required|integer|min:1|max:120',
            'highlights' => 'nullable|array',
            'highlights.*' => 'string|max:255',
            'is_active' => 'boolean',
        ]);

        $virtualTour->update([
            'tour_title' => $request->tour_title,
            'tour_description' => $request->tour_description,
            'duration_minutes' => $request->duration_minutes,
            'highlights' => $request->highlights ? array_filter($request->highlights) : [],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('owner.virtual-tours.index')
            ->with('success', 'Virtual tour updated successfully!');
    }

    public function toggleStatus(VirtualTour $virtualTour)
    {
        // Check if owner can toggle this virtual tour status (owns the room)
        if (Auth::user()->user_id !== $virtualTour->room->owner_id) {
            abort(403, 'Unauthorized access to this virtual tour.');
        }

        $virtualTour->update(['is_active' => !$virtualTour->is_active]);

        $status = $virtualTour->is_active ? 'activated' : 'deactivated';
        
        return back()->with('success', "Virtual tour {$status} successfully!");
    }

    public function destroy(VirtualTour $virtualTour)
    {
        // Check if owner can delete this virtual tour (owns the room)
        if (Auth::user()->user_id !== $virtualTour->room->owner_id) {
            abort(403, 'Unauthorized access to this virtual tour.');
        }

        // Delete associated files
        if ($virtualTour->tour_images) {
            foreach ($virtualTour->tour_images as $image) {
                if (isset($image['url'])) {
                    $path = str_replace('/storage/', '', $image['url']);
                    Storage::disk('public')->delete($path);
                }
            }
        }

        if ($virtualTour->tour_videos) {
            foreach ($virtualTour->tour_videos as $video) {
                if (isset($video['url'])) {
                    $path = str_replace('/storage/', '', $video['url']);
                    Storage::disk('public')->delete($path);
                }
            }
        }

        $virtualTour->delete();

        return redirect()->route('owner.virtual-tours.index')
            ->with('success', 'Virtual tour deleted successfully!');
    }
}
