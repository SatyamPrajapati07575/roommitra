@extends('layouts.modern')
@section('title', 'Compare Rooms')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<link rel="stylesheet" href="{{ asset('css/compare.css') }}?v=1.0.0">
@endpush

@section('content')

{{-- Breadcrumb --}}
<div class="container-modern" style="padding-top: 2rem;">
    <x-breadcrumb :items="[
        ['label' => 'Compare Rooms', 'icon' => 'bx-git-compare']
    ]" />
</div>

{{-- Hero Section --}}
<div class="compare-hero">
    <div class="container-modern">
        <div class="compare-hero-content" data-aos="fade-up">
            <h1>
                <i class='bx bx-git-compare'></i>
                <span>Compare Rooms</span>
            </h1>
            <p>Side-by-side comparison to find your best match</p>
        </div>
    </div>
</div>

<div class="container-modern">

    {{-- Toolbar --}}
    @if(count($compares) > 0)
    <div class="compare-toolbar" data-aos="fade-up">
        <div class="compare-count">
            <div class="compare-count-badge">{{ count($compares) }}</div>
            <div class="compare-count-text">
                Comparing {{ count($compares) }} room{{ count($compares) > 1 ? 's' : '' }}
            </div>
        </div>
        <form action="{{ route('user.compare.clear') }}" method="POST">
            @csrf
            <button type="submit" class="btn-cta-secondary">
                <i class='bx bx-trash'></i> Clear All
            </button>
        </form>
    </div>
    @endif

    {{-- Empty State --}}
    @if(count($compares) === 0)
    <div class="empty-compare" data-aos="fade-up">
        <div class="empty-compare-icon">
            <i class='bx bx-git-compare'></i>
        </div>
        <h2>No Rooms to Compare</h2>
        <p>Start adding rooms to compare their features side-by-side!</p>
        <a href="{{ route('rooms') }}" class="btn-cta-primary">
            <i class='bx bx-search'></i> Browse Rooms
        </a>
    </div>
    @endif

    {{-- Comparison Table --}}
    @if(count($compares) > 0)
    <div class="compare-table-wrapper" data-aos="fade-up">
        <table class="compare-table">
            <thead>
                <tr>
                    <th class="feature-header">Feature</th>
                    @foreach($compares as $compare)
                    <th class="room-header" style="min-width: 280px;">
                        <div class="room-header-cell">
                            @if($compare->room->images && $compare->room->images->first())
                                <img src="{{ asset($compare->room->images->first()->image_url) }}" 
                                     alt="{{ $compare->room->room_title }}" 
                                     class="room-header-img">
                            @else
                                <div class="compare-no-image">
                                    <i class='bx bx-image'></i>
                                    <span>No Image</span>
                                </div>
                            @endif
                            <div class="room-header-title">{{ $compare->room->room_title }}</div>
                            <div class="room-header-price">₹{{ number_format($compare->room->room_price) }}/mo</div>
                            <button class="remove-compare-btn" onclick="toggleCompare({{ $compare->room->room_id }}, this)">
                                <i class='bx bx-x'></i> Remove
                            </button>
                        </div>
                    </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Location</th>
                    @foreach($compares as $compare)
                    <td>{{ ucwords($compare->room->locality) }}, {{ ucwords($compare->room->city) }}</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Price</th>
                    @foreach($compares as $compare)
                    <td class="compare-value-good">₹{{ number_format($compare->room->room_price) }}/month</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Security Deposit</th>
                    @foreach($compares as $compare)
                    <td>₹{{ number_format($compare->room->security_deposit) }}</td>
                    @endforeach
                </tr>
                <tr>
                    <th>Sharing</th>
                    @foreach($compares as $compare)
                    <td>
                        <span class="compare-value-badge">
                            {{ $compare->room->room_capacity === 1 ? 'Single' : $compare->room->room_capacity . ' Sharing' }}
                        </span>
                    </td>
                    @endforeach
                </tr>
                @if($compares->first()->room->room_size)
                <tr>
                    <th>Room Size</th>
                    @foreach($compares as $compare)
                    <td>{{ $compare->room->room_size ?? 'N/A' }} sq.ft</td>
                    @endforeach
                </tr>
                @endif
                <tr>
                    <th>Total Beds</th>
                    @foreach($compares as $compare)
                    <td>{{ $compare->room->total_beds }}</td>
                    @endforeach
                </tr>
                @if($compares->first()->room->floor)
                <tr>
                    <th>Floor</th>
                    @foreach($compares as $compare)
                    <td>{{ $compare->room->floor ?? 'N/A' }}</td>
                    @endforeach
                </tr>
                @endif
                <tr>
                    <th>Kitchen</th>
                    @foreach($compares as $compare)
                    <td>
                        <span class="compare-value-badge">{{ ucfirst($compare->room->kitchen_type) }}</span>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Bathroom</th>
                    @foreach($compares as $compare)
                    <td>
                        <span class="compare-value-badge">{{ ucfirst($compare->room->bathroom_type) }}</span>
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <th>AC</th>
                    @foreach($compares as $compare)
                    <td>
                        @if($compare->room->ac)
                            <span class="feature-yes"><i class='bx bx-check-circle'></i> Yes</span>
                        @else
                            <span class="feature-no"><i class='bx bx-x-circle'></i> No</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Lift</th>
                    @foreach($compares as $compare)
                    <td>
                        @if($compare->room->lift)
                            <span class="feature-yes"><i class='bx bx-check-circle'></i> Yes</span>
                        @else
                            <span class="feature-no"><i class='bx bx-x-circle'></i> No</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Parking</th>
                    @foreach($compares as $compare)
                    <td>
                        @if($compare->room->parking)
                            <span class="feature-yes"><i class='bx bx-check-circle'></i> Yes</span>
                        @else
                            <span class="feature-no"><i class='bx bx-x-circle'></i> No</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Amenities</th>
                    @foreach($compares as $compare)
                    <td>
                        @foreach($compare->room->amenities as $amenity)
                        <span class="compare-value-badge">{{ $amenity->amenity_name }}</span>
                        @endforeach
                    </td>
                    @endforeach
                </tr>
                <tr>
                    <th>Min Stay</th>
                    @foreach($compares as $compare)
                    <td>{{ $compare->room->min_stay_months }} months</td>
                    @endforeach
                </tr>
                <tr>
                    <th>View Details</th>
                    @foreach($compares as $compare)
                    <td>
                        <a href="{{ route('room.show', $compare->room->slug) }}" class="btn-cta-primary" style="width: 100%; text-align: center;">
                            View Room
                        </a>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    @endif

</div>

@endsection

@push('scripts')
<script>
// Toggle compare function
function toggleCompare(roomId, button) {
    fetch(`/user/compare/toggle/${roomId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Toast.fire({
                icon: 'info',
                title: data.message
            });
            
            // Reload page after removal
            if (data.status === 'removed') {
                setTimeout(() => {
                    location.reload();
                }, 500);
            }
        } else {
            Toast.fire({
                icon: 'error',
                title: data.message
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Toast.fire({
            icon: 'error',
            title: 'Something went wrong!'
        });
    });
}
</script>
@endpush
