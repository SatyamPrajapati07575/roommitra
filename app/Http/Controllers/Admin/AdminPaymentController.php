<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index()
    {
        // Optimize query - only load necessary data
        $payments = Payment::with(['user:user_id,full_name', 'booking:booking_id,room_id'])
            ->select('payment_id', 'user_id', 'booking_id', 'amount', 'payment_method', 'status', 'transaction_id', 'created_at')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $total = Payment::count();
        $completed = Payment::where('status', 'success')->sum('amount');
        $pending = Payment::where('status', 'pending')->count();
        $failed = Payment::where('status', 'failed')->count();
        
        return view('admin.payments', compact('payments', 'total', 'completed', 'pending', 'failed'));
    }
}
