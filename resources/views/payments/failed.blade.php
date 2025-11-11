@extends('layouts.app')
@section('title', 'Payment Failed')

@push('styles')
<style>
    .failed-container {
        max-width: 700px;
        margin: 3rem auto;
        padding: 0 1rem;
    }
    
    .failed-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        padding: 3rem 2rem;
        text-align: center;
    }
    
    .failed-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        animation: shake 0.5s ease-in-out;
    }
    
    .failed-icon i {
        font-size: 3.5rem;
        color: white;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
    
    .failed-title {
        font-size: 2rem;
        font-weight: 700;
        color: #ef4444;
        margin-bottom: 0.5rem;
    }
    
    .error-details {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 12px;
        padding: 1.5rem;
        margin: 2rem 0;
        text-align: left;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
        flex-wrap: wrap;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        color: white;
    }
    
    .btn-outline-secondary {
        border: 2px solid #6b7280;
        color: #6b7280;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        background: white;
    }
    
    .btn-outline-secondary:hover {
        background: #6b7280;
        color: white;
    }
    
    .help-section {
        background: #f9fafb;
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 2rem;
    }
    
    .help-section h6 {
        color: #374151;
        margin-bottom: 1rem;
    }
    
    .help-section ul {
        text-align: left;
        color: #6b7280;
    }
</style>
@endpush

@section('content')
<div class="failed-container">
    <div class="failed-card">
        <div class="failed-icon">
            <i class='bx bx-x'></i>
        </div>
        
        <h1 class="failed-title">Payment Failed</h1>
        <p class="text-muted">Unfortunately, your payment could not be processed</p>
        
        @if($payment)
        <div class="error-details">
            <h6><i class='bx bx-error-circle'></i> Error Details</h6>
            
            @if($payment->error_description)
                <p class="mb-2"><strong>Reason:</strong> {{ $payment->error_description }}</p>
            @endif
            
            <p class="mb-2"><strong>Order ID:</strong> {{ $payment->razorpay_order_id }}</p>
            <p class="mb-0"><strong>Amount:</strong> {{ $payment->formatted_amount }}</p>
            
            @if($payment->room)
                <p class="mb-0 mt-2"><strong>Room:</strong> {{ $payment->room->room_title }}</p>
            @endif
        </div>
        @else
        <div class="error-details">
            <p class="mb-0"><i class='bx bx-info-circle'></i> The payment was cancelled or failed to process</p>
        </div>
        @endif
        
        <div class="action-buttons">
            @if($payment)
                <a href="{{ route('payment.checkout', $payment->room->slug) }}" class="btn btn-primary">
                    <i class='bx bx-refresh'></i> Try Again
                </a>
            @endif
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class='bx bx-home'></i> Go to Home
                </a>
        </div>
        
        <div class="help-section">
            <h6><i class='bx bx-help-circle'></i> Common Reasons for Payment Failure</h6>
            <ul class="mb-0">
                <li>Insufficient balance in your account</li>
                <li>Incorrect payment details entered</li>
                <li>Bank server issues or network problems</li>
                <li>Payment cancelled by user</li>
                <li>Card limit exceeded</li>
            </ul>
            
            <div class="mt-3">
                <small class="text-muted">
                    <i class='bx bx-support'></i> 
                    Need help? Contact our support team at 
                    <a href="mailto:support@roommitra.com">support@roommitra.com</a>
                </small>
            </div>
        </div>
    </div>
</div>
@endsection
