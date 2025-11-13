@extends('layouts.owner')
@section('title', 'Edit Virtual Tour')

@push('styles')
<style>
.edit-tour-container {
    padding: 1.5rem;
    max-width: 1200px;
    margin: 0 auto;
}

.page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    text-align: center;
}

.form-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
}

.form-header {
    background: #f8faff;
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.form-content {
    padding: 2rem;
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid #f3f4f6;
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.section-title {
    color: #667eea;
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
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

.form-check {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.form-check input[type="checkbox"] {
    width: 20px;
    height: 20px;
    accent-color: #667eea;
}

.highlights-container {
    margin-top: 1rem;
}

.highlight-item {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    align-items: center;
}

.highlight-input {
    flex: 1;
}

.btn-add-highlight {
    background: #10b981;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    font-size: 0.875rem;
}

.btn-remove-highlight {
    background: #ef4444;
    color: white;
    border: none;
    padding: 0.5rem;
    border-radius: 6px;
    cursor: pointer;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.current-media {
    margin-bottom: 2rem;
}

.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.media-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    background: #f3f4f6;
}

.media-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.media-video {
    width: 100%;
    height: 150px;
}

.media-description {
    padding: 0.5rem;
    font-size: 0.875rem;
    color: #6b7280;
    background: rgba(255,255,255,0.9);
}

.media-remove {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: rgba(239, 68, 68, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #e5e7eb;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.btn:hover {
    transform: translateY(-2px);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-outline {
    background: transparent;
    color: #667eea;
    border: 2px solid #667eea;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .media-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
}
</style>
@endpush

@section('content')
<div class="edit-tour-container">
    <div class="page-header">
        <h1><i class='bx bx-edit'></i> Edit Virtual Tour</h1>
        <p>Update your virtual tour details</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <div class="form-header">
            <h2><i class='bx bx-info-circle'></i> Tour Information</h2>
        </div>

        <form action="{{ route('owner.virtual-tours.update', $virtualTour) }}" method="POST" id="tourForm">
            @csrf
            @method('PATCH')
            <div class="form-content">
                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-edit'></i> Basic Information
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Room</label>
                            <input type="text" class="form-control" value="{{ $virtualTour->room->room_title }} - {{ $virtualTour->room->locality }}" readonly>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="tour_title">Tour Title *</label>
                            <input type="text" name="tour_title" id="tour_title" class="form-control" 
                                   value="{{ old('tour_title', $virtualTour->tour_title) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tour_description">Tour Description</label>
                        <textarea name="tour_description" id="tour_description" class="form-control" rows="4">{{ old('tour_description', $virtualTour->tour_description) }}</textarea>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="duration_minutes">Estimated Duration (minutes) *</label>
                            <input type="number" name="duration_minutes" id="duration_minutes" class="form-control" 
                                   value="{{ old('duration_minutes', $virtualTour->duration_minutes) }}" min="1" max="120" required>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" value="1" 
                                       {{ old('is_active', $virtualTour->is_active) ? 'checked' : '' }}>
                                <label class="form-label" for="is_active">Tour is Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Media -->
                @if(($virtualTour->tour_images && count($virtualTour->tour_images) > 0) || ($virtualTour->tour_videos && count($virtualTour->tour_videos) > 0))
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-image'></i> Current Media
                    </h3>
                    
                    @if($virtualTour->tour_images && count($virtualTour->tour_images) > 0)
                    <div class="current-media">
                        <h4>Images ({{ count($virtualTour->tour_images) }})</h4>
                        <div class="media-grid">
                            @foreach($virtualTour->tour_images as $index => $image)
                                <div class="media-item">
                                    <img src="{{ $image['url'] }}" alt="Tour Image" class="media-image">
                                    @if(isset($image['description']) && $image['description'])
                                        <div class="media-description">{{ $image['description'] }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <p style="margin-top: 1rem; color: #6b7280; font-size: 0.875rem;">
                            <i class='bx bx-info-circle'></i> To update images, please delete this tour and create a new one.
                        </p>
                    </div>
                    @endif

                    @if($virtualTour->tour_videos && count($virtualTour->tour_videos) > 0)
                    <div class="current-media">
                        <h4>Videos ({{ count($virtualTour->tour_videos) }})</h4>
                        <div class="media-grid">
                            @foreach($virtualTour->tour_videos as $index => $video)
                                <div class="media-item">
                                    <video src="{{ $video['url'] }}" class="media-video" controls></video>
                                    @if(isset($video['description']) && $video['description'])
                                        <div class="media-description">{{ $video['description'] }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <p style="margin-top: 1rem; color: #6b7280; font-size: 0.875rem;">
                            <i class='bx bx-info-circle'></i> To update videos, please delete this tour and create a new one.
                        </p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Tour Highlights -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-star'></i> Tour Highlights
                    </h3>
                    
                    <div class="highlights-container">
                        @if($virtualTour->highlights && count($virtualTour->highlights) > 0)
                            @foreach($virtualTour->highlights as $index => $highlight)
                                <div class="highlight-item">
                                    <input type="text" name="highlights[]" class="form-control highlight-input" 
                                           value="{{ old('highlights.' . $index, $highlight) }}" 
                                           placeholder="Enter tour highlight...">
                                    @if($index === 0)
                                        <button type="button" class="btn-add-highlight" onclick="addHighlight()">
                                            <i class='bx bx-plus'></i>
                                        </button>
                                    @else
                                        <button type="button" class="btn-remove-highlight" onclick="removeHighlight(this)">
                                            <i class='bx bx-minus'></i>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="highlight-item">
                                <input type="text" name="highlights[]" class="form-control highlight-input" 
                                       placeholder="e.g., Spacious living room with natural light">
                                <button type="button" class="btn-add-highlight" onclick="addHighlight()">
                                    <i class='bx bx-plus'></i>
                                </button>
                            </div>
                        @endif
                        <div id="additionalHighlights"></div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('owner.virtual-tours.show', $virtualTour) }}" class="btn btn-outline">
                    <i class='bx bx-arrow-back'></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-save'></i> Update Virtual Tour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let highlightCount = {{ $virtualTour->highlights ? count($virtualTour->highlights) : 1 }};

function addHighlight() {
    const container = document.getElementById('additionalHighlights');
    const highlightItem = document.createElement('div');
    highlightItem.className = 'highlight-item';
    highlightItem.innerHTML = `
        <input type="text" name="highlights[]" class="form-control highlight-input" 
               placeholder="Enter tour highlight...">
        <button type="button" class="btn-remove-highlight" onclick="removeHighlight(this)">
            <i class='bx bx-minus'></i>
        </button>
    `;
    container.appendChild(highlightItem);
    highlightCount++;
}

function removeHighlight(button) {
    button.parentElement.remove();
    highlightCount--;
}

// Form validation
document.getElementById('tourForm').addEventListener('submit', function(e) {
    const tourTitle = document.getElementById('tour_title').value;
    const duration = document.getElementById('duration_minutes').value;
    
    if (!tourTitle || !duration) {
        alert('Please fill in all required fields');
        e.preventDefault();
        return false;
    }
    
    return true;
});
</script>
@endpush
