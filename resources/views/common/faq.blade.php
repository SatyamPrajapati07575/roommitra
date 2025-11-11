@extends('layouts.modern')

@section('title', 'Frequently Asked Questions')
@section('meta_description', 'Find answers to common questions about RoomMitra - room booking, payments, cancellations, and more.')

@section('content')
    <section class="section" style="padding-top: 2rem;">
        <div class="container-modern">
            
            <!-- Page Header -->
            <div class="text-center mb-5" data-aos="fade-up">
                <h1 class="heading-modern heading-1 gradient-text mb-3">
                    <i class='bx bx-help-circle'></i> Frequently Asked Questions
                </h1>
                <p class="text-muted" style="max-width: 600px; margin: 0 auto;">
                    Find quick answers to common questions about our platform, booking process, and policies.
                </p>
            </div>

            <!-- FAQ Accordion -->
            <div style="max-width: 900px; margin: 0 auto;">
                <div class="accordion" id="faqAccordion" data-aos="fade-up" data-aos-delay="100">
                    @forelse ($faqs as $category => $items)
                        <div class="accordion-item card-modern mb-3" style="border: none; overflow: visible;">
                            <h2 class="accordion-header" id="heading-{{ Str::slug($category) }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse-{{ Str::slug($category) }}" aria-expanded="false"
                                    aria-controls="collapse-{{ Str::slug($category) }}"
                                    style="background: var(--gradient-primary); color: white; border-radius: var(--radius-xl); font-weight: var(--font-semibold);">
                                    <i class='bx bx-folder' style="margin-right: 0.5rem;"></i> {{ $category }}
                                </button>
                            </h2>
                            <div id="collapse-{{ Str::slug($category) }}" class="accordion-collapse collapse"
                                data-bs-parent="#faqAccordion" aria-labelledby="heading-{{ Str::slug($category) }}">
                                <div class="accordion-body" style="padding: 1.5rem;">
                                    @foreach ($items as $faq)
                                        <div class="mb-4">
                                            <h5 class="mb-2" style="color: var(--primary-600);">
                                                <i class='bx bx-question-mark' style="background: var(--primary-100); border-radius: var(--radius-full); padding: 0.25rem; font-size: 1.25rem;"></i>
                                                {{ $faq->question }}
                                            </h5>
                                            <p class="mb-0 text-muted" style="padding-left: 2.5rem;">{!! nl2br(e($faq->answer)) !!}</p>
                                        </div>
                                        @if (!$loop->last)
                                            <hr style="border-color: var(--border-light);">
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5" data-aos="fade-up">
                            <div class="card-glass" style="padding: 3rem;">
                                <i class='bx bx-info-circle' style="font-size: 4rem; color: var(--primary-400);"></i>
                                <h4 class="mt-3 mb-2">No FAQs Available</h4>
                                <p class="text-muted mb-0">We're currently updating our FAQ section. Please check back later or contact support.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="200">
                <div class="card-glass" style="padding: 3rem 2rem; max-width: 600px; margin: 0 auto;">
                    <i class='bx bx-support' style="font-size: 3rem; color: var(--primary-600);"></i>
                    <h3 class="heading-modern heading-3 mt-3 mb-2">Still have questions?</h3>
                    <p class="text-muted mb-4">Our support team is here to help you 24/7</p>
                    <a href="{{ route('contact.form') }}" class="btn-modern btn-primary">
                        <i class='bx bx-message-dots'></i> Contact Support Team
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection
