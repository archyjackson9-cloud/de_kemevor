@extends('layouts.app')
@section('title', 'Contact Us | The Healing Room Aesthetic Clinic')

@section('content')

<section class="thr-page-hero thr-page-hero--contact">
    <div class="thr-page-hero__content">
        <p class="thr-page-hero__eyebrow">We're Here For You</p>
        <h1 class="thr-page-hero__title">Get In Touch</h1>
        <p class="thr-page-hero__sub">Questions? We'd love to hear from you. Send us a message or give us a call.</p>
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
                <div class="thr-info-card">
                    <div class="thr-info-card__icon"><i class="fas fa-phone"></i></div>
                    <div>
                        <h4>Phone / WhatsApp</h4>
                        <a href="tel:0597173323">0597173323</a>
                    </div>
                </div>
                <div class="thr-info-card">
                    <div class="thr-info-card__icon"><i class="fas fa-globe"></i></div>
                    <div>
                        <h4>Website</h4>
                        <a href="https://www.thehealingroom.com" target="_blank">www.thehealingroom.com</a>
                    </div>
                </div>
                <div class="thr-info-card">
                    <div class="thr-info-card__icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div>
                        <h4>Location</h4>
                        <p>Accra, Ghana<br><small>(Full address provided at booking confirmation)</small></p>
                    </div>
                </div>
                <div class="thr-info-card">
                    <div class="thr-info-card__icon"><i class="fas fa-clock"></i></div>
                    <div>
                        <h4>Business Hours</h4>
                        <p>Mon – Fri: 8:00 AM – 7:00 PM<br>Saturday: 9:00 AM – 5:00 PM<br>Sunday: 10:00 AM – 3:00 PM</p>
                    </div>
                </div>

                {{-- Social Media --}}
                <div class="thr-social-links">
                    <h4>Follow Us</h4>
                    <div class="thr-social-links__grid">
                        <a href="https://instagram.com/thehealing_room26" target="_blank" class="thr-social-link thr-social-link--ig">
                            <i class="fab fa-instagram"></i>
                            <span>@thehealing_room26</span>
                        </a>
                        <a href="https://tiktok.com/@thehealing_room26" target="_blank" class="thr-social-link thr-social-link--tt">
                            <i class="fab fa-tiktok"></i>
                            <span>@thehealing_room26</span>
                        </a>
                        <a href="https://facebook.com/thehealing_room" target="_blank" class="thr-social-link thr-social-link--fb">
                            <i class="fab fa-facebook"></i>
                            <span>@thehealing_room</span>
                        </a>
                        <a href="https://snapchat.com/add/thehealingroom2" target="_blank" class="thr-social-link thr-social-link--sc">
                            <i class="fab fa-snapchat"></i>
                            <span>@thehealingroom2</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Google Maps Placeholder --}}
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
    </div>
</section>

@endsection
