@extends('layouts.modern')
@section('title', 'Visit Details')

@push('styles')
<style>
.visit-details-container {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 0 1rem;
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
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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

.action-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
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

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-danger {
    background: #ef4444;
    color: white;
}

.btn-success {
    background: #10b981;
    color: white;
}

.meeting-info {
    background: #f0f9ff;
    border: 2px solid #0ea5e9;
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.meeting-info h5 {
    color: #0ea5e9;
    margin-bottom: 1rem;
}

.meeting-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: #0ea5e9;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}

.meeting-link:hover {
    background: #0284c7;
    color: white;
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
                    <h1><i class='bx bx-calendar-check'></i> Visit Request</h1>
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
                    <p><i class='bx bx-user'></i> Owner: {{ $visit->room->owner->name }}</p>
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
                        <span class="info-value">{{ $visit->visitor_phone }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $visit->visitor_email }}</span>
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
                <h4><i class='bx bx-message-dots'></i> Owner's Response</h4>
                <p>{{ $visit->owner_notes }}</p>
                @if($visit->owner_responded_at)
                <small class="text-muted">Responded on {{ $visit->owner_responded_at->format('d M Y, h:i A') }}</small>
                @endif
            </div>
            @endif

            <!-- Virtual Meeting Info -->
            @if($visit->visit_type === 'virtual' && $visit->status === 'confirmed' && $visit->meeting_link)
            <div class="meeting-info">
                <h5><i class='bx bx-video'></i> Virtual Meeting Details</h5>
                <p>Join the virtual tour at your confirmed time:</p>
                <a href="{{ $visit->meeting_link }}" target="_blank" class="meeting-link">
                    <i class='bx bx-video'></i> Join Virtual Tour
                </a>
                @if($visit->meeting_id)
                <p style="margin-top: 1rem;"><strong>Meeting ID:</strong> {{ $visit->meeting_id }}</p>
                @endif
                @if($visit->meeting_password)
                <p><strong>Password:</strong> {{ $visit->meeting_password }}</p>
                @endif
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                @if(in_array($visit->status, ['pending', 'confirmed']))
                    <form action="{{ route('visits.cancel', $visit) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Are you sure you want to cancel this visit?')">
                            <i class='bx bx-x'></i> Cancel Visit
                        </button>
                    </form>
                @endif

                <a href="{{ route('room.show', $visit->room->slug) }}" class="btn btn-primary">
                    <i class='bx bx-home'></i> View Room Details
                </a>

                @if($visit->room->activeVirtualTour)
                    <a href="{{ route('virtual-tour.show', $visit->room) }}" class="btn btn-success">
                        <i class='bx bx-video'></i> Take Virtual Tour
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
