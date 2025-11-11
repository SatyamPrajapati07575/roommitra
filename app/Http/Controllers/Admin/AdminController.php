<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Complaint;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display admin dashboard with statistics
     */
    public function index()
    {
        // Users Stats
        $total_users = User::where('role', 'user')->count();
        $total_owners = User::where('role', 'room_owner')->count();
        $blocked_users = User::where('is_blocked', true)->count();
        
        // Rooms Stats
        $total_rooms = Room::count();
        $pending_rooms = Room::where('status', 'pending')->count();
        $approved_rooms = Room::where('status', 'available')->count();
        
        // Bookings Stats
        $total_bookings = Booking::count();
        $pending_bookings = Booking::where('status', 'pending')->count();
        $confirmed_bookings = Booking::where('status', 'confirmed')->count();
        
        // Payments Stats
        $total_payments = Payment::count();
        $completed_payments_amount = Payment::where('status', 'success')->sum('amount');
        $pending_payments = Payment::where('status', 'pending')->count();
        
        // Complaints Stats
        $total_complaints = Complaint::count();
        $pending_complaints = Complaint::where('status', 'pending')->count();
        $resolved_complaints = Complaint::where('status', 'resolved')->count();
        
        // Recent data for dashboard
        $recent_users = User::latest()->take(5)->get();
        $recent_rooms = Room::with('owner:user_id,full_name')->latest()->take(5)->get();
        $recent_bookings = Booking::with(['user:user_id,full_name', 'room:room_id,room_title'])
            ->latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'total_users', 'total_owners', 'blocked_users',
            'total_rooms', 'pending_rooms', 'approved_rooms',
            'total_bookings', 'pending_bookings', 'confirmed_bookings',
            'total_payments', 'completed_payments_amount', 'pending_payments',
            'total_complaints', 'pending_complaints', 'resolved_complaints',
            'recent_users', 'recent_rooms', 'recent_bookings'
        ));
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
        //
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
