@extends('layouts.admin')
@section('title', 'Contact Us')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Edit Contact Us Page',
        'icon' => 'bx bx-phone'
    ])

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5><i class='bx bx-edit'></i> Contact Information</h5>
            </div>
  
    <form class="card-body row g-4" method="POST" enctype="multipart/form-data">
      @csrf
  
      <!-- Title -->
      <div class="col-12">
        <label class="form-label"><i class='bx bx-text'></i> Page Title *</label>
        <input type="text" name="title" class="form-control" placeholder="e.g., Get in Touch" required>
      </div>
  
      <!-- Description -->
      <div class="col-12">
        <label class="form-label"><i class='bx bx-align-left'></i> Short Description *</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Short info or support note..." required></textarea>
      </div>
  
      <!-- Contact Info -->
      <div class="col-md-6">
        <label class="form-label"><i class='bx bx-map'></i> Office Address *</label>
        <input type="text" name="address" class="form-control" placeholder="123, Sunset Street, Delhi" required>
      </div>
  
      <div class="col-md-6">
        <label class="form-label"><i class='bx bx-phone'></i> Phone Number *</label>
        <input type="tel" name="phone" class="form-control" placeholder="+91 9876543210" required>
      </div>
  
      <div class="col-md-6">
        <label class="form-label"><i class='bx bx-envelope'></i> Email Address *</label>
        <input type="email" name="email" class="form-control" placeholder="support@example.com" required>
      </div>
  
      <!-- Map Embed -->
      <div class="col-12">
        <label class="form-label"><i class='bx bx-map-alt'></i> Google Map Embed Code (Optional)</label>
        <textarea name="map_embed" class="form-control" rows="3" placeholder='<iframe src="..."></iframe>'></textarea>
      </div>
  
      <!-- 🖼️ Image / Logo Upload -->
      <div class="col-md-6">
        <label class="form-label">🖼️ Upload Banner / Logo Image</label>
        <input type="file" name="contact_image" class="form-control">
        <small class="text-muted">Recommended size: 1200x400px for banners</small>
      </div>
  
      <!-- Image Preview (if editing existing one) -->
      @if(isset($contactData->contact_image))
        <div class="col-md-6">
          <label class="form-label">Current Image:</label><br>
          <img src="{{ asset('uploads/contact/' . $contactData->contact_image) }}" class="img-fluid rounded shadow-sm" style="max-height: 180px;">
        </div>
      @endif
  
      <!-- SEO Fields -->
      <hr class="mt-4">
      <h5>🔍 SEO Meta Info</h5>
  
      <div class="col-md-6">
        <label class="form-label">Meta Title</label>
        <input type="text" name="meta_title" class="form-control">
      </div>
  
      <div class="col-md-6">
        <label class="form-label">Meta Description</label>
        <input type="text" name="meta_description" class="form-control">
      </div>
  
      <div class="col-12">
        <label class="form-label">Meta Keywords</label>
        <input type="text" name="meta_keywords" class="form-control">
      </div>
  
      <!-- Submit -->
      <div class="col-12 d-flex justify-content-end mt-4">
        <button type="submit" class="btn btn-success">💾 Save Changes</button>
        <button type="reset" class="btn btn-outline-secondary ms-2">Cancel</button>
      </div>
    </form>
  </div>
  
  @endsection
  
  @push('scripts')
  
  @endpush  