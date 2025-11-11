@extends('layouts.owner')

@section('title', 'View Room - ' . $room->room_title)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/owner-room-form.css') }}">
<style>
    /* View Page Specific Styles */
    .info-card {
        background: white;
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-xl);
        margin-bottom: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: var(--spacing-md);
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .info-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: var(--border-radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .info-icon i {
        font-size: 1.5rem;
        color: white;
    }
    
    .info-content h4 {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin: 0 0 0.25rem 0;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .info-content p {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-900);
        margin: 0;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius-full);
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .status-verified {
        background: var(--success-bg);
        color: var(--success-color);
    }
    
    .status-pending {
        background: #fff3cd;
        color: #856404;
    }
    
    .status-rejected {
        background: #f8d7da;
        color: #721c24;
    }
    
    .status-available {
        background: #d1ecf1;
        color: #0c5460;
    }
    
    .amenity-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1rem;
    }
    
    .amenity-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: var(--border-radius-md);
        border: 1px solid var(--gray-200);
        transition: all 0.3s ease;
    }
    
    .amenity-card:hover {
        background: white;
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }
    
    .amenity-card i {
        font-size: 1.5rem;
        color: var(--primary-color);
    }
    
    .amenity-card span {
        font-weight: 500;
        color: var(--gray-700);
    }
    
    .image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }
    
    .gallery-item {
        position: relative;
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .gallery-item:hover {
        box-shadow: var(--shadow-lg);
        transform: translateY(-4px);
    }
    
    .gallery-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        display: block;
    }
    
    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        padding: 1rem;
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
    
    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: var(--spacing-lg);
        padding-bottom: var(--spacing-md);
        border-bottom: 2px solid var(--gray-200);
    }
    
    .section-header i {
        font-size: 1.75rem;
        color: var(--primary-color);
    }
    
    .section-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
    }
    
    .delete-button {
        background: var(--danger-color);
        color: white;
    }
    
    .delete-button:hover {
        background: #c82333;
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')

<div class="room-form-container">
    {{-- Header --}}
    <div class="form-header">
        <div class="form-header-content">
            <h1 class="form-title">
                <i class='bx bx-show'></i>
                {{ $room->room_title }}
            </h1>
            <p class="form-subtitle">Complete room details and information</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('owner.rooms.edit', $room->slug) }}" class="btn btn-primary">
                <i class='bx bx-edit'></i>
                Edit Room
            </a>
            <a href="{{ route('owner.rooms.index') }}" class="btn btn-secondary">
                <i class='bx bx-arrow-back'></i>
                Back
            </a>
        </div>
    </div>

    {{-- Form Wrapper --}}
    <div class="form-wrapper">
        
        {{-- Status & Verification --}}
        <div class="info-card">
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-info-circle'></i>
                    </div>
                    <div class="info-content">
                        <h4>Room Status</h4>
                        <p>
                            <span class="status-badge status-{{ $room->status }}">
                                <i class='bx bx-check-circle'></i>
                                {{ ucfirst($room->status) }}
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-shield-check'></i>
                    </div>
                    <div class="info-content">
                        <h4>Verification</h4>
                        <p>
                            <span class="status-badge {{ $room->is_verified ? 'status-verified' : 'status-pending' }}">
                                <i class='bx {{ $room->is_verified ? "bx-check-circle" : "bx-time" }}'></i>
                                {{ $room->is_verified ? 'Verified' : 'Pending' }}
                            </span>
                        </p>
                    </div>
                </div>
                
                @if($room->room_number)
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-hash'></i>
                    </div>
                    <div class="info-content">
                        <h4>Room Number</h4>
                        <p>{{ $room->room_number }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Basic Information --}}
        <div class="info-card">
            <div class="section-header">
                <i class='bx bx-info-circle'></i>
                <h2>Basic Information</h2>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-rupee'></i>
                    </div>
                    <div class="info-content">
                        <h4>Room Price</h4>
                        <p>₹{{ number_format($room->room_price) }}/month</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-shield'></i>
                    </div>
                    <div class="info-content">
                        <h4>Security Deposit</h4>
                        <p>₹{{ number_format($room->security_deposit) }}</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-calendar'></i>
                    </div>
                    <div class="info-content">
                        <h4>Minimum Stay</h4>
                        <p>{{ $room->min_stay_months }} {{ $room->min_stay_months > 1 ? 'months' : 'month' }}</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-bed'></i>
                    </div>
                    <div class="info-content">
                        <h4>Total Beds</h4>
                        <p>{{ $room->total_beds }}</p>
                    </div>
                </div>
                
                @if($room->room_size)
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-area'></i>
                    </div>
                    <div class="info-content">
                        <h4>Room Size</h4>
                        <p>{{ $room->room_size }} sq.ft</p>
                    </div>
                </div>
                @endif
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-user'></i>
                    </div>
                    <div class="info-content">
                        <h4>Room Capacity</h4>
                        <p>{{ $room->room_capacity }} {{ $room->room_capacity > 1 ? 'people' : 'person' }}</p>
                    </div>
                </div>
                
                @if($room->floor)
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-building'></i>
                    </div>
                    <div class="info-content">
                        <h4>Floor</h4>
                        <p>{{ $room->floor }}{{ $room->floor == 1 ? 'st' : ($room->floor == 2 ? 'nd' : ($room->floor == 3 ? 'rd' : 'th')) }} Floor</p>
                    </div>
                </div>
                @endif
            </div>
            
            @if($room->room_description)
            <div style="margin-top: 2rem;">
                <h4 style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 0.5rem; text-transform: uppercase;">Description</h4>
                <p style="color: var(--gray-700); line-height: 1.6;">{{ $room->room_description }}</p>
            </div>
            @endif
        </div>

        {{-- Kitchen & Bathroom --}}
        <div class="info-card">
            <div class="section-header">
                <i class='bx bx-home'></i>
                <h2>Kitchen & Bathroom</h2>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-food-menu'></i>
                    </div>
                    <div class="info-content">
                        <h4>Kitchen Type</h4>
                        <p>{{ ucfirst($room->kitchen_type) }}</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-bath'></i>
                    </div>
                    <div class="info-content">
                        <h4>Bathroom Type</h4>
                        <p>{{ ucfirst($room->bathroom_type) }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Amenities --}}
        @if($room->amenities && $room->amenities->count() > 0)
        <div class="info-card">
            <div class="section-header">
                <i class='bx bx-star'></i>
                <h2>Amenities & Facilities</h2>
            </div>
            
            <div class="amenity-grid">
                @if($room->ac)
                <div class="amenity-card">
                    <i class='bx bx-wind'></i>
                    <span>Air Conditioning</span>
                </div>
                @endif
                
                @if($room->lift)
                <div class="amenity-card">
                    <i class='bx bx-up-arrow-circle'></i>
                    <span>Lift/Elevator</span>
                </div>
                @endif
                
                @if($room->parking)
                <div class="amenity-card">
                    <i class='bx bx-car'></i>
                    <span>Parking</span>
                </div>
                @endif
                
                @foreach($room->amenities as $amenity)
                <div class="amenity-card">
                    <i class='bx bx-check-circle'></i>
                    <span>{{ $amenity->amenity_name }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Location --}}
        <div class="info-card">
            <div class="section-header">
                <i class='bx bx-map'></i>
                <h2>Location Details</h2>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-map-pin'></i>
                    </div>
                    <div class="info-content">
                        <h4>Address</h4>
                        <p>{{ $room->address_line1 }}</p>
                        @if($room->address_line2)
                        <p style="font-size: 0.875rem; color: var(--gray-600); margin-top: 0.25rem;">{{ $room->address_line2 }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-current-location'></i>
                    </div>
                    <div class="info-content">
                        <h4>Locality</h4>
                        <p>{{ $room->locality }}</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-buildings'></i>
                    </div>
                    <div class="info-content">
                        <h4>City</h4>
                        <p>{{ $room->city }}</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-map-alt'></i>
                    </div>
                    <div class="info-content">
                        <h4>State</h4>
                        <p>{{ $room->state }}</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-envelope'></i>
                    </div>
                    <div class="info-content">
                        <h4>Pincode</h4>
                        <p>{{ $room->pincode }}</p>
                    </div>
                </div>
                
                @if($room->nearby_landmarks)
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-landmark'></i>
                    </div>
                    <div class="info-content">
                        <h4>Nearby Landmarks</h4>
                        <p>{{ $room->nearby_landmarks }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Additional Details --}}
        @if($room->entry_time || $room->exit_time || $room->restrictions)
        <div class="info-card">
            <div class="section-header">
                <i class='bx bx-detail'></i>
                <h2>Additional Details</h2>
            </div>
            
            <div class="info-grid">
                @if($room->entry_time)
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-log-in'></i>
                    </div>
                    <div class="info-content">
                        <h4>Entry Time</h4>
                        <p>{{ \Carbon\Carbon::parse($room->entry_time)->format('h:i A') }}</p>
                    </div>
                </div>
                @endif
                
                @if($room->exit_time)
                <div class="info-item">
                    <div class="info-icon">
                        <i class='bx bx-log-out'></i>
                    </div>
                    <div class="info-content">
                        <h4>Exit Time</h4>
                        <p>{{ \Carbon\Carbon::parse($room->exit_time)->format('h:i A') }}</p>
                    </div>
                </div>
                @endif
            </div>
            
            @if($room->restrictions)
            <div style="margin-top: 2rem;">
                <h4 style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 0.5rem; text-transform: uppercase;">Restrictions</h4>
                <p style="color: var(--gray-700); line-height: 1.6;">{{ $room->restrictions }}</p>
            </div>
            @endif
        </div>
        @endif

        {{-- Room Images --}}
        @if($room->images && $room->images->count() > 0)
        <div class="info-card">
            <div class="section-header">
                <i class='bx bx-images'></i>
                <h2>Room Images ({{ $room->images->count() }})</h2>
            </div>
            
            <div class="image-gallery">
                @foreach($room->images as $image)
                <div class="gallery-item" onclick="openImageModal('{{ asset($image->image_url) }}')">
                    <img src="{{ asset($image->image_url) }}" alt="Room Image {{ $loop->iteration }}">
                    <div class="gallery-overlay">
                        <p style="margin: 0; font-weight: 600;">Image {{ $loop->iteration }}</p>
                        <p style="margin: 0; font-size: 0.875rem;">Click to view full size</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Action Buttons --}}
        <div class="info-card" style="margin-top: 2rem;">
            <div style="display: flex; gap: 1rem; justify-content: space-between; flex-wrap: wrap;">
                <div style="display: flex; gap: 1rem;">
                    <a href="{{ route('owner.rooms.edit', $room->slug) }}" class="btn btn-primary">
                        <i class='bx bx-edit'></i>
                        Edit Room
                    </a>
                    <a href="{{ route('owner.rooms.index') }}" class="btn btn-secondary">
                        <i class='bx bx-arrow-back'></i>
                        Back to Rooms
                    </a>
                </div>
                <form action="{{ route('owner.rooms.destroy', $room->slug) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this room? This action cannot be undone.');" 
                      style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn delete-button">
                        <i class='bx bx-trash'></i>
                        Delete Room
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

{{-- Image Modal --}}
<div id="imageModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 9999; justify-content: center; align-items: center;" onclick="closeImageModal()">
    <span style="position: absolute; top: 20px; right: 40px; color: white; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
    <img id="modalImage" style="max-width: 90%; max-height: 90%; object-fit: contain;">
</div>

@endsection

@push('scripts')
<script>
function openImageModal(imageUrl) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('imageModal').style.display = 'flex';
}

function closeImageModal() {
    document.getElementById('imageModal').style.display = 'none';
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endpush
