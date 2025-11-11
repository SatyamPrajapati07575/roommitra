<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Title & Meta -->
    <title>@yield('title', 'RoomMitra') | Student Accommodation Platform</title>
    <meta name="description" content="@yield('meta_description', 'RoomMitra helps students find 100% verified, affordable, and secure PGs, hostels, and rental rooms near their college.')">
    <meta name="keywords" content="Room booking, Student accommodation, Hostel booking, PGs, RoomMitra, Student housing India">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'RoomMitra') | Student Accommodation">
    <meta property="og:description" content="@yield('meta_description', 'Find verified rooms with owner KYC, secure booking, and flexible cancellations.')">
    <meta property="og:type" content="website">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo/RoomLogo.png') }}" type="image/png">
    
    <!-- Preconnect for Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://unpkg.com">
    
    <!-- Google Fonts - Inter & Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- BoxIcons - Modern Icon Library -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- AOS - Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Application CSS with Versioning -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ config('app.asset_version', '1.0.0') }}">
    
    <!-- Page Specific Styles -->
    @stack('styles')
</head>
<body>
    <!-- Main Wrapper -->
    <div class="main-content">
        <!-- Navigation -->
        @include('components.navbar')
        
        <!-- Alert Messages -->
        <div class="container-modern" style="padding-top: 1rem;">
            @include('components.alert')
        </div>
        
        <!-- Page Content -->
        <div class="page-wrapper">
            @yield('content')
        </div>
        
        <!-- Footer -->
        @include('components.footer')
    </div>
    
    <!-- jQuery (Required for page scripts) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 for Notifications -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- AOS - Animate On Scroll -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
        
        // SweetAlert2 Toast Configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        
        // Make Toast globally available
        window.Toast = Toast;
        
        // Handle session messages with Toast
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif
        
        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif
        
        @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                title: '{{ session('warning') }}'
            });
        @endif
        
        @if(session('info'))
            Toast.fire({
                icon: 'info',
                title: '{{ session('info') }}'
            });
        @endif
    </script>
    
    <!-- Page Specific Scripts -->
    @stack('scripts')
</body>
</html>
