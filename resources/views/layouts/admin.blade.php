<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RoomMitra | @yield('title', 'Home')</title>
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    
    <!-- BoxIcons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- AdminLTE Theme -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    
    <!-- Custom Admin Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin-custom.css') }}?v=2.0.0">
    
    @stack('styles')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class='bx bx-menu' style="font-size: 1.5rem;"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class='bx bx-home-circle'></i> Dashboard
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('admin.complaints.index') }}" class="nav-link">
                        <i class='bx bx-support'></i> Support
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class='bx bx-bell' style="font-size: 1.3rem;"></i>
                        <span class="badge badge-warning navbar-badge">5</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">5 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class='bx bx-calendar-check mr-2'></i> 2 new bookings
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class='bx bx-user-check mr-2'></i> 3 check-ins today
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class='bx bx-star mr-2'></i> 1 new review
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class='bx bx-fullscreen' style="font-size: 1.3rem;"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('admin.dashboard') }}" class="brand-link">
                <div class="logo-icon">
                    <i class='bx bxs-home-heart'></i>
                </div>
                <span class="brand-text">RoomMitra</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
                    <div class="image">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('admin')->user()->full_name ?? 'Admin') }}&background=6366f1&color=fff&bold=true" 
                             alt="Admin Avatar" 
                             class="img-circle elevation-2">
                    </div>
                    <div class="info">
                        <a href="{{ route('admin.dashboard') }}" class="d-block">{{ Auth::guard('admin')->user()->full_name ?? 'Admin' }}</a>
                        <small class="d-block text-muted">Administrator</small>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">

                        {{-- Dashboard --}}
                        @include('admin.partials.sidebar-menu-item', [
                            'route' => 'admin.dashboard',
                            'icon' => 'bx bxs-dashboard',
                            'title' => 'Dashboard'
                        ])

                        {{-- Users --}}
                        @include('admin.partials.sidebar-menu-item', [
                            'route' => 'admin.users.index',
                            'activePattern' => 'admin.users.*',
                            'icon' => 'bx bxs-user-account',
                            'title' => 'Users'
                        ])

                        {{-- Rooms --}}
                        @include('admin.partials.sidebar-menu-item', [
                            'route' => 'admin.rooms.index',
                            'activePattern' => 'admin.rooms.*',
                            'icon' => 'bx bxs-home',
                            'title' => 'Rooms'
                        ])

                        {{-- Bookings --}}
                        @include('admin.partials.sidebar-menu-item', [
                            'route' => 'admin.bookings.index',
                            'activePattern' => 'admin.bookings.*',
                            'icon' => 'bx bxs-calendar-check',
                            'title' => 'Bookings'
                        ])

                        {{-- Payments --}}
                        @include('admin.partials.sidebar-menu-item', [
                            'route' => 'admin.payments.index',
                            'activePattern' => 'admin.payments.*',
                            'icon' => 'bx bxs-wallet',
                            'title' => 'Payments'
                        ])

                        {{-- Complaints --}}
                        @include('admin.partials.sidebar-menu-item', [
                            'route' => 'admin.complaints.index',
                            'activePattern' => 'admin.complaints.*',
                            'icon' => 'bx bxs-error-circle',
                            'title' => 'Complaints'
                        ])

                        {{-- Contact Requests --}}
                        @include('admin.partials.sidebar-menu-item', [
                            'route' => 'admin.contact-messages.index',
                            'activePattern' => 'admin.contact-messages.*',
                            'icon' => 'bx bxs-message-dots',
                            'title' => 'Contact Requests'
                        ])

                        {{-- CMS Pages --}}
                        <!-- <li class="nav-item {{ request()->is('admin/faqs*') || request()->is('admin/testimonials*') || request()->is('admin/about-us*') || request()->is('admin/contact-us*') || request()->is('admin/terms-conditions*') ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ request()->is('admin/faqs*') || request()->is('admin/testimonials*') || request()->is('admin/about-us*') || request()->is('admin/contact-us*') || request()->is('admin/terms-conditions*') ? 'active' : '' }}">
                                <i class='bx bxs-file-doc nav-icon'></i>
                                <p>
                                    CMS Pages
                                    <i class='bx bx-chevron-down right'></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->is('admin/faqs*') ? 'active' : '' }}">
                                        <i class='bx bx-help-circle nav-icon'></i>
                                        <p>FAQs</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->is('admin/testimonials*') ? 'active' : '' }}">
                                        <i class='bx bxs-quote-alt-left nav-icon'></i>
                                        <p>Testimonials</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.about-us.index') }}" class="nav-link {{ request()->is('admin/about-us*') ? 'active' : '' }}">
                                        <i class='bx bx-info-circle nav-icon'></i>
                                        <p>About Us</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.contact-us.index') }}" class="nav-link {{ request()->is('admin/contact-us*') ? 'active' : '' }}">
                                        <i class='bx bx-phone nav-icon'></i>
                                        <p>Contact Us</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.terms-conditions.index') }}" class="nav-link {{ request()->is('admin/terms-conditions*') ? 'active' : '' }}">
                                        <i class='bx bx-file nav-icon'></i>
                                        <p>Terms & Conditions</p>
                                    </a>
                                </li>
                            </ul>
                        </li> -->

                        {{-- Settings --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class='bx bxs-cog nav-icon'></i>
                                <p>
                                    Settings
                                    <i class='bx bx-chevron-down right'></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.logout') }}" class="nav-link">
                                        <i class='bx bx-log-out nav-icon'></i>
                                        <p>Logout</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper bg-light p-3">

            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                <b>Version</b> 2.0.0
            </div>
            <strong>Copyright &copy; 2025 <a href="#" style="color: #6366f1;">RoomMitra</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->
    //sweetalert
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('scripts')

</body>

</html>
