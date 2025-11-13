<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class VisitManagementController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $owner = Auth::user();
        $visits = Visit::with(['room', 'user'])
            ->whereHas('room', function($query) use ($owner) {
                $query->where('owner_id', $owner->user_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('owner.visits.index', compact('visits'));
    }

    public function show(Visit $visit)
    {
        // Check if owner can view this visit (owns the room)
        if (Auth::user()->user_id !== $visit->room->owner_id) {
            abort(403, 'Unauthorized access to this visit.');
        }
        
        $visit->load(['room', 'user']);
        
        return view('owner.visits.show', compact('visit'));
    }

    public function respond(Request $request, Visit $visit)
    {
        // Check if owner can respond to this visit (owns the room)
        if (Auth::user()->user_id !== $visit->room->owner_id) {
            abort(403, 'Unauthorized access to this visit.');
        }

        $request->validate([
            'action' => 'required|in:confirm,reschedule,cancel',
            'confirmed_date' => 'required_if:action,confirm,reschedule|date|after:today',
            'confirmed_time' => 'required_if:action,confirm,reschedule|date_format:H:i',
            'owner_notes' => 'nullable|string|max:1000',
            'meeting_link' => 'nullable|url|required_if:visit_type,virtual',
            'meeting_id' => 'nullable|string|max:255',
            'meeting_password' => 'nullable|string|max:255',
        ]);

        $status = $request->action === 'cancel' ? 'cancelled' : 
                 ($request->action === 'reschedule' ? 'rescheduled' : 'confirmed');

        $updateData = [
            'status' => $status,
            'owner_notes' => $request->owner_notes,
            'owner_responded_at' => now(),
        ];

        if (in_array($request->action, ['confirm', 'reschedule'])) {
            $updateData['confirmed_date'] = $request->confirmed_date;
            $updateData['confirmed_time'] = $request->confirmed_time;
            
            // For virtual visits, add meeting details
            if ($visit->visit_type === 'virtual') {
                $updateData['meeting_link'] = $request->meeting_link;
                $updateData['meeting_id'] = $request->meeting_id;
                $updateData['meeting_password'] = $request->meeting_password;
            }
        }

        $visit->update($updateData);

        // Send notification to user
        $this->notifyUser($visit);

        $message = match($request->action) {
            'confirm' => 'Visit confirmed successfully!',
            'reschedule' => 'Visit rescheduled successfully!',
            'cancel' => 'Visit cancelled successfully!',
        };

        return back()->with('success', $message);
    }

    public function markCompleted(Visit $visit)
    {
        // Check if owner can mark this visit as completed (owns the room)
        if (Auth::user()->user_id !== $visit->room->owner_id) {
            abort(403, 'Unauthorized access to this visit.');
        }

        if ($visit->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed visits can be marked as completed.');
        }

        $visit->update(['status' => 'completed']);

        return back()->with('success', 'Visit marked as completed.');
    }

    private function notifyUser(Visit $visit)
    {
        // Here you can implement email notification to the user
        // For now, we'll just log it
        \Log::info('Visit response sent', [
            'visit_id' => $visit->visit_id,
            'status' => $visit->status,
            'user_id' => $visit->user_id
        ]);
    }
}
