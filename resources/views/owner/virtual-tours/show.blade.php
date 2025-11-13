@extends('layouts.owner')
@section('title', 'Virtual Tour Details')

@push('styles')
<style>
.tour-details-container {
    padding: 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.tour-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

.tour-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
}

.tour-status {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.875rem;
    margin-left: 1rem;
}

.status-active { background: #d1fae5; color: #065f46; }
.status-inactive { background: #fee2e2; color: #991b1b; }

.tour-content {
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

.media-gallery {
    margin-bottom: 2rem;
}

.media-section {
    margin-bottom: 2rem;
}

.media-section h4 {
    color: #667eea;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
}

.media-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    background: #f3f4f6;
}

.media-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.media-video {
    width: 100%;
    height: 150px;
}

.media-description {
    padding: 0.5rem;
    font-size: 0.875rem;
    color: #6b7280;
    background: rgba(255,255,255,0.9);
}

.highlights-list {
    background: #f0f9ff;
    border-radius: 12px;
    padding: 1.5rem;
}

.highlights-list h4 {
    color: #0ea5e9;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.highlight-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0;
    color: #374151;
}

.highlight-item i {
    color: #10b981;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-align: center;
    border: 2px solid #f3f4f6;
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

.action-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 2rem;
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
    border: 2px solid #667eea;
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
    
    .media-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')
<div class="tour-details-container">
    <div class="tour-card">
        <div class="tour-header">
            <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap;">
                <div>
                    <h1><i class='bx bx-video'></i> {{ $virtualTour->tour_title }}</h1>
                    <p>Tour ID: #{{ str_pad($virtualTour->tour_id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <span class="tour-status status-{{ $virtualTour->is_active ? 'active' : 'inactive' }}">
                        {{ $virtualTour->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="tour-content">
            <!-- Room Preview -->
            <div class="room-preview">
                @if($virtualTour->room->images->count() > 0)
                    <img src="{{ $virtualTour->room->images->first()->image_url }}" alt="Room" class="room-image">
                @else
                    <div class="room-image" style="background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                        <i class='bx bx-image' style="font-size: 2rem; color: #9ca3af;"></i>
                    </div>
                @endif
                <div class="room-details">
                    <h5>{{ $virtualTour->room->room_title }}</h5>
                    <p><i class='bx bx-map'></i> {{ $virtualTour->room->locality }}, {{ $virtualTour->room->city }}</p>
                    <p><i class='bx bx-rupee'></i> ₹{{ number_format($virtualTour->room->room_price) }}/month</p>
                    <p><i class='bx bx-calendar-plus'></i> Created on {{ $virtualTour->created_at->format('d M Y, h:i A') }}</p>
                </div>
            </div>

            <!-- Statistics -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $virtualTour->view_count }}</div>
                    <div class="stat-label">Total Views</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $virtualTour->total_images }}</div>
                    <div class="stat-label">Images</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $virtualTour->total_videos }}</div>
                    <div class="stat-label">Videos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $virtualTour->formatted_duration }}</div>
                    <div class="stat-label">Duration</div>
                </div>
            </div>

            <!-- Tour Information -->
            <div class="info-grid">
                <div class="info-section">
                    <h4><i class='bx bx-info-circle'></i> Tour Details</h4>
                    <div class="info-item">
                        <span class="info-label">Title:</span>
                        <span class="info-value">{{ $virtualTour->tour_title }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Duration:</span>
                        <span class="info-value">{{ $virtualTour->formatted_duration }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status:</span>
                        <span class="info-value">{{ $virtualTour->is_active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Created:</span>
                        <span class="info-value">{{ $virtualTour->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    @if($virtualTour->updated_at != $virtualTour->created_at)
                    <div class="info-item">
                        <span class="info-label">Last Updated:</span>
                        <span class="info-value">{{ $virtualTour->updated_at->format('d M Y, h:i A') }}</span>
                    </div>
                    @endif
                </div>

                <div class="info-section">
                    <h4><i class='bx bx-chart-line'></i> Performance</h4>
                    <div class="info-item">
                        <span class="info-label">Total Views:</span>
                        <span class="info-value">{{ $virtualTour->view_count }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Views Today:</span>
                        <span class="info-value">0</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Views This Week:</span>
                        <span class="info-value">{{ $virtualTour->view_count }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Avg. View Duration:</span>
                        <span class="info-value">{{ round($virtualTour->duration_minutes * 0.7) }} min</span>
                    </div>
                </div>
            </div>

            @if($virtualTour->tour_description)
            <div class="info-section">
                <h4><i class='bx bx-note'></i> Description</h4>
                <p>{{ $virtualTour->tour_description }}</p>
            </div>
            @endif

            <!-- Tour Highlights -->
            @if($virtualTour->highlights && count($virtualTour->highlights) > 0)
            <div class="highlights-list">
                <h4><i class='bx bx-star'></i> Tour Highlights</h4>
                @foreach($virtualTour->highlights as $highlight)
                    <div class="highlight-item">
                        <i class='bx bx-check-circle'></i>
                        <span>{{ $highlight }}</span>
                    </div>
                @endforeach
            </div>
            @endif

            <!-- Media Gallery -->
            <div class="media-gallery">
                @if($virtualTour->tour_images && count($virtualTour->tour_images) > 0)
                <div class="media-section">
                    <h4><i class='bx bx-image'></i> Tour Images ({{ count($virtualTour->tour_images) }})</h4>
                    <div class="media-grid">
                        @foreach($virtualTour->tour_images as $image)
                            <div class="media-item">
                                <img src="{{ $image['url'] }}" alt="Tour Image" class="media-image">
                                @if(isset($image['description']) && $image['description'])
                                    <div class="media-description">{{ $image['description'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($virtualTour->tour_videos && count($virtualTour->tour_videos) > 0)
                <div class="media-section">
                    <h4><i class='bx bx-video'></i> Tour Videos ({{ count($virtualTour->tour_videos) }})</h4>
                    <div class="media-grid">
                        @foreach($virtualTour->tour_videos as $video)
                            <div class="media-item">
                                <video src="{{ $video['url'] }}" class="media-video" controls></video>
                                @if(isset($video['description']) && $video['description'])
                                    <div class="media-description">{{ $video['description'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('virtual-tour.show', $virtualTour->room) }}" target="_blank" class="btn btn-success">
                    <i class='bx bx-video'></i> Preview Tour
                </a>

                <a href="{{ route('owner.virtual-tours.edit', $virtualTour) }}" class="btn btn-warning">
                    <i class='bx bx-edit'></i> Edit Tour
                </a>

                <form action="{{ route('owner.virtual-tours.toggle-status', $virtualTour) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $virtualTour->is_active ? 'btn-outline' : 'btn-success' }}">
                        <i class='bx bx-{{ $virtualTour->is_active ? 'pause' : 'play' }}'></i>
                        {{ $virtualTour->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>

                <a href="{{ route('owner.virtual-tours.index') }}" class="btn btn-outline">
                    <i class='bx bx-arrow-back'></i> Back to Tours
                </a>

                <a href="{{ route('owner.rooms.show', $virtualTour->room) }}" class="btn btn-primary">
                    <i class='bx bx-home'></i> View Room
                </a>

                <form action="{{ route('owner.virtual-tours.destroy', $virtualTour) }}" method="POST" 
                      style="display: inline;" 
                      onsubmit="return confirm('Are you sure you want to delete this virtual tour? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class='bx bx-trash'></i> Delete Tour
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
