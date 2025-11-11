@extends('layouts.user-dashboard')
@section('title', 'Dashboard')

@push('styles')
<style>
    /* Stats Cards - Bootstrap Enhanced */
    .stats-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 1.75rem;
        box-shadow: var(--shadow-md);
        border-left: 4px solid var(--brand-primary);
        transition: var(--transition-base);
        height: 100%;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    
    .stats-card:hover {
        box-shadow: var(--shadow-brand);
        transform: translateY(-4px);
    }
    
    .stats-icon {
        width: 65px;
        height: 65px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1.25rem;
        flex-shrink: 0;
    }
    
    .stats-number {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1;
    }
    
    .stats-label {
        color: var(--text-muted);
        font-size: 0.95rem;
        font-weight: 500;
        margin: 0;
    }
    
    /* Quick Action Cards */
    .quick-action-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 2px solid var(--border-light);
        transition: var(--transition-base);
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-primary);
        height: 100%;
        min-height: 160px;
    }
    
    .quick-action-card:hover {
        border-color: var(--brand-primary);
        box-shadow: var(--shadow-brand);
        transform: translateY(-4px);
        color: var(--brand-primary);
    }
    
    .quick-action-card i {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .quick-action-card h5 {
        margin: 0 0 0.5rem 0;
        font-weight: 700;
        font-size: 1.1rem;
    }
    
    .quick-action-card p {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin: 0;
    }
    
    /* Room Card Container - Enhanced */
    .room-card-modern {
        height: 100%;
        display: flex;
        flex-direction: column;
        background: white;
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all var(--transition-base);
        border: 1px solid var(--border-light);
    }
    
    .room-card-modern:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-brand);
    }
    
    .room-card-image {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
        background: var(--bg-gray);
    }
    
    .room-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .room-card-modern:hover .room-card-image img {
        transform: scale(1.1);
    }
    
    .room-card-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .room-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        line-height: 1.4;
    }
    
    .room-card-location {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-muted);
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .room-card-location i {
        color: var(--brand-primary);
        font-size: 1rem;
    }
    
    .room-card-price {
        font-size: 1.75rem;
        font-weight: 800;
        background: var(--brand-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 1rem;
    }
    
    .room-card-price span {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-muted);
    }
    
    .room-card-features {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-light);
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.875rem;
        color: var(--text-secondary);
        background: var(--bg-light);
        padding: 0.375rem 0.75rem;
        border-radius: var(--radius-md);
    }
    
    .feature-item i {
        color: var(--brand-primary);
        font-size: 1rem;
    }
    
    .room-amenities {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .amenity-tag {
        padding: 0.375rem 0.75rem;
        background: var(--brand-gradient-soft);
        border-radius: var(--radius-md);
        font-size: 0.75rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-weight: 500;
    }
    
    .amenity-tag i {
        color: var(--brand-primary);
        font-size: 0.875rem;
    }
    
    .room-card-actions {
        margin-top: auto;
        display: flex;
        gap: 0.75rem;
    }
    
    .room-card-actions .btn-primary,
    .room-card-actions .btn.btn-primary {
        background: var(--brand-gradient) !important;
        border: none !important;
        padding: 0.75rem 1.5rem !important;
        border-radius: var(--radius-md) !important;
        font-weight: 600 !important;
        color: white !important;
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
        justify-content: center !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
    }
    
    .room-card-actions .btn-primary:hover,
    .room-card-actions .btn.btn-primary:hover {
        transform: translateY(-2px) !important;
        box-shadow: var(--shadow-brand) !important;
        background: var(--brand-gradient-hover) !important;
    }
    
    /* No Image Placeholder */
    .no-image-placeholder {
        width: 100%;
        height: 100%;
        background: var(--brand-gradient);
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
    
    /* Pagination - Bootstrap Enhanced */
    .pagination {
        gap: 0.5rem;
        margin-top: 2rem;
    }
    
    .pagination .page-link {
        border: 2px solid var(--border-light);
        border-radius: var(--radius-md);
        color: var(--text-primary);
        padding: 0.75rem 1.25rem;
        transition: all 0.2s ease;
        font-weight: 600;
    }
    
    .pagination .page-link:hover {
        background: var(--brand-gradient);
        color: white;
        border-color: var(--brand-primary);
        transform: translateY(-2px);
    }
    
    .pagination .page-item.active .page-link {
        background: var(--brand-gradient);
        border-color: var(--brand-primary);
        color: white;
    }
    
    /* Section Headers */
    .section-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-light);
    }
    
    .section-header h2 {
        font-size: 1.875rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .section-header h2 i {
        color: var(--brand-primary);
    }
    
    .section-header p {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.95rem;
    }
    
    /* Welcome Banner */
    .welcome-banner {
        background: var(--brand-gradient);
        color: white;
        border-radius: var(--radius-lg);
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-brand);
        overflow: hidden;
        position: relative;
    }
    
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }
    
    .welcome-title {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 0.75rem;
        position: relative;
        z-index: 1;
    }
    
    .welcome-subtitle {
        opacity: 0.95;
        margin: 0;
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }
    
    /* Empty State */
    .empty-state {
        background: white;
        border-radius: var(--radius-lg);
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: var(--shadow-sm);
        border: 2px dashed var(--border-color);
    }
    
    .empty-state i {
        font-size: 5rem;
        color: var(--brand-primary);
        margin-bottom: 1.5rem;
        opacity: 0.8;
    }
    
    .empty-state h4 {
        margin-bottom: 1rem;
        color: var(--text-primary);
        font-weight: 700;
    }
    
    .empty-state p {
        color: var(--text-muted);
        margin-bottom: 2rem;
        font-size: 1rem;
    }
    
    /* Available Rooms Grid */
    .rooms-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    /* Badge Styles */
    .room-badge {
        position: absolute;
        bottom: 0.75rem;
        left: 0.75rem;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        z-index: 10;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }
    
    .room-badge.verified {
        background: rgba(16, 185, 129, 0.95);
        color: white;
    }
    
    .room-badge.pending {
        background: rgba(245, 158, 11, 0.95);
        color: white;
    }
    
    /* Wishlist & Compare Buttons */
    .wishlist-btn, .compare-btn {
        position: absolute;
        top: 0.75rem;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .wishlist-btn {
        right: 0.75rem;
    }
    
    .compare-btn {
        left: 0.75rem;
    }
    
    .wishlist-btn i, .compare-btn i {
        font-size: 1.35rem;
        color: var(--text-secondary);
    }
    
    .wishlist-btn:hover, .compare-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        background: var(--brand-gradient);
    }
    
    .wishlist-btn:hover i, .compare-btn:hover i {
        color: white;
    }
    
    .wishlist-btn.active, .compare-btn.active {
        background: var(--brand-gradient);
    }
    
    .wishlist-btn.active i, .compare-btn.active i {
        color: white;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .stats-card {
            padding: 1.5rem;
        }
        
        .stats-icon {
            width: 55px;
            height: 55px;
            font-size: 1.75rem;
        }
        
        .stats-number {
            font-size: 1.75rem;
        }
        
        .welcome-title {
            font-size: 1.5rem;
        }
        
        .quick-action-card {
            padding: 1.5rem 1rem;
            min-height: 140px;
        }
        
        .section-header h2 {
            font-size: 1.5rem;
        }
        
        .room-card-image {
            height: 200px;
        }
    }
</style>
@endpush

@section('content')
    {{-- Welcome Banner --}}
    <div class="welcome-banner" data-aos="fade-down">
        <div class="row align-items-center g-3">
            <div class="col-lg-8 col-md-7">
                <h1 class="welcome-title mb-0">
                    👋 Welcome back, {{ auth()->user()->full_name }}!
                </h1>
                <p class="welcome-subtitle">Manage your bookings, wishlist, and profile from your dashboard</p>
            </div>
            <div class="col-lg-4 col-md-5 text-md-end text-start">
                @if(auth()->user()->is_verified)
                    <span class="badge bg-success bg-opacity-25 text-success border border-success" style="font-size: 1rem; padding: 0.65rem 1.25rem; border-radius: 2rem; backdrop-filter: blur(10px);">
                        <i class='bx bx-check-shield' style="font-size: 1.1rem;"></i> Verified Account
                    </span>
                @else
                    <span class="badge bg-warning bg-opacity-25 text-warning border border-warning" style="font-size: 1rem; padding: 0.65rem 1.25rem; border-radius: 2rem; backdrop-filter: blur(10px);">
                        <i class='bx bx-time' style="font-size: 1.1rem;"></i> Pending Verification
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="stats-card">
                <div class="stats-icon" style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);">
                    <i class='bx bx-heart' style="color: #ef4444;"></i>
                </div>
                <div class="stats-number">{{ auth()->user()->wishlists()->count() }}</div>
                <p class="stats-label">Saved Rooms</p>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="stats-card" style="border-left-color: var(--success-color);">
                <div class="stats-icon" style="background: var(--success-light);">
                    <i class='bx bx-calendar-check' style="color: var(--success-color);"></i>
                </div>
                <div class="stats-number">{{ auth()->user()->bookings()->count() }}</div>
                <p class="stats-label">My Bookings</p>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <div class="stats-card" style="border-left-color: var(--warning-color);">
                <div class="stats-icon" style="background: var(--warning-light);">
                    <i class='bx bx-star' style="color: var(--warning-color);"></i>
                </div>
                <div class="stats-number">{{ auth()->user()->reviews()->count() }}</div>
                <p class="stats-label">Reviews</p>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <div class="stats-card" style="border-left-color: var(--info-color);">
                <div class="stats-icon" style="background: var(--info-light);">
                    <i class='bx bx-git-compare' style="color: var(--info-color);"></i>
                </div>
                <div class="stats-number">{{ \App\Models\Compare::where('user_id', auth()->user()->user_id)->count() }}</div>
                <p class="stats-label">Comparing</p>
            </div>
        </div>
    </div>

    {{-- Available Rooms Section --}}
    <div class="section-header" data-aos="fade-up">
        <h2>
            <i class='bx bx-buildings'></i>
            Available Rooms
        </h2>
        <p>Browse verified rooms available for rent in your area</p>
    </div>

    @if($rooms && $rooms->count() > 0)
        <div class="row g-4 mb-4">
            @foreach($rooms as $room)
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    @include('components.room-card', ['room' => $room])
                </div>
            @endforeach
        </div>
        
        <div class="d-flex justify-content-center" data-aos="fade-up">
            {{ $rooms->links() }}
        </div>
    @else
        <div class="empty-state" data-aos="fade-up">
            <i class='bx bx-info-circle'></i>
            <h4>No Rooms Available</h4>
            <p>No rooms available at the moment. Please check back later!</p>
            <a href="{{ route('rooms') }}" class="btn btn-primary btn-lg" style="background: var(--brand-gradient); border: none; padding: 0.875rem 2rem; font-weight: 600;">
                <i class='bx bx-search'></i> Browse All Rooms
            </a>
        </div>
    @endif

    {{-- Quick Access --}}
    <div class="section-header mt-5" data-aos="fade-up">
        <h2>
            <i class='bx bx-bolt-circle'></i>
            Quick Access
        </h2>
        <p>Quickly navigate to your most used features</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <a href="{{ route('user.profile.index') }}" class="quick-action-card">
                <i class='bx bx-user-circle' style="color: var(--brand-primary);"></i>
                <h5>My Profile</h5>
                <p>View & edit profile</p>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('user.bookings.index') }}" class="quick-action-card">
                <i class='bx bx-calendar-check' style="color: var(--success-color);"></i>
                <h5>My Bookings</h5>
                <p>Manage bookings</p>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <a href="{{ route('wishlist.index') }}" class="quick-action-card">
                <i class='bx bxs-heart' style="color: #ef4444;"></i>
                <h5>Wishlist</h5>
                <p>Saved rooms</p>
            </a>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="400">
            <a href="{{ route('user.compare.index') }}" class="quick-action-card">
                <i class='bx bx-git-compare' style="color: var(--info-color);"></i>
                <h5>Compare</h5>
                <p>Compare rooms</p>
            </a>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Show success message if present
    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}',
            background: '#d1fae5',
            color: '#065f46',
            iconColor: '#10b981'
        });
    @endif

    // Show error messages if present
    @if(session('error'))
        Toast.fire({
            icon: 'error',
            title: '{{ session('error') }}',
            background: '#fee2e2',
            color: '#991b1b',
            iconColor: '#ef4444'
        });
    @endif

    // Show info messages if present
    @if(session('info'))
        Toast.fire({
            icon: 'info',
            title: '{{ session('info') }}',
            background: '#dbeafe',
            color: '#1e3a8a',
            iconColor: '#3b82f6'
        });
    @endif

    // Show warning messages if present
    @if(session('warning'))
        Toast.fire({
            icon: 'warning',
            title: '{{ session('warning') }}',
            background: '#fef3c7',
            color: '#b45309',
            iconColor: '#f59e0b'
        });
    @endif
</script>
@endpush
