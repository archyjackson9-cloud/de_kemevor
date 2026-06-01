@extends('layouts.app')
@section('title', 'About Us | The Healing Room Aesthetic Clinic')

@section('content')

<section class="thr-page-hero thr-page-hero--about">
    <div class="thr-page-hero__content">
        <p class="thr-page-hero__eyebrow">Our Story</p>
        <h1 class="thr-page-hero__title">About The Healing Room</h1>
        <p class="thr-page-hero__sub">A sanctuary built on expertise, compassion, and results.</p>
    </div>
</section>

{{-- Story Section --}}
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-two-col">
            <div class="thr-two-col__text">
                <p class="thr-section-header__eyebrow">How It All Began</p>
                <h2 class="thr-section-header__title" style="text-align:left">Our Clinic Story</h2>
                <p>The Healing Room was born out of a simple but powerful conviction: every person deserves access to world-class aesthetic and wellness care — delivered with dignity, expertise, and genuine compassion.</p>
                <p style="margin-top:1rem">Founded in the heart of Accra, Ghana, our clinic was created to bridge the gap between luxury wellness and accessible, evidence-based care. We noticed that many women and men were navigating post-partum recovery, skin concerns, and body confidence issues without the professional support they truly needed.</p>
                <p style="margin-top:1rem">Today, The Healing Room has become a trusted sanctuary for hundreds of clients across Ghana — from new mothers reclaiming their bodies after childbirth, to professionals investing in their skin health, to individuals seeking discreet, transformative rejuvenation treatments.</p>
            </div>
            <div class="thr-two-col__visual">
                <div class="thr-about-visual">
                    <div class="thr-about-visual__badge">
                        <span>500+</span>
                        <span>Happy Clients</span>
                    </div>
                    <div class="thr-about-visual__badge">
                        <span>3+</span>
                        <span>Years Experience</span>
                    </div>
                    <div class="thr-about-visual__badge">
                        <span>14+</span>
                        <span>Treatments</span>
                    </div>
                    <div class="thr-about-visual__badge">
                        <span>98%</span>
                        <span>Satisfaction Rate</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Mission --}}
<section class="thr-section thr-section--gold-light">
    <div class="thr-container thr-container--narrow">
        <div class="thr-mission">
            <div class="thr-mission__icon"><i class="fas fa-heart"></i></div>
            <h2 class="thr-mission__title">Our Mission</h2>
            <blockquote class="thr-mission__statement">
                "To restore and maintain the confidence of every client through premium, personalized esthetic treatments — delivered in a safe, private, and empowering environment."
            </blockquote>
        </div>
    </div>
</section>

{{-- Team --}}
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">Meet the Team</p>
            <h2 class="thr-section-header__title">The Experts Behind Your Care</h2>
        </div>
        <div class="thr-team-grid">
            <div class="thr-team-card">
                <div class="thr-team-card__photo">
                    <div class="thr-team-card__photo-placeholder"><i class="fas fa-user-circle"></i></div>
                </div>
                <h3 class="thr-team-card__name">Dr. Akua Sarpong</h3>
                <p class="thr-team-card__title">Founder & Lead Esthetician</p>
                <p class="thr-team-card__bio">With over 10 years of clinical experience in aesthetic medicine and post-surgical care, Dr. Akua founded The Healing Room to create a space where every client feels heard, safe, and transformed. She holds certifications in advanced skincare, body contouring, and rejuvenation therapies.</p>
            </div>
            <div class="thr-team-card">
                <div class="thr-team-card__photo">
                    <div class="thr-team-card__photo-placeholder"><i class="fas fa-user-circle"></i></div>
                </div>
                <h3 class="thr-team-card__name">Maame Ama Boateng</h3>
                <p class="thr-team-card__title">Senior Post-Partum Specialist</p>
                <p class="thr-team-card__bio">Maame is our dedicated post-partum care expert with a background in maternal wellness and physical rehabilitation. She has guided over 200 mothers through their post-birth recovery journeys, specializing in both C-section and natural birth aftercare protocols.</p>
            </div>
            <div class="thr-team-card">
                <div class="thr-team-card__photo">
                    <div class="thr-team-card__photo-placeholder"><i class="fas fa-user-circle"></i></div>
                </div>
                <h3 class="thr-team-card__name">Kweku Asiedu</h3>
                <p class="thr-team-card__title">Body Contouring & Rejuvenation Therapist</p>
                <p class="thr-team-card__bio">Kweku brings a unique male perspective to our rejuvenation and body treatment services. Certified in advanced body contouring, skin tightening, and male wellness therapies, he ensures that all clients — regardless of gender — receive expert, personalized care.</p>
            </div>
        </div>
    </div>
</section>

{{-- Certifications --}}
<section class="thr-section thr-section--dark">
    <div class="thr-container">
        <div class="thr-section-header thr-section-header--light">
            <p class="thr-section-header__eyebrow">Our Credentials</p>
            <h2 class="thr-section-header__title">Certifications & Accreditations</h2>
        </div>
        <div class="thr-certs-strip">
            <div class="thr-cert-badge"><i class="fas fa-certificate"></i> Certified Aesthetic Practitioners</div>
            <div class="thr-cert-badge"><i class="fas fa-shield-alt"></i> Ghana Health Service Registered</div>
            <div class="thr-cert-badge"><i class="fas fa-star"></i> International Aesthetics Federation Member</div>
            <div class="thr-cert-badge"><i class="fas fa-leaf"></i> Organic & Safe-Product Certified</div>
            <div class="thr-cert-badge"><i class="fas fa-graduation-cap"></i> Continuing Education Certified</div>
        </div>
    </div>
</section>

{{-- Values --}}
<section class="thr-section thr-section--light">
    <div class="thr-container">
        <div class="thr-section-header">
            <p class="thr-section-header__eyebrow">What We Stand For</p>
            <h2 class="thr-section-header__title">Our Core Values</h2>
        </div>
        <div class="thr-values-grid">
            <div class="thr-value-item">
                <div class="thr-value-item__num">01</div>
                <h3>Compassion First</h3>
                <p>Every client who walks through our doors is treated with warmth, empathy, and respect — no judgment, ever.</p>
            </div>
            <div class="thr-value-item">
                <div class="thr-value-item__num">02</div>
                <h3>Evidence-Based Excellence</h3>
                <p>We only use treatments backed by science. Our protocols are continuously updated with the latest in aesthetic medicine.</p>
            </div>
            <div class="thr-value-item">
                <div class="thr-value-item__num">03</div>
                <h3>Radical Transparency</h3>
                <p>We tell you exactly what to expect, what's in our products, and what results are realistic — always honest, always clear.</p>
            </div>
            <div class="thr-value-item">
                <div class="thr-value-item__num">04</div>
                <h3>Inclusive Beauty</h3>
                <p>Beauty and wellness have no one face. We celebrate and serve all skin tones, body types, genders, and backgrounds.</p>
            </div>
        </div>
    </div>
</section>

<section class="thr-cta-banner">
    <div class="thr-cta-banner__content">
        <h2 class="thr-cta-banner__title">Ready to Begin Your Journey?</h2>
        <p class="thr-cta-banner__sub">Book a consultation and let our team create a personalized treatment plan for you.</p>
        <a href="{{ route('booking') }}" class="btn btn-white btn-lg">
            <i class="fas fa-calendar-plus"></i> Book Now
        </a>
    </div>
</section>

@endsection
