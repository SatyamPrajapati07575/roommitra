@extends('layouts.admin')
@section('title', 'Manage Rooms')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Manage Rooms',
        'icon' => 'bx bxs-home'
    ])

    <div class="container-fluid">
        {{-- Quick Stats --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3>{{ $rooms->total() }}</h3>
                        <p class="mb-0">Total Rooms</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3>{{ $rooms->where('is_verified', false)->count() }}</h3>
                        <p class="mb-0">Pending Approval</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3>{{ $rooms->where('is_verified', true)->count() }}</h3>
                        <p class="mb-0">Approved</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h3>{{ $rooms->where('status', 'available')->count() }}</h3>
                        <p class="mb-0">Available</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card p-3 mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search by title, owner">
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option value="">All Cities</option>
                        <option>Noida</option>
                        <option>Delhi</option>
                        <option>Gurgaon</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option value="">All Status</option>
                        <option>Available</option>
                        <option>Booked</option>
                        <option>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option value="">Verification</option>
                        <option>Verified</option>
                        <option>Pending</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary w-100"><i class='bx bx-search'></i></button>
                </div>
            </div>
        </div>

        {{-- Rooms Table --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center table-bordered">
                    <thead class="thead-light">
                        <tr class="bg-light text-dark">
                            <th>ID</th>
                            <th>Title</th>
                            <th>Owner</th>
                            <th>Location</th>
                            <th>Rent</th>
                            <th>Posted</th>
                            <th>Status</th>
                            <th>Verified</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rooms as $room)
                            <tr>
                                <td>#{{ $room->room_id }}</td>
                                <td class="text-left">{{ Str::limit($room->room_title, 30) }}</td>
                                <td>{{ $room->owner ? $room->owner->full_name : 'N/A' }}</td>
                                <td>{{ $room->city }}, {{ $room->locality }}</td>
                                <td>₹{{ number_format($room->rent_amount) }}</td>
                                <td>{{ $room->created_at->format('d M, Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $room->status === 'available' ? 'success' : ($room->status === 'booked' ? 'warning' : 'secondary') }}">
                                        <i class='bx {{ $room->status === 'available' ? 'bx-check' : 'bx-time' }}'></i>
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($room->is_verified)
                                        <span class="badge bg-success"><i class='bx bx-check-circle'></i> Yes</span>
                                    @else
                                        <span class="badge bg-warning"><i class='bx bx-time'></i> Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.rooms.show', $room->room_id) }}" 
                                       class="btn btn-sm btn-outline-info" title="View Details">
                                        <i class='bx bx-show'></i>
                                    </a>
                                    @if(!$room->is_verified)
                                        <button class="btn btn-sm btn-outline-success approve-btn" 
                                                data-id="{{ $room->room_id }}" title="Approve">
                                            <i class='bx bx-check'></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class='bx bx-home-circle' style="font-size: 3rem;"></i>
                                    <p class="mt-2">No rooms found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-3">
                {{ $rooms->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Approve room functionality
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function() {
            const roomId = this.getAttribute('data-id');
            
            if(confirm('Are you sure you want to approve this room?')) {
                fetch(`/admin/rooms/${roomId}/approve`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Room approved successfully'
                    });
                    setTimeout(() => location.reload(), 1000);
                })
                .catch(error => {
                    Toast.fire({
                        icon: 'error',
                        title: 'Failed to approve room'
                    });
                });
            }
        });
    });
});
</script>
@endpush
