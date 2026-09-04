@extends('layouts.app')
@section('title', 'The Healing Room | Advanced Aesthetic Clinic – Ghana')

@section('content')

{{-- ── HERO ──────────────────────────────────────────────────────────── --}}
@php
$heroSlideList = $heroSlides->count() ? $heroSlides : collect([
    (object) [
        'image_url'  => 'https://images.unsplash.com/photo-1600334129128-685c5582fd35?w=1600',
        'video_url'  => null,
        'has_video'  => false,
        'eyebrow'    => 'Advanced Aesthetic Clinic · Accra, Ghana',
        'title'      => 'Restore and Maintain',
        'title_gold' => 'Your Confidence',
        'subtitle'   => 'Premium wellness and aesthetic treatments tailored for your unique journey — from post-partum recovery to rejuvenation and beyond.',
    ],
]);
@endphp
<section class="thr-hero" id="heroSlider">
    @foreach($heroSlideList as $i => $slide)
    <div class="thr-hero__slide {{ $i === 0 ? 'is-active' : '' }}"
         style="background-image: linear-gradient(160deg, rgba(26,18,8,.85) 0%, rgba(44,28,10,.7) 50%, rgba(200,151,43,.2) 100%), url('{{ $slide->image_url }}')">
        @if(!empty($slide->has_video) && $slide->video_url)
        <video class="thr-hero__slide-video" autoplay muted loop playsinline poster="{{ $slide->image_url }}">
            <source src="{{ $slide->video_url }}" type="video/mp4">
        </video>
        <div class="thr-hero__slide-video-tint"></div>
        @endif
        <div class="thr-hero__content">
            @if($slide->eyebrow)
            <p class="thr-hero__eyebrow">{{ $slide->eyebrow }}</p>
            @endif
            @if($slide->title || $slide->title_gold)
            <h1 class="thr-hero__headline">
                {{ $slide->title }}
                @if($slide->title_gold)
                <span class="thr-hero__headline--gold">{{ $slide->title_gold }}</span>
                @endif
            </h1>
            @endif
            @if($slide->subtitle)
            <p class="thr-hero__sub">{{ $slide->subtitle }}</p>
            @endif
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
    </div>
    @endforeach

    <div class="thr-hero__overlay"></div>

    @if($heroSlideList->count() > 1)
    <button type="button" class="thr-hero__arrow thr-hero__arrow--prev" data-hero-prev aria-label="Previous slide">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button type="button" class="thr-hero__arrow thr-hero__arrow--next" data-hero-next aria-label="Next slide">
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="thr-hero__dots">
        @foreach($heroSlideList as $i => $slide)
        <button type="button" class="thr-hero__dot {{ $i === 0 ? 'is-active' : '' }}" data-hero-dot="{{ $i }}" aria-label="Go to slide {{ $i + 1 }}"></button>
        @endforeach
    </div>
    @endif

    <div class="thr-hero__scroll">
        <span>Scroll to explore</span>
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

{{-- ── TESTIMONIALS STRIP ────────────────────────────────────────────── --}}
@php
$testimonialList = $testimonials->count() ? $testimonials : collect([
    (object) ['quote' => 'Absolutely life-changing experience. My skin has never looked better!', 'name' => 'Abena M., Accra'],
    (object) ['quote' => 'The post-partum care I received here was beyond what I expected. I feel like myself again.', 'name' => 'Efua A., Tema'],
    (object) ['quote' => 'Professional, discreet, and incredibly effective. I highly recommend The Healing Room.', 'name' => 'Kofi B., East Legon'],
]);
@endphp
@if($testimonialList->isNotEmpty())
<section class="thr-testimonials-strip">
    <div class="thr-testimonials-strip__track" id="testimonialTrack">
        @foreach($testimonialList as $t)
        <div class="thr-testimonial-card">
            <div class="thr-testimonial-card__stars">★★★★★</div>
            <p class="thr-testimonial-card__text">&ldquo;{{ $t->quote }}&rdquo;</p>
            <div class="thr-testimonial-card__footer">
                <span class="thr-testimonial-card__avatar">{{ Str::of($t->name)->substr(0,1) }}</span>
                <p class="thr-testimonial-card__name">{{ $t->name }}</p>
            </div>
        </div>
        @endforeach
        {{-- duplicate for seamless loop --}}
        @foreach($testimonialList as $t)
        <div class="thr-testimonial-card">
            <div class="thr-testimonial-card__stars">★★★★★</div>
            <p class="thr-testimonial-card__text">&ldquo;{{ $t->quote }}&rdquo;</p>
            <div class="thr-testimonial-card__footer">
                <span class="thr-testimonial-card__avatar">{{ Str::of($t->name)->substr(0,1) }}</span>
                <p class="thr-testimonial-card__name">{{ $t->name }}</p>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

{{-- ── FEATURED SERVICES ─────────────────────────────────────────────── --}}
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">{{ $s->get('home_services_eyebrow', 'What We Offer') }}</p>
            <h2 class="thr-section-header__title">{{ $s->get('home_services_title', 'Our Featured Treatments') }}</h2>
            <p class="thr-section-header__sub">{{ $s->get('home_services_sub', 'Every treatment is personalized, evidence-based, and delivered with care.') }}</p>
        </div>
        <div class="thr-services-grid">
            @foreach($featuredServices as $service)
            <div class="thr-service-card thr-service-card--{{ $service->getCategoryColorAttribute() }}">
                @if($service->image)
                <div class="thr-service-card__img">
                    <img src="{{ $service->image_url }}" alt="{{ $service->name }}">
                </div>
                @else
                <div class="thr-service-card__icon">{{ \App\Models\Service::getCategoryIcon($service->category) }}</div>
                @endif
                <div class="thr-service-card__category">{{ $service->category_label }}</div>
                <h3 class="thr-service-card__name">{{ $service->name }}</h3>
                <p class="thr-service-card__desc">{{ $service->short_description }}</p>
                <div class="thr-service-card__meta">
                    <span><i class="fas fa-clock"></i> {{ $service->duration }}</span>
                    <span><i class="fas fa-tag"></i> From GHS {{ number_format($service->price_from, 0) }}</span>
                </div>
                <a href="{{ route('services.show', $service->slug) }}" class="thr-service-card__cta">
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

{{-- ── STORY TEASER ─────────────────────────────────────────────────── --}}
@php
$storyBody = $s->get('home_story_body', "The Healing Room was founded on a simple belief: every client deserves world-class aesthetic and wellness care, delivered with dignity, expertise, and genuine compassion — right here in Accra.\n\nFrom post-partum recovery to skin rejuvenation and body contouring, our specialists bring clinical expertise and a judgment-free environment to every session, so you always leave feeling seen, cared for, and confident.");
$storyPhoto = $s->get('home_story_media') ? asset('storage/'.$s->get('home_story_media')) : ($storyMember->image_url ?? null);
@endphp
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-two-col">
            <div class="thr-two-col__visual">
                <div class="thr-story-photo">
                    @if($storyPhoto)
                    <img src="{{ $storyPhoto }}" alt="{{ $s->get('home_story_title', 'Our Story') }}">
                    @else
                    <div class="thr-story-photo__placeholder">
                        <span>🌿</span>
                    </div>
                    @endif
                    <div class="thr-story-photo__badge">
                        <span>{{ $s->get('home_story_badge_num', '3+') }}</span>
                        <span>{{ $s->get('home_story_badge_label', 'Years of Excellence') }}</span>
                    </div>
                </div>
            </div>
            <div class="thr-two-col__text">
                <p class="thr-section-header__eyebrow">{{ $s->get('home_story_eyebrow', 'Our Story') }}</p>
                <h2 class="thr-section-header__title" style="text-align:left">{{ $s->get('home_story_title', 'A Sanctuary for Restoration & Confidence') }}</h2>
                @foreach(array_filter(explode("\n\n", $storyBody)) as $para)
                <p @if(!$loop->first) style="margin-top:1rem" @endif>{{ trim($para) }}</p>
                @endforeach
                <a href="{{ route('about') }}" class="btn btn-outline-gold" style="margin-top:1.5rem">
                    <i class="fas fa-heart"></i> Learn Our Story
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── WHY CHOOSE US ─────────────────────────────────────────────────── --}}
@php
$whyBackdrop = $s->get('home_why_backdrop') ? asset('storage/'.$s->get('home_why_backdrop')) : ($backdropService->image_url ?? null);
@endphp
<section class="thr-section thr-section--dark @if($whyBackdrop) thr-section--dark-photo @endif"
    @if($whyBackdrop) style="background-image: linear-gradient(160deg, rgba(26,18,8,.93) 0%, rgba(26,18,8,.88) 60%, rgba(200,151,43,.35) 100%), url('{{ $whyBackdrop }}')" @endif>
    <div class="thr-container">
        <div class="thr-section-header thr-section-header--light">
            <p class="thr-section-header__eyebrow">{{ $s->get('home_why_eyebrow', 'Why The Healing Room') }}</p>
            <h2 class="thr-section-header__title">{{ $s->get('home_why_title', 'Excellence in Every Session') }}</h2>
        </div>
        @php
        $whyChooseUsColors = ['pink', 'teal', 'amber', 'purple', 'green'];
        $whyChooseUsCards = $homeValues->count() ? $homeValues : collect([
            (object) ['icon' => 'fa-user-md',  'title' => 'Expert Care', 'body' => 'Our certified specialists bring years of clinical expertise and continuous training in the latest aesthetic techniques.', 'image' => null],
            (object) ['icon' => 'fa-lock',     'title' => 'Privacy & Dignity', 'body' => 'Your privacy is our highest priority. All treatments are conducted in a fully confidential, judgment-free environment.', 'image' => null],
            (object) ['icon' => 'fa-seedling', 'title' => 'Holistic Approach', 'body' => 'We treat the whole person — body, skin, and confidence — using methods that nurture long-term wellness, not just quick fixes.', 'image' => null],
            (object) ['icon' => 'fa-star',     'title' => 'Proven Results', 'body' => 'Our clients see measurable, lasting results. We back our treatments with before-and-after tracking and follow-up support.', 'image' => null],
        ]);
        @endphp
        <div class="thr-value-grid">
            @foreach($whyChooseUsCards as $i => $card)
            @php $cardImage = $card->image ? ($card->image_url ?? asset('storage/'.$card->image)) : null; @endphp
            <div class="thr-value-card">
                <div class="thr-value-card__media @if(!$cardImage) thr-value-card__media--{{ $whyChooseUsColors[$i % 5] }} @endif">
                    @if($cardImage)
                    <img src="{{ $cardImage }}" alt="{{ $card->title }}" loading="lazy">
                    @else
                    <div class="thr-value-card__media-placeholder"><i class="fas {{ $card->icon ?: 'fa-star' }}"></i></div>
                    @endif
                    @if($card->icon && $cardImage)
                    <span class="thr-value-card__badge"><i class="fas {{ $card->icon }}"></i></span>
                    @endif
                </div>
                <div class="thr-value-card__body">
                    <h3>{{ $card->title }}</h3>
                    <p>{{ $card->body }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── GALLERY ──────────────────────────────────────────────────────── --}}
@php
$igHandle = \App\Models\SiteSetting::get('contact_ig_handle', '@thehealing_room26');
$igUrl    = \App\Models\SiteSetting::get('contact_ig_url', 'https://instagram.com/thehealing_room26');
@endphp
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">{{ $s->get('home_gallery_eyebrow', 'Follow Our Journey') }}</p>
            <h2 class="thr-section-header__title">
                <i class="fab fa-instagram" style="color:#E1306C"></i>
                {{ $igHandle }}
            </h2>
            <p class="thr-section-header__sub">{{ $s->get('home_gallery_sub', 'A glimpse into our treatments and the space where your transformation happens.') }}</p>
        </div>
        <div class="thr-instagram-grid">
            @for($i = 0; $i < 6; $i++)
                @if(isset($galleryImages[$i]))
                <a href="{{ $igUrl }}" target="_blank" class="thr-instagram-cell">
                    <img src="{{ $galleryImages[$i]->image_url }}" alt="{{ $galleryImages[$i]->name }}" class="thr-instagram-cell__img">
                    <div class="thr-instagram-cell__overlay"><i class="fab fa-instagram"></i></div>
                </a>
                @else
                <a href="{{ $igUrl }}" target="_blank" class="thr-instagram-cell">
                    <div class="thr-instagram-placeholder">
                        <i class="fas fa-camera"></i>
                        <span>Instagram</span>
                    </div>
                </a>
                @endif
            @endfor
        </div>
        <div class="thr-section__action">
            <a href="{{ $igUrl }}" target="_blank" class="btn btn-outline-gold">
                <i class="fab fa-instagram"></i> Follow {{ $igHandle }}
            </a>
        </div>
    </div>
</section>

{{-- ── PARTNERS ──────────────────────────────────────────────────────── --}}
@if($partners->isNotEmpty())
<section class="thr-section thr-section--partners">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">Trusted By</p>
            <h2 class="thr-section-header__title">Our Partners</h2>
        </div>
        <div class="thr-partners-grid">
            @foreach($partners as $partner)
            <div class="thr-partner-item">
                @if($partner->website_url)
                <a href="{{ $partner->website_url }}" target="_blank" rel="noopener" title="{{ $partner->name }}">
                @endif
                    @if($partner->logo)
                    <img src="{{ $partner->logo_url }}" alt="{{ $partner->name }}" class="thr-partner-logo">
                    @else
                    <span class="thr-partner-name">{{ $partner->name }}</span>
                    @endif
                @if($partner->website_url)
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── CTA BANNER ────────────────────────────────────────────────────── --}}
@php $ctaPhone = \App\Models\SiteSetting::get('contact_phone', '0597173323'); @endphp
<section class="thr-cta-banner"
    @if($backdropService) style="background-image: linear-gradient(135deg, rgba(200,151,43,.88), rgba(154,114,32,.92)), url('{{ $backdropService->image_url }}')" @endif>
    <div class="thr-cta-banner__content">
        <h2 class="thr-cta-banner__title">{{ $s->get('home_cta_title', 'Ready to Feel Beautiful?') }}</h2>
        <p class="thr-cta-banner__sub">{{ $s->get('home_cta_sub', 'Book your session today and take the first step toward renewed confidence.') }}</p>
        <a href="{{ route('booking') }}" class="btn btn-white btn-lg">
            <i class="fas fa-calendar-plus"></i> Book Your Session Today
        </a>
        <p class="thr-cta-banner__note">
            <i class="fas fa-phone"></i> Or call us: <a href="tel:{{ $ctaPhone }}">{{ $ctaPhone }}</a>
        </p>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function () {
    const hero = document.getElementById('heroSlider');
    if (!hero) return;

    const slides = hero.querySelectorAll('.thr-hero__slide');
    const dots   = hero.querySelectorAll('[data-hero-dot]');
    if (slides.length < 2) return;

    let current = 0;
    let timer;

    function goTo(index) {
        slides[current].classList.remove('is-active');
        dots[current]?.classList.remove('is-active');
        current = (index + slides.length) % slides.length;
        slides[current].classList.add('is-active');
        dots[current]?.classList.add('is-active');
    }

    function start() {
        timer = setInterval(() => goTo(current + 1), 6000);
    }

    function stop() {
        clearInterval(timer);
    }

    hero.querySelector('[data-hero-prev]')?.addEventListener('click', () => { goTo(current - 1); stop(); start(); });
    hero.querySelector('[data-hero-next]')?.addEventListener('click', () => { goTo(current + 1); stop(); start(); });
    dots.forEach(dot => dot.addEventListener('click', () => { goTo(Number(dot.dataset.heroDot)); stop(); start(); }));

    hero.addEventListener('mouseenter', stop);
    hero.addEventListener('mouseleave', start);

    start();
})();
</script>
@endpush
