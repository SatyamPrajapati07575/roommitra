<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compare;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    /**
     * Display compare page
     */
    public function index()
    {
        $compares = Compare::where('user_id', Auth::user()->user_id)
            ->with(['room.images', 'room.amenities', 'room.owner'])
            ->get();
        
        return view('user.compare', compact('compares'));
    }

    /**
     * Toggle room in compare list
     */
    public function toggle(Request $request, $roomId)
    {
        $userId = Auth::user()->user_id;
        
        // Check if room exists in compare
        $compare = Compare::where('user_id', $userId)
            ->where('room_id', $roomId)
            ->first();
        
        if ($compare) {
            // Remove from compare
            $compare->delete();
            return response()->json([
                'success' => true,
                'added' => false,
                'status' => 'removed',
                'message' => 'Room removed from compare'
            ]);
        } else {
            // Check limit (max 4 rooms)
            $compareCount = Compare::where('user_id', $userId)->count();
            
            if ($compareCount >= 4) {
                return response()->json([
                    'success' => false,
                    'message' => 'You can compare maximum 4 rooms at a time'
                ], 400);
            }
            
            // Add to compare
            Compare::create([
                'user_id' => $userId,
                'room_id' => $roomId,
            ]);
            
            return response()->json([
                'success' => true,
                'added' => true,
                'status' => 'added',
                'message' => 'Room added to compare'
            ]);
        }
    }

    /**
     * Clear all compares
     */
    public function clear()
    {
        Compare::where('user_id', Auth::user()->user_id)->delete();
        
        return redirect()->route('user.compare.index')->with('success', 'Compare list cleared!');
    }

    /**
     * Get compare count
     */
    public function count()
    {
        $count = Compare::where('user_id', Auth::user()->user_id)->count();
        
        return response()->json([
            'count' => $count
        ]);
    }
}
