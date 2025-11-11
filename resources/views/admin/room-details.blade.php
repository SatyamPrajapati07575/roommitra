@extends('layouts.admin')
@section('title', 'Room Details')

@section('content')
    {{-- Page Header --}}
    @include('admin.partials.page-header', [
        'title' => 'Room Details',
        'icon' => 'bx bxs-door-open'
    ])

    <div class="row">
        {{-- Main Room Info --}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class='bx bx-info-circle'></i> Room Information
                    </h5>
                    <span class="badge bg-{{ 
                        $room->status === 'available' ? 'success' : 
                        ($room->status === 'pending' ? 'warning' : 
                        ($room->status === 'booked' ? 'info' : 'secondary'))
                    }}">
                        <i class='bx bx-{{ 
                            $room->status === 'available' ? 'check-circle' : 
                            ($room->status === 'pending' ? 'time' : 
                            ($room->status === 'booked' ? 'calendar' : 'x-circle'))
                        }}'></i>
                        {{ ucfirst($room->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-2"><strong><i class='bx bx-hash'></i> Room Number:</strong></p>
                            <p class="text-muted">{{ $room->room_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong><i class='bx bx-home'></i> Room Title:</strong></p>
                            <p class="text-muted">{{ $room->room_title }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-2"><strong><i class='bx bx-detail'></i> Description:</strong></p>
                            <p class="text-muted">{{ $room->room_description ?? 'No description available' }}</p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3"><i class='bx bx-money'></i> Pricing Details</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p class="mb-2"><strong>Monthly Rent:</strong></p>
                            <h5 class="text-success">₹{{ number_format($room->room_price) }}</h5>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-2"><strong>Security Deposit:</strong></p>
                            <h5 class="text-info">₹{{ number_format($room->security_deposit) }}</h5>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-2"><strong>Min Stay:</strong></p>
                            <h5 class="text-primary">{{ $room->min_stay_months }} Month(s)</h5>
                        </div>
                    </div>

                    @if($room->sharing_prices && is_array($room->sharing_prices) && count($room->sharing_prices) > 0)
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="mb-2"><strong><i class='bx bx-group'></i> Sharing Prices:</strong></p>
                            <div class="d-flex gap-2 flex-wrap">
                                @foreach($room->sharing_prices as $type => $price)
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($type) }}: ₹{{ number_format($price) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <hr>

                    <h6 class="mb-3"><i class='bx bx-bed'></i> Room Specifications</h6>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Capacity:</strong> {{ $room->room_capacity }} Person(s)</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Total Beds:</strong> {{ $room->total_beds }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Floor:</strong> {{ $room->floor ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Bathroom:</strong> {{ ucfirst($room->bathroom_type) }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Kitchen:</strong> {{ $room->kitchen ? 'Yes (' . ucfirst($room->kitchen_type) . ')' : 'No' }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="mb-1"><strong>Verified:</strong> 
                                <span class="badge bg-{{ $room->is_verified ? 'success' : 'warning' }}">
                                    {{ $room->is_verified ? 'Yes' : 'No' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3"><i class='bx bx-star'></i> Amenities</h6>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <span class="badge bg-{{ $room->ac ? 'success' : 'secondary' }}">
                                <i class='bx bx-wind'></i> AC: {{ $room->ac ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div class="col-md-3 mb-2">
                            <span class="badge bg-{{ $room->lift ? 'success' : 'secondary' }}">
                                <i class='bx bx-up-arrow-circle'></i> Lift: {{ $room->lift ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div class="col-md-3 mb-2">
                            <span class="badge bg-{{ $room->parking ? 'success' : 'secondary' }}">
                                <i class='bx bx-car'></i> Parking: {{ $room->parking ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>

                    @if($room->amenities && $room->amenities->count() > 0)
                    <div class="mt-3">
                        <p class="mb-2"><strong>Additional Amenities:</strong></p>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach($room->amenities as $amenity)
                                <span class="badge bg-info">
                                    <i class='bx bx-check'></i> {{ $amenity->amenity_name ?? 'N/A' }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <hr>

                    <h6 class="mb-3"><i class='bx bx-map'></i> Location Details</h6>
                    <div class="row mb-2">
                        <div class="col-12">
                            <p class="mb-1"><strong>Address Line 1:</strong> {{ $room->address_line1 }}</p>
                            @if($room->address_line2)
                            <p class="mb-1"><strong>Address Line 2:</strong> {{ $room->address_line2 }}</p>
                            @endif
                            <p class="mb-1"><strong>Locality:</strong> {{ $room->locality }}</p>
                            <p class="mb-1"><strong>City:</strong> {{ $room->city }}</p>
                            <p class="mb-1"><strong>State:</strong> {{ $room->state }}</p>
                            <p class="mb-1"><strong>Pincode:</strong> {{ $room->pincode }}</p>
                            @if($room->nearby_landmarks)
                            <p class="mb-1"><strong>Nearby Landmarks:</strong> {{ $room->nearby_landmarks }}</p>
                            @endif
                        </div>
                    </div>

                    @if($room->restrictions)
                    <hr>
                    <h6 class="mb-3"><i class='bx bx-error-circle'></i> Restrictions</h6>
                    <p class="text-muted">{{ $room->restrictions }}</p>
                    @endif
                </div>
            </div>

            {{-- Room Images --}}
            @if($room->images && $room->images->count() > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class='bx bx-images'></i> Room Images</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($room->images as $image)
                        <div class="col-md-4 mb-3">
                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                 alt="Room Image" 
                                 class="img-fluid rounded shadow-sm"
                                 style="height: 200px; object-fit: cover; width: 100%;">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar Info --}}
        <div class="col-lg-4">
            {{-- Owner Details --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class='bx bx-user'></i> Owner Details</h5>
                </div>
                <div class="card-body">
                    @if($room->owner)
                    <div class="text-center mb-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($room->owner->full_name) }}&background=6366f1&color=fff&bold=true" 
                             alt="Owner" 
                             class="rounded-circle mb-2" 
                             width="80" height="80">
                        <h6 class="mb-1">{{ $room->owner->full_name }}</h6>
                        <small class="text-muted">Room Owner</small>
                    </div>
                    <hr>
                    <p class="mb-2">
                        <i class='bx bx-envelope'></i> 
                        <strong>Email:</strong><br>
                        <small>{{ $room->owner->email }}</small>
                    </p>
                    @if($room->owner->phone)
                    <p class="mb-2">
                        <i class='bx bx-phone'></i> 
                        <strong>Phone:</strong><br>
                        <small>{{ $room->owner->phone }}</small>
                    </p>
                    @endif
                    <p class="mb-0">
                        <i class='bx bx-check-circle'></i> 
                        <strong>Verified:</strong> 
                        <span class="badge bg-{{ $room->owner->is_verified ? 'success' : 'warning' }}">
                            {{ $room->owner->is_verified ? 'Yes' : 'No' }}
                        </span>
                    </p>
                    @else
                    <p class="text-muted text-center">Owner information not available</p>
                    @endif
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class='bx bx-cog'></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    @if($room->status === 'pending')
                    <button class="btn btn-success btn-block mb-2" onclick="approveRoom({{ $room->room_id }})">
                        <i class='bx bx-check-circle'></i> Approve Room
                    </button>
                    <button class="btn btn-danger btn-block mb-2" onclick="rejectRoom({{ $room->room_id }})">
                        <i class='bx bx-x-circle'></i> Reject Room
                    </button>
                    @endif
                    
                    @if(!$room->is_verified)
                    <button class="btn btn-info btn-block mb-2" onclick="verifyRoom({{ $room->room_id }})">
                        <i class='bx bx-check-shield'></i> Mark as Verified
                    </button>
                    @endif

                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary btn-block">
                        <i class='bx bx-arrow-back'></i> Back to Rooms
                    </a>
                </div>
            </div>

            {{-- Stats Card --}}
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class='bx bx-bar-chart'></i> Room Stats</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Total Bookings:</strong> 
                        <span class="badge bg-primary">{{ $room->bookings ? $room->bookings->count() : 0 }}</span>
                    </p>
                    <p class="mb-2">
                        <strong>Total Reviews:</strong> 
                        <span class="badge bg-info">{{ $room->reviews ? $room->reviews->count() : 0 }}</span>
                    </p>
                    <p class="mb-2">
                        <strong>Wishlisted:</strong> 
                        <span class="badge bg-warning">{{ $room->wishlists ? $room->wishlists->count() : 0 }}</span>
                    </p>
                    <p class="mb-0">
                        <strong>Created:</strong><br>
                        <small class="text-muted">{{ $room->created_at->format('d M, Y') }}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function approveRoom(roomId) {
        Swal.fire({
            title: 'Approve Room?',
            text: 'This room will be available for booking',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Approve',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/rooms/${roomId}/approve`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Approved!',
                            text: data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            location.reload();
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to approve room'
                    });
                });
            }
        });
    }

    function rejectRoom(roomId) {
        Swal.fire({
            title: 'Reject Room?',
            text: 'This room will be marked as inactive',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Reject',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Add reject endpoint if needed
                Swal.fire('Feature coming soon!', 'Reject functionality will be implemented', 'info');
            }
        });
    }

    function verifyRoom(roomId) {
        Swal.fire({
            title: 'Verify Room?',
            text: 'Mark this room as verified',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#17a2b8',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Verify',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Add verify endpoint if needed
                Swal.fire('Feature coming soon!', 'Verify functionality will be implemented', 'info');
            }
        });
    }
</script>
@endpush
