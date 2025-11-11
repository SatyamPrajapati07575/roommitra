@extends('layouts.app')
@section('title', 'Payment History')

@push('styles')
<style>
    .history-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }
    
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }
    
    .payment-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .payment-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }
    
    .payment-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .payment-id {
        font-weight: 600;
        color: #667eea;
        font-size: 1.1rem;
    }
    
    .status-badge {
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .status-success {
        background: #d1fae5;
        color: #065f46;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .status-failed {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .status-refunded {
        background: #dbeafe;
        color: #1e40af;
    }
    
    .payment-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        padding: 1rem 0;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .detail-item {
        display: flex;
        flex-direction: column;
    }
    
    .detail-label {
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    
    .detail-value {
        font-weight: 600;
        color: #1f2937;
    }
    
    .payment-amount {
        font-size: 1.5rem;
        color: #667eea;
    }
    
    .payment-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .btn-sm {
        padding: 0.4rem 1rem;
        font-size: 0.875rem;
        border-radius: 6px;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 12px;
    }
    
    .empty-state i {
        font-size: 5rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    
    .filter-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 0.9rem;
    }
</style>
@endpush

@section('content')
<div class="history-container">
    <!-- Page Header -->
    <div class="page-header">
        <h2><i class='bx bx-history'></i> Payment History</h2>
        <p class="mb-0">View all your transactions</p>
    </div>

    <!-- Statistics -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-value">{{ $payments->where('status', 'success')->count() }}</div>
            <div class="stat-label"><i class='bx bx-check-circle'></i> Successful</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $payments->whereIn('status', ['created', 'pending'])->count() }}</div>
            <div class="stat-label"><i class='bx bx-time-five'></i> Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $payments->where('status', 'failed')->count() }}</div>
            <div class="stat-label"><i class='bx bx-x-circle'></i> Failed</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">₹{{ number_format($payments->where('status', 'success')->sum('amount'), 2) }}</div>
            <div class="stat-label"><i class='bx bx-wallet'></i> Total Paid</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('payment.history') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>✅ Successful</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏱️ Pending</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>❌ Failed</option>
                        <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>💰 Refunded</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="payment_method" class="form-select">
                        <option value="">All Payment Methods</option>
                        <option value="upi" {{ request('payment_method') == 'upi' ? 'selected' : '' }}>UPI</option>
                        <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                        <option value="netbanking" {{ request('payment_method') == 'netbanking' ? 'selected' : '' }}>Net Banking</option>
                        <option value="wallet" {{ request('payment_method') == 'wallet' ? 'selected' : '' }}>Wallet</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class='bx bx-filter'></i> Apply Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Payment List -->
    @forelse($payments as $payment)
        <div class="payment-card">
            <div class="payment-header">
                <div>
                    <div class="payment-id">
                        <i class='bx bx-receipt'></i> {{ $payment->receipt_number ?? 'Payment #' . $payment->id }}
                    </div>
                    <small class="text-muted">{{ $payment->created_at->format('d M Y, h:i A') }}</small>
                </div>
                <span class="status-badge status-{{ $payment->status }}">
                    @if($payment->status == 'success')
                        <i class='bx bx-check-circle'></i> Successful
                    @elseif($payment->status == 'pending')
                        <i class='bx bx-time-five'></i> Pending
                    @elseif($payment->status == 'failed')
                        <i class='bx bx-x-circle'></i> Failed
                    @elseif($payment->status == 'refunded')
                        <i class='bx bx-refresh'></i> Refunded
                    @else
                        <i class='bx bx-info-circle'></i> {{ ucfirst($payment->status) }}
                    @endif
                </span>
            </div>

            <div class="payment-details">
                <div class="detail-item">
                    <span class="detail-label">Amount</span>
                    <span class="detail-value payment-amount">{{ $payment->formatted_amount }}</span>
                </div>
                
                @if($payment->room)
                <div class="detail-item">
                    <span class="detail-label">Room</span>
                    <span class="detail-value">{{ $payment->room->room_title }}</span>
                </div>
                @endif
                
                @if($payment->payment_method)
                <div class="detail-item">
                    <span class="detail-label">Payment Method</span>
                    <span class="detail-value">{{ strtoupper($payment->payment_method) }}</span>
                </div>
                @endif
                
                @if($payment->razorpay_payment_id)
                <div class="detail-item">
                    <span class="detail-label">Transaction ID</span>
                    <span class="detail-value" style="font-size: 0.85rem;">{{ $payment->razorpay_payment_id }}</span>
                </div>
                @endif
            </div>

            <div class="payment-actions">
                @if($payment->status == 'success')
                    <a href="{{ route('payment.success', $payment->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class='bx bx-show'></i> View Details
                    </a>
                @endif
                
                @if($payment->room)
                    <a href="{{ route('room.show', $payment->room->slug) }}" class="btn btn-sm btn-outline-secondary">
                        <i class='bx bx-home'></i> View Room
                    </a>
                @endif
                
                @if($payment->status == 'failed' && $payment->room)
                    <a href="{{ route('payment.checkout', $payment->room->slug) }}" class="btn btn-sm btn-warning">
                        <i class='bx bx-refresh'></i> Retry Payment
                    </a>
                @endif
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class='bx bx-receipt'></i>
            <h4>No Payments Yet</h4>
            <p class="text-muted">You haven't made any payments yet</p>
            <a href="{{ route('rooms') }}" class="btn btn-primary mt-3">
                <i class='bx bx-search'></i> Browse Rooms
            </a>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($payments->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $payments->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
