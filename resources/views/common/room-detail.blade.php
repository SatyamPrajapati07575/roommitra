@extends('layouts.modern')
@section('title', $room->room_title . ' - RoomMitra')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
<link rel="stylesheet" href="{{ asset('css/room-detail-modern.css') }}">
<link rel="stylesheet" href="{{ asset('css/room-detail-buttons.css') }}">
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="container-modern" style="padding-top: 2rem;">
    <x-breadcrumb :items="[
        ['label' => 'Rooms', 'url' => route('rooms'), 'icon' => 'bx-buildings'],
        ['label' => $room->room_title, 'icon' => 'bx-home-smile']
    ]" />
</div>

{{-- Hero Section with Image Slider --}}
<div class="room-hero">
    @if($room->images && $room->images->count() > 0)
    <div class="swiper swiper-hero">
        <div class="swiper-wrapper">
            @foreach($room->images as $image)
            <div class="swiper-slide">
                <img src="{{ asset($image->image_url) }}" alt="{{ $room->room_title }}">
            </div>
            @endforeach
        </div>
        
        {{-- Navigation Arrows --}}
        <div class="swiper-button-next">
            <i class='bx bx-chevron-right'></i>
        </div>
        <div class="swiper-button-prev">
            <i class='bx bx-chevron-left'></i>
        </div>
        
        {{-- Pagination Dots --}}
        <div class="swiper-pagination"></div>
    </div>
    @endif
    
    <div class="hero-overlay">
        <div class="hero-content">
            <h1 data-aos="fade-up">{{ $room->room_title }}</h1>
            <div class="hero-meta" data-aos="fade-up" data-aos-delay="100">
                <div class="hero-location">
                    <i class='bx bx-map'></i>
                    <span>{{ ucwords($room->locality) }}, {{ ucwords($room->city) }}</span>
                </div>
                <div class="hero-badges">
                    @if($room->is_verified)
                    <span class="hero-badge verified">
                        <i class='bx bx-check-shield'></i> Verified
                    </span>
                    @endif
                    <span class="hero-badge">
                        <i class='bx bx-check-circle'></i> Available
                    </span>
                    <span class="hero-badge">
                        <i class='bx bx-{{ $room->room_capacity === 1 ? "user" : "group" }}'></i>
                        {{ $room->room_capacity === 1 ? 'Single' : $room->room_capacity . ' Sharing' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main Content --}}
<div class="room-detail-main">
    <div class="container-modern">
        <div class="detail-grid">
            
            {{-- Left Content --}}
            <div class="detail-left">
                
                {{-- Description --}}
                @if($room->room_description)
                <div class="info-card" data-aos="fade-up">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class='bx bx-info-circle'></i>
                        </div>
                        <h2 class="card-title">About This Room</h2>
                    </div>
                    <p class="description-text">{{ $room->room_description }}</p>
                </div>
                @endif
                
                {{-- Specifications --}}
                <div class="info-card" data-aos="fade-up">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class='bx bx-detail'></i>
                        </div>
                        <h2 class="card-title">Room Specifications</h2>
                    </div>
                    <div class="specs-grid">
                        <div class="spec-box">
                            <i class='bx bx-bed'></i>
                            <h4>Total Beds</h4>
                            <p>{{ $room->total_beds }}</p>
                        </div>
                        @if($room->room_size)
                        <div class="spec-box">
                            <i class='bx bx-area'></i>
                            <h4>Room Size</h4>
                            <p>{{ $room->room_size }} sq.ft</p>
                        </div>
                        @endif
                        <div class="spec-box">
                            <i class='bx bx-user'></i>
                            <h4>Capacity</h4>
                            <p>{{ $room->room_capacity }} {{ $room->room_capacity > 1 ? 'People' : 'Person' }}</p>
                        </div>
                        @if($room->floor)
                        <div class="spec-box">
                            <i class='bx bx-building'></i>
                            <h4>Floor</h4>
                            <p>{{ $room->floor }}{{ $room->floor == 1 ? 'st' : ($room->floor == 2 ? 'nd' : ($room->floor == 3 ? 'rd' : 'th')) }}</p>
                        </div>
                        @endif
                        <div class="spec-box">
                            <i class='bx bx-food-menu'></i>
                            <h4>Kitchen</h4>
                            <p>{{ ucfirst($room->kitchen_type) }}</p>
                        </div>
                        <div class="spec-box">
                            <i class='bx bx-bath'></i>
                            <h4>Bathroom</h4>
                            <p>{{ ucfirst($room->bathroom_type) }}</p>
                        </div>
                    </div>
                </div>
                
                {{-- Amenities --}}
                @if($room->amenities && $room->amenities->count() > 0)
                <div class="info-card" data-aos="fade-up">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class='bx bx-star'></i>
                        </div>
                        <h2 class="card-title">Amenities & Facilities</h2>
                    </div>
                    <div class="amenities-list">
                        @if($room->ac)
                        <div class="amenity-chip">
                            <i class='bx bx-wind'></i>
                            <span>Air Conditioning</span>
                        </div>
                        @endif
                        @if($room->lift)
                        <div class="amenity-chip">
                            <i class='bx bx-up-arrow-circle'></i>
                            <span>Lift/Elevator</span>
                        </div>
                        @endif
                        @if($room->parking)
                        <div class="amenity-chip">
                            <i class='bx bx-car'></i>
                            <span>Parking</span>
                        </div>
                        @endif
                        @foreach($room->amenities as $amenity)
                        <div class="amenity-chip">
                            <i class='bx bx-check-circle'></i>
                            <span>{{ $amenity->amenity_name }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                {{-- Location --}}
                <div class="info-card" data-aos="fade-up">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class='bx bx-map'></i>
                        </div>
                        <h2 class="card-title">Location</h2>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <div style="display: flex; gap: 1rem; padding: 1rem; background: #f8fafc; border-radius: 1rem;">
                            <i class='bx bx-map-pin' style="font-size: 1.5rem; color: #667eea;"></i>
                            <div>
                                <h4 style="margin: 0 0 0.5rem 0; color: #1e293b; font-weight: 600;">Address</h4>
                                <p style="margin: 0; color: #64748b; line-height: 1.6;">
                                    {{ $room->address_line1 }}@if($room->address_line2), {{ $room->address_line2 }}@endif
                                    <br>{{ ucwords($room->locality) }}, {{ ucwords($room->city) }}
                                    <br>{{ ucwords($room->state) }} - {{ $room->pincode }}
                                </p>
                            </div>
                        </div>
                        @if($room->nearby_landmarks)
                        <div style="display: flex; gap: 1rem; padding: 1rem; background: #f8fafc; border-radius: 1rem;">
                            <i class='bx bx-landmark' style="font-size: 1.5rem; color: #667eea;"></i>
                            <div>
                                <h4 style="margin: 0 0 0.5rem 0; color: #1e293b; font-weight: 600;">Nearby Landmarks</h4>
                                <p style="margin: 0; color: #64748b; line-height: 1.6;">{{ $room->nearby_landmarks }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
            </div>
            
            {{-- Right Sidebar --}}
            <div class="sidebar-sticky">
                <div class="price-card" data-aos="fade-left">
                    <div class="price-banner">
                        <div class="price-label">Monthly Rent</div>
                        <div class="price-value">₹{{ number_format($room->room_price) }}</div>
                        <div class="price-period">per month</div>
                    </div>
                    
                    <div class="price-features">
                        <div class="price-feature">
                            <strong>Security Deposit</strong>
                            <span>₹{{ number_format($room->security_deposit) }}</span>
                        </div>
                        <div class="price-feature">
                            <strong>Minimum Stay</strong>
                            <span>{{ $room->min_stay_months }} {{ $room->min_stay_months > 1 ? 'months' : 'month' }}</span>
                        </div>
                    </div>
                    
                    {{-- Booking & Contact Buttons --}}
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        @auth
                            {{-- Book Now Button - Primary --}}
                            <a href="{{ route('user.booking.checkout', $room->slug) }}" class="room-cta-button room-book-btn">
                                <i class='bx bx-calendar-check'></i>
                                <span>Book Now</span>
                            </a>
                            
                            {{-- Visit Buttons Row --}}
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                                {{-- Schedule Visit Button --}}
                                <a href="{{ route('visits.create', $room) }}" class="room-cta-button" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); font-size: 0.9rem; padding: 0.6rem 1rem;">
                                    <i class='bx bx-calendar-plus'></i>
                                    <span>Schedule Visit</span>
                                </a>
                                
                                {{-- Virtual Tour Button --}}
                                @if($room->activeVirtualTour)
                                    <a href="{{ route('virtual-tour.show', $room) }}" class="room-cta-button" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); font-size: 0.9rem; padding: 0.6rem 1rem;">
                                        <i class='bx bx-video'></i>
                                        <span>Virtual Tour</span>
                                    </a>
                                @else
                                    <button class="room-cta-button" style="background: #9ca3af; cursor: not-allowed; font-size: 0.9rem; padding: 0.6rem 1rem;" disabled>
                                        <i class='bx bx-video-off'></i>
                                        <span>No Virtual Tour</span>
                                    </button>
                                @endif
                            </div>
                            
                            {{-- Contact Owner Button - Secondary --}}
                            <a href="tel:{{ $room->owner->phone ?? '+91-XXXXXXXXXX' }}" class="room-cta-button room-contact-btn">
                                <i class='bx bx-phone'></i>
                                <span>Contact Owner</span>
                            </a>
                            
                            {{-- Secondary Actions Row --}}
                            <div class="room-icon-buttons">
                                <button class="room-icon-btn room-wishlist-btn {{ $isInWishlist ? 'active' : '' }}" 
                                        id="wishlistBtn" 
                                        data-room-id="{{ $room->room_id }}"
                                        data-in-wishlist="{{ $isInWishlist ? 'true' : 'false' }}"
                                        onclick="toggleWishlist({{ $room->room_id }})"
                                        title="{{ $isInWishlist ? 'Remove from Wishlist' : 'Add to Wishlist' }}">
                                    <i class='bx {{ $isInWishlist ? "bxs-heart" : "bx-heart" }}' id="wishlistIcon"></i>
                                </button>
                                <button class="room-icon-btn room-share-btn" 
                                        onclick="shareRoom()"
                                        title="Share this room">
                                    <i class='bx bx-share-alt'></i>
                                </button>
                            </div>
                        @else
                            {{-- Login to Book --}}
                            <a href="{{ route('login') }}" class="room-cta-button room-book-btn">
                                <i class='bx bx-log-in'></i>
                                <span>Login to Book</span>
                            </a>
                        @endauth
                    </div>
                </div>
                
                @if($room->owner)
                <div class="owner-card" data-aos="fade-left" data-aos-delay="100">
                    <div class="owner-header">
                        <div class="owner-avatar">
                            {{ strtoupper(substr($room->owner->name ?? 'O', 0, 1)) }}
                        </div>
                        <div class="owner-name">{{ $room->owner->name ?? 'Owner' }}</div>
                        <div class="owner-verified">
                            <i class='bx bx-shield-check'></i>
                            <span>KYC Verified</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            
        </div>
    </div>
</div>

{{-- Mobile Sticky Booking Bar --}}
@auth
<div class="mobile-booking-bar">
    <div class="mobile-bar-content">
        <div class="mobile-bar-price">
            <div class="mobile-bar-amount">₹{{ number_format($room->room_price) }}</div>
            <div class="mobile-bar-period">per month</div>
        </div>
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <button class="mobile-action-btn {{ $isInWishlist ? 'active' : '' }}" 
                    id="mobileWishlistBtn"
                    onclick="toggleWishlist({{ $room->room_id }})">
                <i class='bx {{ $isInWishlist ? "bxs-heart" : "bx-heart" }}' id="mobileWishlistIcon"></i>
            </button>
            <a href="{{ route('visits.create', $room) }}" class="mobile-action-btn" style="background: #10b981;">
                <i class='bx bx-calendar-plus'></i>
            </a>
            @if($room->activeVirtualTour)
                <a href="{{ route('virtual-tour.show', $room) }}" class="mobile-action-btn" style="background: #3b82f6;">
                    <i class='bx bx-video'></i>
                </a>
            @endif
            <a href="{{ route('user.booking.checkout', $room->slug) }}" class="mobile-bar-button">
                <i class='bx bx-calendar-check'></i>
                <span>Book</span>
            </a>
        </div>
    </div>
</div>
@endauth

{{-- Similar Rooms --}}
@if($similarRooms && $similarRooms->count() > 0)
<section class="similar-rooms-section">
    <div class="container-modern">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">More Options</span>
            <h2 class="section-title-modern">Similar Rooms in {{ ucwords($room->city) }}</h2>
        </div>
        <div class="row g-4">
            @foreach($similarRooms as $similarRoom)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                @include('components.room-card', ['room' => $similarRoom])
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
// Hero Image Slider
const heroSwiper = new Swiper('.swiper-hero', {
    slidesPerView: 1,
    loop: true,
    autoplay: {
        delay: 4000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    effect: 'fade',
    fadeEffect: {
        crossFade: true
    },
    speed: 800,
});

// Wishlist Toggle Function
function toggleWishlist(roomId) {
    const wishlistBtn = document.getElementById('wishlistBtn');
    const wishlistIcon = document.getElementById('wishlistIcon');
    const mobileWishlistBtn = document.getElementById('mobileWishlistBtn');
    const mobileWishlistIcon = document.getElementById('mobileWishlistIcon');
    const isInWishlist = wishlistBtn.getAttribute('data-in-wishlist') === 'true';
    
    fetch(`/wishlist/toggle/${roomId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Toggle the wishlist state
            const newState = !isInWishlist;
            wishlistBtn.setAttribute('data-in-wishlist', newState);
            
            // Update desktop button
            if (newState) {
                wishlistIcon.classList.remove('bx-heart');
                wishlistIcon.classList.add('bxs-heart');
                wishlistBtn.classList.add('active');
                wishlistBtn.title = 'Remove from Wishlist';
            } else {
                wishlistIcon.classList.remove('bxs-heart');
                wishlistIcon.classList.add('bx-heart');
                wishlistBtn.classList.remove('active');
                wishlistBtn.title = 'Add to Wishlist';
            }
            
            // Update mobile button if exists
            if (mobileWishlistBtn && mobileWishlistIcon) {
                if (newState) {
                    mobileWishlistIcon.classList.remove('bx-heart');
                    mobileWishlistIcon.classList.add('bxs-heart');
                    mobileWishlistBtn.classList.add('active');
                } else {
                    mobileWishlistIcon.classList.remove('bxs-heart');
                    mobileWishlistIcon.classList.add('bx-heart');
                    mobileWishlistBtn.classList.remove('active');
                }
            }
            
            // Trigger heartbeat animation
            wishlistIcon.classList.add('animate');
            setTimeout(() => {
                wishlistIcon.classList.remove('animate');
            }, 500);
            
            // Show success toast
            Swal.fire({
                icon: 'success',
                title: newState ? 'Added to Wishlist!' : 'Removed from Wishlist!',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: data.message || 'Something went wrong!',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Failed to update wishlist!',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
        });
    });
}

// Share Function
function shareRoom() {
    const roomUrl = window.location.href;
    const roomTitle = '{{ $room->room_title }}';
    
    if (navigator.share) {
        navigator.share({
            title: roomTitle,
            text: 'Check out this amazing room on RoomMitra!',
            url: roomUrl
        }).then(() => {
            console.log('Thanks for sharing!');
        }).catch(err => {
            console.log('Error sharing:', err);
        });
    } else {
        // Fallback: Copy to clipboard
        navigator.clipboard.writeText(roomUrl).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Link Copied!',
                text: 'Room link has been copied to clipboard',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        });
    }
}
</script>
@endpush
