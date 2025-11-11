{{-- Breadcrumb Component --}}
@props(['items' => []])

<nav aria-label="breadcrumb" style="margin-bottom: 2rem;">
    <ol class="breadcrumb-modern">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">
                <i class='bx bx-home-alt'></i>
                <span>Home</span>
            </a>
        </li>
        @foreach($items as $item)
            @if($loop->last)
                <li class="breadcrumb-item active">
                    @if(isset($item['icon']))
                        <i class='bx {{ $item['icon'] }}'></i>
                    @endif
                    <span>{{ $item['label'] }}</span>
                </li>
            @else
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] ?? '#' }}">
                        @if(isset($item['icon']))
                            <i class='bx {{ $item['icon'] }}'></i>
                        @endif
                        <span>{{ $item['label'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach
    </ol>
</nav>

<style>
.breadcrumb-modern {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    list-style: none;
    padding: 1rem 1.5rem;
    margin: 0;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-item a {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.breadcrumb-item a:hover {
    color: #667eea;
}

.breadcrumb-item.active {
    color: #1e293b;
    font-weight: 600;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 6px;
    border-right: 2px solid #cbd5e1;
    border-top: 2px solid #cbd5e1;
    transform: rotate(45deg);
    margin-right: 0.5rem;
}

.breadcrumb-item i {
    font-size: 1.125rem;
}
</style>
