@extends('layouts.modern')
@section('title', $status == 'success' ? 'Booking Successful' : 'Booking Failed')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/booking-status.css') }}">
@endpush

@section('content')
<div class="status-container">
    <div class="container">
        <div class="status-card">
            @if($status == 'success')
                {{-- Success Status --}}
                <div class="status-icon-container success">
                    <i class='bx bx-check-circle'></i>
                </div>
                
                <h1 class="status-title success">Booking Successful! 🎉</h1>
                <p class="status-message">
                    Your booking has been confirmed successfully. Get ready for an amazing stay!
                </p>

                @if(session('message'))
                    <div class="status-alert warning">
                        <i class='bx bx-info-circle'></i>
                        <div>{{ session('message') }}</div>
                    </div>
                @else
                    <div class="status-alert success">
                        <i class='bx bx-check-shield'></i>
                        <div>Payment received! Confirmation email has been sent to your registered email address.</div>
                    </div>
                @endif

                {{-- Booking Info (if available from session) --}}
                @if(session('booking_details'))
                    <div class="status-info-card">
                        <div class="status-info-row">
                            <span class="status-info-label">
                                <i class='bx bx-id-card'></i>
                                Booking ID
                            </span>
                            <span class="status-info-value">{{ session('booking_details.id') }}</span>
                        </div>
                        <div class="status-info-row">
                            <span class="status-info-label">
                                <i class='bx bx-calendar'></i>
                                Check-in Date
                            </span>
                            <span class="status-info-value">{{ session('booking_details.checkin') }}</span>
                        </div>
                        <div class="status-info-row">
                            <span class="status-info-label">
                                <i class='bx bx-money'></i>
                                Amount Paid
                            </span>
                            <span class="status-info-value">₹{{ number_format(session('booking_details.amount')) }}</span>
                        </div>
                    </div>
                @endif

                <div class="status-actions">
                    <a href="{{ route('user.bookings.index') }}" class="status-btn status-btn-primary">
                        <i class='bx bx-list-ul'></i>
                        <span>View My Bookings</span>
                    </a>
                    <a href="{{ route('rooms') }}" class="status-btn status-btn-secondary">
                        <i class='bx bx-search'></i>
                        <span>Browse More Rooms</span>
                    </a>
                </div>

                <div class="countdown-timer" id="redirectTimer">
                    Redirecting to bookings in <span id="countdown">10</span> seconds...
                </div>

            @else
                {{-- Failure Status --}}
                <div class="status-icon-container fail">
                    <i class='bx bx-x-circle'></i>
                </div>
                
                <h1 class="status-title fail">Payment Failed</h1>
                <p class="status-message">
                    We couldn't process your payment. Please try again or contact support if the issue persists.
                </p>

                <div class="status-alert warning">
                    <i class='bx bx-error-circle'></i>
                    <div>
                        <strong>Common reasons for payment failure:</strong><br>
                        • Insufficient balance<br>
                        • Incorrect payment details<br>
                        • Bank server timeout<br>
                        • Network issues
                    </div>
                </div>

                <div class="status-actions">
                    <a href="{{ url()->previous() }}" class="status-btn status-btn-primary">
                        <i class='bx bx-refresh'></i>
                        <span>Try Again</span>
                    </a>
                    <a href="{{ route('rooms') }}" class="status-btn status-btn-secondary">
                        <i class='bx bx-search'></i>
                        <span>Browse Rooms</span>
                    </a>
                    <a href="{{ route('home') }}" class="status-btn status-btn-secondary">
                        <i class='bx bx-home'></i>
                        <span>Go Home</span>
                    </a>
                </div>

                <div class="status-alert info" style="margin-top: 2rem;">
                    <i class='bx bx-support'></i>
                    <div>
                        Need help? Contact our support team at <strong>support@roommitra.com</strong>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
@if($status == 'success')
// Auto redirect after 10 seconds
let countdown = 10;
const countdownEl = document.getElementById('countdown');
const timerEl = document.getElementById('redirectTimer');

const timer = setInterval(() => {
    countdown--;
    countdownEl.textContent = countdown;
    
    if (countdown <= 0) {
        clearInterval(timer);
        timerEl.innerHTML = '<i class="bx bx-loader-circle bx-spin"></i> Redirecting...';
        window.location.href = '{{ route('user.bookings.index') }}';
    }
}, 1000);

// Stop timer if user interacts with page
document.querySelectorAll('.status-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        clearInterval(timer);
        timerEl.style.display = 'none';
    });
});
@endif
</script>
@endpush
