@extends('layouts.modern')
@section('title', 'Virtual Tour - ' . $room->room_title)

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<style>
.virtual-tour-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 1rem;
}

.tour-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    text-align: center;
}

.tour-content {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
    margin-bottom: 2rem;
}

.tour-main {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.tour-sidebar {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    padding: 1.5rem;
    height: fit-content;
}

.tour-viewer {
    position: relative;
    height: 500px;
    background: #000;
}

.main-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.tour-controls {
    position: absolute;
    bottom: 1rem;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 0.5rem;
    background: rgba(0,0,0,0.7);
    padding: 0.5rem;
    border-radius: 8px;
}

.control-btn {
    background: rgba(255,255,255,0.2);
    color: white;
    border: none;
    padding: 0.5rem;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s;
}

.control-btn:hover {
    background: rgba(255,255,255,0.3);
}

.control-btn.active {
    background: #667eea;
}

.tour-thumbnails {
    padding: 1rem;
    background: #f8faff;
}

.thumbnails-swiper {
    margin: 0;
}

.thumbnail-slide {
    position: relative;
    cursor: pointer;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s;
}

.thumbnail-slide:hover {
    transform: scale(1.05);
}

.thumbnail-slide.active {
    border: 3px solid #667eea;
}

.thumbnail-image {
    width: 100%;
    height: 80px;
    object-fit: cover;
}

.thumbnail-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    color: white;
    padding: 0.5rem;
    font-size: 0.75rem;
}

.tour-info {
    margin-bottom: 1.5rem;
}

.tour-info h3 {
    color: #667eea;
    margin-bottom: 1rem;
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

.highlights {
    margin-bottom: 1.5rem;
}

.highlights h4 {
    color: #667eea;
    margin-bottom: 1rem;
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

.room-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    text-align: center;
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

.btn-outline {
    background: transparent;
    color: #667eea;
    border: 2px solid #667eea;
}

.tour-stats {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 1rem;
    padding: 1rem;
    background: #f8faff;
    border-radius: 12px;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: #667eea;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
}

.fullscreen-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.95);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
}

.fullscreen-image {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}

.fullscreen-close {
    position: absolute;
    top: 2rem;
    right: 2rem;
    background: rgba(255,255,255,0.2);
    color: white;
    border: none;
    padding: 1rem;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.5rem;
}

@media (max-width: 1024px) {
    .tour-content {
        grid-template-columns: 1fr;
    }
    
    .tour-sidebar {
        order: -1;
    }
}

@media (max-width: 768px) {
    .tour-viewer {
        height: 300px;
    }
    
    .tour-stats {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endpush

@section('content')
<div class="virtual-tour-container">
    <div class="tour-header">
        <h1><i class='bx bx-video'></i> Virtual Tour</h1>
        <h2>{{ $virtualTour->tour_title }}</h2>
        <p>{{ $virtualTour->tour_description }}</p>
    </div>

    <div class="tour-content">
        <div class="tour-main">
            <div class="tour-viewer">
                <img id="mainImage" src="{{ $virtualTour->tour_images[0]['url'] ?? '' }}" 
                     alt="Room Tour" class="main-image">
                
                <div class="tour-controls">
                    <button class="control-btn" onclick="previousImage()">
                        <i class='bx bx-chevron-left'></i>
                    </button>
                    <button class="control-btn" onclick="togglePlay()">
                        <i class='bx bx-play' id="playIcon"></i>
                    </button>
                    <button class="control-btn" onclick="nextImage()">
                        <i class='bx bx-chevron-right'></i>
                    </button>
                    <button class="control-btn" onclick="toggleFullscreen()">
                        <i class='bx bx-fullscreen'></i>
                    </button>
                </div>
            </div>

            <div class="tour-thumbnails">
                <div class="swiper thumbnails-swiper">
                    <div class="swiper-wrapper">
                        @foreach($virtualTour->tour_images as $index => $image)
                            <div class="swiper-slide">
                                <div class="thumbnail-slide {{ $index === 0 ? 'active' : '' }}" 
                                     onclick="showImage({{ $index }})">
                                    <img src="{{ $image['url'] }}" alt="Thumbnail" class="thumbnail-image">
                                    <div class="thumbnail-overlay">
                                        {{ $image['description'] ?? 'Image ' . ($index + 1) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="tour-sidebar">
            <div class="tour-info">
                <h3>{{ $room->room_title }}</h3>
                <div class="info-item">
                    <span>Location:</span>
                    <span>{{ $room->locality }}, {{ $room->city }}</span>
                </div>
                <div class="info-item">
                    <span>Price:</span>
                    <span>₹{{ number_format($room->room_price) }}/month</span>
                </div>
                <div class="info-item">
                    <span>Capacity:</span>
                    <span>{{ $room->room_capacity }} {{ $room->room_capacity > 1 ? 'people' : 'person' }}</span>
                </div>
                <div class="info-item">
                    <span>Tour Duration:</span>
                    <span>{{ $virtualTour->formatted_duration }}</span>
                </div>
            </div>

            @if($virtualTour->highlights && count($virtualTour->highlights) > 0)
                <div class="highlights">
                    <h4>Key Features</h4>
                    @foreach($virtualTour->highlights as $highlight)
                        <div class="highlight-item">
                            <i class='bx bx-check-circle'></i>
                            <span>{{ $highlight }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="room-actions">
                @auth
                    <a href="{{ route('visits.create', $room) }}" class="btn btn-primary">
                        <i class='bx bx-calendar-plus'></i> Schedule Visit
                    </a>
                @else
                    <a href="{{ route('login.form') }}" class="btn btn-primary">
                        <i class='bx bx-user'></i> Login to Schedule Visit
                    </a>
                @endauth
                
                <a href="{{ route('room.show', $room->slug) }}" class="btn btn-outline">
                    <i class='bx bx-info-circle'></i> Room Details
                </a>
                
                @auth
                    <a href="{{ route('wishlist.toggle', $room->room_id) }}" class="btn btn-success">
                        <i class='bx bx-heart'></i> Add to Wishlist
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="tour-stats">
        <div class="stat-item">
            <div class="stat-number">{{ $virtualTour->total_images }}</div>
            <div class="stat-label">Images</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $virtualTour->total_videos }}</div>
            <div class="stat-label">Videos</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $virtualTour->view_count }}</div>
            <div class="stat-label">Views</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $virtualTour->formatted_duration }}</div>
            <div class="stat-label">Duration</div>
        </div>
    </div>
</div>

<!-- Fullscreen Overlay -->
<div class="fullscreen-overlay" id="fullscreenOverlay">
    <button class="fullscreen-close" onclick="exitFullscreen()">
        <i class='bx bx-x'></i>
    </button>
    <img id="fullscreenImage" src="" alt="Fullscreen" class="fullscreen-image">
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
let currentImageIndex = 0;
let isPlaying = false;
let playInterval;
const images = @json($virtualTour->tour_images);

// Initialize Swiper
const thumbnailSwiper = new Swiper('.thumbnails-swiper', {
    slidesPerView: 'auto',
    spaceBetween: 10,
    freeMode: true,
    breakpoints: {
        640: {
            slidesPerView: 3,
        },
        768: {
            slidesPerView: 4,
        },
        1024: {
            slidesPerView: 5,
        },
    }
});

function showImage(index) {
    currentImageIndex = index;
    const mainImage = document.getElementById('mainImage');
    mainImage.src = images[index].url;
    
    // Update thumbnail active state
    document.querySelectorAll('.thumbnail-slide').forEach((thumb, i) => {
        thumb.classList.toggle('active', i === index);
    });
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % images.length;
    showImage(currentImageIndex);
}

function previousImage() {
    currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
    showImage(currentImageIndex);
}

function togglePlay() {
    const playIcon = document.getElementById('playIcon');
    
    if (isPlaying) {
        clearInterval(playInterval);
        playIcon.className = 'bx bx-play';
        isPlaying = false;
    } else {
        playInterval = setInterval(nextImage, 3000);
        playIcon.className = 'bx bx-pause';
        isPlaying = true;
    }
}

function toggleFullscreen() {
    const overlay = document.getElementById('fullscreenOverlay');
    const fullscreenImage = document.getElementById('fullscreenImage');
    
    fullscreenImage.src = images[currentImageIndex].url;
    overlay.style.display = 'flex';
}

function exitFullscreen() {
    const overlay = document.getElementById('fullscreenOverlay');
    overlay.style.display = 'none';
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    switch(e.key) {
        case 'ArrowLeft':
            previousImage();
            break;
        case 'ArrowRight':
            nextImage();
            break;
        case ' ':
            e.preventDefault();
            togglePlay();
            break;
        case 'Escape':
            exitFullscreen();
            break;
        case 'f':
        case 'F':
            toggleFullscreen();
            break;
    }
});

// Close fullscreen on click outside image
document.getElementById('fullscreenOverlay').addEventListener('click', function(e) {
    if (e.target === this) {
        exitFullscreen();
    }
});
</script>
@endpush
