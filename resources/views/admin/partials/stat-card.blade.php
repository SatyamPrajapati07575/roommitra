{{-- Statistics Card Partial --}}
<div class="col-md-3 col-sm-6 mb-3">
    <div class="small-box bg-{{ $color }}">
        <div class="inner">
            <h3>{{ $value }}</h3>
            <p>{{ $title }}</p>
        </div>
        <div class="icon">
            <i class='{{ $icon }}'></i>
        </div>
        <a href="{{ $link }}" class="small-box-footer">
            View Details <i class='bx bx-right-arrow-alt'></i>
        </a>
    </div>
</div>
