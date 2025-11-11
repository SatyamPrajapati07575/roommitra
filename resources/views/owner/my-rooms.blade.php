@extends('layouts.owner')
@section('title', 'My Rooms')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/owner-rooms.css') }}">
<link rel="stylesheet" href="{{ asset('css/owner-rooms-dropdown.css') }}">
@endpush

@section('content')

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1"><i class='bx bx-home-alt'></i> My Rooms</h3>
            <p class="text-muted mb-0">Manage your listed rooms</p>
        </div>
        <a href="{{ route('owner.rooms.create') }}" class="btn btn-primary">
            <i class='bx bx-plus-circle'></i> Add New Room
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon primary text-white">
                            <i class='bx bx-home-heart'></i>
                        </div>
                        <div class="stats-content">
                            <h6>Total Rooms</h6>
                            <h3>{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon warning text-white">
                            <i class='bx bx-time-five'></i>
                        </div>
                        <div class="stats-content">
                            <h6>Pending</h6>
                            <h3>{{ $stats['pending'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon success text-white">
                            <i class='bx bx-check-circle'></i>
                        </div>
                        <div class="stats-content">
                            <h6>Available</h6>
                            <h3>{{ $stats['available'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon info text-white">
                            <i class='bx bx-calendar-check'></i>
                        </div>
                        <div class="stats-content">
                            <h6>Booked</h6>
                            <h3>{{ $stats['booked'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('owner.rooms.index') }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class='bx bx-search'></i></span>
                            <input type="text" class="form-control" placeholder="Search by room title" 
                                   name="search" value="{{ request('search') }}" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" name="status">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏱️ Pending</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>✅ Available</option>
                            <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>📅 Booked</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>⚫ Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class='bx bx-filter'></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Rooms List -->
    <div class="card rooms-table-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Room</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Bookings</th>
                            <th class="text-center pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rooms as $room)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            @if ($room->images->isNotEmpty())
                                                <img src="{{ asset($room->images->first()->image_url) }}" 
                                                     alt="{{ $room->room_title }}" 
                                                     class="room-image">
                                            @else
                                                <div class="room-image-placeholder">
                                                    <i class='bx bx-image'></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-4">
                                            <h6 class="mb-0">
                                                <a href="{{ route('owner.rooms.show', $room->slug) }}" 
                                                   class="room-title-link">
                                                    {{ $room->room_title }}
                                                </a>
                                            </h6>
                                            @if($room->room_number)
                                                <small class="room-number">Room #{{ $room->room_number }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="location-text">
                                        <i class='bx bx-map'></i> {{ $room->city }}, {{ $room->state }}
                                    </div>
                                    <small class="locality-text">{{ $room->locality }}</small>
                                </td>
                                <td>
                                    <strong class="price-amount">₹{{ number_format($room->room_price) }}</strong>
                                    <small class="price-period">/month</small>
                                </td>
                                <td>
                                    <div class="capacity-text">
                                        <i class='bx bx-user'></i> {{ $room->room_capacity }} 
                                        <small class="text-muted">persons</small>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'pending' => ['class' => 'warning', 'icon' => 'bx-time-five'],
                                            'available' => ['class' => 'success', 'icon' => 'bx-check-circle'],
                                            'booked' => ['class' => 'info', 'icon' => 'bx-calendar-check'],
                                            'inactive' => ['class' => 'secondary', 'icon' => 'bx-x-circle'],
                                        ];
                                        $config = $statusConfig[$room->status] ?? ['class' => 'secondary', 'icon' => 'bx-help-circle'];
                                    @endphp
                                    <button class="badge badge-{{ $config['class'] }} status-badge-trigger" 
                                            type="button"
                                            data-modal-target="#statusModal{{ $room->room_id }}"
                                            style="border: none; cursor: pointer; font-size: 0.9rem; padding: 0.35rem 0.65rem;">
                                        <i class='bx {{ $config['icon'] }}'></i> {{ ucfirst($room->status) }}
                                    </button>
                                </td>
                                <td>
                                    <span class="booking-count">
                                        {{ $room->bookings->count() }} bookings
                                    </span>
                                </td>
                                <td class="text-center pe-4 action-buttons">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('owner.rooms.show', $room->slug) }}" 
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class='bx bx-show'></i>
                                        </a>
                                        <a href="{{ route('owner.rooms.edit', $room->slug) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                        <form action="{{ route('owner.rooms.destroy', $room->slug) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this room?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class='bx bx-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <i class='bx bx-home-smile'></i>
                                    <p class="mt-2 mb-3">No rooms found</p>
                                    <a href="{{ route('owner.rooms.create') }}" class="btn btn-primary">
                                        <i class='bx bx-plus-circle'></i> Add Your First Room
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($rooms->hasPages())
            <div class="card-footer bg-white border-top">
                <div class="d-flex justify-content-center">
                    {{ $rooms->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>

    {{-- All Status Change Modals --}}
    @foreach($rooms as $room)
        @php
            $statusConfig = [
                'pending' => ['class' => 'warning', 'icon' => 'bx-time-five'],
                'available' => ['class' => 'success', 'icon' => 'bx-check-circle'],
                'booked' => ['class' => 'info', 'icon' => 'bx-calendar-check'],
                'inactive' => ['class' => 'secondary', 'icon' => 'bx-x-circle'],
            ];
            $config = $statusConfig[$room->status] ?? ['class' => 'secondary', 'icon' => 'bx-help-circle'];
        @endphp
        
        <div class="modal fade" id="statusModal{{ $room->room_id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class='bx bx-edit'></i> Change Room Status
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Room:</strong> {{ $room->room_title }}</p>
                        <p><strong>Current Status:</strong> 
                            <span class="badge badge-{{ $config['class'] }}">
                                <i class='bx {{ $config['icon'] }}'></i> {{ ucfirst($room->status) }}
                            </span>
                        </p>
                        <hr>
                        <p>Select new status:</p>
                        <div class="status-options">
                            @foreach(['available', 'booked', 'inactive'] as $statusOption)
                                @if($statusOption !== $room->status)
                                    <form action="{{ route('owner.rooms.update-status', $room->slug) }}" 
                                          method="POST" class="d-inline-block mb-2 w-100">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $statusOption }}">
                                        <button type="submit" class="btn btn-{{ $statusConfig[$statusOption]['class'] }} btn-block">
                                            <i class='bx {{ $statusConfig[$statusOption]['icon'] }}'></i> 
                                            Set as {{ ucfirst($statusOption) }}
                                        </button>
                                    </form>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Simple: One modal at a time
    $('.status-badge-trigger').on('click', function(e) {
        e.preventDefault();
        
        // Close any open modals
        $('.modal').modal('hide');
        
        // Get target modal
        var targetModal = $(this).data('modal-target');
        
        // Open the target modal
        setTimeout(function() {
            $(targetModal).modal('show');
        }, 100);
    });
    
    // Cleanup on modal close
    $('.modal').on('hidden.bs.modal', function() {
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open').css('padding-right', '');
    });
});
</script>
@endpush
