@extends('layouts.owner')
@section('title', 'Visit Requests')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/visit-modal.css') }}">
<style>
.visits-container {
    padding: 1.5rem;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    text-align: center;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: #667eea;
}

.stat-label {
    color: #6b7280;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.visits-table {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.table-header {
    background: #f8faff;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.table-content {
    overflow-x: auto;
}

.visits-table table {
    width: 100%;
    border-collapse: collapse;
}

.visits-table th,
.visits-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}

.visits-table th {
    background: #f8faff;
    font-weight: 600;
    color: #374151;
}

.visits-table tr:hover {
    background: #f8faff;
}

.visit-status {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.75rem;
}

.status-pending { background: #fef3c7; color: #92400e; }
.status-confirmed { background: #d1fae5; color: #065f46; }
.status-completed { background: #dbeafe; color: #1e40af; }
.status-cancelled { background: #fee2e2; color: #991b1b; }
.status-rescheduled { background: #e0e7ff; color: #3730a3; }

.visit-type-badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
}

.type-physical { background: #d1fae5; color: #065f46; }
.type-virtual { background: #dbeafe; color: #1e40af; }

.room-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.room-image {
    width: 50px;
    height: 40px;
    border-radius: 6px;
    object-fit: cover;
}

.room-details h6 {
    margin: 0;
    color: #374151;
    font-weight: 600;
}

.room-details p {
    margin: 0;
    color: #6b7280;
    font-size: 0.875rem;
}

.visitor-info {
    color: #374151;
}

.visitor-info h6 {
    margin: 0 0 0.25rem 0;
    font-weight: 600;
}

.visitor-info p {
    margin: 0;
    color: #6b7280;
    font-size: 0.875rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    transition: all 0.3s;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-success {
    background: #10b981;
    color: white;
}

.btn-warning {
    background: #f59e0b;
    color: white;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn:hover {
    transform: translateY(-1px);
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6b7280;
}

.empty-state i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1rem;
}

.filter-bar {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-select {
    padding: 0.5rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: white;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .filter-bar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .table-content {
        font-size: 0.875rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')
<div class="visits-container">
    <div class="page-header">
        <h1><i class='bx bx-calendar-check'></i> Visit Requests</h1>
        <p>Manage all visit requests for your properties</p>
    </div>

    @php
        $totalVisits = $visits->total();
        $pendingVisits = $visits->where('status', 'pending')->count();
        $confirmedVisits = $visits->where('status', 'confirmed')->count();
        $completedVisits = $visits->where('status', 'completed')->count();
    @endphp

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $totalVisits }}</div>
            <div class="stat-label">Total Requests</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $pendingVisits }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $confirmedVisits }}</div>
            <div class="stat-label">Confirmed</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $completedVisits }}</div>
            <div class="stat-label">Completed</div>
        </div>
    </div>

    <div class="filter-bar">
        <div class="filter-group">
            <label>Status:</label>
            <select class="filter-select" onchange="filterVisits(this.value)">
                <option value="">All Status</option>
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <div class="filter-group">
            <label>Type:</label>
            <select class="filter-select" onchange="filterByType(this.value)">
                <option value="">All Types</option>
                <option value="physical">Physical</option>
                <option value="virtual">Virtual</option>
            </select>
        </div>
    </div>

    @if($visits->count() > 0)
        <div class="visits-table">
            <div class="table-header">
                <h3>Visit Requests</h3>
            </div>
            <div class="table-content">
                <table>
                    <thead>
                        <tr>
                            <th>Room</th>
                            <th>Visitor</th>
                            <th>Type</th>
                            <th>Preferred Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($visits as $visit)
                            <tr>
                                <td>
                                    <div class="room-info">
                                        @if($visit->room->images->count() > 0)
                                            <img src="{{ $visit->room->images->first()->image_url }}" 
                                                 alt="Room" class="room-image">
                                        @else
                                            <div class="room-image" style="background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                                <i class='bx bx-image' style="color: #9ca3af; font-size: 1.2rem;"></i>
                                            </div>
                                        @endif
                                        <div class="room-details">
                                            <h6>{{ $visit->room->room_title }}</h6>
                                            <p>{{ $visit->room->locality }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="visitor-info">
                                        <h6>{{ $visit->visitor_name }}</h6>
                                        <p>{{ $visit->visitor_phone }}</p>
                                    </div>
                                </td>
                                <td>
                                    <span class="visit-type-badge type-{{ $visit->visit_type }}">
                                        <i class='bx bx-{{ $visit->visit_type === 'virtual' ? 'video' : 'walk' }}'></i>
                                        {{ ucfirst($visit->visit_type) }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $visit->formatted_preferred_date_time }}</strong>
                                    @if($visit->confirmed_date)
                                        <br><small style="color: #10b981;">Confirmed: {{ $visit->formatted_confirmed_date_time }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="visit-status status-{{ $visit->status }}">
                                        {{ ucfirst($visit->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('owner.visits.show', $visit) }}" class="btn btn-primary">
                                            <i class='bx bx-show'></i> View
                                        </a>
                                        
                                        @if($visit->status === 'pending')
                                            <button class="btn btn-success" onclick="showResponseModal({{ $visit->visit_id }}, 'confirm', '{{ $visit->visit_type }}')">
                                                <i class='bx bx-check'></i> Confirm
                                            </button>
                                            <button class="btn btn-danger" onclick="showResponseModal({{ $visit->visit_id }}, 'cancel', '{{ $visit->visit_type }}')">
                                                <i class='bx bx-x'></i> Cancel
                                            </button>
                                        @elseif($visit->status === 'confirmed')
                                            <form action="{{ route('owner.visits.complete', $visit) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success">
                                                    <i class='bx bx-check-circle'></i> Complete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div style="margin-top: 2rem;">
            {{ $visits->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class='bx bx-calendar-x'></i>
            <h3>No Visit Requests</h3>
            <p>You haven't received any visit requests yet. Promote your rooms to get more visitors!</p>
        </div>
    @endif
</div>

<!-- Response Modal -->
<div class="visit-modal-overlay" id="responseModal">
    <div class="visit-modal">
        <div class="visit-modal-header">
            <h3 class="visit-modal-title" id="modalTitle">
                <i class='bx bx-reply'></i> Respond to Visit Request
            </h3>
            <button type="button" class="visit-modal-close" onclick="closeModal()">
                <i class='bx bx-x'></i>
            </button>
        </div>
        
        <div class="visit-modal-body">
            <form id="responseForm" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" id="visitId" name="visit_id">
                <input type="hidden" id="actionType" name="action">
                
                <div class="response-details active" id="confirmFields">
                    <h5><i class='bx bx-calendar-check'></i> Set Visit Date & Time</h5>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Date *</label>
                            <input type="date" name="confirmed_date" class="form-control" 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Time *</label>
                            <input type="time" name="confirmed_time" class="form-control" required>
                        </div>
                    </div>

                    <!-- Virtual Meeting Setup -->
                    <div class="virtual-meeting-setup" id="virtualFields">
                        <h6><i class='bx bx-video'></i> Virtual Meeting Setup</h6>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Meeting Link *</label>
                                <input type="url" name="meeting_link" class="form-control" 
                                       placeholder="https://meet.google.com/xxx-xxxx-xxx">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Meeting ID (Optional)</label>
                                <input type="text" name="meeting_id" class="form-control" 
                                       placeholder="123-456-789">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Meeting Password (Optional)</label>
                            <input type="text" name="meeting_password" class="form-control" 
                                   placeholder="Enter meeting password">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Notes to Visitor</label>
                    <textarea name="owner_notes" class="form-control" rows="3" 
                              placeholder="Any additional information or instructions..."></textarea>
                </div>
            </form>
        </div>
        
        <div class="visit-modal-footer">
            <button type="button" class="btn btn-outline" onclick="closeModal()">
                <i class='bx bx-x'></i> Cancel
            </button>
            <button type="submit" form="responseForm" class="btn btn-primary" id="submitBtn">
                <i class='bx bx-send'></i> Submit Response
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showResponseModal(visitId, action, visitType = 'physical') {
    const modal = document.getElementById('responseModal');
    const form = document.getElementById('responseForm');
    const title = document.getElementById('modalTitle');
    const actionInput = document.getElementById('actionType');
    const confirmFields = document.getElementById('confirmFields');
    const virtualFields = document.getElementById('virtualFields');
    const submitBtn = document.getElementById('submitBtn');
    
    // Set form action and hidden inputs
    form.action = `/owner/visits/${visitId}/respond`;
    actionInput.value = action;
    
    // Update modal title and button based on action
    const actionConfig = {
        confirm: {
            title: '<i class="bx bx-check-circle"></i> Confirm Visit Request',
            buttonText: '<i class="bx bx-check"></i> Confirm Visit',
            buttonClass: 'btn btn-success'
        },
        cancel: {
            title: '<i class="bx bx-x-circle"></i> Cancel Visit Request',
            buttonText: '<i class="bx bx-x"></i> Cancel Visit',
            buttonClass: 'btn btn-danger'
        }
    };
    
    const config = actionConfig[action] || actionConfig.confirm;
    title.innerHTML = config.title;
    submitBtn.innerHTML = config.buttonText;
    submitBtn.className = config.buttonClass;
    
    // Show/hide fields based on action
    if (action === 'confirm') {
        confirmFields.classList.add('active');
        
        // Show virtual meeting fields for virtual visits
        if (visitType === 'virtual') {
            virtualFields.classList.add('active');
        } else {
            virtualFields.classList.remove('active');
        }
    } else {
        confirmFields.classList.remove('active');
        virtualFields.classList.remove('active');
    }
    
    // Show modal
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('responseModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
    
    // Reset form
    document.getElementById('responseForm').reset();
    
    // Hide all sections
    document.getElementById('confirmFields').classList.remove('active');
    document.getElementById('virtualFields').classList.remove('active');
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Close modal when clicking outside
    document.getElementById('responseModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
    
    // Form submission with loading state
    document.getElementById('responseForm').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.classList.add('btn-loading');
        submitBtn.disabled = true;
        
        // Re-enable after 5 seconds in case of error
        setTimeout(() => {
            submitBtn.classList.remove('btn-loading');
            submitBtn.disabled = false;
        }, 5000);
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
});

// Filter functions
function filterVisits(status) {
    const rows = document.querySelectorAll('.visit-row');
    rows.forEach(row => {
        if (!status || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function filterByType(type) {
    const rows = document.querySelectorAll('.visit-row');
    rows.forEach(row => {
        if (!type || row.dataset.type === type) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endpush
