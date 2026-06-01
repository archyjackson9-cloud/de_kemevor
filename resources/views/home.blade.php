@extends('layouts.app')
@section('title', 'The Healing Room | Advanced Aesthetic Clinic – Ghana')

@section('content')

{{-- ── HERO ──────────────────────────────────────────────────────────── --}}
<section class="thr-hero">
    <div class="thr-hero__overlay"></div>
    <div class="thr-hero__content">
        <p class="thr-hero__eyebrow">Advanced Aesthetic Clinic · Accra, Ghana</p>
        <h1 class="thr-hero__headline">
            Restore and Maintain<br>
            <span class="thr-hero__headline--gold">Your Confidence</span>
        </h1>
        <p class="thr-hero__sub">
            Premium wellness and aesthetic treatments tailored for your unique journey —<br>
            from post-partum recovery to rejuvenation and beyond.
        </p>
        <div class="thr-hero__actions">
            <a href="{{ route('booking') }}" class="btn btn-gold btn-lg">
                <i class="fas fa-calendar-plus"></i> Book Your Session
            </a>
            <a href="{{ route('services') }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-spa"></i> Explore Services
            </a>
        </div>
        <div class="thr-hero__badges">
            <span><i class="fas fa-shield-alt"></i> 100% Private & Confidential</span>
            <span><i class="fas fa-award"></i> Expert-Led Treatments</span>
            <span><i class="fas fa-heart"></i> Holistic Approach</span>
        </div>
    </div>
    <div class="thr-hero__scroll">
        <span>Scroll to explore</span>
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

{{-- ── TESTIMONIALS STRIP ────────────────────────────────────────────── --}}
<section class="thr-testimonials-strip">
    <div class="thr-testimonials-strip__track" id="testimonialTrack">
        @php
        $testimonials = [
            ['text' => '"Absolutely life-changing experience. My skin has never looked better!"', 'name' => 'Abena M., Accra'],
            ['text' => '"The post-partum care I received here was beyond what I expected. I feel like myself again."', 'name' => 'Efua A., Tema'],
            ['text' => '"Professional, discreet, and incredibly effective. I highly recommend The Healing Room."', 'name' => 'Kofi B., East Legon'],
            ['text' => '"The BBL aftercare protocol here is unmatched. Best decision I ever made."', 'name' => 'Ama D., Kumasi'],
            ['text' => '"Finally a clinic that treats you with dignity and delivers real results."', 'name' => 'Akosua T., Accra'],
            ['text' => '"My acne cleared up in just 4 sessions. I cried tears of joy!"', 'name' => 'Yaa O., Takoradi'],
        ];
        @endphp

        @foreach($testimonials as $t)
        <div class="thr-testimonial-card">
            <div class="thr-testimonial-card__stars">★★★★★</div>
            <p class="thr-testimonial-card__text">{{ $t['text'] }}</p>
            <p class="thr-testimonial-card__name">— {{ $t['name'] }}</p>
        </div>
        @endforeach
        {{-- duplicate for seamless loop --}}
        @foreach($testimonials as $t)
        <div class="thr-testimonial-card">
            <div class="thr-testimonial-card__stars">★★★★★</div>
            <p class="thr-testimonial-card__text">{{ $t['text'] }}</p>
            <p class="thr-testimonial-card__name">— {{ $t['name'] }}</p>
        </div>
        @endforeach
    </div>
</section>

{{-- ── FEATURED SERVICES ─────────────────────────────────────────────── --}}
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">What We Offer</p>
            <h2 class="thr-section-header__title">Our Featured Treatments</h2>
            <p class="thr-section-header__sub">Every treatment is personalized, evidence-based, and delivered with care.</p>
        </div>
        <div class="thr-services-grid">
            @foreach($featuredServices as $service)
            <div class="thr-service-card thr-service-card--{{ $service->getCategoryColorAttribute() }}">
                <div class="thr-service-card__icon">{{ \App\Models\Service::getCategoryIcon($service->category) }}</div>
                <div class="thr-service-card__category">{{ $service->category_label }}</div>
                <h3 class="thr-service-card__name">{{ $service->name }}</h3>
                <p class="thr-service-card__desc">{{ $service->short_description }}</p>
                <div class="thr-service-card__meta">
                    <span><i class="fas fa-clock"></i> {{ $service->duration }}</span>
                    <span><i class="fas fa-tag"></i> From GHS {{ number_format($service->price_from, 0) }}</span>
                </div>
                <a href="{{ route('booking') }}?service={{ $service->slug }}" class="thr-service-card__cta">
                    Learn More <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            @endforeach
        </div>
        <div class="thr-section__action">
            <a href="{{ route('services') }}" class="btn btn-gold">
                View All {{ \App\Models\Service::where('is_active',true)->count() }} Services <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- ── WHY CHOOSE US ─────────────────────────────────────────────────── --}}
<section class="thr-section thr-section--dark">
    <div class="thr-container">
        <div class="thr-section-header thr-section-header--light">
            <p class="thr-section-header__eyebrow">Why The Healing Room</p>
            <h2 class="thr-section-header__title">Excellence in Every Session</h2>
        </div>
        <div class="thr-value-grid">
            <div class="thr-value-card">
                <div class="thr-value-card__icon"><i class="fas fa-user-md"></i></div>
                <h3>Expert Care</h3>
                <p>Our certified specialists bring years of clinical expertise and continuous training in the latest aesthetic techniques.</p>
            </div>
            <div class="thr-value-card">
                <div class="thr-value-card__icon"><i class="fas fa-lock"></i></div>
                <h3>Privacy & Dignity</h3>
                <p>Your privacy is our highest priority. All treatments are conducted in a fully confidential, judgment-free environment.</p>
            </div>
            <div class="thr-value-card">
                <div class="thr-value-card__icon"><i class="fas fa-seedling"></i></div>
                <h3>Holistic Approach</h3>
                <p>We treat the whole person — body, skin, and confidence — using methods that nurture long-term wellness, not just quick fixes.</p>
            </div>
            <div class="thr-value-card">
                <div class="thr-value-card__icon"><i class="fas fa-star"></i></div>
                <h3>Proven Results</h3>
                <p>Our clients see measurable, lasting results. We back our treatments with before-and-after tracking and follow-up support.</p>
            </div>
        </div>
    </div>
</section>

{{-- ── INSTAGRAM PLACEHOLDER ────────────────────────────────────────── --}}
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">Follow Our Journey</p>
            <h2 class="thr-section-header__title">
                <i class="fab fa-instagram" style="color:#E1306C"></i>
                @thehealing_room26
            </h2>
        </div>
        <div class="thr-instagram-grid">
            @for($i = 1; $i <= 6; $i++)
            <a href="https://instagram.com/thehealing_room26" target="_blank" class="thr-instagram-cell">
                <div class="thr-instagram-placeholder">
                    <i class="fas fa-camera"></i>
                    <span>Instagram</span>
                </div>
            </a>
            @endfor
        </div>
        <div class="thr-section__action">
            <a href="https://instagram.com/thehealing_room26" target="_blank" class="btn btn-outline-gold">
                <i class="fab fa-instagram"></i> Follow @thehealing_room26
            </a>
        </div>
    </div>
</section>

{{-- ── CTA BANNER ────────────────────────────────────────────────────── --}}
<section class="thr-cta-banner">
    <div class="thr-cta-banner__content">
        <h2 class="thr-cta-banner__title">Ready to Feel Beautiful?</h2>
        <p class="thr-cta-banner__sub">Book your session today and take the first step toward renewed confidence.</p>
        <a href="{{ route('booking') }}" class="btn btn-white btn-lg">
            <i class="fas fa-calendar-plus"></i> Book Your Session Today
        </a>
        <p class="thr-cta-banner__note">
            <i class="fas fa-phone"></i> Or call us: <a href="tel:0597173323">0597173323</a>
        </p>
    </div>
</section>

@endsection
