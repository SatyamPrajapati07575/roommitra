{{-- Reusable Sidebar Dropdown Item Component --}}
@props([
    'route',
    'icon',
    'title'
])

<li class="nav-item">
    <a href="{{ route($route) }}" class="nav-link">
        <i class='{{ $icon }} nav-icon'></i>
        <p>{{ $title }}</p>
    </a>
</li>
