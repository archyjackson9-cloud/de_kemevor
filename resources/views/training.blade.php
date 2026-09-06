@extends('layouts.app')
@section('title', $s->get('training_hero_title', 'Esthetic Training Program') . ' | The Healing Room Aesthetic Clinic')

@section('content')

{{-- ── HERO ──────────────────────────────────────────────────────────── --}}
<section class="thr-page-hero thr-page-hero--about"
    @if($s->get('training_hero_type') === 'image' && $s->get('training_hero_media'))
        style="background-image:url('{{ asset('storage/'.$s->get('training_hero_media')) }}');background-size:cover;background-position:center;"
    @endif
>
    @if($s->get('training_hero_type') === 'video' && $s->get('training_hero_media'))
    <video class="thr-page-hero__video-bg" autoplay muted loop playsinline poster="{{ $s->get('training_hero_poster') ? asset('storage/'.$s->get('training_hero_poster')) : '' }}">
        <source src="{{ asset('storage/'.$s->get('training_hero_media')) }}" type="video/mp4">
    </video>
    @endif
    <div class="thr-page-hero__overlay"></div>
    <div class="thr-page-hero__content">
        <p class="thr-page-hero__eyebrow">{{ $s->get('training_hero_eyebrow', 'Learn. Grow. Transform.') }}</p>
        <h1 class="thr-page-hero__title">{{ $s->get('training_hero_title', 'Esthetic Training Program') }}</h1>
        <p class="thr-page-hero__sub">{{ $s->get('training_hero_sub', 'Gain the knowledge, skills and confidence to become a professional esthetician and build a successful career in the beauty & wellness industry.') }}</p>
        <div class="thr-hero__actions" style="margin-top:2rem">
            <a href="#enroll" class="btn btn-gold btn-lg">
                <i class="fas fa-graduation-cap"></i> Enroll Today
            </a>
            <a href="#curriculum" class="btn btn-outline-light btn-lg">
                <i class="fas fa-list-ol"></i> View Curriculum
            </a>
        </div>
        <div class="thr-hero__badges">
            <span><i class="fas fa-certificate"></i> Certificate Awarded Upon Completion</span>
            <span><i class="fas fa-layer-group"></i> {{ $phases->count() ?: 7 }} Structured Phases</span>
            <span><i class="fas fa-user-tie"></i> Expert-Led & Hands-On</span>
        </div>
    </div>
</section>

{{-- ── PROGRAM DESCRIPTION ──────────────────────────────────────────── --}}
@php
$programBody = $s->get('training_description', "Gain the knowledge, skills and confidence to become a professional esthetician and build a successful career in the beauty & wellness industry.\n\nOur Esthetic Training Program takes you from foundational mindset and safety through hands-on technique, product knowledge, and real client-facing skills — all the way to the business side of running a career in esthetics. Every phase builds on the last, so you graduate ready for the treatment room and beyond.");
@endphp
<section class="thr-section thr-section--light">
    <div class="thr-container" style="max-width:820px;text-align:center">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">{{ $s->get('training_description_eyebrow', 'About the Program') }}</p>
            <h2 class="thr-section-header__title">{{ $s->get('training_description_title', 'From Knowledge to Confidence, From Skills to Success') }}</h2>
        </div>
        @foreach(array_filter(explode("\n\n", $programBody)) as $para)
        <p style="color:var(--text-light);line-height:1.8;{{ !$loop->first ? 'margin-top:1rem' : '' }}">{{ trim($para) }}</p>
        @endforeach
    </div>
</section>

{{-- ── WHO IS THIS COURSE FOR? ──────────────────────────────────────── --}}
@if($whoFor->isNotEmpty())
<section class="thr-section thr-section--gold-light">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">{{ $s->get('training_who_eyebrow', 'Who Is This For') }}</p>
            <h2 class="thr-section-header__title">{{ $s->get('training_who_title', 'Who Is This Course For?') }}</h2>
        </div>
        <div class="thr-certs-strip">
            @foreach($whoFor as $w)
            <div class="thr-cert-badge thr-cert-badge--dark"><i class="fas fa-check-circle"></i> {{ $w->label }}</div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── WHAT YOU WILL LEARN ──────────────────────────────────────────── --}}
@if($learnPoints->isNotEmpty())
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">{{ $s->get('training_learn_eyebrow', 'Curriculum Highlights') }}</p>
            <h2 class="thr-section-header__title">{{ $s->get('training_learn_title', 'What You Will Learn') }}</h2>
        </div>
        <div class="thr-checklist">
            @foreach($learnPoints as $point)
            <div class="thr-checklist__item">
                <span class="thr-checklist__icon"><i class="fas fa-check"></i></span>
                <p>{{ $point->text }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── WHAT YOU'LL GAIN ──────────────────────────────────────────────── --}}
@if($gainItems->isNotEmpty())
<section class="thr-section thr-section--dark">
    <div class="thr-container">
        <div class="thr-section-header thr-section-header--light">
            <p class="thr-section-header__eyebrow">{{ $s->get('training_gain_eyebrow', 'What You\'ll Gain') }}</p>
            <h2 class="thr-section-header__title">{{ $s->get('training_gain_title', 'Your Passion. Our Training. Limitless Possibilities.') }}</h2>
        </div>
        <div class="thr-value-grid thr-value-grid--icons">
            @foreach($gainItems as $item)
            <div class="thr-expect-item thr-expect-item--dark">
                <div class="thr-expect-item__icon"><i class="fas {{ $item->icon }}"></i></div>
                <h4>{{ $item->title }}</h4>
                <p>{{ $item->body }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── COURSE STRUCTURE ─────────────────────────────────────────────── --}}
@php
$phaseColors = ['green', 'pink', 'amber', 'teal', 'purple', 'amber', 'green'];
$phaseIcons  = [1 => 'fa-shield-halved', 2 => 'fa-microscope', 3 => 'fa-comments', 4 => 'fa-hand-holding-medical', 5 => 'fa-vial', 6 => 'fa-face-smile', 7 => 'fa-chart-line'];
@endphp
<section class="thr-section thr-section--light" id="curriculum">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">{{ $s->get('training_structure_eyebrow', 'Course Structure') }}</p>
            <h2 class="thr-section-header__title">{{ $s->get('training_structure_title', 'Your Learning Journey, Phase by Phase') }}</h2>
            <p class="thr-section-header__sub">{{ $s->get('training_structure_sub', 'Each phase builds on the one before it — from mindset and safety, all the way to running your own successful career.') }}</p>
        </div>

        <div class="thr-phase-list">
            @forelse($phases as $i => $phase)
            <div class="thr-phase {{ $i % 2 === 1 ? 'thr-phase--reverse' : '' }}">
                <div class="thr-phase__visual">
                    @if($phase->image)
                    <img src="{{ $phase->image_url }}" alt="{{ $phase->title }}" loading="lazy">
                    @else
                    <div class="thr-phase__placeholder thr-phase__placeholder--{{ $phaseColors[$i % 5] }}">
                        <i class="fas {{ $phaseIcons[$phase->phase_number] ?? 'fa-spa' }}"></i>
                    </div>
                    @endif
                    <div class="thr-phase__badge thr-phase__badge--{{ $phaseColors[$i % 5] }}">
                        <span>Phase</span>
                        <strong>{{ $phase->phase_number }}</strong>
                    </div>
                </div>
                <div class="thr-phase__content">
                    @if($phase->subtitle)
                    <p class="thr-phase__subtitle">{{ $phase->subtitle }}</p>
                    @endif
                    <h3>{{ $phase->title }}</h3>
                    @if($phase->description)
                    <p class="thr-phase__desc">{{ $phase->description }}</p>
                    @endif
                    @if($phase->topic_list)
                    <ul class="thr-phase__topics">
                        @foreach($phase->topic_list as $topic)
                        <li><i class="fas fa-check"></i> {{ $topic }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
            @empty
            <div class="admin-empty"><i class="fas fa-layer-group"></i> Curriculum phases coming soon.</div>
            @endforelse
        </div>
    </div>
</section>

{{-- ── ASSESSMENT & CERTIFICATION ───────────────────────────────────── --}}
<section class="thr-section thr-section--gold-light">
    <div class="thr-container">
        <div class="thr-two-col">
            <div class="thr-two-col__visual" style="display:flex;align-items:center;justify-content:center">
                <div class="thr-cert-seal">
                    <div class="thr-cert-seal__ring">
                        <i class="fas fa-award"></i>
                        <span>Certificate<br>Awarded</span>
                    </div>
                </div>
            </div>
            <div class="thr-two-col__text">
                <p class="thr-section-header__eyebrow">{{ $s->get('training_cert_eyebrow', 'Assessment & Certification') }}</p>
                <h2 class="thr-section-header__title" style="text-align:left">{{ $s->get('training_cert_title', 'Graduate With a Recognized Certificate') }}</h2>
                @php $certBody = $s->get('training_cert_body', "Throughout the program, you'll be assessed on both theory and hands-on technique to make sure you're confident and competent at every phase.\n\nUpon successfully completing all phases and your final practical assessment, you will be awarded The Healing Room's Esthetic Training Certificate — a mark of the skills and professionalism you've built."); @endphp
                @foreach(array_filter(explode("\n\n", $certBody)) as $para)
                <p @if(!$loop->first) style="margin-top:1rem" @endif>{{ trim($para) }}</p>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ── ENROLL ────────────────────────────────────────────────────────── --}}
<section class="thr-section thr-section--light" id="enroll">
    <div class="thr-container">
        <div class="thr-contact-grid">
            <div class="thr-contact-form-wrap">
                <h2 class="thr-contact-form-wrap__title">{{ $s->get('training_enroll_title', 'Invest In Your Future — Enroll Today') }}</h2>
                @if(session('success'))
                <div class="thr-alert thr-alert--success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif
                @if($errors->any())
                <div class="thr-alert thr-alert--error">
                    @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
                </div>
                @endif
                <form method="POST" action="{{ route('training.enroll') }}" class="thr-form">
                    @csrf
                    <div class="thr-form__row">
                        <div class="thr-form__group">
                            <label>Your Name <span class="req">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Abena Mensah">
                        </div>
                        <div class="thr-form__group">
                            <label>Email Address <span class="req">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@email.com">
                        </div>
                    </div>
                    <div class="thr-form__row">
                        <div class="thr-form__group">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="0244 000 000">
                        </div>
                        <div class="thr-form__group">
                            <label>Phase You're Most Interested In</label>
                            <select name="phase_interest">
                                <option value="">Not sure yet</option>
                                @foreach($phases as $phase)
                                <option value="Phase {{ $phase->phase_number }}: {{ $phase->title }}" {{ old('phase_interest') == 'Phase '.$phase->phase_number.': '.$phase->title ? 'selected' : '' }}>
                                    Phase {{ $phase->phase_number }}: {{ $phase->title }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="thr-form__group">
                        <label>Message</label>
                        <textarea name="message" rows="5" placeholder="Tell us a bit about your background or any questions you have...">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-gold btn-full">
                        <i class="fas fa-paper-plane"></i> Submit Enrollment Inquiry
                    </button>
                </form>
            </div>

            <div class="thr-contact-info">
                @php $trainingPhone = \App\Models\SiteSetting::get('contact_phone', '0597173323'); @endphp
                <div class="thr-info-card">
                    <div class="thr-info-card__icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <h4>Call or WhatsApp Us</h4>
                        <a href="tel:{{ preg_replace('/\s+/','',$trainingPhone) }}">{{ $trainingPhone }}</a>
                    </div>
                </div>
                <div class="thr-info-card">
                    <div class="thr-info-card__icon"><i class="fas fa-certificate"></i></div>
                    <div>
                        <h4>Certificate Awarded</h4>
                        <p>Upon successful completion of all {{ $phases->count() ?: 7 }} phases and final assessment.</p>
                    </div>
                </div>
                <div class="thr-info-card">
                    <div class="thr-info-card__icon"><i class="fas fa-users"></i></div>
                    <div>
                        <h4>Who Should Apply</h4>
                        <p>Aspiring estheticians, beauty & wellness enthusiasts, salon & spa professionals, and entrepreneurs.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
