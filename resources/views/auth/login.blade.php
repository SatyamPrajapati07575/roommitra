@extends('layouts.modern')

@section('title', 'Login - RoomMitra')

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
                        <h2>Welcome Back!</h2>
                        <p>Login to access your RoomMitra account and find your perfect accommodation</p>
                        
                        <div class="auth-features">
                            <div class="auth-feature">
                                <i class='bx bx-check-circle'></i>
                                <span>100% Verified Listings</span>
                            </div>
                            <div class="auth-feature">
                                <i class='bx bx-check-circle'></i>
                                <span>Zero Brokerage Fee</span>
                            </div>
                            <div class="auth-feature">
                                <i class='bx bx-check-circle'></i>
                                <span>Safe & Secure Platform</span>
                            </div>
                            <div class="auth-feature">
                                <i class='bx bx-check-circle'></i>
                                <span>24/7 Customer Support</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Side - Login Form -->
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="auth-right">
                        <div class="auth-header">
                            <h3>Sign In</h3>
                            <p>Enter your credentials to access your account</p>
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
                        
                        <form method="POST" action="{{ route('login') }}" novalidate>
                            @csrf
                            
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
                            
                            <div class="form-group-modern">
                                <label for="password" class="form-label-modern">
                                    <i class='bx bx-lock-alt'></i> Password
                                </label>
                                <input type="password" 
                                       class="form-control-modern @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter your password" 
                                       required>
                                @error('password')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group-modern">
                                <label for="role" class="form-label-modern">
                                    <i class='bx bx-user'></i> Login As
                                </label>
                                <select class="form-select-modern" name="role" id="role" required>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Student</option>
                                    <option value="room_owner" {{ old('role') == 'room_owner' ? 'selected' : '' }}>Room Owner</option>
                                </select>
                            </div>
                            
                            <div class="remember-forgot">
                                <div class="form-check-modern">
                                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">Remember me</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                            </div>
                            
                            <button type="submit" class="btn-auth-primary">
                                <i class='bx bx-log-in'></i> Sign In
                            </button>
                            
                            <div class="divider">
                                <span>Or continue with</span>
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
                                Don't have an account? <a href="{{ route('register.form') }}">Create Account</a>
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
