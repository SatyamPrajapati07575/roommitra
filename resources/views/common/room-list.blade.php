@extends('layouts.modern')

@section('title', 'Available Rooms - Find Your Perfect Accommodation')
@section('meta_description', 'Browse all available rooms for students. Filter by city, price, and sharing type to find your perfect accommodation.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<style>
    .rooms-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 4rem 0 3rem;
        margin-bottom: 3rem;
        position: relative;
        overflow: hidden;
    }
    
    .rooms-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><circle cx="50" cy="50" r="40" fill="rgba(255,255,255,0.05)"/></svg>');
        background-size: 100px 100px;
        opacity: 0.3;
    }
    
    .rooms-hero-content {
        position: relative;
        z-index: 1;
        color: white;
        text-align: center;
    }
    
    .rooms-hero-content h1 {
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 1rem;
        text-shadow: 
            0 2px 4px rgba(0,0,0,0.9),
            0 4px 8px rgba(0,0,0,0.8),
            0 8px 16px rgba(0,0,0,0.7);
        color: #ffffff;
    }
    
    .rooms-hero-content p {
        font-size: 1.25rem;
        font-weight: 600;
        text-shadow: 
            0 2px 4px rgba(0,0,0,0.8),
            0 4px 8px rgba(0,0,0,0.6);
        color: #ffffff;
    }
    
    .filter-card {
        background: white;
        border-radius: 1.5rem;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        margin-top: -3rem;
        margin-bottom: 3rem;
        position: relative;
        z-index: 10;
    }
    
    .filter-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    
    .filter-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }
    
    .filter-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    
    .quick-filters {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #f1f5f9;
    }
    
    .quick-filter-chip {
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 2px solid #e2e8f0;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.875rem;
        color: #475569;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .quick-filter-chip:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .quick-filter-chip.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
    }
    
    .results-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 1rem;
    }
    
    .results-count {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.125rem;
        font-weight: 600;
        color: #1e293b;
    }
    
    .results-count i {
        font-size: 1.5rem;
        color: #667eea;
    }
    
    .sort-select {
        padding: 0.75rem 1.25rem;
        border: 2px solid #e2e8f0;
        border-radius: 0.75rem;
        font-weight: 600;
        color: #475569;
        background: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .sort-select:hover {
        border-color: #667eea;
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 1.5rem;
    }
    
    .empty-state-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }
    
    .empty-state-icon i {
        font-size: 3rem;
        color: white;
    }
    
    .empty-state h3 {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        font-size: 1.125rem;
        color: #64748b;
        margin-bottom: 2rem;
    }
</style>
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="container-modern" style="padding-top: 2rem;">
    <x-breadcrumb :items="[
        ['label' => 'Browse Rooms', 'icon' => 'bx-buildings']
    ]" />
</div>

{{-- Hero Section --}}
<div class="rooms-hero">
    <div class="container-modern">
        <div class="rooms-hero-content" data-aos="fade-up">
            <h1>Find Your Perfect Room</h1>
            <p>Browse {{ $rooms->total() }} verified accommodations</p>
        </div>
    </div>
</div>

<div class="container-modern">

    {{-- Filter Card --}}
    <div class="filter-card" data-aos="fade-up">
        <div class="filter-header">
            <div class="filter-icon">
                <i class='bx bx-filter'></i>
            </div>
            <h2 class="filter-title">Search & Filter</h2>
        </div>
        
        {{-- Quick Filters --}}
        <div class="quick-filters">
            <a href="{{ route('rooms') }}" class="quick-filter-chip {{ !request()->hasAny(['city', 'min_price', 'max_price', 'capacity']) ? 'active' : '' }}">
                <i class='bx bx-home'></i> All Rooms
            </a>
            <a href="{{ route('rooms', ['capacity' => 1]) }}" class="quick-filter-chip {{ request('capacity') == 1 ? 'active' : '' }}">
                <i class='bx bx-user'></i> Single
            </a>
            <a href="{{ route('rooms', ['capacity' => 2]) }}" class="quick-filter-chip {{ request('capacity') == 2 ? 'active' : '' }}">
                <i class='bx bx-group'></i> 2 Sharing
            </a>
            <a href="{{ route('rooms', ['max_price' => 10000]) }}" class="quick-filter-chip {{ request('max_price') == 10000 ? 'active' : '' }}">
                <i class='bx bx-rupee'></i> Under ₹10k
            </a>
        </div>
        
        {{-- Advanced Filters --}}
        <form method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #475569;">
                        <i class='bx bx-map'></i> City
                    </label>
                    <input type="text" name="city" style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; font-size: 1rem;" 
                           placeholder="Enter city" value="{{ request('city') }}">
                </div>
                
                <div class="col-md-2">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #475569;">
                        <i class='bx bx-rupee'></i> Min Price
                    </label>
                    <input type="number" name="min_price" style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; font-size: 1rem;" 
                           placeholder="₹5,000" value="{{ request('min_price') }}">
                </div>
                
                <div class="col-md-2">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #475569;">
                        <i class='bx bx-rupee'></i> Max Price
                    </label>
                    <input type="number" name="max_price" style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; font-size: 1rem;" 
                           placeholder="₹20,000" value="{{ request('max_price') }}">
                </div>
                
                <div class="col-md-2">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #475569;">
                        <i class='bx bx-user'></i> Sharing
                    </label>
                    <select name="capacity" style="width: 100%; padding: 0.875rem; border: 2px solid #e2e8f0; border-radius: 0.75rem; font-size: 1rem; background: white;">
                        <option value="">All Types</option>
                        <option value="1" {{ request('capacity') == 1 ? 'selected' : '' }}>Single</option>
                        <option value="2" {{ request('capacity') == 2 ? 'selected' : '' }}>2 Sharing</option>
                        <option value="3" {{ request('capacity') == 3 ? 'selected' : '' }}>3 Sharing</option>
                        <option value="4" {{ request('capacity') == 4 ? 'selected' : '' }}>4+ Sharing</option>
                    </select>
                </div>
                
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn-cta-primary" style="flex: 1;">
                        <i class='bx bx-search'></i> Search
                    </button>
                    <a href="{{ route('rooms') }}" class="btn-cta-secondary">
                        <i class='bx bx-reset'></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Results Header --}}
    <div class="results-header" data-aos="fade-up">
        <div class="results-count">
            <i class='bx bx-check-circle'></i>
            <span>Found <strong>{{ $rooms->total() }}</strong> room(s)</span>
        </div>
        <select class="sort-select" onchange="window.location.href=this.value">
            <option value="{{ route('rooms', request()->except('sort')) }}">Sort By</option>
            <option value="{{ route('rooms', array_merge(request()->all(), ['sort' => 'price_low'])) }}">Price: Low to High</option>
            <option value="{{ route('rooms', array_merge(request()->all(), ['sort' => 'price_high'])) }}">Price: High to Low</option>
            <option value="{{ route('rooms', array_merge(request()->all(), ['sort' => 'newest'])) }}">Newest First</option>
        </select>
    </div>

    {{-- Room Grid --}}
    <div class="row g-4" style="margin-bottom: 3rem;">
        @forelse ($rooms as $room)
            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                @include('components.room-card', ['room' => $room])
            </div>
        @empty
            <div class="col-12" data-aos="fade-up">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class='bx bx-search'></i>
                    </div>
                    <h3>No Rooms Found</h3>
                    <p>Try adjusting your filters or check back later for new listings.</p>
                    <a href="{{ route('rooms') }}" class="btn-cta-primary">
                        <i class='bx bx-reset'></i> Clear All Filters
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($rooms->hasPages())
        <div style="margin-top: 3rem; margin-bottom: 3rem;" data-aos="fade-up">
            {{ $rooms->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection
