@extends('layouts.modern')
@section('title', 'My Visits')

@push('styles')
<style>
.visits-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    text-align: center;
}

.visits-grid {
    display: grid;
    gap: 1.5rem;
}

.visit-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s;
}

.visit-card:hover {
    transform: translateY(-4px);
}

.visit-card-header {
    padding: 1.5rem;
    background: #f8faff;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: start;
    flex-wrap: wrap;
    gap: 1rem;
}

.visit-card-body {
    padding: 1.5rem;
}

.room-info {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.room-image {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    flex-shrink: 0;
}

.room-details h5 {
    color: #667eea;
    margin-bottom: 0.5rem;
}

.room-details p {
    margin: 0.25rem 0;
    color: #6b7280;
    font-size: 0.875rem;
}

.visit-status {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
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
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    margin-top: 0.5rem;
}

.type-physical { background: #d1fae5; color: #065f46; }
.type-virtual { background: #dbeafe; color: #1e40af; }

.visit-meta {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 1rem 0;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    font-size: 0.875rem;
}

.meta-item i {
    color: #667eea;
}

.visit-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-top: 1rem;
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
    gap: 0.5rem;
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

.btn-outline {
    background: transparent;
    color: #667eea;
    border: 1px solid #667eea;
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

@media (max-width: 768px) {
    .visit-card-header {
        flex-direction: column;
        align-items: start;
    }
    
    .room-info {
        flex-direction: column;
    }
    
    .room-image {
        width: 100%;
        height: 120px;
    }
    
    .visit-meta {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="visits-container">
    <div class="page-header">
        <h1><i class='bx bx-calendar-check'></i> My Visits</h1>
        <p>Track all your room visit requests and schedules</p>
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
            <div class="stat-label">Total Visits</div>
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

    @if($visits->count() > 0)
        <div class="visits-grid">
            @foreach($visits as $visit)
                <div class="visit-card">
                    <div class="visit-card-header">
                        <div>
                            <h6>Visit #{{ str_pad($visit->visit_id, 6, '0', STR_PAD_LEFT) }}</h6>
                            <small class="text-muted">{{ $visit->created_at->format('d M Y, h:i A') }}</small>
                        </div>
                        <div>
                            <span class="visit-status status-{{ $visit->status }}">
                                {{ ucfirst($visit->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="visit-card-body">
                        <div class="room-info">
                            @if($visit->room->images->count() > 0)
                                <img src="{{ $visit->room->images->first()->image_url }}" alt="Room" class="room-image">
                            @else
                                <div class="room-image" style="background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                    <i class='bx bx-image' style="color: #9ca3af;"></i>
                                </div>
                            @endif
                            <div class="room-details">
                                <h5>{{ $visit->room->room_title }}</h5>
                                <p><i class='bx bx-map'></i> {{ $visit->room->locality }}, {{ $visit->room->city }}</p>
                                <p><i class='bx bx-rupee'></i> ₹{{ number_format($visit->room->room_price) }}/month</p>
                                <span class="visit-type-badge type-{{ $visit->visit_type }}">
                                    <i class='bx bx-{{ $visit->visit_type === 'virtual' ? 'video' : 'walk' }}'></i>
                                    {{ ucfirst($visit->visit_type) }}
                                </span>
                            </div>
                        </div>

                        <div class="visit-meta">
                            <div class="meta-item">
                                <i class='bx bx-calendar'></i>
                                <span>{{ $visit->formatted_preferred_date_time }}</span>
                            </div>
                            @if($visit->confirmed_date)
                                <div class="meta-item">
                                    <i class='bx bx-check-circle'></i>
                                    <span>Confirmed: {{ $visit->formatted_confirmed_date_time }}</span>
                                </div>
                            @endif
                            <div class="meta-item">
                                <i class='bx bx-user'></i>
                                <span>Owner: {{ $visit->room->owner->name }}</span>
                            </div>
                        </div>

                        <div class="visit-actions">
                            <a href="{{ route('visits.show', $visit) }}" class="btn btn-primary">
                                <i class='bx bx-show'></i> View Details
                            </a>
                            
                            @if($visit->visit_type === 'virtual' && $visit->status === 'confirmed' && $visit->meeting_link)
                                <a href="{{ $visit->meeting_link }}" target="_blank" class="btn btn-success">
                                    <i class='bx bx-video'></i> Join Meeting
                                </a>
                            @endif

                            @if($visit->room->activeVirtualTour)
                                <a href="{{ route('virtual-tour.show', $visit->room) }}" class="btn btn-outline">
                                    <i class='bx bx-video'></i> Virtual Tour
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $visits->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class='bx bx-calendar-x'></i>
            <h3>No Visits Yet</h3>
            <p>You haven't scheduled any room visits yet. Start exploring rooms and schedule your first visit!</p>
            <a href="{{ route('rooms') }}" class="btn btn-primary" style="margin-top: 1rem;">
                <i class='bx bx-search'></i> Browse Rooms
            </a>
        </div>
    @endif
</div>
@endsection
