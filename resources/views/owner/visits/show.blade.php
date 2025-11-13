@extends('layouts.owner')
@section('title', 'Visit Details')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/visit-modal.css') }}">
<style>
.visit-details-container {
    padding: 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.visit-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

.visit-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
}

.visit-status {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
}

.status-pending { background: #fef3c7; color: #92400e; }
.status-confirmed { background: #d1fae5; color: #065f46; }
.status-completed { background: #dbeafe; color: #1e40af; }
.status-cancelled { background: #fee2e2; color: #991b1b; }
.status-rescheduled { background: #e0e7ff; color: #3730a3; }

.visit-type-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    margin-left: 1rem;
}

.type-physical { background: #d1fae5; color: #065f46; }
.type-virtual { background: #dbeafe; color: #1e40af; }

.visit-content {
    padding: 2rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.info-section {
    background: #f8faff;
    padding: 1.5rem;
    border-radius: 12px;
}

.info-section h4 {
    color: #667eea;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0;
    border-bottom: 1px solid #e5e7eb;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #374151;
}

.info-value {
    color: #6b7280;
}

.room-preview {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: #f8faff;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.room-image {
    width: 120px;
    height: 90px;
    object-fit: cover;
    border-radius: 8px;
}

.room-details h5 {
    color: #667eea;
    margin-bottom: 0.5rem;
}

.room-details p {
    margin: 0.25rem 0;
    color: #6b7280;
}

.response-form {
    background: #f0f9ff;
    border: 2px solid #0ea5e9;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.response-form h4 {
    color: #0ea5e9;
    margin-bottom: 1rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-bottom: 1rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #374151;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.action-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: transform 0.3s;
}

.btn:hover {
    transform: translateY(-2px);
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

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-outline {
    background: transparent;
    color: #667eea;
    border: 2px solid #667eea;
}

.meeting-setup {
    background: #f0f9ff;
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 1rem;
    display: none;
}

.meeting-setup.show {
    display: block;
}

.meeting-setup h5 {
    color: #0ea5e9;
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .room-preview {
        flex-direction: column;
    }
    
    .room-image {
        width: 100%;
        height: 200px;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')
<div class="visit-details-container">
    <div class="visit-card">
        <div class="visit-header">
            <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap;">
                <div>
                    <h1><i class='bx bx-calendar-check'></i> Visit Request Details</h1>
                    <p>Request ID: #{{ str_pad($visit->visit_id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <span class="visit-status status-{{ $visit->status }}">
                        {{ ucfirst($visit->status) }}
                    </span>
                    <span class="visit-type-badge type-{{ $visit->visit_type }}">
                        <i class='bx bx-{{ $visit->visit_type === 'virtual' ? 'video' : 'walk' }}'></i>
                        {{ ucfirst($visit->visit_type) }} Visit
                    </span>
                </div>
            </div>
        </div>

        <div class="visit-content">
            <!-- Room Preview -->
            <div class="room-preview">
                @if($visit->room->images->count() > 0)
                    <img src="{{ $visit->room->images->first()->image_url }}" alt="Room" class="room-image">
                @else
                    <div class="room-image" style="background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                        <i class='bx bx-image' style="font-size: 2rem; color: #9ca3af;"></i>
                    </div>
                @endif
                <div class="room-details">
                    <h5>{{ $visit->room->room_title }}</h5>
                    <p><i class='bx bx-map'></i> {{ $visit->room->locality }}, {{ $visit->room->city }}</p>
                    <p><i class='bx bx-rupee'></i> ₹{{ number_format($visit->room->room_price) }}/month</p>
                    <p><i class='bx bx-calendar-plus'></i> Requested on {{ $visit->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>

            <!-- Visit Information -->
            <div class="info-grid">
                <div class="info-section">
                    <h4><i class='bx bx-calendar'></i> Visit Schedule</h4>
                    <div class="info-item">
                        <span class="info-label">Preferred Date & Time:</span>
                        <span class="info-value">{{ $visit->formatted_preferred_date_time }}</span>
                    </div>
                    @if($visit->alternative_date)
                    <div class="info-item">
                        <span class="info-label">Alternative Date & Time:</span>
                        <span class="info-value">{{ $visit->formatted_alternative_date_time }}</span>
                    </div>
                    @endif
                    @if($visit->confirmed_date)
                    <div class="info-item">
                        <span class="info-label">Confirmed Date & Time:</span>
                        <span class="info-value">{{ $visit->formatted_confirmed_date_time }}</span>
                    </div>
                    @endif
                </div>

                <div class="info-section">
                    <h4><i class='bx bx-user'></i> Visitor Information</h4>
                    <div class="info-item">
                        <span class="info-label">Name:</span>
                        <span class="info-value">{{ $visit->visitor_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">
                            <a href="tel:{{ $visit->visitor_phone }}" style="color: #667eea;">{{ $visit->visitor_phone }}</a>
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">
                            <a href="mailto:{{ $visit->visitor_email }}" style="color: #667eea;">{{ $visit->visitor_email }}</a>
                        </span>
                    </div>
                </div>
            </div>

            @if($visit->special_requirements)
            <div class="info-section">
                <h4><i class='bx bx-note'></i> Special Requirements</h4>
                <p>{{ $visit->special_requirements }}</p>
            </div>
            @endif

            @if($visit->owner_notes)
            <div class="info-section">
                <h4><i class='bx bx-message-dots'></i> Your Response</h4>
                <p>{{ $visit->owner_notes }}</p>
                @if($visit->owner_responded_at)
                <small class="text-muted">Responded on {{ $visit->owner_responded_at->format('d M Y, h:i A') }}</small>
                @endif
            </div>
            @endif

            <!-- Virtual Meeting Info -->
            @if($visit->visit_type === 'virtual' && $visit->status === 'confirmed' && $visit->meeting_link)
            <div class="info-section" style="background: #f0f9ff; border: 2px solid #0ea5e9;">
                <h4><i class='bx bx-video'></i> Virtual Meeting Details</h4>
                <div class="info-item">
                    <span class="info-label">Meeting Link:</span>
                    <span class="info-value">
                        <a href="{{ $visit->meeting_link }}" target="_blank" style="color: #0ea5e9;">{{ $visit->meeting_link }}</a>
                    </span>
                </div>
                @if($visit->meeting_id)
                <div class="info-item">
                    <span class="info-label">Meeting ID:</span>
                    <span class="info-value">{{ $visit->meeting_id }}</span>
                </div>
                @endif
                @if($visit->meeting_password)
                <div class="info-item">
                    <span class="info-label">Password:</span>
                    <span class="info-value">{{ $visit->meeting_password }}</span>
                </div>
                @endif
            </div>
            @endif

            <!-- Response Actions -->
            @if($visit->status === 'pending')
            <div class="response-form">
                <h4><i class='bx bx-reply'></i> Respond to Visit Request</h4>
                <p style="color: #6b7280; margin-bottom: 1.5rem;">Click on an action below to respond to this visit request.</p>
                
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <button type="button" class="btn btn-success" onclick="openResponseModal('confirm')">
                        <i class='bx bx-check-circle'></i> Confirm Visit
                    </button>
                    <button type="button" class="btn btn-warning" onclick="openResponseModal('reschedule')">
                        <i class='bx bx-calendar-edit'></i> Reschedule Visit
                    </button>
                    <button type="button" class="btn btn-danger" onclick="openResponseModal('cancel')">
                        <i class='bx bx-x-circle'></i> Cancel Visit
                    </button>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                @if($visit->status === 'confirmed')
                    <form action="{{ route('owner.visits.complete', $visit) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success" 
                                onclick="return confirm('Mark this visit as completed?')">
                            <i class='bx bx-check-circle'></i> Mark as Completed
                        </button>
                    </form>
                @endif

                <a href="{{ route('owner.visits.index') }}" class="btn btn-outline">
                    <i class='bx bx-arrow-back'></i> Back to Visits
                </a>

                <a href="{{ route('owner.rooms.show', $visit->room) }}" class="btn btn-primary">
                    <i class='bx bx-home'></i> View Room
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Visit Response Modal -->
@if($visit->status === 'pending')
<div class="visit-modal-overlay" id="responseModal">
    <div class="visit-modal">
        <div class="visit-modal-header">
            <h3 class="visit-modal-title" id="modalTitle">
                <i class='bx bx-reply'></i> Respond to Visit Request
            </h3>
            <button type="button" class="visit-modal-close" onclick="closeResponseModal()">
                <i class='bx bx-x'></i>
            </button>
        </div>
        
        <div class="visit-modal-body">
            <!-- Visit Information Summary -->
            <div class="visit-info-card">
                <h4 style="color: #667eea; margin-bottom: 1rem;">
                    <i class='bx bx-info-circle'></i> Visit Details
                </h4>
                <div class="visit-info-grid">
                    <div class="visit-info-item">
                        <span class="visit-info-label">Visitor</span>
                        <span class="visit-info-value">{{ $visit->visitor_name }}</span>
                    </div>
                    <div class="visit-info-item">
                        <span class="visit-info-label">Visit Type</span>
                        <span class="visit-info-value">{{ ucfirst($visit->visit_type) }} Visit</span>
                    </div>
                    <div class="visit-info-item">
                        <span class="visit-info-label">Preferred Date</span>
                        <span class="visit-info-value">{{ $visit->formatted_preferred_date_time }}</span>
                    </div>
                    <div class="visit-info-item">
                        <span class="visit-info-label">Phone</span>
                        <span class="visit-info-value">{{ $visit->visitor_phone }}</span>
                    </div>
                </div>
            </div>

            <!-- Response Form -->
            <form action="{{ route('owner.visits.respond', $visit) }}" method="POST" id="responseForm">
                @csrf
                @method('PATCH')
                
                <input type="hidden" name="action" id="responseAction">
                
                <!-- Response Type Display -->
                <div class="response-type-selector">
                    <h4 id="responseTypeTitle">Select Response Type</h4>
                    <div class="response-options">
                        <div class="response-option">
                            <input type="radio" name="response_type" id="confirm_radio" value="confirm">
                            <label for="confirm_radio" class="response-option-label response-option-confirm">
                                <i class='bx bx-check-circle'></i><br>
                                Confirm Visit
                            </label>
                        </div>
                        <div class="response-option">
                            <input type="radio" name="response_type" id="reschedule_radio" value="reschedule">
                            <label for="reschedule_radio" class="response-option-label response-option-reschedule">
                                <i class='bx bx-calendar-edit'></i><br>
                                Reschedule Visit
                            </label>
                        </div>
                        <div class="response-option">
                            <input type="radio" name="response_type" id="cancel_radio" value="cancel">
                            <label for="cancel_radio" class="response-option-label response-option-cancel">
                                <i class='bx bx-x-circle'></i><br>
                                Cancel Visit
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Confirm/Reschedule Details -->
                <div class="response-details" id="confirmDetails">
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
                    @if($visit->visit_type === 'virtual')
                    <div class="virtual-meeting-setup" id="virtualMeetingSetup">
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
                    @endif
                </div>

                <!-- Cancel Details -->
                <div class="response-details" id="cancelDetails">
                    <h5><i class='bx bx-info-circle'></i> Cancellation Reason</h5>
                    <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 1rem;">
                        Please provide a reason for cancelling this visit request.
                    </p>
                </div>

                <!-- Owner Notes -->
                <div class="form-group">
                    <label class="form-label">Notes to Visitor</label>
                    <textarea name="owner_notes" class="form-control" rows="3" 
                              placeholder="Any additional information or instructions for the visitor..."></textarea>
                </div>
            </form>
        </div>
        
        <div class="visit-modal-footer">
            <button type="button" class="btn btn-outline" onclick="closeResponseModal()">
                <i class='bx bx-x'></i> Cancel
            </button>
            <button type="submit" form="responseForm" class="btn btn-primary" id="submitBtn">
                <i class='bx bx-send'></i> Send Response
            </button>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
// Modal functionality
function openResponseModal(action) {
    const modal = document.getElementById('responseModal');
    const modalTitle = document.getElementById('modalTitle');
    const responseAction = document.getElementById('responseAction');
    const submitBtn = document.getElementById('submitBtn');
    
    // Set the action
    responseAction.value = action;
    
    // Update modal title and button text based on action
    const actionConfig = {
        confirm: {
            title: '<i class="bx bx-check-circle"></i> Confirm Visit Request',
            buttonText: '<i class="bx bx-check"></i> Confirm Visit',
            buttonClass: 'btn btn-success'
        },
        reschedule: {
            title: '<i class="bx bx-calendar-edit"></i> Reschedule Visit Request',
            buttonText: '<i class="bx bx-calendar-edit"></i> Reschedule Visit',
            buttonClass: 'btn btn-warning'
        },
        cancel: {
            title: '<i class="bx bx-x-circle"></i> Cancel Visit Request',
            buttonText: '<i class="bx bx-x"></i> Cancel Visit',
            buttonClass: 'btn btn-danger'
        }
    };
    
    const config = actionConfig[action];
    modalTitle.innerHTML = config.title;
    submitBtn.innerHTML = config.buttonText;
    submitBtn.className = config.buttonClass;
    
    // Pre-select the radio button
    document.getElementById(action + '_radio').checked = true;
    
    // Show appropriate details section
    handleResponseTypeChange(action);
    
    // Auto-fill with visitor's preferred date/time for confirm action
    if (action === 'confirm') {
        const dateInput = document.querySelector('input[name="confirmed_date"]');
        const timeInput = document.querySelector('input[name="confirmed_time"]');
        
        if (dateInput && timeInput) {
            const preferredDate = '{{ $visit->preferred_date->format('Y-m-d') }}';
            const preferredTime = '{{ $visit->preferred_time_for_input }}';
            
            dateInput.value = preferredDate;
            timeInput.value = preferredTime;
        }
    }
    
    // Show modal
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeResponseModal() {
    const modal = document.getElementById('responseModal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
    
    // Reset form
    document.getElementById('responseForm').reset();
    
    // Hide all details sections
    document.querySelectorAll('.response-details').forEach(section => {
        section.classList.remove('active');
    });
}

function handleResponseTypeChange(responseType) {
    // Hide all details sections
    document.querySelectorAll('.response-details').forEach(section => {
        section.classList.remove('active');
    });
    
    // Show appropriate section
    if (responseType === 'confirm' || responseType === 'reschedule') {
        document.getElementById('confirmDetails').classList.add('active');
        
        // Show virtual meeting setup for virtual visits when confirming
        @if($visit->visit_type === 'virtual')
        if (responseType === 'confirm') {
            document.getElementById('virtualMeetingSetup').classList.add('active');
        } else {
            document.getElementById('virtualMeetingSetup').classList.remove('active');
        }
        @endif
    } else if (responseType === 'cancel') {
        document.getElementById('cancelDetails').classList.add('active');
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Radio button change handlers
    document.querySelectorAll('input[name="response_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.checked) {
                document.getElementById('responseAction').value = this.value;
                handleResponseTypeChange(this.value);
            }
        });
    });
    
    // Close modal when clicking outside
    document.getElementById('responseModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeResponseModal();
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
            closeResponseModal();
        }
    });
});
</script>
@endpush
