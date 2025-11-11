@extends('layouts.app')
@section('title', 'Payment Successful')

@push('styles')
<style>
    .success-container {
        max-width: 700px;
        margin: 3rem auto;
        padding: 0 1rem;
    }
    
    .success-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 3rem 2rem;
        text-align: center;
    }
    
    .success-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        animation: scaleIn 0.5s ease-out;
    }
    
    .success-icon i {
        font-size: 3.5rem;
        color: white;
    }
    
    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }
    
    .success-title {
        font-size: 2rem;
        font-weight: 700;
        color: #10b981;
        margin-bottom: 0.5rem;
    }
    
    .payment-details {
        background: #f9fafb;
        border-radius: 12px;
        padding: 2rem;
        margin: 2rem 0;
        text-align: left;
    }
    
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .detail-row:last-child {
        border-bottom: none;
    }
    
    .detail-label {
        color: #6b7280;
        font-weight: 500;
    }
    
    .detail-value {
        color: #1f2937;
        font-weight: 600;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-outline-primary {
        border: 2px solid #667eea;
        color: #667eea;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        background: white;
    }
    
    .btn-outline-primary:hover {
        background: #667eea;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="success-container">
    <div class="success-card">
        <div class="success-icon">
            <i class='bx bx-check'></i>
        </div>
        
        <h1 class="success-title">Payment Successful!</h1>
        <p class="text-muted">Your payment has been processed successfully</p>
        
        <div class="payment-details">
            <h5 class="mb-3">Payment Details</h5>
            
            <div class="detail-row">
                <span class="detail-label">Transaction ID</span>
                <span class="detail-value">{{ $payment->razorpay_payment_id }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Amount Paid</span>
                <span class="detail-value">{{ $payment->formatted_amount }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Payment Method</span>
                <span class="detail-value">{{ ucfirst($payment->payment_method ?? 'N/A') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Room</span>
                <span class="detail-value">{{ $payment->room->room_title }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Date & Time</span>
                <span class="detail-value">{{ $payment->paid_at->format('d M Y, h:i A') }}</span>
            </div>
            
            @if($payment->receipt_number)
            <div class="detail-row">
                <span class="detail-label">Receipt Number</span>
                <span class="detail-value">{{ $payment->receipt_number }}</span>
            </div>
            @endif
        </div>
        
        <div class="alert alert-info">
            <i class='bx bx-info-circle'></i>
            A confirmation email has been sent to <strong>{{ $payment->customer_email }}</strong>
        </div>
        
        <div class="action-buttons">
            @if($payment->booking_id)
                <a href="{{ route('user.bookings') }}" class="btn btn-primary">
                    <i class='bx bx-calendar-check'></i> View Bookings
                </a>
            @endif
            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                <i class='bx bx-home'></i> Go to Home
            </a>
        </div>
        
        <div class="mt-4">
            <small class="text-muted">
                <i class='bx bx-shield-check'></i> 
                This transaction is secure and encrypted
            </small>
        </div>
    </div>
</div>
@endsection
