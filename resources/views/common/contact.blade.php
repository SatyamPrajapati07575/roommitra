@extends('layouts.modern')
@section('title', 'Contact Us')
@section('meta_description', 'Get in touch with RoomMitra support team. We are here to help you 24/7 with any queries or concerns.')

@section('content')
    <section class="section" style="padding-top: 2rem;">
        <div class="container-modern">
            
            <!-- Page Header -->
            <div class="text-center mb-5" data-aos="fade-up">
                <h1 class="heading-modern heading-1 gradient-text mb-3">
                    <i class='bx bx-envelope'></i> Contact Us
                </h1>
                <p class="text-muted" style="max-width: 600px; margin: 0 auto;">
                    We typically respond within 24 hours. Please feel free to reach out for any inquiries, support needs, or feedback.
                </p>
            </div>

            <div class="px-4 px-md-0">
            <div class="row g-5">

                <!-- Contact Information -->
                <div class="col-lg-5">
                    <div class="card-modern h-100" data-aos="fade-right">
                        <div style="padding: 2rem;">
                            <h3 class="heading-modern heading-3 mb-4">
                                <i class='bx bx-map'></i> Get In Touch
                            </h3>

                            <div class="ratio ratio-16x9 mb-4" style="border-radius: var(--radius-xl); overflow: hidden;">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d224345.839203315!2d77.0688998!3d28.5272803!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d1c2a5c0ef88d%3A0x3c0f6fca18a9bced!2sDelhi!5e0!3m2!1sen!2sin!4v1611111111111"
                                    style="border:0;" allowfullscreen="" loading="lazy" class="w-100"></iframe>
                            </div>

                            <ul class="list-unstyled">
                                <li class="mb-4 d-flex align-items-start">
                                    <i class='bx bx-map' style="font-size: 1.5rem; color: var(--primary-600); margin-right: 1rem;"></i>
                                    <div>
                                        <strong>Location</strong><br>
                                        <span class="text-muted">Lucknow, Uttar Pradesh, India</span>
                                    </div>
                                </li>
                                <li class="mb-4 d-flex align-items-start">
                                    <i class='bx bx-envelope' style="font-size: 1.5rem; color: var(--primary-600); margin-right: 1rem;"></i>
                                    <div>
                                        <strong>Email</strong><br>
                                        <a href="mailto:support@roommitra.com" class="text-muted">support@roommitra.com</a>
                                    </div>
                                </li>
                                <li class="mb-4 d-flex align-items-start">
                                    <i class='bx bx-phone' style="font-size: 1.5rem; color: var(--primary-600); margin-right: 1rem;"></i>
                                    <div>
                                        <strong>Phone</strong><br>
                                        <a href="tel:+919305089318" class="text-muted">+91 9305089318</a>
                                    </div>
                                </li>
                                <li class="mb-4 d-flex align-items-start">
                                    <i class='bx bx-time' style="font-size: 1.5rem; color: var(--primary-600); margin-right: 1rem;"></i>
                                    <div>
                                        <strong>Available</strong><br>
                                        <span class="text-muted">24/7 Support</span>
                                    </div>
                                </li>
                            </ul>

                            <div class="mt-4">
                                <h5 class="mb-3">Follow Us</h5>
                                <div class="d-flex gap-3">
                                    <a href="#" class="social-link"><i class='bx bxl-facebook'></i></a>
                                    <a href="#" class="social-link"><i class='bx bxl-instagram'></i></a>
                                    <a href="#" class="social-link"><i class='bx bxl-linkedin'></i></a>
                                    <a href="#" class="social-link"><i class='bx bxl-twitter'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="card-modern" data-aos="fade-left">
                        <div style="padding: 2rem;">
                            <h3 class="heading-modern heading-3 mb-4">
                                <i class='bx bx-message-dots'></i> Send Us a Message
                            </h3>
                            <form id="contactForm" class="form-modern" novalidate>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label for="name" class="form-label-modern">
                                                <i class='bx bx-user'></i> Full Name *
                                            </label>
                                            <input type="text" class="form-input-modern" id="name" name="name" placeholder="Enter your full name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label for="email" class="form-label-modern">
                                                <i class='bx bx-envelope'></i> Email Address *
                                            </label>
                                            <input type="email" class="form-input-modern" id="email" name="email" placeholder="your@email.com" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label for="phone" class="form-label-modern">
                                                <i class='bx bx-phone'></i> Phone Number *
                                            </label>
                                            <input type="tel" class="form-input-modern" id="phone" name="phone" placeholder="+91" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-modern">
                                            <label for="subject" class="form-label-modern">
                                                <i class='bx bx-category'></i> Subject *
                                            </label>
                                            <select class="form-input-modern" id="subject" name="subject" required>
                                                <option value="">Select a subject</option>
                                                <option value="general">General Inquiry</option>
                                                <option value="complaint">Complaint</option>
                                                <option value="owner">Owner Query</option>
                                                <option value="partnership">Partnership</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group-modern">
                                            <label for="message" class="form-label-modern">
                                                <i class='bx bx-message-detail'></i> Message
                                            </label>
                                            <textarea class="form-input-modern" id="message" rows="5" name="message" placeholder="Write your message here..."></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn-modern btn-primary w-100">
                                            <i class='bx bx-send'></i> Send Message
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FAQ Link -->
            <div class="row mt-5">
                <div class="col-12" data-aos="fade-up">
                    <div class="card-glass text-center" style="padding: 2rem;">
                        <p class="lead mb-3">
                            <i class='bx bx-help-circle' style="font-size: 2rem; color: var(--primary-600);"></i>
                        </p>
                        <p class="mb-0">
                            Looking for quick answers? Visit our 
                            <a href="{{ route('faqs') }}" class="gradient-text fw-bold">FAQs Page</a> 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('contactForm');
        
        // Remove previous error styling
        function clearErrors() {
            form.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            form.querySelectorAll('.invalid-feedback').forEach(el => {
                el.remove();
            });
        }
        
        // Show field errors
        function showFieldError(fieldName, message) {
            const field = form.querySelector(`[name="${fieldName}"]`);
            if (field) {
                field.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback d-block mt-1';
                errorDiv.style.color = '#dc3545';
                errorDiv.style.fontSize = '0.875rem';
                errorDiv.textContent = message;
                field.parentElement.appendChild(errorDiv);
            }
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearErrors();

            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalHTML = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Sending...';

            try {
                const response = await fetch("{{ route('contact.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    Toast.fire({
                        icon: 'success',
                        title: data.message || 'Message sent successfully!',
                        timer: 3000
                    });
                    form.reset();
                } else {
                    // Show validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(fieldName => {
                            const messages = data.errors[fieldName];
                            if (Array.isArray(messages)) {
                                showFieldError(fieldName, messages[0]);
                            }
                        });
                        Toast.fire({
                            icon: 'error',
                            title: data.message || 'Please check the form fields'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message || 'Something went wrong!'
                        });
                    }
                }
            } catch (error) {
                console.error('Contact form error:', error);
                Toast.fire({
                    icon: 'error',
                    title: 'Network error. Please try again later.'
                });
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHTML;
            }
        });
        
        // Clear error on input
        form.querySelectorAll('input, textarea, select').forEach(field => {
            field.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                const errorDiv = this.parentElement.querySelector('.invalid-feedback');
                if (errorDiv) errorDiv.remove();
            });
        });
    });
</script>
@endpush
