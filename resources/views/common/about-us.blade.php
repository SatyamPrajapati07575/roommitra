@extends('layouts.modern')
@section('title', 'About Us - RoomMitra')
@section('meta_description', 'Discover RoomMitra - India\'s most trusted student accommodation platform. Learn our story, mission, and how we are revolutionizing student housing.')

@section('content')

<!-- Hero Section -->
<section class="about-hero">
    <div class="about-hero-overlay"></div>
    <div class="container-modern">
        <div class="about-hero-content" data-aos="fade-up">
            <h1 class="about-hero-title">Revolutionizing Student Accommodation</h1>
            <p class="about-hero-subtitle">Making room hunting stress-free for students across India</p>
            <div class="about-hero-stats">
                <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                    <i class='bx bx-home-alt'></i>
                    <h3>1000+</h3>
                    <p>Verified Listings</p>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                    <i class='bx bx-user-check'></i>
                    <h3>500+</h3>
                    <p>Happy Students</p>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                    <i class='bx bx-map-alt'></i>
                    <h3>5+</h3>
                    <p>Cities</p>
                </div>
                <div class="stat-item" data-aos="fade-up" data-aos-delay="400">
                    <i class='bx bx-shield-check'></i>
                    <h3>100%</h3>
                    <p>Verified</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Story Section -->
<section class="about-story">
    <div class="container-modern">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="story-image-wrapper">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=1200" alt="Student collaboration" class="story-image">
                    <div class="story-badge">
                        <i class='bx bx-rocket'></i>
                        <span>Est. 2023</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="section-label">Our Story</span>
                <h2 class="section-title">From Struggle to Solution</h2>
                <div class="story-content">
                    <p class="lead">It started in August 2023, when our founder faced the nightmare of finding accommodation in a new city.</p>
                    <p>"Fake listings, hidden charges, unsafe neighborhoods, and endless broker calls made the experience exhausting. That is when we realized — <strong>students deserve better</strong>."</p>
                    <p>RoomMitra was born from this frustration. We built a platform where trust comes first, transparency is non-negotiable, and every listing is verified.</p>
                    <div class="story-features">
                        <div class="feature-item">
                            <i class='bx bx-check-circle'></i>
                            <span>Zero Brokerage</span>
                        </div>
                        <div class="feature-item">
                            <i class='bx bx-check-circle'></i>
                            <span>100% Verified Listings</span>
                        </div>
                        <div class="feature-item">
                            <i class='bx bx-check-circle'></i>
                            <span>Student-First Approach</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="mission-vision">
    <div class="container-modern">
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-up">
                <div class="mission-card">
                    <div class="mission-icon">
                        <i class='bx bx-check-circle'></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>To simplify student accommodation by providing verified, affordable, and hassle-free housing options across India. We aim to eliminate broker fraud and make room hunting transparent and trustworthy.</p>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="mission-card vision-card">
                    <div class="mission-icon">
                        <i class='bx bx-bulb'></i>
                    </div>
                    <h3>Our Vision</h3>
                    <p>To become India\'s most trusted student accommodation platform, empowering millions of students to find their perfect home away from home with confidence and ease.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="why-choose">
    <div class="container-modern">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Why RoomMitra</span>
            <h2 class="section-title">What Makes Us Different</h2>
            <p class="section-subtitle">We are not just another listing platform — we are your trusted partner</p>
        </div>
        <div class="row g-4">
            @php
                $features = [
                    ['Verified Listings', 'bx-shield-check', 'Every property is physically verified by our team before listing', 'primary'],
                    ['Zero Brokerage', 'bx-wallet', 'Direct contact with owners — no hidden charges or middlemen', 'success'],
                    ['Student Safety', 'bx-lock-alt', 'Background-verified owners and safe neighborhood ratings', 'warning'],
                    ['Smart Filters', 'bx-filter-alt', 'Find rooms by budget, amenities, and proximity to your college', 'info'],
                    ['24/7 Support', 'bx-support', 'Our team is always here to help you with any queries', 'danger'],
                    ['Community Reviews', 'bx-star', 'Real reviews from students who have lived there', 'purple']
                ];
            @endphp
            @foreach($features as $index => $feature)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                <div class="feature-card feature-{{ $feature[3] }}">
                    <div class="feature-icon">
                        <i class='bx {{ $feature[1] }}'></i>
                    </div>
                    <h4>{{ $feature[0] }}</h4>
                    <p>{{ $feature[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Timeline -->
<section class="timeline-section">
    <div class="container-modern">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Our Journey</span>
            <h2 class="section-title">Milestones We Have Achieved</h2>
        </div>
        <div class="row g-4">
            @php
                $timeline = [
                    ['Aug 2023', 'The Idea', 'Born from a personal struggle of finding accommodation', 'bx-bulb', '#fbbf24'],
                    ['Nov 2023', 'Research Phase', 'Surveyed 200+ students to understand pain points', 'bx-search', '#8b5cf6'],
                    ['Jan 2024', 'Development Begins', 'Built MVP with core features and modern tech stack', 'bx-code', '#3b82f6'],
                    ['Apr 2024', 'Beta Launch', 'Launched in Lucknow with 50 verified listings', 'bx-rocket', '#10b981'],
                    ['Aug 2024', 'Growing Fast', 'Reached 500+ listings and 300+ happy students', 'bx-trending-up', '#06b6d4'],
                    ['Coming Soon', 'Pan India', 'Expanding to 10+ major student cities', 'bx-globe', '#f97316']
                ];
            @endphp
            @foreach($timeline as $index => $item)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="timeline-card-modern">
                    <div class="timeline-icon-modern" style="background: {{ $item[4] }};">
                        <i class='bx {{ $item[3] }}'></i>
                    </div>
                    <span class="timeline-date-modern">{{ $item[0] }}</span>
                    <h4>{{ $item[1] }}</h4>
                    <p>{{ $item[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Values -->
<section class="values-section">
    <div class="container-modern">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Our Values</span>
            <h2 class="section-title">What Drives Us Every Day</h2>
        </div>
        <div class="row g-4">
            @php
                $values = [
                    ['Trust & Transparency', 'bx-shield-check', 'We believe in complete honesty with our users', '#667eea'],
                    ['Student Empathy', 'bx-heart', 'We have lived the struggle — we understand you', '#f093fb'],
                    ['Innovation', 'bx-rocket', 'Constantly improving to serve you better', '#4facfe'],
                    ['Community First', 'bx-group', 'Building a supportive student ecosystem', '#43e97b']
                ];
            @endphp
            @foreach($values as $index => $value)
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="{{ $index * 100 }}">
                <div class="value-card-modern">
                    <div class="value-icon-modern" style="background: linear-gradient(135deg, {{ $value[3] }}22, {{ $value[3] }}44);">
                        <i class='bx {{ $value[1] }}' style="color: {{ $value[3] }}; font-size: 2.5rem;"></i>
                    </div>
                    <h4>{{ $value[0] }}</h4>
                    <p>{{ $value[2] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="team-section">
    <div class="container-modern">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Meet The Team</span>
            <h2 class="section-title">Passionate People Behind RoomMitra</h2>
        </div>
        <div class="row g-4 justify-content-center">
            @php
                $team = [
                    ['Founder & CEO', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=400', 'Visionary Leader'],
                    ['CTO', 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?q=80&w=400', 'Tech Expert'],
                    ['Head of Operations', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400', 'Operations Wizard'],
                    ['Marketing Lead', 'https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=400', 'Growth Hacker']
                ];
            @endphp
            @foreach($team as $index => $member)
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="team-card">
                    <div class="team-image">
                        <img src="{{ $member[1] }}" alt="{{ $member[0] }}">
                        <div class="team-overlay">
                            <div class="team-social">
                                <a href="#"><i class='bx bxl-linkedin'></i></a>
                                <a href="#"><i class='bx bxl-twitter'></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="team-info">
                        <h4>Team Member</h4>
                        <span class="team-role">{{ $member[0] }}</span>
                        <p>{{ $member[2] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Gallery -->
<section class="gallery-section">
    <div class="container-modern">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Behind The Scenes</span>
            <h2 class="section-title">Glimpse of Our Journey</h2>
        </div>
        <div class="gallery-grid" data-aos="fade-up">
            @php
                $gallery = [
                    'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=600',
                    'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=600',
                    'https://images.unsplash.com/photo-1556761175-4b46a572b786?q=80&w=600',
                    'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?q=80&w=600',
                    'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=600',
                    'https://images.unsplash.com/photo-1552664730-d307ca884978?q=80&w=600'
                ];
            @endphp
            @foreach($gallery as $img)
                <div class="gallery-item">
                    <img src="{{ $img }}" alt="RoomMitra Journey" loading="lazy">
                    <div class="gallery-overlay">
                        <i class='bx bx-zoom-in'></i>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container-modern">
        <div class="cta-card" data-aos="zoom-in">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h2 class="cta-title">Ready to Find Your Perfect Room?</h2>
                    <p class="cta-subtitle">Join thousands of students who have found their home with RoomMitra</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('rooms') }}" class="btn-cta">
                        <span>Browse Rooms</span>
                        <i class='bx bx-right-arrow-alt'></i>
                    </a>
                    <a href="{{ route('contact.form') }}" class="btn-cta-outline">
                        <span>Contact Us</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
