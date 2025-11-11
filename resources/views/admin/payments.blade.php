@extends('layouts.admin')
@section('title', 'Manage Payments')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Manage Payments',
        'icon' => 'bx bxs-wallet'
    ])

    <div class="container-fluid">
        {{-- Quick Stats --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3>{{ $payments->total() }}</h3>
                        <p class="mb-0">Total Payments</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3>₹{{ number_format($payments->where('status', 'success')->sum('amount')) }}</h3>
                        <p class="mb-0">Completed</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3>{{ $payments->where('status', 'pending')->count() }}</h3>
                        <p class="mb-0">Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h3>{{ $payments->where('status', 'failed')->count() }}</h3>
                        <p class="mb-0">Failed</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card p-3 mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search by User or Transaction ID">
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option value="">All Status</option>
                        <option>Completed</option>
                        <option>Pending</option>
                        <option>Failed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option value="">Payment Method</option>
                        <option>Card</option>
                        <option>UPI</option>
                        <option>Net Banking</option>
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

        {{-- Payments Table --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center table-bordered">
                    <thead class="thead-light">
                        <tr class="bg-light text-dark">
                            <th>ID</th>
                            <th>User</th>
                            <th>Booking ID</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Transaction ID</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>#{{ $payment->payment_id }}</td>
                                <td>{{ $payment->user ? $payment->user->full_name : 'N/A' }}</td>
                                <td>#{{ $payment->booking_id }}</td>
                                <td>₹{{ number_format($payment->amount) }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class='bx {{ 
                                            $payment->payment_method == 'card' ? 'bx-credit-card' : 
                                            ($payment->payment_method == 'upi' ? 'bxl-google' : 'bx-building') 
                                        }}'></i>
                                        {{ ucfirst($payment->payment_method ?? 'N/A') }}
                                    </span>
                                </td>
                                <td><small>{{ $payment->transaction_id ?? 'N/A' }}</small></td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $payment->status === 'success' ? 'success' : 
                                        ($payment->status === 'pending' ? 'warning' : 'danger')
                                    }}">
                                        <i class='bx {{ 
                                            $payment->status === 'success' ? 'bx-check-circle' : 
                                            ($payment->status === 'pending' ? 'bx-time' : 'bx-x-circle')
                                        }}'></i>
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->created_at->format('d M, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info view-payment-btn" 
                                            data-id="{{ $payment->payment_id }}" title="View Details">
                                        <i class='bx bx-show'></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-5">
                                    <i class='bx bx-wallet' style="font-size: 3rem;"></i>
                                    <p class="mt-2">No payments found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-3">
                {{ $payments->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View payment details
    document.querySelectorAll('.view-payment-btn').forEach(button => {
        button.addEventListener('click', function() {
            const paymentId = this.getAttribute('data-id');
            
            Toast.fire({
                icon: 'info',
                title: 'Payment details coming soon'
            });
        });
    });
});
</script>
@endpush
