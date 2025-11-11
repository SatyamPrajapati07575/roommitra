<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $ownerId = Auth::user()->user_id;
        
        $payments = Payment::whereHas('booking', function($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })
        ->with(['user:user_id,full_name', 'booking.room:room_id,room_title'])
        ->orderBy('created_at', 'desc')
        ->paginate(15);
        
        $total = Payment::whereHas('booking', function($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->count();
        
        $success = Payment::whereHas('booking', function($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->where('status', 'success')->sum('amount');
        
        $pending = Payment::whereHas('booking', function($query) use ($ownerId) {
            $query->where('owner_id', $ownerId);
        })->where('status', 'pending')->count();
        
        return view('owner.payments', compact('payments', 'total', 'success', 'pending'));
    }
}
