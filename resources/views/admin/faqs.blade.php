@extends('layouts.admin')
@section('title', 'Manage FAQs')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Manage FAQs',
        'icon' => 'bx bx-help-circle'
    ])

    <div class="container-fluid">
        {{-- Add FAQ Button --}}
        <div class="mb-3">
            <button class="btn btn-primary" data-toggle="modal" data-target="#addFaqModal">
                <i class='bx bx-plus'></i> Add New FAQ
            </button>
        </div>

        {{-- Filters --}}
        <div class="card p-3 mb-4">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search by question">
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option value="">All Categories</option>
                        <option>Booking</option>
                        <option>Payment</option>
                        <option>General</option>
                        <option>Technical</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control">
                        <option value="">All Status</option>
                        <option>Active</option>
                        <option>Inactive</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary w-100"><i class='bx bx-search'></i></button>
                </div>
            </div>
        </div>

        {{-- FAQs Table --}}
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle text-center table-bordered">
                    <thead class="thead-light">
                        <tr class="bg-light text-dark">
                            <th>ID</th>
                            <th>Question</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($faqs ?? [] as $faq)
                            <tr>
                                <td>#{{ $faq->id }}</td>
                                <td class="text-left">{{ Str::limit($faq->question, 50) }}</td>
                                <td>
                                    <span class="badge bg-info">{{ ucfirst($faq->category ?? '-') }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $faq->is_active ? 'success' : 'secondary' }}">
                                        <i class='bx {{ $faq->is_active ? "bx-check" : "bx-x" }}'></i>
                                        {{ $faq->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $faq->created_at->format('d M, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-info view-faq-btn"
                                            data-id="{{ $faq->id }}" title="View">
                                        <i class='bx bx-show'></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary edit-faq-btn"
                                            data-id="{{ $faq->id }}" title="Edit">
                                        <i class='bx bx-edit'></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger delete-faq-btn" 
                                            data-id="{{ $faq->id }}" title="Delete">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class='bx bx-help-circle' style="font-size: 3rem;"></i>
                                    <p class="mt-2">No FAQs found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if(isset($faqs) && $faqs->hasPages())
                <div class="p-3">
                    {{ $faqs->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add FAQ Modal -->
    <div class="modal fade" id="addFaqModal" tabindex="-1" aria-labelledby="addFaqLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" id="addFaqForm" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addFaqLabel"><i class='bx bx-plus'></i> Add New FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Question</label>
                        <input type="text" class="form-control" name="question" required>
                    </div>

                    <div class="mb-3">
                        <label>Answer</label>
                        <textarea class="form-control" name="answer" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Category</label>
                        <select class="form-control" name="category">
                            <option value="booking">Booking</option>
                            <option value="payment">Payment</option>
                            <option value="general">General</option>
                            <option value="technical">Technical</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select class="form-control" name="is_active">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>


    </div>


    <!-- Edit FAQ Modal -->
    <div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" id="editFaqForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editFaqLabel">✏️ Edit FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">

                    <div class="mb-3">
                        <label>Question</label>
                        <input type="text" class="form-control" name="question" id="edit-question" required>
                    </div>

                    <div class="mb-3">
                        <label>Answer</label>
                        <textarea class="form-control" name="answer" rows="4" id="edit-answer"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Category</label>
                            <select class="form-control" name="category" id="edit-category">
                                <option value="">Select Category</option>
                                <option value="General Questions">General Questions</option>
                                <option value="For Students (Users)">For Students (Users)</option>
                                <option value="For Room Owners">For Room Owners</option>
                                <option value="Security & Verification">Security & Verification</option>
                                <option value="Technical Questions">Technical Questions</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Status</label>
                            <select class="form-control" name="is_active" id="edit-status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">💾 Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>


    <!-- View FAQ Modal -->
    <div class="modal fade" id="viewFaqModal" tabindex="-1" aria-labelledby="viewFaqLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewFaqLabel">📖 FAQ Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <!-- FAQ Question -->
                    <h5 id="view-question" class="mb-3 fw-bold">Loading...</h5>

                    <!-- FAQ Answer -->
                    <div class="mb-2">
                        <strong>Answer:</strong>
                        <p id="view-answer">Loading...</p>
                    </div>

                    <!-- FAQ Category -->
                    <div class="mb-2">
                        <strong>Category:</strong>
                        <span id="view-category">Loading...</span>
                    </div>

                    <!-- FAQ Status -->
                    <div class="mb-2">
                        <strong>Status:</strong>
                        <span id="view-status">Loading...</span>
                    </div>


                    <!-- FAQ Created At -->
                    <div class="mb-2">
                        <strong>Created At:</strong>
                        <span id="view-date">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Toast setup
     

        // Utility function to fetch JSON with CSRF
        async function fetchWithCSRF(url, method = 'GET', body = null) {
            const headers = {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            };

            const response = await fetch(url, {
                method,
                headers,
                body
            });

            if (!response.ok) throw await response.json();
            return await response.json();
        }

        // Toggle FAQ status
        function initFaqToggle() {
            document.querySelectorAll('.faq-toggle').forEach(toggle => {
                toggle.addEventListener('click', async function() {
                    const faqId = this.dataset.id;
                    try {
                        const data = await fetchWithCSRF(`/admin/faqs/${faqId}/toggle-status`, 'PATCH');
                        Toast.fire({
                            icon: 'success',
                            title: data.success ? '✅ FAQ activated' : '❌ FAQ deactivated'
                        });
                    } catch (err) {
                        console.error(err);
                        Toast.fire({
                            icon: 'error',
                            title: 'An error occurred. Please try again.'
                        });
                    }
                });
            });
        }

        // Add FAQ
        function initAddFaqForm() {
            const form = document.getElementById('addFaqForm');
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.disabled = true;
                submitBtn.innerText = 'Submitting...';

                try {
                    const response = await fetch('/admin/faqs', {
                        method: 'POST',
                        body: new FormData(form)
                    });
                    const data = await response.json();

                    Toast.fire({
                        icon: data.success ? 'success' : 'error',
                        title: data.message || 'Submission failed.'
                    });

                    if (data.success) {
                        form.reset();
                        $('#addFaqModal').modal('hide');
                    }
                } catch (error) {
                    console.error(error);
                    Toast.fire({
                        icon: 'error',
                        title: 'An error occurred. Please try again.'
                    });
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Submit';
                }
            });
        }

        // View FAQ
        function initViewFaqButtons() {
            document.querySelectorAll('.view-faq-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    try {
                        const url = this.dataset.url;
                        const faq = await (await fetch(url)).json();

                        document.getElementById('view-question').textContent = faq.question;
                        document.getElementById('view-answer').innerHTML = faq.answer;
                        document.getElementById('view-category').innerText = faq.category || '—';
                        document.getElementById('view-status').innerText = faq.is_active ? 'Active' :
                            'Inactive';
                        document.getElementById('view-date').innerText = new Date(faq.created_at)
                            .toLocaleString();

                        new bootstrap.Modal(document.getElementById('viewFaqModal')).show();
                    } catch (error) {
                        Toast.fire({
                            icon: 'error',
                            title: 'An error occurred. Please try again.'
                        });
                    }
                });
            });
        }

        // Edit FAQ
        function initEditFaqButtons() {
            document.querySelectorAll('.edit-faq-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const faqId = this.dataset.id;
                    const showUrl = `{{ route('admin.faqs.show', ':id') }}`.replace(':id', faqId);
                    const updateUrl = this.dataset.url;

                    try {
                        const faq = await (await fetch(showUrl)).json();

                        document.getElementById('edit-id').value = faq.id;
                        document.getElementById('edit-question').value = faq.question;
                        document.getElementById('edit-answer').value = faq.answer;
                        document.getElementById('edit-category').value = faq.category;
                        document.getElementById('edit-status').value = faq.is_active;
                        document.getElementById('editFaqForm').action = updateUrl;

                        new bootstrap.Modal(document.getElementById('editFaqModal')).show();
                    } catch (err) {
                        Toast.fire({
                            icon: 'error',
                            title: 'An error occurred. Please try again.'
                        });
                    }
                });
            });
        }

        function initEditFaqForm() {
            document.getElementById('editFaqForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);

                try {
                    await fetchWithCSRF(form.action, 'POST', formData);
                    Toast.fire({
                        icon: 'success',
                        title: '✅ FAQ updated!'
                    })
                } catch (error) {
                    Toast.fire({
                        icon: 'error',
                        title: 'An error occurred. Please try again.'
                    });
                }
            });
        }

        // Delete FAQ
        function initDeleteFaqButtons() {
            document.querySelectorAll('.delete-faq-btn').forEach(button => {
                button.addEventListener('click', async function() {
                    const faqId = this.dataset.id;
                    if (!confirm('Are you sure you want to delete this FAQ?')) return;

                    try {
                        await fetchWithCSRF(`/admin/faqs/${faqId}`, 'DELETE');
                        Toast.fire({
                            icon: 'success',
                            title: 'FAQ deleted!'
                        })

                    } catch (error) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Something went wrong. Please try again.'
                        });
                    }
                });
            });
        }

        // Init all
        initFaqToggle();
        initAddFaqForm();
        initViewFaqButtons();
        initEditFaqButtons();
        initEditFaqForm();
        initDeleteFaqButtons();

        // Automatically submit filter on change or typing
        document.getElementById('filter-search').addEventListener('input', debounce(() => {
            submitFilters();
        }, 500));

        document.getElementById('filter-category').addEventListener('change', submitFilters);
        document.getElementById('filter-status').addEventListener('change', submitFilters);

        function submitFilters() {
            const search = document.getElementById('filter-search').value;
            const category = document.getElementById('filter-category').value;
            const status = document.getElementById('filter-status').value;

            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (category) params.append('category', category);
            if (status) params.append('status', status);

            window.location.href = `?${params.toString()}`;
        }

        // Debounce function to avoid rapid firing
        function debounce(func, delay) {
            let timeout;
            return function() {
                clearTimeout(timeout);
                timeout = setTimeout(func, delay);
            };
        }
    </script>
@endpush
