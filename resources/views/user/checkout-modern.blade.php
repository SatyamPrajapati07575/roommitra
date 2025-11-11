@extends('layouts.modern')
@section('title', 'Checkout - ' . $room->room_title)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/checkout-modern.css') }}">
@endpush

@section('content')
<div class="checkout-container">
    <div class="container">
        {{-- Header --}}
        <div class="checkout-header" data-aos="fade-down">
            <h1><i class='bx bx-calendar-check'></i> Complete Your Booking</h1>
            <p>Just a few steps away from your perfect stay!</p>
        </div>

        <div class="row g-4">
            {{-- Left Column - Booking Details --}}
            <div class="col-lg-7">
                {{-- Room Summary Card --}}
                <div class="modern-card" data-aos="fade-right">
                    <div class="modern-card-header">
                        <div class="modern-card-icon">
                            <i class='bx bx-home-smile'></i>
                        </div>
                        <h2 class="modern-card-title">Room Details</h2>
                    </div>
                    
                    @if($room->images && $room->images->count() > 0)
                        <img src="{{ asset($room->images->first()->image_url) }}" 
                             alt="{{ $room->room_title }}" 
                             class="room-image-banner">
                    @endif
                    
                    <h3 class="room-title-checkout">{{ $room->room_title }}</h3>
                    <div class="room-location">
                        <i class='bx bx-map'></i>
                        <span>{{ ucwords($room->locality) }}, {{ ucwords($room->city) }}</span>
                    </div>

                    @if($room->amenities && $room->amenities->count() > 0)
                        <div class="amenity-list">
                            @foreach($room->amenities->take(6) as $amenity)
                                <span class="amenity-pill {{ $amenity->status == 'paid' ? 'paid' : '' }}">
                                    <i class='bx bx-check-circle'></i>
                                    {{ $amenity->amenity_name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Booking Information Form --}}
                <div class="modern-card" data-aos="fade-right" data-aos-delay="100">
                    <div class="modern-card-header">
                        <div class="modern-card-icon">
                            <i class='bx bx-calendar'></i>
                        </div>
                        <h2 class="modern-card-title">Booking Information</h2>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class='bx bx-time'></i> Stay Duration
                                </label>
                                <select class="form-control-modern" id="stayMonths">
                                    @for ($i = $room->min_stay_months; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }} Month{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class='bx bx-user'></i> Occupancy
                                </label>
                                <select class="form-control-modern" id="occupancySelect">
                                    @for ($i = 1; $i <= $room->room_capacity; $i++)
                                        <option value="{{ $i }}">{{ $i }} Person{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class='bx bx-calendar-check'></i> Check-in Date
                                </label>
                                <input type="date" 
                                       class="form-control-modern" 
                                       id="checkinDate" 
                                       min="{{ date('Y-m-d') }}"
                                       required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group-modern">
                                <label class="form-label-modern">
                                    <i class='bx bx-calendar-x'></i> Check-out Date
                                </label>
                                <input type="date" 
                                       class="form-control-modern" 
                                       id="checkoutDate" 
                                       readonly>
                            </div>
                        </div>
                    </div>

                    <div class="info-badge">
                        <i class='bx bx-info-circle'></i>
                        Minimum stay: {{ $room->min_stay_months }} {{ $room->min_stay_months > 1 ? 'months' : 'month' }}
                    </div>
                </div>

                {{-- Payment Options --}}
                <div class="modern-card" data-aos="fade-right" data-aos-delay="100">
                    <div class="modern-card-header">
                        <div class="modern-card-icon">
                            <i class='bx bx-wallet'></i>
                        </div>
                        <h2 class="modern-card-title">Payment Options</h2>
                    </div>

                    <div class="row g-3">
                        {{-- Payment Frequency --}}
                        <div class="col-12">
                            <label class="form-label-modern">
                                <i class='bx bx-money'></i> Payment Frequency
                            </label>
                            <div class="payment-option-grid">
                                <label class="payment-option-card active" data-value="full">
                                    <input type="radio" name="payment_frequency" value="full" checked>
                                    <div class="payment-option-content">
                                        <i class='bx bx-wallet-alt'></i>
                                        <div>
                                            <div class="payment-option-title">Pay Full Amount</div>
                                            <div class="payment-option-desc">One-time payment for entire duration</div>
                                        </div>
                                    </div>
                                    <div class="payment-option-check"><i class='bx bx-check-circle'></i></div>
                                </label>
                                
                                <label class="payment-option-card" data-value="monthly">
                                    <input type="radio" name="payment_frequency" value="monthly">
                                    <div class="payment-option-content">
                                        <i class='bx bx-calendar-event'></i>
                                        <div>
                                            <div class="payment-option-title">Pay Monthly</div>
                                            <div class="payment-option-desc">Pay rent every month</div>
                                        </div>
                                    </div>
                                    <div class="payment-option-check"><i class='bx bx-check-circle'></i></div>
                                </label>
                            </div>
                        </div>

                        {{-- Payment Type --}}
                        <div class="col-12">
                            <label class="form-label-modern">
                                <i class='bx bx-credit-card'></i> Payment Method
                            </label>
                            <div class="payment-option-grid">
                                <label class="payment-option-card active" data-value="online">
                                    <input type="radio" name="payment_type" value="online" checked>
                                    <div class="payment-option-content">
                                        <i class='bx bx-credit-card'></i>
                                        <div>
                                            <div class="payment-option-title">Online Payment</div>
                                            <div class="payment-option-desc">UPI, Card, Net Banking</div>
                                        </div>
                                    </div>
                                    <div class="payment-option-check"><i class='bx bx-check-circle'></i></div>
                                </label>
                                
                                <label class="payment-option-card" data-value="offline">
                                    <input type="radio" name="payment_type" value="offline">
                                    <div class="payment-option-content">
                                        <i class='bx bx-store'></i>
                                        <div>
                                            <div class="payment-option-title">Pay to Owner</div>
                                            <div class="payment-option-desc">Direct payment to owner</div>
                                        </div>
                                    </div>
                                    <div class="payment-option-check"><i class='bx bx-check-circle'></i></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="info-badge" style="margin-top: 1rem;">
                        <i class='bx bx-info-circle'></i>
                        <span id="paymentInfo">Pay full amount upfront for better discounts!</span>
                    </div>
                </div>

                {{-- Terms & Conditions --}}
                <div class="modern-card" data-aos="fade-right" data-aos-delay="200">
                    <div class="custom-checkbox">
                        <input type="checkbox" id="agreeTerms" required>
                        <label for="agreeTerms">
                            I agree to the <a href="#" style="color: #667eea; font-weight: 600;">Terms & Conditions</a> and <a href="#" style="color: #667eea; font-weight: 600;">Cancellation Policy</a>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Right Column - Price Summary --}}
            <div class="col-lg-5">
                <div class="sticky-summary">
                    <div class="modern-card" data-aos="fade-left">
                        <div class="modern-card-header">
                            <div class="modern-card-icon">
                                <i class='bx bx-receipt'></i>
                            </div>
                            <h2 class="modern-card-title">Price Summary</h2>
                        </div>

                        @php
                            $baseRent = intval($room->room_price);
                            $securityDeposit = intval($room->security_deposit);
                            $amenitiesTotal = 0;
                            foreach ($room->amenities as $amenity) {
                                if ($amenity->status == 'paid') {
                                    $amenitiesTotal += intval($amenity->price);
                                }
                            }
                        @endphp

                        <div class="pricing-table">
                            <div class="pricing-row">
                                <span class="pricing-label">Base Rent (Monthly)</span>
                                <span class="pricing-value" id="baseRentDisplay">₹{{ number_format($baseRent) }}</span>
                            </div>

                            @if($amenitiesTotal > 0)
                                @foreach($room->amenities as $amenity)
                                    @if($amenity->status == 'paid')
                                        <div class="pricing-row">
                                            <span class="pricing-label">{{ $amenity->amenity_name }}</span>
                                            <span class="pricing-value">₹{{ number_format($amenity->price) }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                            <div class="pricing-row">
                                <span class="pricing-label">Security Deposit (Refundable)</span>
                                <span class="pricing-value">₹{{ number_format($securityDeposit) }}</span>
                            </div>

                            <div class="pricing-row">
                                <span class="pricing-label">Duration</span>
                                <span class="pricing-value" id="durationDisplay">1 Month</span>
                            </div>

                            <div class="pricing-row total">
                                <span class="pricing-label" id="totalLabel">Total Amount</span>
                                <span class="pricing-value" id="totalAmount">₹0</span>
                            </div>
                            
                            <div class="pricing-row" id="monthlyInfoRow" style="display: none; background: #fef3c7; padding: 1rem; border-radius: 0.75rem; margin-top: 0.5rem;">
                                <div style="width: 100%;">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <span class="pricing-label" style="color: #92400e;">First Month Payment</span>
                                        <span class="pricing-value" style="color: #92400e;" id="firstMonthAmount">₹0</span>
                                    </div>
                                    <small style="color: #92400e; opacity: 0.8; margin-top: 0.25rem; display: block;">
                                        Subsequent months: <span id="subsequentAmount">₹0</span>/month
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="security-badge">
                            <i class='bx bx-shield-check'></i>
                            <span>100% Secure Payment</span>
                        </div>

                        {{-- Action Buttons --}}
                        <form method="POST" action="{{ route('user.booking.pay', $room->room_id) }}" id="bookingForm">
                            @csrf
                            <input type="hidden" name="checkin_date" id="checkinDateInput">
                            <input type="hidden" name="checkout_date" id="checkoutDateInput">
                            <input type="hidden" name="months" id="selectedMonths">
                            <input type="hidden" name="occupancy" id="selectedOccupancy">
                            <input type="hidden" name="total" id="totalPrice">
                            <input type="hidden" name="payment_frequency" id="paymentFrequency" value="full">
                            <input type="hidden" name="payment_type" id="paymentType" value="online">
                            <input type="hidden" name="monthly_amount" id="monthlyAmount">

                            <div class="action-buttons">
                                <a href="{{ route('room.show', $room->slug) }}" class="btn-modern btn-back">
                                    <i class='bx bx-arrow-back'></i>
                                    <span>Back</span>
                                </a>
                                
                                {{-- Razorpay Payment Button (Online) --}}
                                <button type="button" class="btn-modern btn-primary-modern" id="razorpayPayBtn">
                                    <i class='bx bx-credit-card'></i>
                                    <span id="btnText">Pay with Razorpay</span>
                                </button>
                                
                                {{-- Offline Booking Button --}}
                                <button type="submit" class="btn-modern btn-primary-modern" id="offlineBookBtn" style="display: none;">
                                    <i class='bx bx-check-circle'></i>
                                    <span>Confirm Offline Booking</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Room data
    const baseRent = {{ $baseRent }};
    const security = {{ $securityDeposit }};
    const amenities = {{ $amenitiesTotal }};
    const sharingPrices = @json($room->sharing_prices);
    let currentBaseRent = baseRent;

    // Update buttons based on payment type
    function updatePaymentButtons() {
        const paymentType = $('#paymentType').val();
        
        if (paymentType === 'online') {
            $('#razorpayPayBtn').css('display', 'inline-flex');
            $('#offlineBookBtn').hide();
        } else {
            $('#razorpayPayBtn').hide();
            $('#offlineBookBtn').css('display', 'inline-flex');
        }
    }

    // Calculate total
    function calculateTotal() {
        const months = parseInt($('#stayMonths').val() || 1);
        const monthlyRent = currentBaseRent + amenities;
        const paymentFreq = $('input[name="payment_frequency"]:checked').val();
        
        let total;
        if (paymentFreq === 'monthly') {
            const firstMonth = monthlyRent + security;
            total = firstMonth;
            $('#monthlyAmount').val(monthlyRent);
            $('#firstMonthAmount').text(`₹${firstMonth.toLocaleString('en-IN')}`);
            $('#subsequentAmount').text(`₹${monthlyRent.toLocaleString('en-IN')}`);
            $('#monthlyInfoRow').show();
            $('#totalLabel').text('Amount to Pay Now');
        } else {
            total = monthlyRent * months + security;
            $('#monthlyInfoRow').hide();
            $('#totalLabel').text('Total Amount');
        }
        
        $('#totalAmount').text(`₹${total.toLocaleString('en-IN')}`);
        $('#durationDisplay').text(`${months} Month${months > 1 ? 's' : ''}`);
        $('#totalPrice').val(total);
    }

    // Update base rent on occupancy change
    $('#occupancySelect').on('change', function() {
        const occupancy = parseInt($(this).val());
        
        if (occupancy == 1 && sharingPrices.single) {
            currentBaseRent = parseInt(sharingPrices.single);
        } else if (occupancy == 2 && sharingPrices.double) {
            currentBaseRent = parseInt(sharingPrices.double);
        } else if (occupancy >= 3 && sharingPrices.triple) {
            currentBaseRent = parseInt(sharingPrices.triple);
        } else {
            currentBaseRent = baseRent;
        }
        
        $('#baseRentDisplay').text(`₹${currentBaseRent.toLocaleString('en-IN')}`);
        calculateTotal();
    });

    // Update checkout date
    function updateCheckoutDate() {
        const checkInVal = $('#checkinDate').val();
        if (!checkInVal) return;
        
        const checkInDate = new Date(checkInVal);
        const months = parseInt($('#stayMonths').val() || 1);
        const checkoutDate = new Date(checkInDate);
        checkoutDate.setMonth(checkInDate.getMonth() + months);
        
        $('#checkoutDate').val(checkoutDate.toISOString().split('T')[0]);
    }

    // Event listeners
    $('#stayMonths').on('change', function() {
        calculateTotal();
        updateCheckoutDate();
    });

    $('#checkinDate').on('change', updateCheckoutDate);

    // Form submission for offline booking
    $('#bookingForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate
        if (!$('#agreeTerms').is(':checked')) {
            Swal.fire({
                icon: 'warning',
                title: 'Terms & Conditions',
                text: 'Please agree to the Terms & Conditions to proceed',
                confirmButtonColor: '#667eea'
            });
            return;
        }
        
        if (!$('#checkinDate').val()) {
            Swal.fire({
                icon: 'warning',
                title: 'Check-in Date Required',
                text: 'Please select a check-in date',
                confirmButtonColor: '#667eea'
            });
            $('#checkinDate').focus();
            return;
        }
        
        // Fill hidden fields
        $('#checkinDateInput').val($('#checkinDate').val());
        $('#checkoutDateInput').val($('#checkoutDate').val());
        $('#selectedMonths').val($('#stayMonths').val());
        $('#selectedOccupancy').val($('#occupancySelect').val());
        
        // Show loading on offline booking button
        if ($('#offlineBookBtn').is(':visible')) {
            $('#offlineBookBtn').prop('disabled', true)
                .html('<i class="bx bx-loader-alt bx-spin"></i> <span>Processing...</span>');
        }
        
        // Submit form
        this.submit();
    });

    // Payment option cards handling
    $('.payment-option-card').on('click', function(e) {
        const name = $(this).find('input').attr('name');
        const value = $(this).data('value');
        
        // Remove active class from all cards with same name
        $(`.payment-option-card input[name="${name}"]`).closest('.payment-option-card').removeClass('active');
        
        // Add active to clicked card
        $(this).addClass('active');
        $(this).find('input').prop('checked', true);
        
        // Update hidden fields
        if (name === 'payment_frequency') {
            $('#paymentFrequency').val(value);
            calculateTotal();
            
            // Update info text
            if (value === 'monthly') {
                $('#paymentInfo').html('Pay monthly for flexible payment. Security deposit will be charged in first month.');
            } else {
                $('#paymentInfo').html('Pay full amount upfront for better discounts!');
            }
        } else if (name === 'payment_type') {
            $('#paymentType').val(value);
            updatePaymentButtons();
        }
    });

    // Initialize
    calculateTotal();
    
    // Set min date for checkin
    const today = new Date().toISOString().split('T')[0];
    $('#checkinDate').attr('min', today);
    
    // Handle payment type change
    updatePaymentButtons();
});
</script>

{{-- Razorpay SDK --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

{{-- Razorpay Payment Integration --}}
<script>
$(document).on('click', '#razorpayPayBtn', function() {
    // Validate form
    if (!$('#agreeTerms').is(':checked')) {
        Swal.fire({
            icon: 'warning',
            title: 'Please Accept',
            text: 'Please accept the terms & conditions',
        });
        return;
    }
    
    if (!$('#checkinDate').val() || !$('#checkoutDate').val()) {
        Swal.fire({
            icon: 'warning',
            title: 'Required Fields',
            text: 'Please select check-in and check-out dates',
        });
        return;
    }
    
    // Disable button and show loading
    const $btn = $(this);
    const $btnText = $btn.find('span');
    const originalText = $btnText.html();
    $btn.prop('disabled', true);
    $btnText.html('Processing...');
    
    // Get total amount
    const totalAmount = parseFloat($('#totalPrice').val());
    
    // Create payment order
    $.ajax({
        url: '{{ route("payment.create-order") }}',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        contentType: 'application/json',
        data: JSON.stringify({
            room_id: {{ $room->room_id }},
            amount: totalAmount
        }),
        success: function(data) {
            if (data.success) {
                openRazorpayCheckout(data.checkout_data, $btn, originalText);
            } else {
                throw new Error(data.message || 'Failed to create payment order');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Payment Error',
                text: 'Failed to initiate payment. Please try again.',
            });
            $btn.prop('disabled', false);
            $btnText.html(originalText);
        }
    });
});

function openRazorpayCheckout(checkoutData, $btn, originalText) {
    const options = {
        ...checkoutData,
        handler: function(response) {
            verifyPayment(response, $btn, originalText);
        },
        modal: {
            ondismiss: function() {
                $btn.prop('disabled', false);
                $btn.find('span').html(originalText);
                Swal.fire({
                    icon: 'info',
                    title: 'Payment Cancelled',
                    text: 'You cancelled the payment process',
                });
            }
        }
    };
    
    const rzp = new Razorpay(options);
    rzp.open();
}

function verifyPayment(response, $btn, originalText) {
    $btn.find('span').html('Verifying...');
    
    $.ajax({
        url: '{{ route("payment.verify") }}',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        contentType: 'application/json',
        data: JSON.stringify({
            razorpay_payment_id: response.razorpay_payment_id,
            razorpay_order_id: response.razorpay_order_id,
            razorpay_signature: response.razorpay_signature
        }),
        success: function(data) {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Successful!',
                    text: 'Redirecting to success page...',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = data.redirect_url;
                });
            } else {
                throw new Error(data.message || 'Payment verification failed');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Verification Failed',
                text: 'Payment verification failed. Please contact support.',
            });
            $btn.prop('disabled', false);
            $btn.find('span').html(originalText);
        }
    });
}
</script>
@endpush
