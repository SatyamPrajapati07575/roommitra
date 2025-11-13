@extends('layouts.owner')
@section('title', 'Virtual Tours')

@push('styles')
<style>
.tours-container {
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

.header-actions {
    margin-top: 1rem;
}

.btn-create {
    background: rgba(255,255,255,0.2);
    color: white;
    padding: 0.75rem 1.5rem;
    border: 2px solid rgba(255,255,255,0.3);
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.btn-create:hover {
    background: rgba(255,255,255,0.3);
    color: white;
    transform: translateY(-2px);
}

.tours-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
}

.tour-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s;
}

.tour-card:hover {
    transform: translateY(-4px);
}

.tour-thumbnail {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.tour-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.tour-overlay {
    position: absolute;
    top: 1rem;
    right: 1rem;
    display: flex;
    gap: 0.5rem;
}

.tour-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.badge-active {
    background: #d1fae5;
    color: #065f46;
}

.badge-inactive {
    background: #fee2e2;
    color: #991b1b;
}

.tour-stats {
    position: absolute;
    bottom: 1rem;
    left: 1rem;
    display: flex;
    gap: 1rem;
}

.stat-item {
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.tour-content {
    padding: 1.5rem;
}

.tour-title {
    color: #374151;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.tour-room {
    color: #667eea;
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.tour-description {
    color: #6b7280;
    font-size: 0.875rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.tour-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    color: #6b7280;
}

.tour-actions {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
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

.btn:hover {
    transform: translateY(-1px);
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

.btn-outline {
    background: transparent;
    color: #667eea;
    border: 1px solid #667eea;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6b7280;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
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
    .tours-grid {
        grid-template-columns: 1fr;
    }
    
    .tour-actions {
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')
<div class="tours-container">
    <div class="page-header">
        <h1><i class='bx bx-video'></i> Virtual Tours</h1>
        <p>Manage virtual tours for your properties</p>
        <div class="header-actions">
            <a href="{{ route('owner.virtual-tours.create') }}" class="btn-create">
                <i class='bx bx-plus'></i> Create Virtual Tour
            </a>
        </div>
    </div>

    @php
        $totalTours = $virtualTours->total();
        $activeTours = $virtualTours->where('is_active', true)->count();
        $totalViews = $virtualTours->sum('view_count');
        $avgViews = $totalTours > 0 ? round($totalViews / $totalTours) : 0;
    @endphp

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $totalTours }}</div>
            <div class="stat-label">Total Tours</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $activeTours }}</div>
            <div class="stat-label">Active Tours</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $totalViews }}</div>
            <div class="stat-label">Total Views</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $avgViews }}</div>
            <div class="stat-label">Avg Views/Tour</div>
        </div>
    </div>

    @if($virtualTours->count() > 0)
        <div class="tours-grid">
            @foreach($virtualTours as $tour)
                <div class="tour-card">
                    <div class="tour-thumbnail">
                        @if($tour->tour_images && count($tour->tour_images) > 0)
                            <img src="{{ $tour->tour_images[0]['url'] }}" alt="Tour" class="tour-image">
                        @else
                            <div class="tour-image" style="background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                                <i class='bx bx-image' style="font-size: 3rem; color: #9ca3af;"></i>
                            </div>
                        @endif
                        
                        <div class="tour-overlay">
                            <span class="tour-badge {{ $tour->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $tour->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                        
                        <div class="tour-stats">
                            <div class="stat-item">
                                <i class='bx bx-image'></i>
                                <span>{{ $tour->total_images }}</span>
                            </div>
                            <div class="stat-item">
                                <i class='bx bx-video'></i>
                                <span>{{ $tour->total_videos }}</span>
                            </div>
                            <div class="stat-item">
                                <i class='bx bx-show'></i>
                                <span>{{ $tour->view_count }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tour-content">
                        <h3 class="tour-title">{{ $tour->tour_title }}</h3>
                        <div class="tour-room">
                            <i class='bx bx-home'></i> {{ $tour->room->room_title }}
                        </div>
                        
                        @if($tour->tour_description)
                            <p class="tour-description">{{ $tour->tour_description }}</p>
                        @endif
                        
                        <div class="tour-meta">
                            <span>
                                <i class='bx bx-time'></i> {{ $tour->formatted_duration }}
                            </span>
                            <span>
                                <i class='bx bx-calendar'></i> {{ $tour->created_at->format('d M Y') }}
                            </span>
                        </div>
                        
                        <div class="tour-actions">
                            <a href="{{ route('owner.virtual-tours.show', $tour) }}" class="btn btn-primary">
                                <i class='bx bx-show'></i> View
                            </a>
                            
                            <a href="{{ route('virtual-tour.show', $tour->room) }}" target="_blank" class="btn btn-success">
                                <i class='bx bx-video'></i> Preview
                            </a>
                            
                            <a href="{{ route('owner.virtual-tours.edit', $tour) }}" class="btn btn-warning">
                                <i class='bx bx-edit'></i> Edit
                            </a>
                            
                            <form action="{{ route('owner.virtual-tours.toggle-status', $tour) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $tour->is_active ? 'btn-outline' : 'btn-success' }}">
                                    <i class='bx bx-{{ $tour->is_active ? 'pause' : 'play' }}'></i>
                                    {{ $tour->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            
                            <form action="{{ route('owner.virtual-tours.destroy', $tour) }}" method="POST" 
                                  style="display: inline;" 
                                  onsubmit="return confirm('Are you sure you want to delete this virtual tour?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class='bx bx-trash'></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $virtualTours->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class='bx bx-video-off'></i>
            <h3>No Virtual Tours</h3>
            <p>You haven't created any virtual tours yet. Create your first virtual tour to showcase your rooms!</p>
            <a href="{{ route('owner.virtual-tours.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                <i class='bx bx-plus'></i> Create Virtual Tour
            </a>
        </div>
    @endif
</div>
@endsection
