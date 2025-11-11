@extends('layouts.user-dashboard')
@section('title', 'My Bookings')

@push('styles')
<style>
    .booking-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        margin-bottom: 1.5rem;
    }
    
    .booking-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
        transform: translateY(-2px);
    }
    
    .booking-status-badge {
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-confirmed {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #b45309;
    }
    
    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .status-completed {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .payment-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-md);
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .payment-paid {
        background: #d1fae5;
        color: #065f46;
    }
    
    .payment-pending {
        background: #fef3c7;
        color: #b45309;
    }
    
    .room-image {
        width: 120px;
        height: 100px;
        object-fit: cover;
        border-radius: var(--radius-md);
    }
    
    .booking-detail-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-light);
    }
    
    .booking-detail-item:last-child {
        border-bottom: none;
    }
    
    .booking-detail-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-light);
        border-radius: var(--radius-md);
        color: var(--brand-primary);
        font-size: 1.25rem;
    }
    
    .booking-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .empty-state-icon {
        font-size: 5rem;
        color: var(--text-muted);
        opacity: 0.3;
    }
    
    @media (max-width: 768px) {
        .room-image {
            width: 80px;
            height: 70px;
        }
        
        .booking-actions {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
    {{-- Page Header --}}
    <div class="mb-4" data-aos="fade-down">
        <h1 class="h2" style="font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 0.75rem;">
            <i class='bx bx-calendar-check' style="color: var(--brand-primary);"></i>
            My Bookings
        </h1>
        <p style="color: var(--text-muted); margin: 0;">Track and manage all your room bookings</p>
    </div>

    @if($bookings->count() > 0)
        @foreach($bookings as $booking)
            <div class="booking-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                <div class="row align-items-center">
                    {{-- Room Image --}}
                    <div class="col-md-2 col-12 mb-3 mb-md-0">
                        @if($booking->room && $booking->room->images && $booking->room->images->count() > 0)
                            <img src="{{ asset($booking->room->images->first()->image_url) }}" 
                                 alt="{{ $booking->room->room_title }}" 
                                 class="room-image">
                        @else
                            <div class="room-image" style="background: var(--bg-light); display: flex; align-items: center; justify-content: center;">
                                <i class='bx bx-image' style="font-size: 2rem; color: var(--text-muted);"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Booking Details --}}
                    <div class="col-md-7 col-12">
                        <h4 style="font-weight: 700; margin-bottom: 0.5rem;">
                            {{ $booking->room->room_title ?? 'Room Not Found' }}
                        </h4>
                        
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 0.75rem;">
                            <span class="booking-status-badge status-{{ strtolower($booking->status) }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                            <span class="payment-status payment-{{ strtolower($booking->payment_status) }}">
                                <i class='bx {{ $booking->payment_status == "paid" ? "bx-check-circle" : "bx-time-five" }}'></i>
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.5rem; font-size: 0.9rem; color: var(--text-secondary);">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class='bx bx-calendar' style="color: var(--brand-primary);"></i>
                                <span><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M, Y') }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class='bx bx-calendar-x' style="color: var(--error-color);"></i>
                                <span><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M, Y') }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class='bx bx-rupee' style="color: var(--success-color);"></i>
                                <span><strong>Amount:</strong> ₹{{ number_format($booking->total_amount, 0) }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class='bx bx-receipt' style="color: var(--info-color);"></i>
                                <span><strong>Booking ID:</strong> #{{ $booking->booking_id }}</span>
                            </div>
                        </div>

                        @if($booking->transaction_id)
                            <div style="margin-top: 0.5rem; font-size: 0.85rem; color: var(--text-muted);">
                                <i class='bx bx-transfer'></i>
                                <strong>Transaction:</strong> {{ $booking->transaction_id }}
                            </div>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="col-md-3 col-12 text-md-end">
                        <div class="booking-actions justify-content-md-end">
                            @if($booking->room)
                                <a href="{{ route('room.show', $booking->room->slug ?? $booking->room->room_id) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class='bx bx-show'></i> View Room
                                </a>
                            @endif
                            
                            @if($booking->status == 'confirmed' && $booking->payment_status == 'paid')
                                <button class="btn btn-sm btn-outline-success" disabled>
                                    <i class='bx bx-check-circle'></i> Active
                                </button>
                            @elseif($booking->status == 'pending')
                                <button class="btn btn-sm btn-outline-warning">
                                    <i class='bx bx-time-five'></i> Pending
                                </button>
                            @endif
                        </div>
                        
                        <div style="margin-top: 0.75rem; font-size: 0.85rem; color: var(--text-muted);">
                            <i class='bx bx-time'></i>
                            Booked {{ $booking->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                {{-- Owner Details (Expandable) --}}
                @if($booking->room && $booking->room->owner)
                    <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-light);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--brand-gradient); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                {{ substr($booking->room->owner->full_name, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--text-primary);">
                                    {{ $booking->room->owner->full_name }}
                                </div>
                                <div style="font-size: 0.85rem; color: var(--text-muted);">
                                    <i class='bx bx-phone'></i> {{ $booking->room->owner->phone ?? 'N/A' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach

        {{-- Summary Stats --}}
        <div class="row g-3 mt-4">
            <div class="col-md-3 col-6">
                <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.5rem; border-radius: var(--radius-lg); color: white; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 700;">{{ $bookings->count() }}</div>
                    <div style="font-size: 0.9rem; opacity: 0.9;">Total Bookings</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 1.5rem; border-radius: var(--radius-lg); color: white; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 700;">{{ $bookings->where('status', 'confirmed')->count() }}</div>
                    <div style="font-size: 0.9rem; opacity: 0.9;">Confirmed</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 1.5rem; border-radius: var(--radius-lg); color: white; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 700;">{{ $bookings->where('payment_status', 'paid')->count() }}</div>
                    <div style="font-size: 0.9rem; opacity: 0.9;">Paid</div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); padding: 1.5rem; border-radius: var(--radius-lg); color: white; text-align: center;">
                    <div style="font-size: 2rem; font-weight: 700;">₹{{ number_format($bookings->sum('total_amount'), 0) }}</div>
                    <div style="font-size: 0.9rem; opacity: 0.9;">Total Spent</div>
                </div>
            </div>
        </div>
    @else
        {{-- Empty State --}}
        <div class="empty-state" data-aos="fade-up">
            <i class='bx bx-calendar-x empty-state-icon'></i>
            <h3 style="color: var(--text-primary); margin-top: 1rem;">No Bookings Yet</h3>
            <p style="color: var(--text-muted); max-width: 400px; margin: 1rem auto;">
                You haven't made any bookings yet. Start exploring rooms and book your perfect stay!
            </p>
            <a href="{{ route('rooms') }}" class="btn btn-primary mt-3" style="padding: 0.75rem 2rem;">
                <i class='bx bx-search-alt'></i> Browse Rooms
            </a>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    // Show success message if present
    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            background: '#d1fae5',
            color: '#065f46',
            iconColor: '#10b981'
        });
    @endif

    // Show error messages if present
    @if(session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}',
            background: '#fee2e2',
            color: '#991b1b',
            iconColor: '#ef4444'
        });
    @endif
</script>
@endpush
