@extends('layouts.owner')
@section('title', 'Add New Room')

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
                    <i class='bx bxs-home-heart'></i>
                    Add New Room for Rent
                </h2>
                <p>Fill in the details below to list your room on RoomMitra</p>
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

            <form action="{{ route('owner.rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

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
                                   value="{{ old('room_title') }}" required>
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
                                   value="{{ old('room_number') }}">
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
                                  rows="4" placeholder="Describe your room, its features, nearby facilities, etc." required>{{ old('room_description') }}</textarea>
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
                                       placeholder="5000" value="{{ old('room_price') }}" required min="500" step="100">
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
                                       placeholder="10000" value="{{ old('security_deposit') }}" required min="0" step="100">
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
                                   placeholder="3" value="{{ old('min_stay_months', 3) }}" required min="1" max="24">
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
                                   placeholder="2" value="{{ old('total_beds', 1) }}" required min="1" max="10">
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
                                   placeholder="150" value="{{ old('room_size') }}" min="50" max="5000">
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
                                   placeholder="2" value="{{ old('room_capacity', 1) }}" required min="1" max="10">
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
                                   placeholder="1" value="{{ old('floor') }}" min="0" max="50">
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
                                <option value="attached" {{ old('bathroom_type') == 'attached' ? 'selected' : '' }}>Attached Bathroom</option>
                                <option value="common" {{ old('bathroom_type') == 'common' ? 'selected' : '' }}>Common Bathroom</option>
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
                                <option value="private" {{ old('kitchen_type') == 'private' ? 'selected' : '' }}>Private Kitchen</option>
                                <option value="shared" {{ old('kitchen_type') == 'shared' ? 'selected' : '' }}>Shared Kitchen</option>
                                <option value="none" {{ old('kitchen_type') == 'none' ? 'selected' : '' }}>No Kitchen</option>
                            </select>
                            <input type="hidden" name="kitchen" id="kitchenField" value="{{ old('kitchen', '0') }}">
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
                    <p class="section-description">Upload clear, high-quality photos of your room (Maximum 5 images)</p>

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
                        <div class="checkbox-item">
                            <input type="checkbox" name="{{ $amenity->amenity_key }}" id="{{ $amenity->amenity_key }}" value="1" {{ old($amenity->amenity_key) ? 'checked' : '' }}>
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
                               value="{{ old('address_line1') }}" required>
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
                               value="{{ old('address_line2') }}">
                    </div>

                    <div class="form-row cols-2">
                        <div class="form-group">
                            <label>
                                State <span class="required">*</span>
                            </label>
                            <select name="state_id" id="stateSelect" class="form-control @error('state') is-invalid @enderror" required>
                                <option value="">Select State</option>
                                @foreach($states as $state)
                                <option value="{{ $state->state_id }}" {{ old('state_id') == $state->state_id ? 'selected' : '' }}>
                                    {{ $state->state_name }}
                                </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="state" id="stateName">
                            @error('state')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                City <span class="required">*</span>
                            </label>
                            <select name="city_id" id="citySelect" class="form-control @error('city') is-invalid @enderror" required disabled>
                                <option value="">Select State First</option>
                            </select>
                            <input type="hidden" name="city" id="cityName">
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
                                   value="{{ old('locality') }}" required>
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
                                   value="{{ old('pincode') }}" required pattern="[0-9]{6}" maxlength="6">
                            @error('pincode')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            Nearby Landmarks <span class="optional">(Optional)</span>
                        </label>
                        <textarea name="nearby_landmarks" class="form-control" rows="2" 
                                  placeholder="e.g., Near City Mall, 5 min from Railway Station">{{ old('nearby_landmarks') }}</textarea>
                        <span class="form-text">
                            <i class='bx bx-info-circle'></i>
                            Help tenants locate your property easily
                        </span>
                    </div>
                </div>

                {{-- Hidden Fields --}}
                <input type="hidden" name="owner_id" value="{{ Auth::user()->user_id }}">
                <input type="hidden" name="status" value="pending">

                {{-- Form Actions --}}
                <div class="form-actions">
                    <a href="{{ route('owner.rooms.index') }}" class="btn-secondary">
                        <i class='bx bx-x'></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class='bx bx-check'></i>
                        Submit Room for Approval
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

    // State and City dynamic dropdown
    const states = @json($states);
    const cities = @json($cities);
    
    document.getElementById('stateSelect').addEventListener('change', function() {
        const stateId = this.value;
        const citySelect = document.getElementById('citySelect');
        const stateName = this.options[this.selectedIndex].text;
        
        document.getElementById('stateName').value = stateName !== 'Select State' ? stateName : '';
        
        citySelect.innerHTML = '<option value="">Select City</option>';
        citySelect.disabled = true;
        document.getElementById('cityName').value = '';
        
        if (stateId) {
            const stateCities = cities.filter(city => city.state_id == stateId);
            
            if (stateCities.length > 0) {
                stateCities.forEach(city => {
                    const option = document.createElement('option');
                    option.value = city.city_id;
                    option.textContent = city.city_name;
                    citySelect.appendChild(option);
                });
                citySelect.disabled = false;
            } else {
                citySelect.innerHTML = '<option value="">No cities available</option>';
            }
        }
    });
    
    document.getElementById('citySelect').addEventListener('change', function() {
        const cityName = this.options[this.selectedIndex].text;
        document.getElementById('cityName').value = cityName !== 'Select City' && cityName !== 'No cities available' ? cityName : '';
    });
</script>
@endpush
