{{-- Reusable Page Header Component --}}
@props([
    'title',
    'icon' => 'bx bxs-dashboard'
])

<section class="content-header mb-4">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="fw-bold">
                    <i class='{{ $icon }}'></i> {{ $title }}
                </h1>
            </div>
            @if(isset($breadcrumb))
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{ $breadcrumb }}
                </ol>
            </div>
            @endif
        </div>
    </div>
</section>
