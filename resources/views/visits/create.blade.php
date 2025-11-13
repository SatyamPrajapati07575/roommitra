@extends('layouts.modern')
@section('title', 'Schedule Visit - ' . $room->room_title)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/forms.css') }}">
<style>
.visit-form-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.visit-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.visit-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    text-align: center;
}

.visit-form {
    padding: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #374151;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.visit-type-selector {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.visit-type-option {
    position: relative;
}

.visit-type-option input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.visit-type-card {
    padding: 1.5rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
}

.visit-type-option input[type="radio"]:checked + .visit-type-card {
    border-color: #667eea;
    background: #f8faff;
}

.visit-type-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    color: #667eea;
}

.datetime-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    transition: transform 0.3s;
}

.btn-submit:hover {
    transform: translateY(-2px);
}

.room-info {
    background: #f8faff;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
}

.room-info h4 {
    color: #667eea;
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .visit-type-selector {
        grid-template-columns: 1fr;
    }
    
    .datetime-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="visit-form-container">
    <div class="visit-card">
        <div class="visit-header">
            <h1><i class='bx bx-calendar-check'></i> Schedule a Visit</h1>
            <p>Book your visit to see this amazing room</p>
        </div>

        <div class="visit-form">
            <div class="room-info">
                <h4>{{ $room->room_title }}</h4>
                <p><i class='bx bx-map'></i> {{ $room->locality }}, {{ $room->city }}</p>
                <p><i class='bx bx-rupee'></i> ₹{{ number_format($room->room_price) }}/month</p>
            </div>

            <form action="{{ route('visits.store') }}" method="POST">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->room_id }}">

                <div class="form-group">
                    <label class="form-label">Visit Type</label>
                    <div class="visit-type-selector">
                        <div class="visit-type-option">
                            <input type="radio" name="visit_type" value="physical" id="physical" checked>
                            <label for="physical" class="visit-type-card">
                                <div class="visit-type-icon">
                                    <i class='bx bx-walk'></i>
                                </div>
                                <h5>Physical Visit</h5>
                                <p>Visit the room in person</p>
                            </label>
                        </div>
                        <div class="visit-type-option">
                            <input type="radio" name="visit_type" value="virtual" id="virtual">
                            <label for="virtual" class="visit-type-card">
                                <div class="visit-type-icon">
                                    <i class='bx bx-video'></i>
                                </div>
                                <h5>Virtual Tour</h5>
                                <p>Video call with owner</p>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Preferred Date & Time</label>
                    <div class="datetime-grid">
                        <input type="date" name="preferred_date" class="form-control" 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        <input type="time" name="preferred_time" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Alternative Date & Time (Optional)</label>
                    <div class="datetime-grid">
                        <input type="date" name="alternative_date" class="form-control" 
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        <input type="time" name="alternative_time" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Your Name</label>
                    <input type="text" name="visitor_name" class="form-control" 
                           value="{{ auth()->user()->name ?? '' }}" required>
                </div>

                <div class="datetime-grid">
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="visitor_phone" class="form-control" 
                               value="{{ auth()->user()->phone ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="visitor_email" class="form-control" 
                               value="{{ auth()->user()->email ?? '' }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Special Requirements (Optional)</label>
                    <textarea name="special_requirements" class="form-control" rows="3" 
                              placeholder="Any specific questions or requirements..."></textarea>
                </div>

                <button type="submit" class="btn-submit">
                    <i class='bx bx-calendar-plus'></i> Schedule Visit
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill alternative date/time based on preferred
    const preferredDate = document.querySelector('input[name="preferred_date"]');
    const preferredTime = document.querySelector('input[name="preferred_time"]');
    const altDate = document.querySelector('input[name="alternative_date"]');
    const altTime = document.querySelector('input[name="alternative_time"]');

    function suggestAlternative() {
        if (preferredDate.value && preferredTime.value) {
            const date = new Date(preferredDate.value + 'T' + preferredTime.value);
            date.setDate(date.getDate() + 1); // Next day
            
            altDate.value = date.toISOString().split('T')[0];
            altTime.value = preferredTime.value;
        }
    }

    preferredDate.addEventListener('change', suggestAlternative);
    preferredTime.addEventListener('change', suggestAlternative);
});
</script>
@endpush
