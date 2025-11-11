@extends('layouts.modern')
@section('title', 'My Wishlist - Saved Rooms')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<style>
    .wishlist-hero {
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        padding: 4rem 0 3rem;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }
    
    .wishlist-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><path d="M50 30 L70 50 L50 70 L30 50 Z" fill="rgba(255,255,255,0.05)"/></svg>');
        background-size: 80px 80px;
        opacity: 0.4;
    }
    
    .wishlist-hero-content {
        position: relative;
        z-index: 1;
        color: white;
        text-align: center;
    }
    
    .wishlist-hero-content h1 {
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        text-shadow: 
            0 2px 4px rgba(0,0,0,0.9),
            0 4px 8px rgba(0,0,0,0.8),
            0 8px 16px rgba(0,0,0,0.7);
        color: #ffffff;
    }
    
    .wishlist-hero-content h1 i {
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.9));
    }
    
    .wishlist-hero-content p {
        font-size: 1.25rem;
        font-weight: 600;
        text-shadow: 
            0 2px 4px rgba(0,0,0,0.8),
            0 4px 8px rgba(0,0,0,0.6);
        color: #ffffff;
    }
    
    .wishlist-stats {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin-top: -3rem;
        margin-bottom: 3rem;
        position: relative;
        z-index: 10;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 2rem;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3);
    }
    
    .stat-icon i {
        font-size: 1.75rem;
        color: white;
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }
    
    .stat-label {
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .empty-wishlist {
        text-align: center;
        padding: 5rem 2rem;
        background: linear-gradient(135deg, #fdf2f8 0%, #f3e8ff 100%);
        border-radius: 2rem;
        margin: 3rem 0;
    }
    
    .empty-wishlist-icon {
        width: 120px;
        height: 120px;
        background: linear-gradient(135deg, #ec4899 0%, #8b5cf6 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        box-shadow: 0 10px 30px rgba(236, 72, 153, 0.3);
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .empty-wishlist-icon i {
        font-size: 4rem;
        color: white;
    }
    
    .empty-wishlist h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
    }
    
    .empty-wishlist p {
        font-size: 1.125rem;
        color: #64748b;
        margin-bottom: 2rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="container-modern" style="padding-top: 2rem;">
    <x-breadcrumb :items="[
        ['label' => 'My Wishlist', 'icon' => 'bxs-heart']
    ]" />
</div>

{{-- Hero Section --}}
<div class="wishlist-hero">
    <div class="container-modern">
        <div class="wishlist-hero-content" data-aos="fade-up">
            <h1>
                <i class='bx bxs-heart'></i>
                My Wishlist
            </h1>
            <p>Your favorite accommodations in one place</p>
        </div>
    </div>
</div>

<div class="container-modern">

    {{-- Stats Card --}}
    @if(count($wishlists) > 0)
    <div class="wishlist-stats" data-aos="fade-up">
        <div class="stat-item">
            <div class="stat-icon">
                <i class='bx bxs-heart'></i>
            </div>
            <div class="stat-value">{{ count($wishlists) }}</div>
            <div class="stat-label">Saved Rooms</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon">
                <i class='bx bx-rupee'></i>
            </div>
            <div class="stat-value">₹{{ number_format($wishlists->pluck('room.room_price')->avg()) }}</div>
            <div class="stat-label">Avg Price</div>
        </div>
        <div class="stat-item">
            <div class="stat-icon">
                <i class='bx bx-map'></i>
            </div>
            <div class="stat-value">{{ $wishlists->pluck('room.city')->unique()->count() }}</div>
            <div class="stat-label">Cities</div>
        </div>
    </div>
    @endif

    {{-- Empty State --}}
    <div id="empty-wishlist-message" style="{{ count($wishlists) ? 'display:none;' : '' }}" data-aos="fade-up">
        <div class="empty-wishlist">
            <div class="empty-wishlist-icon">
                <i class='bx bxs-heart-circle'></i>
            </div>
            <h2>Your Wishlist is Empty</h2>
            <p>Start adding rooms you love to keep them saved for later!</p>
            <a href="{{ route('rooms') }}" class="btn-cta-primary">
                <i class='bx bx-search'></i> Browse Rooms
            </a>
        </div>
    </div>

    {{-- Room Grid --}}
    <div class="row g-4" style="margin-bottom: 3rem;">
        @forelse($wishlists as $item)
            @php
                $room = $item->room;
            @endphp
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                @include('components.room-card', ['room' => $room])
            </div>
        @empty
        @endforelse
    </div>

</div>

@endsection
@push('scripts')
<script>
// Override toggleWishlist to handle wishlist page removal
const originalToggleWishlist = window.toggleWishlist;
window.toggleWishlist = function(roomId, button) {
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
            // Remove card with animation
            const card = button.closest('.col-md-6, .col-lg-4');
            if (card && !data.added) {
                card.style.transition = 'all 0.3s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                
                setTimeout(() => {
                    card.remove();
                    
                    // Check if wishlist is now empty
                    const remainingCards = document.querySelectorAll('.room-card-modern');
                    if (remainingCards.length === 0) {
                        document.getElementById('empty-wishlist-message').style.display = 'block';
                        // Hide stats card
                        const statsCard = document.querySelector('.wishlist-stats');
                        if (statsCard) statsCard.style.display = 'none';
                    }
                }, 300);
                
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
};
</script>
@endpush
