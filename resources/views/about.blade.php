@extends('layouts.app')
@section('title', $s->get('about_hero_title', 'About Us') . ' | The Healing Room Aesthetic Clinic')

@section('content')

{{-- ── PAGE HERO ────────────────────────────────────────────────────── --}}
<section class="thr-page-hero"
    @if($s->get('about_hero_type') === 'image' && $s->get('about_hero_media'))
        style="background-image:url('{{ asset('storage/'.$s->get('about_hero_media')) }}');background-size:cover;background-position:center;"
    @endif
>
    @if($s->get('about_hero_type') === 'video' && $s->get('about_hero_media'))
    <video class="thr-page-hero__video-bg" autoplay muted loop playsinline>
        <source src="{{ asset('storage/'.$s->get('about_hero_media')) }}" type="video/mp4">
    </video>
    @endif
    <div class="thr-page-hero__overlay"></div>
    <div class="thr-page-hero__content">
        <p class="thr-page-hero__eyebrow">{{ $s->get('about_hero_eyebrow', 'Our Story') }}</p>
        <h1 class="thr-page-hero__title">{{ $s->get('about_hero_title', 'About The Healing Room') }}</h1>
        <p class="thr-page-hero__sub">{{ $s->get('about_hero_sub', 'A sanctuary built on expertise, compassion, and results.') }}</p>
    </div>
</section>

{{-- ── STORY ────────────────────────────────────────────────────────── --}}
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-two-col">
            <div class="thr-two-col__text">
                <p class="thr-section-header__eyebrow">{{ $s->get('about_story_eyebrow', 'How It All Began') }}</p>
                <h2 class="thr-section-header__title" style="text-align:left">{{ $s->get('about_story_title', 'Our Clinic Story') }}</h2>
                @php $storyBody = $s->get('about_story_body', "The Healing Room was born out of a simple but powerful conviction: every person deserves access to world-class aesthetic and wellness care — delivered with dignity, expertise, and genuine compassion.\n\nFounded in the heart of Accra, Ghana, our clinic was created to bridge the gap between luxury wellness and accessible, evidence-based care.\n\nToday, The Healing Room has become a trusted sanctuary for hundreds of clients across Ghana."); @endphp
                @foreach(array_filter(explode("\n\n", $storyBody)) as $para)
                <p @if(!$loop->first) style="margin-top:1rem" @endif>{{ trim($para) }}</p>
                @endforeach
            </div>
            <div class="thr-two-col__visual">
                <div class="thr-about-visual">
                    @for($i = 1; $i <= 4; $i++)
                    @if($s->get('about_stat_'.$i.'_num'))
                    <div class="thr-about-visual__badge">
                        <span>{{ $s->get('about_stat_'.$i.'_num') }}</span>
                        <span>{{ $s->get('about_stat_'.$i.'_label') }}</span>
                    </div>
                    @endif
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── MISSION ──────────────────────────────────────────────────────── --}}
@if($s->get('about_mission'))
<section class="thr-section thr-section--gold-light">
    <div class="thr-container thr-container--narrow">
        <div class="thr-mission">
            <div class="thr-mission__icon"><i class="fas fa-heart"></i></div>
            <h2 class="thr-mission__title">Our Mission</h2>
            <blockquote class="thr-mission__statement">
                "{{ $s->get('about_mission') }}"
            </blockquote>
        </div>
    </div>
</section>
@endif

{{-- ── TEAM ─────────────────────────────────────────────────────────── --}}
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">Meet the Team</p>
            <h2 class="thr-section-header__title">The Experts Behind Your Care</h2>
        </div>
        <div class="thr-team-grid">
            @forelse($teamMembers as $member)
            <div class="thr-team-card">
                <div class="thr-team-card__photo">
                    @if($member->image)
                    <img src="{{ $member->image_url }}" alt="{{ $member->name }}" class="thr-team-card__photo-img">
                    @else
                    <div class="thr-team-card__photo-placeholder"><i class="fas fa-user-circle"></i></div>
                    @endif
                </div>
                <h3 class="thr-team-card__name">{{ $member->name }}</h3>
                <p class="thr-team-card__title">{{ $member->role }}</p>
                @if($member->bio)
                <p class="thr-team-card__bio">{{ $member->bio }}</p>
                @endif
            </div>
            @empty
            <p style="color:#888;text-align:center;grid-column:1/-1">Team profiles coming soon.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- ── CERTIFICATIONS ───────────────────────────────────────────────── --}}
@if($certs->isNotEmpty())
<section class="thr-section thr-section--dark">
    <div class="thr-container">
        <div class="thr-section-header thr-section-header--light">
            <p class="thr-section-header__eyebrow">Our Credentials</p>
            <h2 class="thr-section-header__title">Certifications & Accreditations</h2>
        </div>
        <div class="thr-certs-strip">
            @foreach($certs as $cert)
            <div class="thr-cert-badge"><i class="fas {{ $cert->icon }}"></i> {{ $cert->label }}</div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── CORE VALUES ──────────────────────────────────────────────────── --}}
@if($values->isNotEmpty())
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">What We Stand For</p>
            <h2 class="thr-section-header__title">Our Core Values</h2>
        </div>
        <div class="thr-values-grid">
            @foreach($values as $value)
            <div class="thr-value-item">
                <div class="thr-value-item__num">{{ $value->number }}</div>
                <h3>{{ $value->title }}</h3>
                <p>{{ $value->body }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── CTA BANNER ───────────────────────────────────────────────────── --}}
<section class="thr-cta-banner">
    <div class="thr-cta-banner__content">
        <h2 class="thr-cta-banner__title">{{ $s->get('about_cta_title', 'Ready to Begin Your Journey?') }}</h2>
        <p class="thr-cta-banner__sub">{{ $s->get('about_cta_sub', 'Book a consultation and let our team create a personalized treatment plan for you.') }}</p>
        <a href="{{ route('booking') }}" class="btn btn-white btn-lg">
            <i class="fas fa-calendar-plus"></i> Book Now
        </a>
    </div>
</section>

@endsection
