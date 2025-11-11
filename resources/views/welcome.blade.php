@extends('layouts.modern')
@section('title', 'Find Your Perfect Student Accommodation | RoomMitra')
@section('meta_description', 'Find verified student accommodation with RoomMitra. Browse PGs, hostels, and rooms near your college with 100% verified listings, zero brokerage, and 24/7 support.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}?v={{ config('app.asset_version', '1.0.0') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-modern">
    <div class="container-modern">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="hero-content">
                    <h1 class="hero-title">Find Your Perfect Student Accommodation</h1>
                    <p class="hero-subtitle">Discover verified PGs, hostels, and rooms near your college with zero brokerage and 100% transparency.</p>
                    
                    <div class="hero-search">
                        <i class='bx bx-search' style="font-size: 1.5rem; color: #64748b;"></i>
                        <input type="text" placeholder="Search by college, city, or area..." id="hero-search-input">
                        <a href="{{ route('rooms') }}" class="btn-search">
                            <span>Search Rooms</span>
                            <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                    
                    <div class="hero-features">
                        <div class="hero-feature-item">
                            <i class='bx bx-check-circle'></i>
                            <span>Verified Listings</span>
                        </div>
                        <div class="hero-feature-item">
                            <i class='bx bx-check-circle'></i>
                            <span>Zero Brokerage</span>
                        </div>
                        <div class="hero-feature-item">
                            <i class='bx bx-check-circle'></i>
                            <span>24/7 Support</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1555854877-bab0e564b8d5?w=600&q=80" alt="Student Accommodation" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container-modern">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Why Choose Us</span>
            <h2 class="section-title-modern">What Makes RoomMitra Different</h2>
            <p class="section-description">We are not just another listing platform — we are your trusted partner in finding the perfect accommodation</p>
        </div>
        
        <div class="row g-4">
            @php
                $features = [
                    ['Verified Listings', 'bx-shield-check', 'Every property is physically verified by our team before listing', 100],
                    ['Zero Brokerage', 'bx-wallet', 'Direct contact with owners — no hidden charges or middlemen', 200],
                    ['Student Safety', 'bx-lock-alt', 'Background-verified owners and safe neighborhood ratings', 300],
                    ['Smart Filters', 'bx-filter-alt', 'Find rooms by budget, amenities, and proximity to your college', 100],
                    ['24/7 Support', 'bx-support', 'Our team is always here to help you with any queries', 200],
                    ['Easy Booking', 'bx-calendar-check', 'Simple and secure booking process with instant confirmation', 300]
                ];
            @endphp
            @foreach($features as $index => $feature)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $feature[3] }}">
                <div class="feature-card-modern">
                    <div class="feature-icon-modern">
                        <i class='bx {{ $feature[1] }}'></i>
                    </div>
                    <h3>{{ $feature[0] }}</h3>
                    <p>{{ $feature[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Rooms Section -->
<section class="rooms-section">
    <div class="container-modern">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Available Now</span>
            <h2 class="section-title-modern">Featured Accommodations</h2>
            <p class="section-description">Handpicked verified rooms and PGs perfect for students</p>
        </div>
        
        <div class="row g-4">
            @forelse ($rooms as $room)
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    @include('components.room-card', ['room' => $room])
                </div>
            @empty
                <div class="col-12" data-aos="fade-up">
                    <div class="alert alert-modern alert-warning text-center" style="max-width: 600px; margin: 0 auto;">
                        <div class="alert-icon">
                            <i class='bx bx-info-circle'></i>
                        </div>
                        <div class="alert-content">
                            <h4 class="alert-title">No Rooms Available Yet</h4>
                            <p class="alert-message">We are adding verified listings soon. Check back shortly!</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if($rooms->isNotEmpty())
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('rooms') }}" class="btn-cta-primary">
                <span>View All Rooms</span>
                <i class='bx bx-right-arrow-alt'></i>
            </a>
        </div>
        @endif
    </div>
</section>

<!-- How It Works Section -->
<section class="how-it-works">
    <div class="container-modern">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Simple Process</span>
            <h2 class="section-title-modern">How It Works</h2>
            <p class="section-description">Finding your perfect accommodation is just a few steps away</p>
        </div>
        
        <div class="row g-4">
            @php
                $steps = [
                    ['Search', 'Browse verified rooms near your college using smart filters', '100'],
                    ['Compare', 'Check amenities, prices, and reviews from real students', '200'],
                    ['Visit', 'Schedule a visit or take a virtual tour of shortlisted rooms', '300'],
                    ['Book', 'Secure your room with instant confirmation and zero brokerage', '400']
                ];
            @endphp
            @foreach($steps as $index => $step)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $step[2] }}">
                <div class="step-card">
                    <div class="step-number">{{ $index + 1 }}</div>
                    <h3>{{ $step[0] }}</h3>
                    <p>{{ $step[1] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials Section with Swiper -->
<section class="testimonials-section">
    <div class="container-modern">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Reviews</span>
            <h2 class="section-title-modern">What Students Say About Us</h2>
            <p class="section-description">Real experiences from students who found their perfect accommodation</p>
        </div>
        
        <div class="swiper testimonialSwiper" data-aos="fade-up">
            <div class="swiper-wrapper">
                @php
                    $testimonials = [
                        ['Rahul Sharma', 'Engineering Student, Lucknow', 'RoomMitra made my room hunting so easy! Found a verified PG near my college in just 2 days. Zero brokerage and the owner was genuine.', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80'],
                        ['Priya Singh', 'MBA Student, Lucknow', 'Best platform for student accommodation! The verification process gives me peace of mind. My room is exactly as shown in photos.', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200&q=80'],
                        ['Amit Kumar', 'Medical Student, Lucknow', 'No hidden charges, transparent process, and excellent support team. Highly recommend RoomMitra to all students.', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&q=80'],
                        ['Sneha Verma', 'Law Student, Lucknow', 'Found a safe and affordable room near my college. The filters helped me narrow down options quickly. Thank you RoomMitra!', 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&q=80']
                    ];
                @endphp
                @foreach($testimonials as $testimonial)
                <div class="swiper-slide">
                    <div class="testimonial-card-modern">
                        <div class="testimonial-avatar">
                            <img src="{{ $testimonial[3] }}" alt="{{ $testimonial[0] }}">
                        </div>
                        <div class="testimonial-rating">
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                            <i class='bx bxs-star'></i>
                        </div>
                        <p class="testimonial-text">"{{ $testimonial[2] }}"</p>
                        <h5 class="testimonial-author">{{ $testimonial[0] }}</h5>
                        <p class="testimonial-role">{{ $testimonial[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container-modern">
        <div class="row g-4" data-aos="fade-up">
            @php
                $stats = [
                    ['bx-home-alt', '500+', 'Verified Rooms'],
                    ['bx-user-check', '1000+', 'Happy Students'],
                    ['bx-shield-check', '100%', 'KYC Verified Owners'],
                    ['bx-map-alt', '5+', 'Cities Covered']
                ];
            @endphp
            @foreach($stats as $index => $stat)
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="stat-card-modern">
                    <i class='bx {{ $stat[0] }} stat-icon'></i>
                    <span class="stat-number counter" data-target="{{ preg_replace('/[^0-9]/', '', $stat[1]) }}">0</span><span class="stat-number">{{ preg_replace('/[0-9]/', '', $stat[1]) }}</span>
                    <p class="stat-label">{{ $stat[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section-home">
    <div class="container-modern">
        <div class="cta-box" data-aos="zoom-in">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2>Ready to Find Your Perfect Room?</h2>
                    <p>Join thousands of students who have found their ideal accommodation with RoomMitra. Start your search today!</p>
                </div>
                <div class="col-lg-4">
                    <div class="cta-buttons">
                        <a href="{{ route('rooms') }}" class="btn-cta-primary">
                            <span>Browse Rooms</span>
                            <i class='bx bx-right-arrow-alt'></i>
                        </a>
                        <a href="{{ route('contact.form') }}" class="btn-cta-secondary">
                            <span>Contact Us</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
// Swiper Testimonials
const testimonialSwiper = new Swiper('.testimonialSwiper', {
    slidesPerView: 1,
    spaceBetween: 30,
    loop: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        }
    }
});

// Counter Animation
const counters = document.querySelectorAll(".counter");
const animateCounters = () => {
    counters.forEach((counter) => {
        const updateCount = () => {
            const target = +counter.getAttribute("data-target");
            const count = +counter.innerText;
            const inc = Math.ceil(target / 100);

            if (count < target) {
                counter.innerText = count + inc;
                setTimeout(updateCount, 30);
            } else {
                counter.innerText = target;
            }
        };
        updateCount();
    });
};

let started = false;
window.addEventListener("scroll", () => {
    const statsSection = document.querySelector(".stats-section");
    if (statsSection) {
        const sectionTop = statsSection.getBoundingClientRect().top;
        const screenHeight = window.innerHeight;

        if (!started && sectionTop < screenHeight) {
            started = true;
            animateCounters();
        }
    }
});
</script>
@endpush
