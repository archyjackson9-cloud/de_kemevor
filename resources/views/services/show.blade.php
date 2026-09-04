@extends('layouts.app')

@section('title', $service->seo_title)
@section('meta_description', $service->seo_description)
@section('canonical', route('services.show', $service->slug))
@section('og_type', 'website')
@section('og_title', $service->seo_title)
@section('og_description', $service->seo_description)
@if($service->image)
@section('og_image', $service->image_url)
@endif

@push('schema')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type'    => 'Service',
    'name'     => $service->name,
    'description' => $service->seo_description,
    'url'      => route('services.show', $service->slug),
    'category' => $service->category_label,
    'provider' => array_filter([
        '@type' => 'MedicalBusiness',
        'name'  => 'The Healing Room Esthetic Clinic',
        'image' => $service->image ? $service->image_url : null,
        'telephone' => '0597173323',
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Lashibi',
            'addressCountry'  => 'GH',
        ],
    ]),
    'areaServed' => 'Ghana',
    'offers' => [
        '@type' => 'Offer',
        'priceCurrency' => 'GHS',
        'price' => number_format((float) $service->price_from, 2, '.', ''),
        'url' => route('services.show', $service->slug),
    ],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')

{{-- ── HERO ──────────────────────────────────────────────────────────── --}}
<section class="thr-service-hero" @if($service->image) style="background-image:url('{{ $service->image_url }}')" @endif>
    <div class="thr-service-hero__overlay"></div>
    <div class="thr-service-hero__content">
        <div class="thr-service-hero__breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="sep">/</span>
            <a href="{{ route('services') }}">Services</a>
            <span class="sep">/</span>
            <span>{{ $service->name }}</span>
        </div>
        <div class="thr-service-hero__inner">
            <p class="thr-service-hero__eyebrow">
                {{ \App\Models\Service::getCategoryIcon($service->category) }} {{ $service->category_label }}
            </p>
            <h1 class="thr-service-hero__title">{{ $service->name }}</h1>
            <p class="thr-service-hero__sub">{{ $service->short_description }}</p>
            <div class="thr-service-hero__stats">
                <div class="thr-service-hero__stat">
                    <i class="fas fa-tag"></i>
                    <span>
                        <span class="thr-service-hero__stat-label">Starting From</span>
                        <span class="thr-service-hero__stat-value">GHS {{ number_format($service->price_from, 0) }}</span>
                    </span>
                </div>
                <div class="thr-service-hero__stat">
                    <i class="fas fa-clock"></i>
                    <span>
                        <span class="thr-service-hero__stat-label">Session Duration</span>
                        <span class="thr-service-hero__stat-value">{{ $service->duration }}</span>
                    </span>
                </div>
                <div class="thr-service-hero__stat">
                    <i class="fas fa-shield-alt"></i>
                    <span>
                        <span class="thr-service-hero__stat-label">Setting</span>
                        <span class="thr-service-hero__stat-value">Private & Confidential</span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── MAIN CONTENT ──────────────────────────────────────────────────── --}}
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-service-layout">

            {{-- Article --}}
            <div>
                <article class="thr-article">
                    <h2 class="thr-article__title">Why Choose The Healing Room for {{ $service->name }}?</h2>

                    @forelse($service->article_paragraphs as $paragraph)
                    <p>{{ $paragraph }}</p>
                    @empty
                    <p>{{ $service->short_description }}</p>
                    <p>At The Healing Room, every {{ Str::lower($service->name) }} session is delivered by trained specialists in a private, judgment-free environment — tailored to your body, your goals, and your comfort. Book a consultation today and let our team guide you toward a personalized treatment plan.</p>
                    @endforelse
                </article>

                <div class="thr-expect-grid">
                    <div class="thr-expect-item">
                        <div class="thr-expect-item__icon"><i class="fas fa-comments"></i></div>
                        <h4>Consultation</h4>
                        <p>We start by understanding your goals, health history, and any concerns before recommending a plan.</p>
                    </div>
                    <div class="thr-expect-item">
                        <div class="thr-expect-item__icon"><i class="fas fa-user-md"></i></div>
                        <h4>Expert-Led Treatment</h4>
                        <p>Your session is carried out by trained specialists using safe, evidence-informed techniques.</p>
                    </div>
                    <div class="thr-expect-item">
                        <div class="thr-expect-item__icon"><i class="fas fa-lock"></i></div>
                        <h4>Privacy & Comfort</h4>
                        <p>Every treatment room is private and discreet, so you can relax fully throughout your visit.</p>
                    </div>
                    <div class="thr-expect-item">
                        <div class="thr-expect-item__icon"><i class="fas fa-heart"></i></div>
                        <h4>Aftercare Support</h4>
                        <p>We follow up with guidance and support to help you maintain and build on your results.</p>
                    </div>
                </div>

                @if($relatedServices->isNotEmpty())
                <div style="margin-top:3.5rem">
                    <h3 style="font-family:var(--font-serif);font-size:1.5rem;margin-bottom:.5rem">
                        More {{ $service->category_label }} Treatments
                    </h3>
                    <p style="color:var(--text-light);font-size:.92rem;margin-bottom:0">Explore related treatments in the same category.</p>
                    <div class="thr-related-grid">
                        @foreach($relatedServices as $related)
                        <a href="{{ route('services.show', $related->slug) }}" class="thr-related-card">
                            <div class="thr-related-card__name">{{ $related->name }}</div>
                            <p class="thr-related-card__desc">{{ Str::limit($related->short_description, 90) }}</p>
                            <div class="thr-related-card__price">From GHS {{ number_format($related->price_from, 0) }}</div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Booking Sidebar --}}
            <aside>
                <div class="thr-booking-card">
                    <div class="thr-booking-card__category">
                        <span class="category-badge category-badge--{{ $service->category }}">
                            {{ \App\Models\Service::getCategoryIcon($service->category) }} {{ $service->category_label }}
                        </span>
                    </div>
                    <h3 style="font-family:var(--font-serif);font-size:1.3rem">{{ $service->name }}</h3>

                    <div class="thr-booking-card__price-row">
                        <span class="thr-booking-card__price-label">From</span>
                        <span class="thr-booking-card__price-value">GHS {{ number_format($service->price_from, 0) }}</span>
                    </div>

                    <div class="thr-booking-card__row">
                        <span><i class="fas fa-clock"></i> Duration</span>
                        <strong>{{ $service->duration }}</strong>
                    </div>
                    <div class="thr-booking-card__row">
                        <span><i class="fas fa-map-marker-alt"></i> Location</span>
                        <strong>Lashibi, Ghana</strong>
                    </div>

                    <a href="{{ route('booking') }}?service={{ $service->slug }}" class="btn btn-gold btn-lg">
                        <i class="fas fa-calendar-plus"></i> Book This Treatment
                    </a>

                    <div class="thr-booking-card__trust">
                        <span><i class="fas fa-check-circle"></i> 100% Private & Confidential</span>
                        <span><i class="fas fa-check-circle"></i> Expert-Led Treatment</span>
                        <span><i class="fas fa-check-circle"></i> Personalized Treatment Plan</span>
                    </div>
                </div>
            </aside>

        </div>
    </div>
</section>

{{-- ── CTA BANNER ────────────────────────────────────────────────────── --}}
<section class="thr-cta-banner">
    <div class="thr-cta-banner__content">
        <h2 class="thr-cta-banner__title">Ready to Begin Your {{ $service->name }} Journey?</h2>
        <p class="thr-cta-banner__sub">Book a consultation today and let our specialists design a treatment plan around your goals.</p>
        <a href="{{ route('booking') }}?service={{ $service->slug }}" class="btn btn-white btn-lg">
            <i class="fas fa-calendar-plus"></i> Book Now
        </a>
        <p class="thr-cta-banner__note">
            <i class="fas fa-phone"></i> Or call us: <a href="tel:0597173323">0597173323</a>
        </p>
    </div>
</section>

@endsection
