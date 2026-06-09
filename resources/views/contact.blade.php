@extends('layouts.app')
@section('title', $s->get('contact_hero_title', 'Contact Us') . ' | The Healing Room Aesthetic Clinic')

@section('content')

{{-- ── PAGE HERO ────────────────────────────────────────────────────── --}}
<section class="thr-page-hero"
    @if($s->get('contact_hero_type') === 'image' && $s->get('contact_hero_media'))
        style="background-image:url('{{ asset('storage/'.$s->get('contact_hero_media')) }}');background-size:cover;background-position:center;"
    @endif
>
    @if($s->get('contact_hero_type') === 'video' && $s->get('contact_hero_media'))
    <video class="thr-page-hero__video-bg" autoplay muted loop playsinline>
        <source src="{{ asset('storage/'.$s->get('contact_hero_media')) }}" type="video/mp4">
    </video>
    @endif
    <div class="thr-page-hero__overlay"></div>
    <div class="thr-page-hero__content">
        <p class="thr-page-hero__eyebrow">{{ $s->get('contact_hero_eyebrow', "We're Here For You") }}</p>
        <h1 class="thr-page-hero__title">{{ $s->get('contact_hero_title', 'Get In Touch') }}</h1>
        <p class="thr-page-hero__sub">{{ $s->get('contact_hero_sub', "Questions? We'd love to hear from you. Send us a message or give us a call.") }}</p>
    </div>
</section>

<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-contact-grid">

            {{-- Contact Form --}}
            <div class="thr-contact-form-wrap">
                <h2 class="thr-contact-form-wrap__title">Send Us a Message</h2>
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
                <form method="POST" action="{{ route('contact.send') }}" class="thr-form">
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
                            <label>Subject <span class="req">*</span></label>
                            <input type="text" name="subject" value="{{ old('subject') }}" required placeholder="How can we help?">
                        </div>
                    </div>
                    <div class="thr-form__group">
                        <label>Your Message <span class="req">*</span></label>
                        <textarea name="message" rows="6" required placeholder="Tell us about your concern or question...">{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-gold btn-full">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>

            {{-- Contact Info --}}
            <div class="thr-contact-info">
                @if($s->get('contact_phone'))
                <div class="thr-info-card">
                    <div class="thr-info-card__icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <h4>Phone / WhatsApp</h4>
                        <a href="tel:{{ preg_replace('/\s+/','',$s->get('contact_phone')) }}">{{ $s->get('contact_phone') }}</a>
                    </div>
                </div>
                @endif

                @if($s->get('contact_website'))
                <div class="thr-info-card">
                    <div class="thr-info-card__icon"><i class="fas fa-globe"></i></div>
                    <div>
                        <h4>Website</h4>
                        <a href="{{ $s->get('contact_website') }}" target="_blank">{{ $s->get('contact_website') }}</a>
                    </div>
                </div>
                @endif

                @if($s->get('contact_location'))
                <div class="thr-info-card">
                    <div class="thr-info-card__icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h4>Location</h4>
                        <p>{{ $s->get('contact_location') }}<br><small>(Full address provided at booking confirmation)</small></p>
                    </div>
                </div>
                @endif

                @if($s->get('contact_hours'))
                <div class="thr-info-card">
                    <div class="thr-info-card__icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <h4>Business Hours</h4>
                        <p>{!! nl2br(e($s->get('contact_hours'))) !!}</p>
                    </div>
                </div>
                @endif

                {{-- Social Media --}}
                @php
                    $socials = [
                        ['handle' => $s->get('contact_ig_handle'), 'url' => $s->get('contact_ig_url'), 'icon' => 'fab fa-instagram', 'class' => 'thr-social-link--ig'],
                        ['handle' => $s->get('contact_tt_handle'), 'url' => $s->get('contact_tt_url'), 'icon' => 'fab fa-tiktok',    'class' => 'thr-social-link--tt'],
                        ['handle' => $s->get('contact_fb_handle'), 'url' => $s->get('contact_fb_url'), 'icon' => 'fab fa-facebook',  'class' => 'thr-social-link--fb'],
                        ['handle' => $s->get('contact_sc_handle'), 'url' => $s->get('contact_sc_url'), 'icon' => 'fab fa-snapchat', 'class' => 'thr-social-link--sc'],
                    ];
                    $activeSocials = array_filter($socials, fn($s) => $s['handle'] || $s['url']);
                @endphp
                @if($activeSocials)
                <div class="thr-social-links">
                    <h4>Follow Us</h4>
                    <div class="thr-social-links__grid">
                        @foreach($activeSocials as $social)
                        <a href="{{ $social['url'] ?? '#' }}" target="_blank" class="thr-social-link {{ $social['class'] }}">
                            <i class="{{ $social['icon'] }}"></i>
                            <span>{{ $social['handle'] ?? $social['url'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Map --}}
        @if($s->get('contact_map_embed'))
        <div class="thr-map-embed" style="margin-top:2.5rem;border-radius:var(--radius);overflow:hidden;border:1px solid var(--border)">
            {!! $s->get('contact_map_embed') !!}
        </div>
        @else
        <div class="thr-map-placeholder">
            <div class="thr-map-placeholder__inner">
                <i class="fas fa-map-marked-alt"></i>
                <h3>Find Us in Accra</h3>
                <p>Google Maps embed will appear here once the clinic address is finalized.</p>
                <a href="https://maps.google.com" target="_blank" class="btn btn-gold btn-sm">
                    <i class="fas fa-directions"></i> Get Directions
                </a>
            </div>
        </div>
        @endif
    </div>
</section>

@endsection
