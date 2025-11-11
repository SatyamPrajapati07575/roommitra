@extends('layouts.owner')
@section('title', 'Owner Dashboard')

@section('content')
    {{-- Page Header --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class='bx bxs-dashboard'></i> Owner Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            {{-- Room Stats --}}
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $total_rooms }}</h3>
                            <p>Total Rooms</p>
                        </div>
                        <div class="icon">
                            <i class='bx bxs-home'></i>
                        </div>
                        <a href="{{ route('owner.rooms.index') }}" class="small-box-footer">
                            View All <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $available_rooms }}</h3>
                            <p>Available Rooms</p>
                        </div>
                        <div class="icon">
                            <i class='bx bx-check-circle'></i>
                        </div>
                        <a href="{{ route('owner.rooms.index') }}" class="small-box-footer">
                            Manage <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $pending_rooms }}</h3>
                            <p>Pending Approval</p>
                        </div>
                        <div class="icon">
                            <i class='bx bx-time'></i>
                        </div>
                        <a href="{{ route('owner.rooms.index') }}" class="small-box-footer">
                            Check Status <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $booked_rooms }}</h3>
                            <p>Booked Rooms</p>
                        </div>
                        <div class="icon">
                            <i class='bx bx-calendar'></i>
                        </div>
                        <a href="{{ route('owner.rooms.index') }}" class="small-box-footer">
                            Details <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Booking Stats --}}
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $total_bookings }}</h3>
                            <p>Total Bookings</p>
                        </div>
                        <div class="icon">
                            <i class='bx bx-calendar-check'></i>
                        </div>
                        <a href="{{ route('owner.bookings.index') }}" class="small-box-footer">
                            View All <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $confirmed_bookings }}</h3>
                            <p>Confirmed</p>
                        </div>
                        <div class="icon">
                            <i class='bx bx-check-double'></i>
                        </div>
                        <a href="{{ route('owner.bookings.index') }}" class="small-box-footer">
                            Manage <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>₹{{ number_format($this_month_earnings) }}</h3>
                            <p>This Month Earnings</p>
                        </div>
                        <div class="icon">
                            <i class='bx bx-wallet'></i>
                        </div>
                        <a href="{{ route('owner.payments.index') }}" class="small-box-footer">
                            View Payments <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>₹{{ number_format($total_earnings) }}</h3>
                            <p>Total Earnings</p>
                        </div>
                        <div class="icon">
                            <i class='bx bx-money'></i>
                        </div>
                        <a href="{{ route('owner.payments.index') }}" class="small-box-footer">
                            Details <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
            </div>
            {{-- Quick Actions --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class='bx bx-cog'></i> Quick Actions</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('owner.rooms.create') }}" class="btn btn-success btn-block">
                                        <i class='bx bx-plus-circle'></i> Add New Room
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('owner.rooms.index') }}" class="btn btn-info btn-block">
                                        <i class='bx bx-building'></i> Manage Rooms
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('owner.bookings.index') }}" class="btn btn-warning btn-block">
                                        <i class='bx bx-calendar'></i> View Bookings
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="{{ route('owner.payments.index') }}" class="btn btn-primary btn-block">
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
                {{-- Recent Rooms --}}
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class='bx bx-home'></i> Recent Rooms</h3>
                        </div>
                        <div class="card-body p-0">
                            @if($recent_rooms && $recent_rooms->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($recent_rooms as $room)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $room->room_title }}</strong><br>
                                        <small class="text-muted">
                                            <i class='bx bx-money'></i> ₹{{ number_format($room->room_price) }}/month
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ 
                                        $room->status === 'available' ? 'success' : 
                                        ($room->status === 'pending' ? 'warning' : 
                                        ($room->status === 'booked' ? 'info' : 'secondary'))
                                    }}">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-center text-muted p-4">
                                <i class='bx bx-info-circle'></i> No rooms yet. <a href="{{ route('owner.rooms.create') }}">Add your first room!</a>
                            </p>
                            @endif
                        </div>
                        @if($recent_rooms && $recent_rooms->count() > 0)
                        <div class="card-footer">
                            <a href="{{ route('owner.rooms.index') }}" class="btn btn-sm btn-primary">
                                <i class='bx bx-right-arrow-alt'></i> View All Rooms
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Recent Bookings --}}
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class='bx bx-calendar-check'></i> Recent Bookings</h3>
                        </div>
                        <div class="card-body p-0">
                            @if($recent_bookings && $recent_bookings->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($recent_bookings as $booking)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <strong>{{ $booking->room ? $booking->room->room_title : 'N/A' }}</strong><br>
                                            <small class="text-muted">
                                                <i class='bx bx-user'></i> {{ $booking->user ? $booking->user->full_name : 'N/A' }}
                                            </small><br>
                                            <small class="text-muted">
                                                <i class='bx bx-calendar'></i> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M, Y') }}
                                            </small>
                                        </div>
                                        <span class="badge bg-{{ 
                                            $booking->status === 'confirmed' ? 'success' : 
                                            ($booking->status === 'pending' ? 'warning' : 
                                            ($booking->status === 'cancelled' ? 'danger' : 'info'))
                                        }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <p class="text-center text-muted p-4">
                                <i class='bx bx-info-circle'></i> No bookings yet.
                            </p>
                            @endif
                        </div>
                        @if($recent_bookings && $recent_bookings->count() > 0)
                        <div class="card-footer">
                            <a href="{{ route('owner.bookings.index') }}" class="btn btn-sm btn-primary">
                                <i class='bx bx-right-arrow-alt'></i> View All Bookings
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
