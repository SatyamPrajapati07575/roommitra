{{-- Reusable Sidebar Dropdown Menu Component --}}
@props([
    'icon',
    'title'
])

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class='{{ $icon }} nav-icon'></i>
        <p>
            {{ $title }}
            <i class='bx bx-chevron-down right'></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        {{ $slot }}
    </ul>
</li>
