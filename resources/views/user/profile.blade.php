@extends('layouts.user-dashboard')
@section('title', 'My Profile')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user-profile.css') }}?v={{ config('app.asset_version', '1.0.0') }}">
@endpush
@section('content')
    {{-- Success/Error Messages (Hidden - Using Toast Notifications) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-none" role="alert">
            <i class='bx bx-check-circle'></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show d-none" role="alert">
            <i class='bx bx-error'></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        @php
            $user = auth()->user();
        @endphp

        {{-- Profile Card --}}
        <div class="col-lg-4 col-md-12" data-aos="fade-up">
            <div class="profile-card">
                <div class="profile-card-header">
                    <div class="profile-avatar-wrapper">
                        @if ($user->profile && $user->profile->avatar)
                            <img src="{{ asset($user->profile->avatar) }}" alt="User Avatar" class="profile-avatar">
                        @else
                            <img src="{{ asset('img/avatar/avatar.png') }}" alt="Default Avatar" class="profile-avatar">
                        @endif
                        
                        @if ($user->is_verified)
                            <div class="profile-verified-badge">
                                <i class='bx bx-check'></i>
                            </div>
                        @endif
                    </div>
                    
                    <h2 class="profile-name">{{ $user->full_name }}</h2>
                    <span class="profile-role">{{ ucfirst($user->role) }}</span>
                    
                    @if ($user->is_verified)
                        <div class="mt-2">
                            <span class="profile-badge profile-badge-success">
                                <i class='bx bx-check-shield'></i> Verified Account
                            </span>
                        </div>
                    @else
                        <div class="mt-2">
                            <span class="profile-badge profile-badge-warning">
                                <i class='bx bx-time'></i> Pending Verification
                            </span>
                        </div>
                    @endif
                </div>
                
                <div class="profile-card-body">
                    <div class="profile-info-item">
                        <div class="profile-info-icon">
                            <i class='bx bx-envelope'></i>
                        </div>
                        <div class="profile-info-content">
                            <div class="profile-info-label">Email</div>
                            <p class="profile-info-value">{{ $user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-icon">
                            <i class='bx bx-phone'></i>
                        </div>
                        <div class="profile-info-content">
                            <div class="profile-info-label">Phone</div>
                            <p class="profile-info-value">{{ $user->phone }}</p>
                        </div>
                    </div>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-icon">
                            <i class='bx bx-calendar'></i>
                        </div>
                        <div class="profile-info-content">
                            <div class="profile-info-label">Member Since</div>
                            <p class="profile-info-value">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-icon">
                            <i class='bx bx-time-five'></i>
                        </div>
                        <div class="profile-info-content">
                            <div class="profile-info-label">Last Updated</div>
                            <p class="profile-info-value">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    
                    <div class="profile-stats">
                        <div class="profile-stat-item">
                            <div class="profile-stat-value">{{ $user->bookings()->count() }}</div>
                            <div class="profile-stat-label">Bookings</div>
                        </div>
                        <div class="profile-stat-item">
                            <div class="profile-stat-value">{{ $user->wishlists()->count() }}</div>
                            <div class="profile-stat-label">Wishlist</div>
                        </div>
                        <div class="profile-stat-item">
                            <div class="profile-stat-value">{{ $user->reviews()->count() }}</div>
                            <div class="profile-stat-label">Reviews</div>
                        </div>
                    </div>
                    
                    <div class="profile-actions">
                        <button type="button" class="btn-profile-primary" id="edit-profile">
                            <i class='bx bx-edit'></i> Edit Profile
                        </button>
                    </div>
                    
                    @php
                        $social_links = $user->profile->social_links ?? [];
                        // Handle if social_links is a string (not yet decoded)
                        if (is_string($social_links)) {
                            $social_links = json_decode($social_links, true) ?? [];
                        }
                        // Ensure it's an array
                        if (!is_array($social_links)) {
                            $social_links = [];
                        }
                    @endphp
                    
                    @if(!empty(array_filter($social_links)))
                        <div class="profile-social-links">
                            @if(!empty($social_links['facebook']))
                                <a href="{{ $social_links['facebook'] }}" class="profile-social-link" title="Facebook" target="_blank" rel="noopener noreferrer">
                                    <i class='bx bxl-facebook'></i>
                                </a>
                            @endif
                            
                            @if(!empty($social_links['twitter']))
                                <a href="{{ $social_links['twitter'] }}" class="profile-social-link" title="Twitter" target="_blank" rel="noopener noreferrer">
                                    <i class='bx bxl-twitter'></i>
                                </a>
                            @endif
                            
                            @if(!empty($social_links['instagram']))
                                <a href="{{ $social_links['instagram'] }}" class="profile-social-link" title="Instagram" target="_blank" rel="noopener noreferrer">
                                    <i class='bx bxl-instagram'></i>
                                </a>
                            @endif
                            
                            @if(!empty($social_links['linkedin']))
                                <a href="{{ $social_links['linkedin'] }}" class="profile-social-link" title="LinkedIn" target="_blank" rel="noopener noreferrer">
                                    <i class='bx bxl-linkedin'></i>
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-3" style="color: var(--text-muted); font-size: 0.9rem;">
                            <i class='bx bx-link-external' style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="mb-0 mt-2">No social links added yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
          

        {{-- Profile Tabs --}}
        <div class="col-lg-8 col-md-12" data-aos="fade-up" data-aos-delay="100">
            <div class="profile-tabs">
                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">
                            <i class='bx bx-user'></i> Personal
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#education" type="button" role="tab">
                            <i class='bx bx-graduation'></i> Education
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#bio" type="button" role="tab">
                            <i class='bx bx-info-circle'></i> Bio
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                            <i class='bx bx-lock'></i> Password
                        </button>
                    </li>
                </ul>
                @php
                    if (isset($user->profile->date_of_birth)) {
                        $dob = date('Y-m-d', strtotime($user->profile->date_of_birth));
                    }
                @endphp
                
                <div class="tab-content">
                    {{-- Personal Details Tab --}}
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <h3 class="profile-section-title">
                            <i class='bx bx-user-circle'></i>
                            Personal Details
                        </h3>
                        
                        <div class="profile-details-grid">
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-calendar'></i> Date of Birth
                                </div>
                                <div class="profile-detail-value">{{ $dob ?? 'N/A' }}</div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-user'></i> Gender
                                </div>
                                <div class="profile-detail-value">{{ ucfirst($user->profile->gender ?? 'N/A') }}</div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-map'></i> City
                                </div>
                                <div class="profile-detail-value">{{ ucwords($user->profile->city ?? 'N/A') }}</div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-map-pin'></i> State
                                </div>
                                <div class="profile-detail-value">{{ ucwords($user->profile->state ?? 'N/A') }}</div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-world'></i> Country
                                </div>
                                <div class="profile-detail-value">{{ ucwords($user->profile->country ?? 'N/A') }}</div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-mail-send'></i> Pincode
                                </div>
                                <div class="profile-detail-value">{{ $user->profile->pincode ?? 'N/A' }}</div>
                            </div>
                        </div>
                        
                        <div class="profile-details-grid mt-4">
                            <div class="profile-detail-item" style="grid-column: 1 / -1;">
                                <div class="profile-detail-label">
                                    <i class='bx bx-home'></i> Current Address
                                </div>
                                <div class="profile-detail-value">{{ $user->profile->current_address ?? 'N/A' }}</div>
                            </div>
                            
                            <div class="profile-detail-item" style="grid-column: 1 / -1;">
                                <div class="profile-detail-label">
                                    <i class='bx bx-home-heart'></i> Permanent Address
                                </div>
                                <div class="profile-detail-value">{{ $user->profile->permanent_address ?? 'N/A' }}</div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-buildings'></i> Locality
                                </div>
                                <div class="profile-detail-value">{{ ucwords($user->profile->locality ?? 'N/A') }}</div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-id-card'></i> Aadhar Number
                                </div>
                                <div class="profile-detail-value">{{ $user->profile->aadhar ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    {{-- Education Tab --}}
                    <div class="tab-pane fade" id="education" role="tabpanel">
                        <h3 class="profile-section-title">
                            <i class='bx bx-graduation'></i>
                            Education Information
                        </h3>
                        
                        <div class="profile-details-grid">
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-building'></i> College/University
                                </div>
                                <div class="profile-detail-value">{{ $user->profile->college_name ?? 'N/A' }}</div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-book'></i> Course
                                </div>
                                <div class="profile-detail-value">{{ $user->profile->course ?? 'N/A' }}</div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-time'></i> Study Year
                                </div>
                                <div class="profile-detail-value">
                                    @if ($user->profile && $user->profile->study_year)
                                        {{ $user->profile->study_year }} Year
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                            
                            <div class="profile-detail-item">
                                <div class="profile-detail-label">
                                    <i class='bx bx-id-card'></i> ID Card
                                </div>
                                <div class="profile-detail-value">
                                    @if($user->profile && $user->profile->id_card_url)
                                        <a href="{{ asset($user->profile->id_card_url) }}" class="btn btn-sm btn-profile-secondary" target="_blank">
                                            <i class='bx bx-download'></i> View / Download
                                        </a>
                                    @else
                                        Not Uploaded
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bio Tab --}}
                    <div class="tab-pane fade" id="bio" role="tabpanel">
                        <h3 class="profile-section-title">
                            <i class='bx bx-info-circle'></i>
                            Bio & About Me
                        </h3>
                        
                        <div class="profile-detail-item" style="border-left: 3px solid var(--brand-primary); padding: 1.5rem; background: var(--bg-light); border-radius: var(--radius-md);">
                            <div class="profile-detail-label" style="margin-bottom: 1rem;">
                                <i class='bx bx-user-voice'></i> About Me
                            </div>
                            <div class="profile-detail-value" style="line-height: 1.6;">
                                {{ $user->profile->bio ?? 'No bio added yet. Tell us something about yourself!' }}
                            </div>
                        </div>
                        
                        <h4 class="mt-4 mb-3" style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">
                            <i class='bx bx-link'></i> Social Links
                        </h4>
                        
                        @php
                            $social_links_bio = $user->profile->social_links ?? [];
                            // Handle if social_links is a string (not yet decoded)
                            if (is_string($social_links_bio)) {
                                $social_links_bio = json_decode($social_links_bio, true) ?? [];
                            }
                            // Ensure it's an array
                            if (!is_array($social_links_bio)) {
                                $social_links_bio = [];
                            }
                        @endphp
                        
                        @if(!empty(array_filter($social_links_bio)))
                            <div class="profile-social-links">
                                @if(!empty($social_links_bio['facebook']))
                                    <a href="{{ $social_links_bio['facebook'] }}" class="profile-social-link" title="Facebook" target="_blank" rel="noopener noreferrer">
                                        <i class='bx bxl-facebook'></i>
                                    </a>
                                @endif
                                
                                @if(!empty($social_links_bio['twitter']))
                                    <a href="{{ $social_links_bio['twitter'] }}" class="profile-social-link" title="Twitter" target="_blank" rel="noopener noreferrer">
                                        <i class='bx bxl-twitter'></i>
                                    </a>
                                @endif
                                
                                @if(!empty($social_links_bio['instagram']))
                                    <a href="{{ $social_links_bio['instagram'] }}" class="profile-social-link" title="Instagram" target="_blank" rel="noopener noreferrer">
                                        <i class='bx bxl-instagram'></i>
                                    </a>
                                @endif
                                
                                @if(!empty($social_links_bio['linkedin']))
                                    <a href="{{ $social_links_bio['linkedin'] }}" class="profile-social-link" title="LinkedIn" target="_blank" rel="noopener noreferrer">
                                        <i class='bx bxl-linkedin'></i>
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4" style="background: var(--bg-light); border-radius: var(--radius-md); color: var(--text-muted);">
                                <i class='bx bx-link-external' style="font-size: 2.5rem; opacity: 0.3;"></i>
                                <p class="mb-0 mt-2"><strong>No social links added</strong></p>
                                <p class="mb-0" style="font-size: 0.85rem;">Add your social media profiles from edit page</p>
                            </div>
                        @endif
                    </div>

                    {{-- Password Tab --}}
                    <div class="tab-pane fade" id="password" role="tabpanel">
                        <h3 class="profile-section-title">
                            <i class='bx bx-lock-alt'></i>
                            Change Password
                        </h3>
                        
                        <form method="post" action="{{ route('user.profile.update-password') }}" class="password-form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="current_password">
                                    <i class='bx bx-key'></i> Current Password
                                </label>
                                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter your current password" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password">
                                    <i class='bx bx-lock'></i> New Password
                                </label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password" required>
                                <div class="password-strength mt-2">
                                    <div class="password-strength-bar" style="width: 0%;"></div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password_confirmation">
                                    <i class='bx bx-check-shield'></i> Confirm Password
                                </label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" required>
                            </div>
                            
                            <button type="submit" class="btn-profile-primary">
                                <i class='bx bx-save'></i> Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
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

    // Show validation errors
    @if($errors->any())
        Toast.fire({
            icon: 'error',
            title: 'Validation Errors',
            html: '<ul style="text-align: left; margin: 0; padding-left: 1.5rem;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            timer: 5000,
            background: '#fee2e2',
            color: '#991b1b',
            iconColor: '#ef4444'
        });
    @endif

    // Edit Profile Button
    const editButton = document.getElementById('edit-profile');
    if (editButton) {
        editButton.addEventListener('click', function() {
            window.location.href = "{{ route('user.profile.edit', auth()->user()->user_id) }}";
        });
    }

    // Auto-dismiss alert boxes after 5 seconds
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Password Strength Indicator
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.querySelector('.password-strength-bar');
            
            let strength = 0;
            if (password.length >= 8) strength += 25;
            if (password.match(/[a-z]+/)) strength += 25;
            if (password.match(/[A-Z]+/)) strength += 25;
            if (password.match(/[0-9]+/)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength < 50) {
                strengthBar.style.background = 'var(--error-color)';
            } else if (strength < 75) {
                strengthBar.style.background = 'var(--warning-color)';
            } else {
                strengthBar.style.background = 'var(--success-color)';
            }
        });
    }

    // Initialize tooltips if present
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endpush
