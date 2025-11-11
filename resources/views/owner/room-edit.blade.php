@extends('layouts.owner')
@section('title', 'Edit Room')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/owner-room-form.css') }}">
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="room-form-wrapper">
            
            {{-- Form Header --}}
            <div class="room-form-header">
                <h2>
                    <i class='bx bxs-edit-alt'></i>
                    Edit Room Details
                </h2>
                <p>Update the details of your room</p>
            </div>

            {{-- Success/Error Messages --}}
            @if(session('success'))
            <div class="alert alert-success">
                <i class='bx bx-check-circle' style="font-size: 1.5rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <i class='bx bx-error-circle' style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin: 0.5rem 0 0 1.5rem;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form action="{{ route('owner.rooms.update', $room->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Section 1: Basic Information --}}
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-info-circle'></i>
                        Basic Information
                    </h3>
                    <p class="section-description">Enter the basic details of your room</p>

                    <div class="form-row cols-2">
                        <div class="form-group">
                            <label>
                                Room Title <span class="required">*</span>
                            </label>
                            <input type="text" name="room_title" class="form-control @error('room_title') is-invalid @enderror" 
                                   placeholder="e.g., Spacious 2BHK Near Railway Station" 
                                   value="{{ old('room_title', $room->room_title) }}" required>
                            <span class="form-text">
                                <i class='bx bx-info-circle'></i>
                                Give an attractive title to your room
                            </span>
                            @error('room_title')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                Room Number <span class="optional">(Optional)</span>
                            </label>
                            <input type="text" name="room_number" class="form-control" 
                                   placeholder="e.g., 101, A-12" 
                                   value="{{ old('room_number', $room->room_number) }}">
                            <span class="form-text">
                                <i class='bx bx-info-circle'></i>
                                Flat/Room number if applicable
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            Description <span class="required">*</span>
                        </label>
                        <textarea name="room_description" class="form-control @error('room_description') is-invalid @enderror" 
                                  rows="4" placeholder="Describe your room, its features, nearby facilities, etc." required>{{ old('room_description', $room->room_description) }}</textarea>
                        <span class="form-text">
                            <i class='bx bx-info-circle'></i>
                            Provide a detailed description to attract tenants
                        </span>
                        @error('room_description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Section 2: Pricing Details --}}
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-money'></i>
                        Pricing Details
                    </h3>
                    <p class="section-description">Set your monthly rent and other charges</p>

                    <div class="form-row cols-3">
                        <div class="form-group">
                            <label>
                                Monthly Rent <span class="required">*</span>
                            </label>
                            <div class="price-input-wrapper">
                                <span class="currency-symbol">₹</span>
                                <input type="number" name="room_price" class="form-control @error('room_price') is-invalid @enderror" 
                                       placeholder="5000" value="{{ old('room_price', $room->room_price) }}" required min="500" step="100">
                            </div>
                            @error('room_price')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                Security Deposit <span class="required">*</span>
                            </label>
                            <div class="price-input-wrapper">
                                <span class="currency-symbol">₹</span>
                                <input type="number" name="security_deposit" class="form-control @error('security_deposit') is-invalid @enderror" 
                                       placeholder="10000" value="{{ old('security_deposit', $room->security_deposit) }}" required min="0" step="100">
                            </div>
                            @error('security_deposit')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                Minimum Stay (Months) <span class="required">*</span>
                            </label>
                            <input type="number" name="min_stay_months" class="form-control @error('min_stay_months') is-invalid @enderror" 
                                   placeholder="3" value="{{ old('min_stay_months', $room->min_stay_months) }}" required min="1" max="24">
                            @error('min_stay_months')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 3: Room Specifications --}}
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-bed'></i>
                        Room Specifications
                    </h3>
                    <p class="section-description">Define the capacity and specifications of your room</p>

                    <div class="form-row cols-4">
                        <div class="form-group">
                            <label>
                                Total Beds <span class="required">*</span>
                            </label>
                            <input type="number" name="total_beds" class="form-control @error('total_beds') is-invalid @enderror" 
                                   placeholder="2" value="{{ old('total_beds', $room->total_beds) }}" required min="1" max="10">
                            <span class="form-text">
                                <i class='bx bx-info-circle'></i>
                                Number of beds available
                            </span>
                            @error('total_beds')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                Room Size (Sq.ft) <span class="optional">(Optional)</span>
                            </label>
                            <input type="number" name="room_size" class="form-control @error('room_size') is-invalid @enderror" 
                                   placeholder="150" value="{{ old('room_size', $room->room_size) }}" min="50" max="5000">
                            <span class="form-text">
                                <i class='bx bx-info-circle'></i>
                                Room size in square feet
                            </span>
                            @error('room_size')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                Room Capacity <span class="required">*</span>
                            </label>
                            <input type="number" name="room_capacity" class="form-control @error('room_capacity') is-invalid @enderror" 
                                   placeholder="2" value="{{ old('room_capacity', $room->room_capacity) }}" required min="1" max="10">
                            <span class="form-text">
                                <i class='bx bx-info-circle'></i>
                                Max persons allowed
                            </span>
                            @error('room_capacity')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                Floor Number <span class="optional">(Optional)</span>
                            </label>
                            <input type="number" name="floor" class="form-control" 
                                   placeholder="1" value="{{ old('floor', $room->floor) }}" min="0" max="50">
                            <span class="form-text">
                                <i class='bx bx-info-circle'></i>
                                Floor number (0 for ground)
                            </span>
                        </div>
                    </div>

                    <div class="form-row cols-2">
                        <div class="form-group">
                            <label>
                                Bathroom Type <span class="required">*</span>
                            </label>
                            <select name="bathroom_type" class="form-control @error('bathroom_type') is-invalid @enderror" required>
                                <option value="">Select Bathroom Type</option>
                                <option value="attached" {{ old('bathroom_type', $room->bathroom_type) == 'attached' ? 'selected' : '' }}>Attached Bathroom</option>
                                <option value="common" {{ old('bathroom_type', $room->bathroom_type) == 'common' ? 'selected' : '' }}>Common Bathroom</option>
                            </select>
                            @error('bathroom_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                Kitchen Availability <span class="required">*</span>
                            </label>
                            <select name="kitchen_type" class="form-control @error('kitchen_type') is-invalid @enderror" id="kitchenType" required>
                                <option value="">Select Kitchen Type</option>
                                <option value="private" {{ old('kitchen_type', $room->kitchen_type) == 'private' ? 'selected' : '' }}>Private Kitchen</option>
                                <option value="shared" {{ old('kitchen_type', $room->kitchen_type) == 'shared' ? 'selected' : '' }}>Shared Kitchen</option>
                                <option value="none" {{ old('kitchen_type', $room->kitchen_type) == 'none' ? 'selected' : '' }}>No Kitchen</option>
                            </select>
                            <input type="hidden" name="kitchen" id="kitchenField" value="{{ old('kitchen', $room->kitchen) }}">
                            @error('kitchen_type')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Section 4: Room Images --}}
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-images'></i>
                        Room Images
                    </h3>
                    <p class="section-description">Update images - Leave empty to keep existing images</p>

                    {{-- Existing Images --}}
                    @if($room->images && $room->images->count() > 0)
                    <div class="existing-images-section">
                        <h4 class="existing-images-title">Current Images</h4>
                        <div class="existing-images-grid">
                            @foreach($room->images as $image)
                            <div class="existing-image-card" id="image-{{ $image->id }}">
                                <img src="{{ asset($image->image_url) }}" alt="Room image">
                                <div class="existing-image-overlay">
                                    <span class="badge">{{ $loop->iteration }}</span>
                                </div>
                                <button type="button" class="btn-delete-image" onclick="deleteImage({{ $image->id }})" title="Delete Image">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </div>
                            @endforeach
                        </div>
                        <p class="form-text mt-2">
                            <i class='bx bx-info-circle'></i>
                            Upload new images below to replace existing ones
                        </p>
                    </div>
                    @endif

                    {{-- Modern Upload Area --}}
                    <div class="image-upload-area" id="uploadArea">
                        <div class="upload-icon">
                            <i class='bx bx-cloud-upload'></i>
                        </div>
                        <div class="upload-text">
                            <h4>Drag & Drop Images Here</h4>
                            <p>or click to browse from your device</p>
                            <span class="upload-hint">
                                <i class='bx bx-info-circle'></i>
                                JPG, PNG or JPEG • Max 2MB each • Up to 5 images
                            </span>
                        </div>
                        <input type="file" name="room_images[]" class="file-input-hidden" multiple accept="image/*" id="roomImages">
                    </div>

                    {{-- Upload Progress --}}
                    <div class="upload-progress" id="uploadProgress" style="display: none;">
                        <div class="upload-stats">
                            <span>Selected Images: <strong id="imageCount">0</strong> / 5</span>
                            <span>Total Size: <strong id="totalSize">0 KB</strong></span>
                        </div>
                    </div>

                    {{-- Image Preview Grid --}}
                    <div class="image-preview-grid" id="imagePreview"></div>
                </div>

                {{-- Section 5: Amenities --}}
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-star'></i>
                        Amenities & Facilities
                    </h3>
                    <p class="section-description">Select the amenities available in your room</p>

                    <div class="checkbox-grid">
                        @foreach($amenities as $amenity)
                        @php
                            $isSelected = in_array($amenity->amenity_name, $selectedAmenities) || old($amenity->amenity_key);
                        @endphp
                        <div class="checkbox-item">
                            <input type="checkbox" name="{{ $amenity->amenity_key }}" id="{{ $amenity->amenity_key }}" value="1" {{ $isSelected ? 'checked' : '' }}>
                            <label for="{{ $amenity->amenity_key }}">
                                <i class='bx {{ $amenity->icon_class }}'></i> {{ $amenity->amenity_name }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Section 6: Location Details --}}
                <div class="form-section">
                    <h3 class="section-title">
                        <i class='bx bx-map'></i>
                        Location Details
                    </h3>
                    <p class="section-description">Provide the complete address of your room</p>

                    <div class="form-group">
                        <label>
                            Address Line 1 <span class="required">*</span>
                        </label>
                        <input type="text" name="address_line1" class="form-control @error('address_line1') is-invalid @enderror" 
                               placeholder="House/Flat No., Street Name" 
                               value="{{ old('address_line1', $room->address_line1) }}" required>
                        @error('address_line1')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>
                            Address Line 2 <span class="optional">(Optional)</span>
                        </label>
                        <input type="text" name="address_line2" class="form-control" 
                               placeholder="Landmark, Area" 
                               value="{{ old('address_line2', $room->address_line2) }}">
                    </div>

                    <div class="form-row cols-2">
                        <div class="form-group">
                            <label>
                                State <span class="required">*</span>
                            </label>
                            <input type="text" name="state" class="form-control @error('state') is-invalid @enderror" 
                                   placeholder="e.g., Uttar Pradesh" 
                                   value="{{ old('state', $room->state) }}" required>
                            @error('state')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                City <span class="required">*</span>
                            </label>
                            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                                   placeholder="e.g., Lucknow" 
                                   value="{{ old('city', $room->city) }}" required>
                            @error('city')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row cols-2">
                        <div class="form-group">
                            <label>
                                Locality <span class="required">*</span>
                            </label>
                            <input type="text" name="locality" class="form-control @error('locality') is-invalid @enderror" 
                                   placeholder="e.g., Indira Nagar" 
                                   value="{{ old('locality', $room->locality) }}" required>
                            @error('locality')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                Pincode <span class="required">*</span>
                            </label>
                            <input type="text" name="pincode" class="form-control @error('pincode') is-invalid @enderror" 
                                   placeholder="226016" 
                                   value="{{ old('pincode', $room->pincode) }}" required pattern="[0-9]{6}" maxlength="6">
                            @error('pincode')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="form-actions">
                    <a href="{{ route('owner.rooms.index') }}" class="btn-secondary">
                        <i class='bx bx-x'></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class='bx bx-check'></i>
                        Update Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Kitchen type handler
    document.getElementById('kitchenType').addEventListener('change', function() {
        const kitchenField = document.getElementById('kitchenField');
        if (this.value === 'none') {
            kitchenField.value = '0';
        } else {
            kitchenField.value = '1';
        }
    });

    // Initialize on page load
    const kitchenType = document.getElementById('kitchenType').value;
    if (kitchenType === 'none') {
        document.getElementById('kitchenField').value = '0';
    } else if (kitchenType) {
        document.getElementById('kitchenField').value = '1';
    }

    // Checkbox visual feedback
    document.querySelectorAll('.checkbox-item input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                this.closest('.checkbox-item').classList.add('checked');
            } else {
                this.closest('.checkbox-item').classList.remove('checked');
            }
        });
        
        // Initialize on page load
        if (checkbox.checked) {
            checkbox.closest('.checkbox-item').classList.add('checked');
        }
    });

    // ===================================
    // MODERN IMAGE UPLOAD WITH DRAG & DROP
    // ===================================
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('roomImages');
    const previewGrid = document.getElementById('imagePreview');
    const uploadProgress = document.getElementById('uploadProgress');
    const imageCount = document.getElementById('imageCount');
    const totalSize = document.getElementById('totalSize');
    
    let selectedFiles = [];
    
    // Click to upload
    uploadArea.addEventListener('click', () => fileInput.click());
    
    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    // Highlight drop area
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.add('dragover');
        });
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, () => {
            uploadArea.classList.remove('dragover');
        });
    });
    
    // Handle dropped files
    uploadArea.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    });
    
    // Handle selected files
    fileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });
    
    function handleFiles(files) {
        files = Array.from(files).filter(file => file.type.startsWith('image/'));
        
        if (selectedFiles.length + files.length > 5) {
            alert('⚠️ Maximum 5 images allowed! You can only add ' + (5 - selectedFiles.length) + ' more image(s).');
            return;
        }
        
        files.forEach(file => {
            if (file.size > 2048 * 1024) {
                alert(`⚠️ ${file.name} is too large! Max size is 2MB.`);
                return;
            }
            
            selectedFiles.push(file);
            previewFile(file, selectedFiles.length - 1);
        });
        
        updateStats();
        updateFileInput();
    }
    
    function previewFile(file, index) {
        const reader = new FileReader();
        
        reader.onload = (e) => {
            const card = document.createElement('div');
            card.className = 'preview-card';
            card.dataset.index = index;
            
            card.innerHTML = `
                <img src="${e.target.result}" alt="Preview" class="preview-image">
                <div class="preview-overlay"></div>
                <div class="preview-badge">${index + 1}</div>
                <div class="preview-remove" onclick="removeImage(${index})">
                    <i class='bx bx-x'></i>
                </div>
                <div class="preview-info">
                    <p class="preview-filename">${file.name}</p>
                    <div class="preview-size">${formatFileSize(file.size)}</div>
                </div>
            `;
            
            previewGrid.appendChild(card);
        };
        
        reader.readAsDataURL(file);
    }
    
    window.removeImage = function(index) {
        selectedFiles.splice(index, 1);
        previewGrid.innerHTML = '';
        
        selectedFiles.forEach((file, idx) => {
            previewFile(file, idx);
        });
        
        updateStats();
        updateFileInput();
    }
    
    function updateStats() {
        const count = selectedFiles.length;
        const size = selectedFiles.reduce((acc, file) => acc + file.size, 0);
        
        imageCount.textContent = count;
        totalSize.textContent = formatFileSize(size);
        
        if (count > 0) {
            uploadProgress.style.display = 'block';
        } else {
            uploadProgress.style.display = 'none';
        }
    }
    
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    }

    // Delete existing image function
    function deleteImage(imageId) {
        if (!confirm('Are you sure you want to delete this image?')) {
            return;
        }

        const imageCard = document.getElementById(`image-${imageId}`);
        
        fetch(`/owner/room-images/${imageId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the image card with animation
                imageCard.style.opacity = '0';
                imageCard.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    imageCard.remove();
                    
                    // Show success message
                    const message = document.createElement('div');
                    message.className = 'alert alert-success';
                    message.innerHTML = '<i class="bx bx-check-circle"></i> Image deleted successfully!';
                    message.style.position = 'fixed';
                    message.style.top = '20px';
                    message.style.right = '20px';
                    message.style.zIndex = '9999';
                    document.body.appendChild(message);
                    
                    setTimeout(() => message.remove(), 3000);
                }, 300);
            } else {
                alert('Error: ' + (data.message || 'Failed to delete image'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete image. Please try again.');
        });
    }
</script>
@endpush
