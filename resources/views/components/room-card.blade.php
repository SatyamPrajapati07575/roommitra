<!-- Modern Room Card Component -->
@props(['room'])

<div class="room-card-modern" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 ?? 0 }}">
    <!-- Card Image -->
    <div class="room-card-image">
        @if($room->images && $room->images->first())
            <img src="{{ asset($room->images->first()->image_url) }}" 
                 alt="{{ $room->room_title }}"
                 loading="lazy">
        @else
            <!-- Default No Image Placeholder -->
            <div class="no-image-placeholder">
                <i class='bx bx-image'></i>
                <span>No Image Available</span>
            </div>
        @endif
        
        <!-- Verified Badge -->
        @if($room->is_verified)
            <span class="room-badge verified">
                <i class='bx bx-check-shield'></i> Verified
            </span>
        @else
            <span class="room-badge pending">
                <i class='bx bx-time'></i> Pending
            </span>
        @endif
        
        <!-- Wishlist Button -->
        @auth
            <button class="wishlist-btn {{ auth()->user()->wishlists->where('room_id', $room->room_id)->count() ? 'active' : '' }}" 
                    onclick="toggleWishlist({{ $room->room_id }}, this)"
                    title="Add to Wishlist">
                <i class='bx {{ auth()->user()->wishlists->where('room_id', $room->room_id)->count() ? 'bxs-heart' : 'bx-heart' }}'></i>
            </button>
            
            <!-- Compare Button -->
            <button class="compare-btn {{ \App\Models\Compare::where('user_id', auth()->user()->user_id)->where('room_id', $room->room_id)->count() ? 'active' : '' }}" 
                    onclick="toggleCompare({{ $room->room_id }}, this)"
                    title="Add to Compare">
                <i class='bx bx-git-compare'></i>
            </button>
        @endauth
    </div>
    
    <!-- Card Body -->
    <div class="room-card-body">
        <!-- Room Title -->
        <h3 class="room-card-title" title="{{ $room->room_title }}">
            {{ $room->room_title }}
        </h3>
        
        <!-- Location -->
        <div class="room-card-location">
            <i class='bx bx-map'></i>
            <span>{{ ucwords($room->locality) }}, {{ ucwords($room->city) }}</span>
        </div>
        
        <!-- Price -->
        <div class="room-card-price">
            ₹{{ number_format($room->room_price) }}
            <span>/month</span>
        </div>
        
        <!-- Features -->
        <div class="room-card-features">
            <div class="feature-item">
                <i class='bx bx-user'></i>
                <span>{{ $room->room_capacity === 1 ? 'Single' : $room->room_capacity . ' Sharing' }}</span>
            </div>
            <div class="feature-item">
                <i class='bx bx-bath'></i>
                <span>{{ ucwords($room->bathroom_type) }}</span>
            </div>
            <div class="feature-item">
                <i class='bx bx-area'></i>
                <span>{{ $room->room_size ?? 'N/A' }} sq.ft</span>
            </div>
        </div>
        
        <!-- Amenities -->
        @if($room->amenities->count() > 0)
            <div class="room-amenities">
                @foreach($room->amenities->take(4) as $amenity)
                    <span class="amenity-tag">
                        @php
                            $amenityIcons = [
                                'WiFi' => 'bx-wifi',
                                'wifi' => 'bx-wifi',
                                'Laundry' => 'bx-tshirt',
                                'laundry' => 'bx-tshirt',
                                'RO Water' => 'bx-water',
                                'ro' => 'bx-water',
                                'Fridge' => 'bx-fridge',
                                'TV' => 'bx-tv',
                                'tv' => 'bx-tv',
                                'AC' => 'bx-wind',
                                'Parking' => 'bx-car',
                            ];
                            $iconClass = $amenityIcons[$amenity->amenity_name] ?? 'bx-check-circle';
                        @endphp
                        <i class='bx {{ $iconClass }}'></i>
                        {{ $amenity->amenity_name }}
                    </span>
                @endforeach
                @if($room->amenities->count() > 4)
                    <span class="amenity-tag">+{{ $room->amenities->count() - 4 }} more</span>
                @endif
            </div>
        @endif
        
        <!-- Actions -->
        <div class="room-card-actions">
            <a href="{{ route('room.show', $room->slug) }}" class="btn btn-primary w-100">
                <i class='bx bx-show'></i>
                <span>View Details</span>
            </a>
        </div>
    </div>
</div>

<style>
/* No Image Placeholder */
.no-image-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    color: white;
}

.no-image-placeholder i {
    font-size: 4rem;
    opacity: 0.9;
}

.no-image-placeholder span {
    font-size: 1rem;
    font-weight: 600;
    opacity: 0.9;
}

/* Room Badge - Small Corner Badge */
.room-card-modern .room-card-image .room-badge {
    position: absolute !important;
    bottom: 0.5rem !important;
    left: 0.5rem !important;
    right: auto !important;
    top: auto !important;
    width: auto !important;
    height: auto !important;
    padding: 0.35rem 0.75rem !important;
    border-radius: 1.5rem !important;
    font-size: 0.7rem !important;
    font-weight: 600 !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.35rem !important;
    z-index: 4 !important;
    box-shadow: 0 2px 6px rgba(0,0,0,0.25) !important;
    backdrop-filter: blur(4px) !important;
    white-space: nowrap !important;
    line-height: 1 !important;
}

.room-card-modern .room-card-image .room-badge i {
    font-size: 0.85rem !important;
    line-height: 1 !important;
}

.room-card-modern .room-card-image .room-badge.verified {
    background: rgba(16, 185, 129, 0.95) !important;
    color: white !important;
}

.room-card-modern .room-card-image .room-badge.pending {
    background: rgba(245, 158, 11, 0.95) !important;
    color: white !important;
}

/* Compare Button Styles */
.compare-btn {
    position: absolute;
    top: 0.75rem;
    left: 0.75rem;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.95);
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 5;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.compare-btn i {
    font-size: 1.25rem;
    color: #667eea;
    transition: color 0.3s ease;
}

.compare-btn:hover {
    background: #667eea;
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.compare-btn:hover i {
    color: white;
}

.compare-btn.active {
    background: #667eea;
}

.compare-btn.active i {
    color: white;
}

/* Wishlist Button - Ensure it's on the right */
.wishlist-btn {
    position: absolute;
    top: 0.75rem;
    right: 0.75rem;
    left: auto !important;
    width: 40px;
    height: 40px;
    z-index: 5;
}
</style>

<script>
// Wishlist Toggle Function
function toggleWishlist(roomId, button) {
    fetch(`/wishlist/toggle/${roomId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const icon = button.querySelector('i');
            
            // Check if added or removed based on status
            if (data.status === 'added') {
                icon.classList.remove('bx-heart');
                icon.classList.add('bxs-heart');
                button.classList.add('active');
                Toast.fire({
                    icon: 'success',
                    title: 'Added to wishlist!'
                });
            } else if (data.status === 'removed') {
                icon.classList.remove('bxs-heart');
                icon.classList.add('bx-heart');
                button.classList.remove('active');
                Toast.fire({
                    icon: 'info',
                    title: 'Removed from wishlist'
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong!'
        });
    });
}

// Compare Toggle Function
function toggleCompare(roomId, button) {
    fetch(`/user/compare/toggle/${roomId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const icon = button.querySelector('i');
            if (data.added) {
                button.classList.add('active');
                Toast.fire({
                    icon: 'success',
                    title: 'Added to compare!'
                });
            } else {
                button.classList.remove('active');
                Toast.fire({
                    icon: 'info',
                    title: 'Removed from compare'
                });
            }
        } else {
            Toast.fire({
                icon: 'warning',
                title: data.message || 'Maximum 4 rooms can be compared'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong!'
        });
    });
}
</script>
