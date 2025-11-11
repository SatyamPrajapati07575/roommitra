<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - RoomMitra</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Brand Theme -->
    <link rel="stylesheet" href="{{ asset('css/brand-theme.css') }}">
    
    <!-- Components CSS -->
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-light);
            overflow-x: hidden;
        }
        
        /* Sidebar Styles */
        .dashboard-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem;
            background: var(--brand-gradient);
            color: white;
        }
        
        .sidebar-logo {
            font-size: 1.5rem;
            font-weight: 800;
            text-decoration: none;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .sidebar-user {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255,255,255,0.2);
        }
        
        .sidebar-user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid white;
            object-fit: cover;
        }
        
        .sidebar-user-info {
            margin-left: 0.75rem;
        }
        
        .sidebar-user-name {
            font-weight: 600;
            font-size: 1rem;
            margin: 0;
        }
        
        .sidebar-user-email {
            font-size: 0.8rem;
            opacity: 0.9;
            margin: 0;
        }
        
        .sidebar-menu {
            padding: 1.5rem 0;
        }
        
        .sidebar-menu-title {
            padding: 0 1.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        
        .sidebar-menu-item {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .sidebar-menu-item:hover {
            background: var(--brand-gradient-soft);
            color: var(--brand-primary);
        }
        
        .sidebar-menu-item.active {
            background: var(--brand-gradient-soft);
            color: var(--brand-primary);
            font-weight: 600;
            border-left: 4px solid var(--brand-primary);
        }
        
        .sidebar-menu-item i {
            font-size: 1.25rem;
            margin-right: 0.75rem;
            width: 24px;
        }
        
        .sidebar-menu-badge {
            margin-left: auto;
            padding: 0.25rem 0.5rem;
            background: var(--brand-primary);
            color: white;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        /* Main Content */
        .dashboard-main {
            margin-left: 280px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
            width: calc(100% - 280px);
            overflow-x: hidden;
        }
        
        /* Top Navbar */
        .dashboard-navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .navbar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-primary);
            cursor: pointer;
        }
        
        .navbar-search {
            flex: 1;
            max-width: 500px;
            position: relative;
        }
        
        .navbar-search input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid var(--border-light);
            border-radius: var(--radius-md);
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        
        .navbar-search input:focus {
            outline: none;
            border-color: var(--brand-primary);
        }
        
        .navbar-search i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }
        
        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .navbar-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-light);
            border: none;
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
        }
        
        .navbar-btn:hover {
            background: var(--brand-gradient-soft);
            color: var(--brand-primary);
        }
        
        .navbar-btn .badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 18px;
            height: 18px;
            background: var(--error-color);
            color: white;
            border-radius: 50%;
            font-size: 0.65rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Content Area */
        .dashboard-content {
            padding: 2rem;
            max-width: 100%;
            overflow-x: hidden;
        }
        
        /* Mobile Responsive */
        @media (max-width: 992px) {
            .dashboard-sidebar {
                left: -280px;
            }
            
            .dashboard-sidebar.active {
                left: 0;
            }
            
            .dashboard-main {
                margin-left: 0;
                width: 100%;
            }
            
            .navbar-toggle {
                display: block;
            }
            
            .navbar-search {
                display: none;
            }
        }
        
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        
        .sidebar-overlay.active {
            display: block;
        }
        
        /* Scrollbar Styling */
        .dashboard-sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .dashboard-sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .dashboard-sidebar::-webkit-scrollbar-thumb {
            background: var(--neutral-300);
            border-radius: 10px;
        }
        
        .dashboard-sidebar::-webkit-scrollbar-thumb:hover {
            background: var(--brand-primary);
        }
        
        /* Hide scrollbar for main content but keep functionality */
        .dashboard-content::-webkit-scrollbar {
            width: 8px;
        }
        
        .dashboard-content::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .dashboard-content::-webkit-scrollbar-thumb {
            background: var(--neutral-300);
            border-radius: 10px;
        }
        
        .dashboard-content::-webkit-scrollbar-thumb:hover {
            background: var(--brand-primary);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    
    <!-- Sidebar -->
    <aside class="dashboard-sidebar" id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <a href="{{ route('home') }}" class="sidebar-logo">
                <i class='bx bx-home-heart'></i>
                <span>RoomMitra</span>
            </a>
            
            <!-- User Info -->
            <div class="sidebar-user d-flex align-items-center">
                @if(auth()->user()->profile && auth()->user()->profile->avatar)
                    <img src="{{ asset(auth()->user()->profile->avatar) }}" alt="Avatar" class="sidebar-user-avatar">
                @else
                    <img src="{{ asset('img/avatar/avatar.png') }}" alt="Avatar" class="sidebar-user-avatar">
                @endif
                <div class="sidebar-user-info">
                    <p class="sidebar-user-name">{{ auth()->user()->full_name }}</p>
                    <p class="sidebar-user-email">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
        
        <!-- Sidebar Menu -->
        <nav class="sidebar-menu">
            <div class="sidebar-menu-title">Main Menu</div>
            
            <a href="{{ route('user.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class='bx bx-home-circle'></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('user.profile.index') }}" class="sidebar-menu-item {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                <i class='bx bx-user-circle'></i>
                <span>My Profile</span>
            </a>
            
            <a href="{{ route('user.bookings.index') }}" class="sidebar-menu-item {{ request()->routeIs('user.bookings.*') ? 'active' : '' }}">
                <i class='bx bx-calendar-check'></i>
                <span>My Bookings</span>
                @if(auth()->user()->bookings()->count() > 0)
                    <span class="sidebar-menu-badge">{{ auth()->user()->bookings()->count() }}</span>
                @endif
            </a>
            
            <a href="{{ route('wishlist.index') }}" class="sidebar-menu-item {{ request()->routeIs('wishlist.*') ? 'active' : '' }}">
                <i class='bx bx-heart'></i>
                <span>Wishlist</span>
                @if(auth()->user()->wishlists()->count() > 0)
                    <span class="sidebar-menu-badge">{{ auth()->user()->wishlists()->count() }}</span>
                @endif
            </a>
            
            <a href="{{ route('user.compare.index') }}" class="sidebar-menu-item {{ request()->routeIs('user.compare.*') ? 'active' : '' }}">
                <i class='bx bx-git-compare'></i>
                <span>Compare Rooms</span>
            </a>
            
            <a href="{{ route('user.payments.index') }}" class="sidebar-menu-item {{ request()->routeIs('user.payments.*') ? 'active' : '' }}">
                <i class='bx bx-wallet'></i>
                <span>Payments</span>
            </a>
            
            <div class="sidebar-menu-title" style="margin-top: 1.5rem;">Support</div>
            
            <a href="{{ route('user.reviews.index') }}" class="sidebar-menu-item {{ request()->routeIs('user.reviews.*') ? 'active' : '' }}">
                <i class='bx bx-star'></i>
                <span>My Reviews</span>
            </a>
            
            <a href="{{ route('user.complaints.index') }}" class="sidebar-menu-item {{ request()->routeIs('user.complaints.*') ? 'active' : '' }}">
                <i class='bx bx-message-square-error'></i>
                <span>Complaints</span>
            </a>
            
            <div class="sidebar-menu-title" style="margin-top: 1.5rem;">Browse</div>
            
            <a href="{{ route('rooms') }}" class="sidebar-menu-item">
                <i class='bx bx-search-alt'></i>
                <span>Browse Rooms</span>
            </a>
            
            <a href="{{ route('home') }}" class="sidebar-menu-item">
                <i class='bx bx-home'></i>
                <span>Home</span>
            </a>
            
            <div class="sidebar-menu-title" style="margin-top: 1.5rem;">Account</div>
            
            <a href="{{ route('logout') }}" class="sidebar-menu-item" style="color: var(--error-color);">
                <i class='bx bx-log-out'></i>
                <span>Logout</span>
            </a>
        </nav>
    </aside>
    
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Main Content -->
    <main class="dashboard-main">
        <!-- Top Navbar -->
        <nav class="dashboard-navbar">
            <button class="navbar-toggle" id="sidebarToggle">
                <i class='bx bx-menu'></i>
            </button>
            
            <div class="navbar-search">
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Search rooms, bookings...">
            </div>
            
            <div class="navbar-actions">
                <button class="navbar-btn" title="Notifications">
                    <i class='bx bx-bell'></i>
                    @if(auth()->user()->bookings()->where('status', 'pending')->count() > 0)
                        <span class="badge">{{ auth()->user()->bookings()->where('status', 'pending')->count() }}</span>
                    @endif
                </button>
                
                <a href="{{ route('user.profile.index') }}" class="navbar-btn" title="Profile">
                    <i class='bx bx-user'></i>
                </a>
            </div>
        </nav>
        
        <!-- Page Content -->
        <div class="dashboard-content">
            @yield('content')
        </div>
    </main>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 600,
            once: true
        });
        
        // Initialize Toast Configuration (Global - Used by all pages)
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
        
        // Sidebar Toggle (Mobile)
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        });
        
        sidebarOverlay?.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });
    </script>
    
    @stack('scripts')
</body>
</html>
