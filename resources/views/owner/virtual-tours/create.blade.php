@extends('layouts.owner')
@section('title', 'Create Virtual Tour')

@push('styles')
<style>
.create-tour-container {
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

.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

.file-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    background: #f9fafb;
    transition: all 0.3s;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: #667eea;
    background: #f0f9ff;
}

.file-upload-area.dragover {
    border-color: #667eea;
    background: #e0f2fe;
}

.file-upload-icon {
    font-size: 3rem;
    color: #9ca3af;
    margin-bottom: 1rem;
}

.file-upload-text {
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.file-upload-hint {
    font-size: 0.875rem;
    color: #9ca3af;
}

.file-input {
    display: none;
}

.file-preview {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.file-preview-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    background: #f3f4f6;
}

.file-preview-image {
    width: 100%;
    height: 120px;
    object-fit: cover;
}

.file-preview-video {
    width: 100%;
    height: 120px;
}

.file-preview-remove {
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

.btn-secondary {
    background: #6b7280;
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
    
    .file-preview {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    }
}
</style>
@endpush

@section('content')
<div class="create-tour-container">
    <div class="page-header">
        <h1><i class='bx bx-video-plus'></i> Create Virtual Tour</h1>
        <p>Create an immersive virtual tour for your property</p>
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

        <form action="{{ route('owner.virtual-tours.store') }}" method="POST" enctype="multipart/form-data" id="tourForm">
            @csrf
            <div class="form-content">
                <!-- Basic Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-edit'></i> Basic Information
                    </h3>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="room_id">Select Room *</label>
                            <select name="room_id" id="room_id" class="form-control form-select" required>
                                <option value="">Choose a room...</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->room_id }}" {{ old('room_id') == $room->room_id ? 'selected' : '' }}>
                                        {{ $room->room_title }} - {{ $room->locality }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="tour_title">Tour Title *</label>
                            <input type="text" name="tour_title" id="tour_title" class="form-control" 
                                   value="{{ old('tour_title') }}" placeholder="e.g., Luxury 2BHK Virtual Walkthrough" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tour_description">Tour Description</label>
                        <textarea name="tour_description" id="tour_description" class="form-control" rows="4" 
                                  placeholder="Describe what visitors will see in this virtual tour...">{{ old('tour_description') }}</textarea>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label" for="duration_minutes">Estimated Duration (minutes) *</label>
                            <input type="number" name="duration_minutes" id="duration_minutes" class="form-control" 
                                   value="{{ old('duration_minutes', 5) }}" min="1" max="120" required>
                        </div>
                    </div>
                </div>

                <!-- Tour Images -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-image'></i> Tour Images
                    </h3>
                    
                    <div class="file-upload-area" id="imageUploadArea">
                        <i class='bx bx-cloud-upload file-upload-icon'></i>
                        <div class="file-upload-text">Click to upload images or drag and drop</div>
                        <div class="file-upload-hint">PNG, JPG, JPEG up to 10MB each (Max 20 images)</div>
                        <input type="file" name="tour_images[]" id="tourImages" class="file-input" 
                               multiple accept="image/*">
                    </div>
                    
                    <div id="imagePreview" class="file-preview"></div>
                    
                    <div id="imageDescriptions" style="margin-top: 1rem;"></div>
                </div>

                <!-- Tour Videos -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-video'></i> Tour Videos (Optional)
                    </h3>
                    
                    <div class="file-upload-area" id="videoUploadArea">
                        <i class='bx bx-video-plus file-upload-icon'></i>
                        <div class="file-upload-text">Click to upload videos or drag and drop</div>
                        <div class="file-upload-hint">MP4, MOV, AVI up to 50MB each (Max 5 videos)</div>
                        <input type="file" name="tour_videos[]" id="tourVideos" class="file-input" 
                               multiple accept="video/*">
                    </div>
                    
                    <div id="videoPreview" class="file-preview"></div>
                    
                    <div id="videoDescriptions" style="margin-top: 1rem;"></div>
                </div>

                <!-- Tour Highlights -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-star'></i> Tour Highlights (Optional)
                    </h3>
                    
                    <div class="highlights-container">
                        <div class="highlight-item">
                            <input type="text" name="highlights[]" class="form-control highlight-input" 
                                   placeholder="e.g., Spacious living room with natural light" 
                                   value="{{ old('highlights.0') }}">
                            <button type="button" class="btn-add-highlight" onclick="addHighlight()">
                                <i class='bx bx-plus'></i>
                            </button>
                        </div>
                        <div id="additionalHighlights"></div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('owner.virtual-tours.index') }}" class="btn btn-outline">
                    <i class='bx bx-arrow-back'></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-save'></i> Create Virtual Tour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let imageFiles = [];
let videoFiles = [];
let highlightCount = 1;

// Image upload handling
document.getElementById('imageUploadArea').addEventListener('click', function() {
    document.getElementById('tourImages').click();
});

document.getElementById('tourImages').addEventListener('change', function(e) {
    handleImageFiles(e.target.files);
});

// Video upload handling
document.getElementById('videoUploadArea').addEventListener('click', function() {
    document.getElementById('tourVideos').click();
});

document.getElementById('tourVideos').addEventListener('change', function(e) {
    handleVideoFiles(e.target.files);
});

// Drag and drop for images
document.getElementById('imageUploadArea').addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dragover');
});

document.getElementById('imageUploadArea').addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
});

document.getElementById('imageUploadArea').addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
    handleImageFiles(e.dataTransfer.files);
});

// Drag and drop for videos
document.getElementById('videoUploadArea').addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dragover');
});

document.getElementById('videoUploadArea').addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
});

document.getElementById('videoUploadArea').addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
    handleVideoFiles(e.dataTransfer.files);
});

function handleImageFiles(files) {
    const maxFiles = 20;
    const maxSize = 10 * 1024 * 1024; // 10MB
    
    if (imageFiles.length + files.length > maxFiles) {
        alert(`Maximum ${maxFiles} images allowed`);
        return;
    }
    
    Array.from(files).forEach((file, index) => {
        if (!file.type.startsWith('image/')) {
            alert(`${file.name} is not an image file`);
            return;
        }
        
        if (file.size > maxSize) {
            alert(`${file.name} is too large. Maximum size is 10MB`);
            return;
        }
        
        imageFiles.push(file);
        displayImagePreview(file, imageFiles.length - 1);
    });
    
    updateImageInput();
}

function handleVideoFiles(files) {
    const maxFiles = 5;
    const maxSize = 50 * 1024 * 1024; // 50MB
    
    if (videoFiles.length + files.length > maxFiles) {
        alert(`Maximum ${maxFiles} videos allowed`);
        return;
    }
    
    Array.from(files).forEach((file, index) => {
        if (!file.type.startsWith('video/')) {
            alert(`${file.name} is not a video file`);
            return;
        }
        
        if (file.size > maxSize) {
            alert(`${file.name} is too large. Maximum size is 50MB`);
            return;
        }
        
        videoFiles.push(file);
        displayVideoPreview(file, videoFiles.length - 1);
    });
    
    updateVideoInput();
}

function displayImagePreview(file, index) {
    const preview = document.getElementById('imagePreview');
    const descriptions = document.getElementById('imageDescriptions');
    
    const reader = new FileReader();
    reader.onload = function(e) {
        const previewItem = document.createElement('div');
        previewItem.className = 'file-preview-item';
        previewItem.innerHTML = `
            <img src="${e.target.result}" alt="Preview" class="file-preview-image">
            <button type="button" class="file-preview-remove" onclick="removeImage(${index})">×</button>
        `;
        preview.appendChild(previewItem);
        
        const descriptionItem = document.createElement('div');
        descriptionItem.className = 'form-group';
        descriptionItem.innerHTML = `
            <label class="form-label">Description for "${file.name}"</label>
            <input type="text" name="image_descriptions[]" class="form-control" 
                   placeholder="Describe this image...">
        `;
        descriptions.appendChild(descriptionItem);
    };
    reader.readAsDataURL(file);
}

function displayVideoPreview(file, index) {
    const preview = document.getElementById('videoPreview');
    const descriptions = document.getElementById('videoDescriptions');
    
    const url = URL.createObjectURL(file);
    const previewItem = document.createElement('div');
    previewItem.className = 'file-preview-item';
    previewItem.innerHTML = `
        <video src="${url}" class="file-preview-video" controls></video>
        <button type="button" class="file-preview-remove" onclick="removeVideo(${index})">×</button>
    `;
    preview.appendChild(previewItem);
    
    const descriptionItem = document.createElement('div');
    descriptionItem.className = 'form-group';
    descriptionItem.innerHTML = `
        <label class="form-label">Description for "${file.name}"</label>
        <input type="text" name="video_descriptions[]" class="form-control" 
               placeholder="Describe this video...">
    `;
    descriptions.appendChild(descriptionItem);
}

function removeImage(index) {
    imageFiles.splice(index, 1);
    refreshImagePreviews();
    updateImageInput();
}

function removeVideo(index) {
    videoFiles.splice(index, 1);
    refreshVideoPreviews();
    updateVideoInput();
}

function refreshImagePreviews() {
    document.getElementById('imagePreview').innerHTML = '';
    document.getElementById('imageDescriptions').innerHTML = '';
    imageFiles.forEach((file, index) => {
        displayImagePreview(file, index);
    });
}

function refreshVideoPreviews() {
    document.getElementById('videoPreview').innerHTML = '';
    document.getElementById('videoDescriptions').innerHTML = '';
    videoFiles.forEach((file, index) => {
        displayVideoPreview(file, index);
    });
}

function updateImageInput() {
    const dt = new DataTransfer();
    imageFiles.forEach(file => dt.items.add(file));
    document.getElementById('tourImages').files = dt.files;
}

function updateVideoInput() {
    const dt = new DataTransfer();
    videoFiles.forEach(file => dt.items.add(file));
    document.getElementById('tourVideos').files = dt.files;
}

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
    if (imageFiles.length === 0) {
        alert('Please upload at least one image for the virtual tour');
        e.preventDefault();
        return false;
    }
    
    const roomId = document.getElementById('room_id').value;
    const tourTitle = document.getElementById('tour_title').value;
    const duration = document.getElementById('duration_minutes').value;
    
    if (!roomId || !tourTitle || !duration) {
        alert('Please fill in all required fields');
        e.preventDefault();
        return false;
    }
    
    return true;
});
</script>
@endpush
