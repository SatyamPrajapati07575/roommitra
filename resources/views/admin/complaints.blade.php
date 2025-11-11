@extends('layouts.admin')
@section('title', 'Manage Complaints')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Manage Complaints',
        'icon' => 'bx bxs-error-circle'
    ])

    <div class="container-fluid">
        {{-- Quick Stats --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3>{{ $total ?? 0 }}</h3>
                        <p class="mb-0">Total Complaints</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3>{{ $pending ?? 0 }}</h3>
                        <p class="mb-0">Pending</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h3>{{ $inprogress ?? 0 }}</h3>
                        <p class="mb-0">In Progress</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3>{{ $resolved ?? 0 }}</h3>
                        <p class="mb-0">Resolved</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card p-3 mb-4">
            <div class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search by Subject or User">
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option value="">All Status</option>
                        <option>Pending</option>
                        <option>In Progress</option>
                        <option>Resolved</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option value="">User Type</option>
                        <option>Student</option>
                        <option>Owner</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary w-100"><i class='bx bx-search'></i></button>
                </div>
            </div>
        </div>

        {{-- Complaints Table --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center table-bordered">
                    <thead class="thead-light">
                        <tr class="bg-light text-dark">
                            <th>ID</th>
                            <th>User</th>
                            <th>User Type</th>
                            <th>Subject</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($complaints as $complaint)
                            <tr>
                                <td>#{{ $complaint->id }}</td>
                                <td>{{ $complaint->user ? $complaint->user->full_name : $complaint->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $complaint->user_type == 'Owner' ? 'success' : 'info' }}">
                                        {{ $complaint->user_type }}
                                    </span>
                                </td>
                                <td class="text-left">{{ Str::limit($complaint->subject, 40) }}</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $complaint->status == 'resolved' ? 'success' : 
                                        ($complaint->status == 'in_progress' ? 'info' : 'warning') 
                                    }}">
                                        <i class='bx {{ 
                                            $complaint->status == 'resolved' ? 'bx-check-circle' : 
                                            ($complaint->status == 'in_progress' ? 'bx-time' : 'bx-error-circle') 
                                        }}'></i>
                                        {{ ucwords(str_replace('_', ' ', $complaint->status)) }}
                                    </span>
                                </td>
                                <td>{{ $complaint->created_at->format('d M, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info view-complaint-btn"
                                            data-id="{{ $complaint->id }}" title="View Details">
                                        <i class='bx bx-show'></i>
                                    </button>
                                    @if($complaint->status != 'resolved')
                                        <button class="btn btn-sm btn-outline-success resolve-complaint-btn" 
                                                data-id="{{ $complaint->id }}" title="Mark Resolved">
                                            <i class='bx bx-check'></i>
                                        </button>
                                    @endif
                                    <button class="btn btn-sm btn-outline-danger delete-complaint-btn" 
                                            data-id="{{ $complaint->id }}" title="Delete">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class='bx bx-error-alt' style="font-size: 3rem;"></i>
                                    <p class="mt-2">No complaints found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-3">
                {{ $complaints->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View complaint details
    document.querySelectorAll('.view-complaint-btn').forEach(button => {
        button.addEventListener('click', function() {
            const complaintId = this.getAttribute('data-id');
            
            fetch(`/admin/complaints/${complaintId}`)
                .then(response => response.json())
                .then(data => {
                    Toast.fire({
                        icon: 'info',
                        title: 'Complaint: ' + data.subject
                    });
                })
                .catch(error => {
                    Toast.fire({
                        icon: 'error',
                        title: 'Failed to load complaint details'
                    });
                });
        });
    });

    // Resolve complaint
    document.querySelectorAll('.resolve-complaint-btn').forEach(button => {
        button.addEventListener('click', function() {
            const complaintId = this.getAttribute('data-id');
            
            if(confirm('Mark this complaint as resolved?')) {
                fetch(`/admin/complaints/${complaintId}/resolve`, {
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
                        title: 'Complaint marked as resolved'
                    });
                    setTimeout(() => location.reload(), 1000);
                })
                .catch(error => {
                    Toast.fire({
                        icon: 'error',
                        title: 'Failed to resolve complaint'
                    });
                });
            }
        });
    });

    // Delete complaint
    document.querySelectorAll('.delete-complaint-btn').forEach(button => {
        button.addEventListener('click', function() {
            const complaintId = this.getAttribute('data-id');
            
            if(confirm('Are you sure you want to delete this complaint?')) {
                fetch(`/admin/complaints/${complaintId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Complaint deleted successfully'
                    });
                    setTimeout(() => location.reload(), 1000);
                })
                .catch(error => {
                    Toast.fire({
                        icon: 'error',
                        title: 'Failed to delete complaint'
                    });
                });
            }
        });
    });
});
</script>
@endpush
