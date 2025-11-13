<!-- Modern Navbar Component -->
<nav class="navbar-modern" id="mainNavbar">
    <div class="container-modern">
        <div class="navbar-container">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="navbar-brand">
                <img src="{{ asset('logo/RoomLogo.png') }}" alt="RoomMitra Logo">
            </a>

            <!-- Mobile Menu Toggle -->
            <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle navigation" type="button">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>

            <!-- Navigation Links -->
            <div class="navbar-menu" id="navbarMenu">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                            <i class='bx bx-home-alt'></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rooms') }}" class="nav-link {{ request()->routeIs('rooms') ? 'active' : '' }}">
                            <i class='bx bx-building-house'></i>Rooms
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                            <i class='bx bx-info-circle'></i>About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('wishlist.index') }}" class="nav-link {{ request()->routeIs('wishlist.index') ? 'active' : '' }}">
                            <i class='bx bx-heart'></i>Wishlist
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.compare.index') }}" class="nav-link {{ request()->routeIs('user.compare.index') ? 'active' : '' }}">
                            <i class='bx bx-git-compare'></i>Compare
                        </a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a href="{{ route('visits.index') }}" class="nav-link {{ request()->routeIs('visits.*') ? 'active' : '' }}">
                            <i class='bx bx-calendar-check'></i>My Visits
                        </a>
                    </li>
                    @endauth
                    <li class="nav-item">
                        <a href="{{ route('contact.form') }}" class="nav-link {{ request()->routeIs('contact.form') ? 'active' : '' }}">
                            <i class='bx bx-envelope'></i>Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('faqs') }}" class="nav-link {{ request()->routeIs('faqs') ? 'active' : '' }}">
                            <i class='bx bx-help-circle'></i>FAQ
                        </a>
                    </li>
                </ul>

                <!-- Auth Buttons -->
                <div class="navbar-actions">
                    @auth
                        <div class="user-menu">
                            <button class="user-menu-toggle" id="userMenuToggle" type="button">
                                <div class="user-avatar">
                                    <i class='bx bx-user'></i>
                                </div>
                                <span class="user-name">{{ Auth::user()->full_name }}</span>
                                <i class='bx bx-chevron-down'></i>
                            </button>
                            <div class="user-dropdown" id="userDropdown">
                                <a href="{{ route('user.profile.index') }}" class="dropdown-item">
                                    <i class='bx bx-user-circle'></i>Profile
                                </a>
                                <a href="{{ route('user.bookings.index') }}" class="dropdown-item">
                                    <i class='bx bx-calendar-check'></i>My Bookings
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="dropdown-item">
                                    <i class='bx bx-heart'></i>Wishlist
                                </a>
                                <a href="{{ route('user.compare.index') }}" class="dropdown-item">
                                    <i class='bx bx-git-compare'></i>Compare Rooms
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('logout') }}" class="dropdown-item text-danger">
                                    <i class='bx bx-log-out'></i>Logout
                                </a>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login.form') }}" class="btn-outline btn-sm">
                            <i class='bx bx-log-in'></i>Login
                        </a>
                        <a href="{{ route('register.form') }}" class="btn-primary btn-sm">
                            <i class='bx bx-user-plus'></i>Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbarToggle = document.getElementById('navbarToggle');
    const navbarMenu = document.getElementById('navbarMenu');
    
    if (navbarToggle) {
        navbarToggle.addEventListener('click', function() {
            navbarMenu.classList.toggle('active');
        });
    }

    const userMenuToggle = document.getElementById('userMenuToggle');
    const userMenu = userMenuToggle?.closest('.user-menu');
    
    if (userMenuToggle && userMenu) {
        userMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenu.classList.toggle('active');
        });

        document.addEventListener('click', function(e) {
            if (!userMenu.contains(e.target)) {
                userMenu.classList.remove('active');
            }
        });
    }

    const navbar = document.getElementById('mainNavbar');
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
});
</script>
