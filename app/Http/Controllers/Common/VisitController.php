<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class VisitController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user = Auth::user();
        $visits = Visit::with(['room', 'room.owner', 'room.images'])
            ->where('user_id', $user->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('visits.index', compact('visits'));
    }

    public function create(Room $room)
    {
        return view('visits.create', compact('room'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,room_id',
            'visit_type' => 'required|in:physical,virtual',
            'preferred_date' => 'required|date|after:today',
            'preferred_time' => 'required|date_format:H:i',
            'alternative_date' => 'nullable|date|after:today',
            'alternative_time' => 'nullable|date_format:H:i',
            'visitor_name' => 'required|string|max:255',
            'visitor_phone' => 'required|string|max:15',
            'visitor_email' => 'required|email|max:255',
            'special_requirements' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $room = Room::findOrFail($request->room_id);

        // Check if user already has a pending visit for this room
        $existingVisit = Visit::where('user_id', $user->user_id)
            ->where('room_id', $request->room_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingVisit) {
            return back()->with('error', 'You already have a pending visit request for this room.');
        }

        $visit = Visit::create([
            'user_id' => $user->user_id,
            'room_id' => $request->room_id,
            'visit_type' => $request->visit_type,
            'preferred_date' => $request->preferred_date,
            'preferred_time' => $request->preferred_time,
            'alternative_date' => $request->alternative_date,
            'alternative_time' => $request->alternative_time,
            'visitor_name' => $request->visitor_name,
            'visitor_phone' => $request->visitor_phone,
            'visitor_email' => $request->visitor_email,
            'special_requirements' => $request->special_requirements,
            'status' => 'pending',
        ]);

        // Send notification to room owner
        $this->notifyOwner($visit);

        return redirect()->route('visits.show', $visit->visit_id)
            ->with('success', 'Visit request submitted successfully! The owner will respond soon.');
    }

    public function show(Visit $visit)
    {
        // Check if user can view this visit
        if (Auth::user()->user_id !== $visit->user_id) {
            abort(403, 'Unauthorized access to this visit.');
        }
        
        $visit->load(['room', 'room.owner', 'room.images', 'user']);
        
        return view('visits.show', compact('visit'));
    }

    public function cancel(Visit $visit)
    {
        // Check if user can cancel this visit
        if (Auth::user()->user_id !== $visit->user_id) {
            abort(403, 'Unauthorized access to this visit.');
        }

        if (!in_array($visit->status, ['pending', 'confirmed'])) {
            return back()->with('error', 'Cannot cancel this visit.');
        }

        $visit->update(['status' => 'cancelled']);

        return back()->with('success', 'Visit request cancelled successfully.');
    }

    private function notifyOwner(Visit $visit)
    {
        // Here you can implement email notification to the owner
        // For now, we'll just log it or you can implement email later
        \Log::info('Visit request created', [
            'visit_id' => $visit->visit_id,
            'room_id' => $visit->room_id,
            'owner_id' => $visit->room->owner_id
        ]);
    }
}
