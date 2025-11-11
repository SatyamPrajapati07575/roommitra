@extends('layouts.admin')
@section('title', 'Manage Bookings')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Manage Bookings',
        'icon' => 'bx bxs-calendar-check'
    ])

    <div class="container-fluid">
        {{-- Quick Stats --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3>{{ $bookings->total() }}</h3>
                        <p class="mb-0">Total Bookings</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3>{{ $bookings->where('status', 'pending')->count() }}</h3>
                        <p class="mb-0">Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3>{{ $bookings->where('status', 'confirmed')->count() }}</h3>
                        <p class="mb-0">Confirmed</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h3>{{ $bookings->where('status', 'cancelled')->count() }}</h3>
                        <p class="mb-0">Cancelled</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card p-3 mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search by User or Room">
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option value="">All Status</option>
                        <option>Pending</option>
                        <option>Confirmed</option>
                        <option>Completed</option>
                        <option>Cancelled</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" placeholder="From Date">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" placeholder="To Date">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary w-100"><i class='bx bx-search'></i></button>
                </div>
            </div>
        </div>

        {{-- Bookings Table --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center table-bordered">
                    <thead class="thead-light">
                        <tr class="bg-light text-dark">
                            <th>ID</th>
                            <th>User</th>
                            <th>Room</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Booked On</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr>
                                <td>#{{ $booking->booking_id }}</td>
                                <td>{{ $booking->user ? $booking->user->full_name : 'N/A' }}</td>
                                <td class="text-left">{{ $booking->room ? Str::limit($booking->room->room_title, 25) : 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M, Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M, Y') }}</td>
                                <td>₹{{ number_format($booking->total_amount) }}</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $booking->status === 'confirmed' ? 'success' : 
                                        ($booking->status === 'pending' ? 'warning' : 
                                        ($booking->status === 'cancelled' ? 'danger' : 'info'))
                                    }}">
                                        <i class='bx {{ 
                                            $booking->status === 'confirmed' ? 'bx-check-circle' : 
                                            ($booking->status === 'pending' ? 'bx-time' : 
                                            ($booking->status === 'cancelled' ? 'bx-x-circle' : 'bx-info-circle'))
                                        }}'></i>
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>{{ $booking->created_at->format('d M, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info view-booking-btn" 
                                            data-id="{{ $booking->booking_id }}" title="View Details">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class='bx bx-calendar-x' style="font-size: 3rem;"></i>
                                    <p class="mt-2">No bookings found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-3">
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View booking details
    document.querySelectorAll('.view-booking-btn').forEach(button => {
        button.addEventListener('click', function() {
            const bookingId = this.getAttribute('data-id');
            
            Toast.fire({
                icon: 'info',
                title: 'Booking details coming soon'
            });
        });
    });
});
</script>
@endpush
