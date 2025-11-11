@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
    {{-- Page Header --}}
    @include('admin.partials.page-header', [
        'title' => 'Admin Dashboard',
        'icon' => 'bx bxs-dashboard'
    ])
  
    {{-- Summary Cards --}}
    <div class="row">
        @include('admin.partials.stat-card', [
            'title' => 'Total Students',
            'value' => $total_users,
            'icon' => 'bx bxs-user-account',
            'color' => 'info',
            'link' => route('admin.users.index')
        ])

        @include('admin.partials.stat-card', [
            'title' => 'Total Owners',
            'value' => $total_owners,
            'icon' => 'bx bxs-user-badge',
            'color' => 'primary',
            'link' => route('admin.users.index')
        ])

        @include('admin.partials.stat-card', [
            'title' => 'Total Rooms',
            'value' => $total_rooms,
            'icon' => 'bx bxs-home',
            'color' => 'success',
            'link' => route('admin.rooms.index')
        ])

        @include('admin.partials.stat-card', [
            'title' => 'Pending Rooms',
            'value' => $pending_rooms,
            'icon' => 'bx bx-hourglass',
            'color' => 'warning',
            'link' => route('admin.rooms.index')
        ])
    </div>

    {{-- Additional Stats Row --}}
    <div class="row">
        @include('admin.partials.stat-card', [
            'title' => 'Total Bookings',
            'value' => $total_bookings,
            'icon' => 'bx bx-calendar-check',
            'color' => 'success',
            'link' => route('admin.bookings.index')
        ])

        @include('admin.partials.stat-card', [
            'title' => 'Total Revenue',
            'value' => '₹' . number_format($completed_payments_amount),
            'icon' => 'bx bx-wallet',
            'color' => 'primary',
            'link' => route('admin.payments.index')
        ])

        @include('admin.partials.stat-card', [
            'title' => 'Pending Complaints',
            'value' => $pending_complaints,
            'icon' => 'bx bx-error-circle',
            'color' => 'danger',
            'link' => route('admin.complaints.index')
        ])

        @include('admin.partials.stat-card', [
            'title' => 'Resolved Complaints',
            'value' => $resolved_complaints,
            'icon' => 'bx bx-check-circle',
            'color' => 'success',
            'link' => route('admin.complaints.index')
        ])
    </div>
  
    {{-- Quick Actions --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class='bx bx-cog'></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.rooms.index') }}" class="btn btn-success btn-block">
                                <i class='bx bx-check-circle'></i> Approve Rooms
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.complaints.index') }}" class="btn btn-info btn-block">
                                <i class='bx bx-message-dots'></i> View Complaints
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-warning btn-block">
                                <i class='bx bx-calendar'></i> Manage Bookings
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-primary btn-block">
                                <i class='bx bx-wallet'></i> View Payments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class='bx bx-bell'></i> Quick Overview</h5>
                </div>
                <div class="card-body">
                    @if($pending_rooms > 0)
                        <div class="alert alert-warning">
                            <i class='bx bx-error-circle'></i> 
                            <strong>{{ $pending_rooms }}</strong> rooms pending approval
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class='bx bx-check-circle'></i> No pending room approvals
                        </div>
                    @endif
                    
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary btn-sm">
                        <i class='bx bx-right-arrow-alt'></i> View All Rooms
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class='bx bx-user'></i> User Statistics</h5>
                </div>
                <div class="card-body">
                    <p><strong>Total Users:</strong> {{ $total_users ?? 0 }}</p>
                    <p><strong>Room Owners:</strong> {{ $total_owners ?? 0 }}</p>
                    <p><strong>Total Rooms:</strong> {{ $total_rooms ?? 0 }}</p>
                    
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">
                        <i class='bx bx-right-arrow-alt'></i> Manage Users
                    </a>
                </div>
            </div>
        </div>
    </div>
    
@endsection
