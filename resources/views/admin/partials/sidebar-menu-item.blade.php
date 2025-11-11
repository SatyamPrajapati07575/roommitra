{{-- Sidebar Menu Item Partial --}}
<li class="nav-item">
    <a href="{{ route($route) }}" 
       class="nav-link {{ (request()->routeIs($activePattern ?? $route) || request()->is(str_replace('.', '/', $activePattern ?? $route) . '*')) ? 'active' : '' }}">
        <i class='{{ $icon }} nav-icon'></i>
        <p>{{ $title }}</p>
    </a>
</li>
