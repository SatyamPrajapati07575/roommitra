{{-- Reusable Sidebar Menu Item Component --}}
@props([
    'route',
    'icon',
    'title',
    'routePattern' => null
])

<li class="nav-item">
    <a href="{{ route($route) }}" 
       class="nav-link {{ request()->routeIs($routePattern ?? $route) ? 'active' : '' }}">
        <i class='{{ $icon }} nav-icon'></i>
        <p>{{ $title }}</p>
    </a>
</li>
