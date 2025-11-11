@extends('layouts.admin')
@section('title', 'About Us')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Edit About Us Page',
        'icon' => 'bx bx-info-circle'
    ])

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5><i class='bx bx-edit'></i> Page Content</h5>
            </div>

        <form class="card-body row g-4" method="POST" enctype="multipart/form-data">
            <!-- 1. Title -->
            <div class="col-12">
                <label class="form-label"><i class='bx bx-text'></i> Page Title *</label>
                <input type="text" name="title" class="form-control" placeholder="e.g. About Sunset Villas" required>
            </div>

            <!-- 2. Short Description -->
            <div class="col-12">
                <label class="form-label"><i class='bx bx-align-left'></i> Short Description *</label>
                <textarea name="short_description" class="form-control" rows="3" placeholder="A short intro about the company..."
                    required></textarea>
            </div>

            <!-- 3. Full Description -->
            <div class="col-12">
                <label class="form-label"><i class='bx bx-book'></i> Full Description *</label>
                <textarea id="editor" name="full_description" required></textarea>
            </div>

            <!-- 4. Image Upload -->
            <div class="col-md-6">
                <label class="form-label"><i class='bx bx-image'></i> Upload Banner / Team Image</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Recommended: 1200x400px</small>
            </div>

            <!-- 5. Mission -->
            <div class="col-md-6">
                <label class="form-label"><i class='bx bx-target-lock'></i> Mission (Optional)</label>
                <input type="text" name="mission" class="form-control" placeholder="Our mission is to...">
            </div>

            <div class="col-md-6">
                <label class="form-label"><i class='bx bx-star'></i> Vision (Optional)</label>
                <input type="text" name="vision" class="form-control" placeholder="We envision a world where...">
            </div>

            <!-- 6. SEO Meta Info -->
            <hr>
            <h5 class="mt-3">🔍 SEO Meta Information</h5>

            <div class="col-md-6">
                <label class="form-label">Meta Title</label>
                <input type="text" name="meta_title" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label">Meta Description</label>
                <input type="text" name="meta_description" class="form-control">
            </div>

            <div class="col-12">
                <label class="form-label">Meta Keywords (comma separated)</label>
                <input type="text" name="meta_keywords" class="form-control">
            </div>

            <!-- Save Buttons -->
            <div class="col-12 d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-success">💾 Save Changes</button>
                <button type="reset" class="btn btn-outline-secondary ms-2">Cancel</button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
