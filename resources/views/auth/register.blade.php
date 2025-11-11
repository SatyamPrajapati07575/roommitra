@extends('layouts.modern')

@section('title', 'Create Account - RoomMitra')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}?v={{ config('app.asset_version', '1.0.0') }}">
@endpush

@section('content')

<section class="auth-section">
    <div class="container-modern">
        <div class="auth-card" data-aos="fade-up">
            <div class="row g-0">
                <!-- Left Side - Brand & Features -->
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="auth-left">
                        <h2>Join RoomMitra!</h2>
                        <p>Create your account and start finding your perfect student accommodation today</p>
                        
                        <div class="auth-features">
                            <div class="auth-feature">
                                <i class='bx bx-check-circle'></i>
                                <span>Quick & Easy Registration</span>
                            </div>
                            <div class="auth-feature">
                                <i class='bx bx-check-circle'></i>
                                <span>Access to Verified Listings</span>
                            </div>
                            <div class="auth-feature">
                                <i class='bx bx-check-circle'></i>
                                <span>Connect Directly with Owners</span>
                            </div>
                            <div class="auth-feature">
                                <i class='bx bx-check-circle'></i>
                                <span>Save Your Favorite Rooms</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Registration Form -->
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="auth-right">
                        <div class="auth-header">
                            <h3>Create Account</h3>
                            <p>Fill in your details to get started</p>
                        </div>
                        
                        @if(session('success'))
                        <div class="alert-modern alert-success">
                            <i class='bx bx-check-circle'></i> {{ session('success') }}
                        </div>
                        @endif
                        
                        @if(session('error'))
                        <div class="alert-modern alert-error">
                            <i class='bx bx-error-circle'></i> {{ session('error') }}
                        </div>
                        @endif
                        
                        @if(isset($email))
                        <div class="alert-modern alert-success">
                            <i class='bx bx-check-circle'></i> Verification email sent to {{ $email }}
                        </div>
                        @endif
                        
                        <form method="POST" action="{{ route('register') }}" novalidate>
                            @csrf
                            
                            <div class="form-row-modern">
                                <div class="form-group-modern">
                                    <label for="full_name" class="form-label-modern">
                                        <i class='bx bx-user'></i> Full Name
                                    </label>
                                    <input type="text" 
                                           class="form-control-modern @error('full_name') is-invalid @enderror" 
                                           id="full_name" 
                                           name="full_name" 
                                           value="{{ old('full_name') }}"
                                           placeholder="Enter your full name" 
                                           required>
                                    @error('full_name')
                                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group-modern">
                                    <label for="email" class="form-label-modern">
                                        <i class='bx bx-envelope'></i> Email Address
                                    </label>
                                    <input type="email" 
                                           class="form-control-modern @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           placeholder="Enter your email" 
                                           required>
                                    @error('email')
                                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group-modern">
                                <label for="phone" class="form-label-modern">
                                    <i class='bx bx-phone'></i> Phone Number
                                </label>
                                <input type="tel" 
                                       class="form-control-modern @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}"
                                       placeholder="Enter your phone number" 
                                       required>
                                @error('phone')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-row-modern">
                                <div class="form-group-modern">
                                    <label for="password" class="form-label-modern">
                                        <i class='bx bx-lock-alt'></i> Password
                                    </label>
                                    <input type="password" 
                                           class="form-control-modern @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Create a password" 
                                           required>
                                    @error('password')
                                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group-modern">
                                    <label for="password_confirmation" class="form-label-modern">
                                        <i class='bx bx-lock-alt'></i> Confirm Password
                                    </label>
                                    <input type="password" 
                                           class="form-control-modern" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Re-enter password" 
                                           required>
                                </div>
                            </div>
                            
                            <div class="form-group-modern">
                                <label for="role" class="form-label-modern">
                                    <i class='bx bx-briefcase'></i> Register As
                                </label>
                                <select class="form-select-modern" name="role" id="role" required>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Student</option>
                                    <option value="room_owner" {{ old('role') == 'room_owner' ? 'selected' : '' }}>Room Owner</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn-auth-primary">
                                <i class='bx bx-user-plus'></i> Create Account
                            </button>
                            
                            <div class="divider">
                                <span>Or register with</span>
                            </div>
                            
                            <div class="social-login">
                                <a href="{{ route('social.login', ['provider' => 'google', 'role' => 'user']) }}" class="btn-social">
                                    <i class='bx bxl-google'></i>
                                    <span>Google (Student)</span>
                                </a>
                                <a href="{{ route('social.login', ['provider' => 'google', 'role' => 'room_owner']) }}" class="btn-social">
                                    <i class='bx bxl-google'></i>
                                    <span>Google (Owner)</span>
                                </a>
                            </div>
                            
                            <div class="auth-footer">
                                Already have an account? <a href="{{ route('login.form') }}">Sign In</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
@endpush
