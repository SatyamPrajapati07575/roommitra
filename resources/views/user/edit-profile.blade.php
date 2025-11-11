@extends('layouts.user-dashboard')
@section('title', 'Edit Profile')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/user-profile.css') }}?v={{ config('app.asset_version', '1.0.0') }}">
@endpush

@section('content')
    {{-- Page Header --}}
    <div class="mb-4" data-aos="fade-down">
        <h1 class="h2" style="font-weight: 800; color: var(--text-primary); display: flex; align-items: center; gap: 0.75rem;">
            <i class='bx bx-edit' style="color: var(--brand-primary);"></i>
            Edit Profile
        </h1>
        <p style="color: var(--text-muted); margin: 0;">Update your personal information and preferences</p>
    </div>

    <div class="row g-4">

        {{-- Error Messages (Hidden - Using Toast Notifications) --}}
        @if ($errors->any())
            <div class="col-12 d-none">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class='bx bx-error-circle'></i>
                    <strong>Whoops! Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif
        @php
            $avatar = null;
            if ($user->profile) {
                $avatar = $user->profile->avatar;
            }
            $isValidAvatar = $avatar && trim($avatar) !== 'N/A';
        @endphp

        {{-- Profile Card --}}
        <div class="col-lg-4 col-md-12" data-aos="fade-up">
            <div class="profile-card">
                <div class="profile-card-header">
                    <div class="profile-avatar-wrapper">
                        <img src="{{ $isValidAvatar ? asset($avatar) : asset('img/avatar/avatar.png') }}" 
                             alt="User Avatar" 
                             class="profile-avatar" 
                             id="avatar-preview">
                        
                        @if ($user->is_verified)
                            <div class="profile-verified-badge">
                                <i class='bx bx-check'></i>
                            </div>
                        @endif
                    </div>
                    
                    <h2 class="profile-name">{{ $user->full_name ?? 'N/A' }}</h2>
                    <span class="profile-role">{{ ucfirst($user->role ?? 'user') }}</span>
                    
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
                            <p class="profile-info-value">{{ $user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="profile-info-item">
                        <div class="profile-info-icon">
                            <i class='bx bx-phone'></i>
                        </div>
                        <div class="profile-info-content">
                            <div class="profile-info-label">Phone</div>
                            <p class="profile-info-value">{{ $user->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                    
                    <div class="profile-actions mt-4">
                        <button type="button" class="btn-profile-primary" id="upload_profile_picture">
                            <i class='bx bx-upload'></i> Upload Photo
                        </button>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('user.profile.index') }}" class="btn-profile-secondary" style="text-decoration: none;">
                            <i class='bx bx-arrow-back'></i> Back to Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>


        {{-- Edit Form Tabs --}}
        <div class="col-lg-8 col-md-12" data-aos="fade-up" data-aos-delay="100">
            <form action="{{ route('user.profile.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="file" class="form-control d-none" name="avatar" id="profile_picture_input" accept="image/*">
                
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
                    </ul>

                    <div class="tab-content">

                        {{-- Personal Tab --}}
                        <div class="tab-pane fade show active" id="personal" role="tabpanel">
                            <h3 class="profile-section-title">
                                <i class='bx bx-user-circle'></i>
                                Personal Information
                            </h3>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="full_name">
                                            <i class='bx bx-user'></i> Full Name
                                        </label>
                                        <input type="text" class="form-control" id="full_name" name="full_name" 
                                               value="{{ $user->full_name ?? '' }}" 
                                               placeholder="Enter your full name" required />
                                        @error('full_name')
                                            <small class="text-danger"><i class='bx bx-error-circle'></i> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">
                                            <i class='bx bx-phone'></i> Phone Number
                                        </label>
                                        <input type="tel" class="form-control" id="phone" name="phone"
                                               value="{{ $user->phone ?? '' }}" 
                                               placeholder="Enter phone number" required />
                                        @error('phone')
                                            <small class="text-danger"><i class='bx bx-error-circle'></i> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date_of_birth">
                                            <i class='bx bx-calendar'></i> Date of Birth
                                        </label>
                                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth"
                                               value="{{ optional($user->profile->date_of_birth)->format('Y-m-d') }}" />
                                        @error('date_of_birth')
                                            <small class="text-danger"><i class='bx bx-error-circle'></i> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">
                                            <i class='bx bx-user'></i> Gender
                                        </label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ old('gender', $user->profile->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ old('gender', $user->profile->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                            <option value="Other" {{ old('gender', $user->profile->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('gender')
                                            <small class="text-danger"><i class='bx bx-error-circle'></i> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address">
                                            <i class='bx bx-home'></i> Current Address
                                        </label>
                                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your current address">{{ $user->profile->current_address ?? '' }}</textarea>
                                        @error('address')
                                            <small class="text-danger"><i class='bx bx-error-circle'></i> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="permanent_address">
                                            <i class='bx bx-home-heart'></i> Permanent Address
                                        </label>
                                        <textarea class="form-control" id="permanent_address" name="permanent_address" rows="2" placeholder="Enter permanent address">{{ $user->profile->permanent_address ?? '' }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="locality">
                                            <i class='bx bx-buildings'></i> Locality
                                        </label>
                                        <input type="text" class="form-control" id="locality" name="locality" 
                                               placeholder="Enter locality" 
                                               value="{{ $user->profile->locality ?? '' }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">
                                            <i class='bx bx-map'></i> City
                                        </label>
                                        <input type="text" class="form-control" id="city" name="city" 
                                               placeholder="Enter city" 
                                               value="{{ $user->profile->city ?? '' }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="state">
                                            <i class='bx bx-map-pin'></i> State
                                        </label>
                                        <input type="text" class="form-control" id="state" name="state" 
                                               placeholder="Enter state" 
                                               value="{{ $user->profile->state ?? '' }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country">
                                            <i class='bx bx-world'></i> Country
                                        </label>
                                        <input type="text" class="form-control" id="country" name="country" 
                                               placeholder="Enter country" 
                                               value="{{ $user->profile->country ?? '' }}">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pincode">
                                            <i class='bx bx-mail-send'></i> Pincode
                                        </label>
                                        <input type="text" class="form-control" id="pincode" name="pincode" 
                                               placeholder="Enter pincode" 
                                               value="{{ $user->profile->pincode ?? '' }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="aadhar">
                                            <i class='bx bx-id-card'></i> Aadhar Number
                                        </label>
                                        <input type="text" class="form-control" id="aadhar" name="aadhar"
                                               value="{{ $user->profile->aadhar ?? '' }}" 
                                               placeholder="Enter Aadhar number" />
                                        @error('aadhar')
                                            <small class="text-danger"><i class='bx bx-error-circle'></i> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Education Tab --}}
                        <div class="tab-pane fade" id="education" role="tabpanel">
                            <h3 class="profile-section-title">
                                <i class='bx bx-graduation'></i>
                                Education Information
                            </h3>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="college">
                                            <i class='bx bx-building'></i> College/University
                                        </label>
                                        <input type="text" class="form-control" id="college" name="college"
                                               value="{{ $user->profile->college_name ?? '' }}" 
                                               placeholder="Enter college or university name" />
                                        @error('college')
                                            <small class="text-danger"><i class='bx bx-error-circle'></i> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="course">
                                            <i class='bx bx-book'></i> Course
                                        </label>
                                        <input type="text" class="form-control" id="course" name="course"
                                               value="{{ $user->profile->course ?? '' }}" 
                                               placeholder="Enter course name" />
                                        @error('course')
                                            <small class="text-danger"><i class='bx bx-error-circle'></i> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="study_year">
                                            <i class='bx bx-time'></i> Study Year
                                        </label>
                                        <input type="number" class="form-control" id="study_year" name="study_year" 
                                               placeholder="Enter year (e.g., 1, 2, 3)" 
                                               value="{{ $user->profile->study_year ?? '' }}" 
                                               min="1" max="5" />
                                        @error('year')
                                            <small class="text-danger"><i class='bx bx-error-circle'></i> {{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_card">
                                            <i class='bx bx-id-card'></i> Upload ID Card
                                        </label>
                                        <input type="file" class="form-control" id="id_card" name="id_card" accept="image/*,.pdf" />
                                        <small class="text-muted" style="font-size: 0.8rem;">
                                            <i class='bx bx-info-circle'></i> Accepted formats: JPG, PNG, PDF
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bio Tab --}}
                        <div class="tab-pane fade" id="bio" role="tabpanel">
                            <h3 class="profile-section-title">
                                <i class='bx bx-info-circle'></i>
                                Bio & Social Links
                            </h3>
                            
                            <div class="form-group mb-4">
                                <label for="bio">
                                    <i class='bx bx-user-voice'></i> About Me
                                </label>
                                <textarea class="form-control" id="bio" name="bio" rows="5" 
                                          placeholder="Tell us something about yourself...">{{ $user->profile->bio ?? '' }}</textarea>
                                <small class="text-muted" style="font-size: 0.8rem;">
                                    <i class='bx bx-info-circle'></i> This will be displayed on your public profile
                                </small>
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

                            <h4 class="mb-3" style="font-size: 1.25rem; font-weight: 700; color: var(--text-primary);">
                                <i class='bx bx-link'></i> Social Media Links
                            </h4>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="facebook">
                                            <i class='bx bxl-facebook-circle'></i> Facebook
                                        </label>
                                        <input type="url" class="form-control" id="facebook" name="social_links[facebook]"
                                               value="{{ $social_links['facebook'] ?? '' }}" 
                                               placeholder="https://facebook.com/yourname" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="twitter">
                                            <i class='bx bxl-twitter'></i> Twitter
                                        </label>
                                        <input type="url" class="form-control" id="twitter" name="social_links[twitter]"
                                               value="{{ $social_links['twitter'] ?? '' }}" 
                                               placeholder="https://twitter.com/yourhandle" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="instagram">
                                            <i class='bx bxl-instagram'></i> Instagram
                                        </label>
                                        <input type="url" class="form-control" id="instagram" name="social_links[instagram]"
                                               value="{{ $social_links['instagram'] ?? '' }}" 
                                               placeholder="https://instagram.com/yourusername" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="linkedin">
                                            <i class='bx bxl-linkedin-square'></i> LinkedIn
                                        </label>
                                        <input type="url" class="form-control" id="linkedin" name="social_links[linkedin]"
                                               value="{{ $social_links['linkedin'] ?? '' }}"
                                               placeholder="https://linkedin.com/in/yourprofile" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Submit Actions --}}
                    <div class="d-flex gap-3 mt-4 justify-content-end">
                        <a href="{{ route('user.profile.index') }}" class="btn-profile-secondary" style="text-decoration: none;">
                            <i class='bx bx-x'></i> Cancel
                        </a>
                        <button class="btn-profile-primary" type="submit">
                            <i class='bx bx-save'></i> Save All Changes
                        </button>
                    </div>
                </div>
            </form>
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
            title: 'Please fix the errors',
            html: '<ul style="text-align: left; margin: 0; padding-left: 1.5rem;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
            timer: 5000,
            background: '#fee2e2',
            color: '#991b1b',
            iconColor: '#ef4444'
        });
    @endif

    // Upload Profile Picture
    document.getElementById('upload_profile_picture').addEventListener('click', function() {
        document.getElementById('profile_picture_input').click();
    });

    // Image Preview
    document.getElementById('profile_picture_input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
                
                Toast.fire({
                    icon: 'success',
                    title: 'Photo selected! Save changes to update.',
                    timer: 2000
                });
            };
            reader.readAsDataURL(file);
        }
    });

    // Auto-dismiss alert boxes after 5 seconds
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Form validation feedback
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    }

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endpush
