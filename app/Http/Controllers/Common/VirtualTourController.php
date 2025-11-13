<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\VirtualTour;
use App\Models\Room;
use Illuminate\Http\Request;

class VirtualTourController extends Controller
{
    public function show(Room $room)
    {
        $virtualTour = $room->activeVirtualTour;
        
        if (!$virtualTour) {
            return redirect()->route('room.show', $room->slug)
                ->with('error', 'Virtual tour is not available for this room.');
        }

        // Increment view count
        $virtualTour->incrementViewCount();

        return view('virtual-tours.show', compact('room', 'virtualTour'));
    }

    public function embed(Room $room)
    {
        $virtualTour = $room->activeVirtualTour;
        
        if (!$virtualTour) {
            abort(404, 'Virtual tour not found');
        }

        // Increment view count
        $virtualTour->incrementViewCount();

        return view('virtual-tours.embed', compact('room', 'virtualTour'));
    }
}
