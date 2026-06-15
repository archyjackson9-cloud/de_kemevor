<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="The Healing Room – Advanced Aesthetic Clinic. Restore and Maintain Your Confidence. Premium wellness & aesthetic treatments in Ghana.">
    <title>@yield('title', 'The Healing Room | Aesthetic Clinic')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="antialiased">

{{-- Navigation --}}
<nav class="thr-nav" id="mainNav">
    <div class="thr-nav__container">
        <a href="{{ route('home') }}" class="thr-nav__brand">
            <span class="thr-nav__brand-icon">🌿</span>
            <span class="thr-nav__brand-text">
                <span class="thr-nav__brand-main">The Healing Room</span>
                <span class="thr-nav__brand-sub">Aesthetic Clinic</span>
            </span>
        </a>

        <button class="thr-nav__toggle" id="navToggle" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>

        <ul class="thr-nav__links" id="navLinks">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('services') }}" class="{{ request()->routeIs('services') ? 'active' : '' }}">Services</a></li>
            <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
            <li><a href="{{ route('econsultation') }}" class="{{ request()->routeIs('econsultation*') ? 'active' : '' }}">E-Consultation</a></li>
            <li><a href="{{ route('booking') }}" class="thr-nav__cta {{ request()->routeIs('booking*') ? 'active' : '' }}">Book Now</a></li>
        </ul>
    </div>
</nav>

{{-- Flash Messages --}}
@if(session('success'))
<div class="thr-flash thr-flash--success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button class="thr-flash__close" onclick="this.parentElement.remove()">×</button>
</div>
@endif
@if(session('error'))
<div class="thr-flash thr-flash--error">
    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    <button class="thr-flash__close" onclick="this.parentElement.remove()">×</button>
</div>
@endif

<main>
    @yield('content')
</main>

{{-- Footer --}}
<footer class="thr-footer">
    <div class="thr-footer__container">
        <div class="thr-footer__grid">
            <div class="thr-footer__brand">
                <div class="thr-footer__logo">
                    <span>🌿</span>
                    <div>
                        <div class="thr-footer__logo-main">The Healing Room</div>
                        <div class="thr-footer__logo-sub">Aesthetic Clinic</div>
                    </div>
                </div>
                <p class="thr-footer__tagline">Restore and Maintain Your Confidence.</p>
                <div class="thr-footer__social">
                    <a href="https://instagram.com/thehealing_room26" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://tiktok.com/@thehealing_room26" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="https://facebook.com/thehealing_room" target="_blank" title="Facebook"><i class="fab fa-facebook"></i></a>
                    <a href="https://snapchat.com/add/thehealingroom2" target="_blank" title="Snapchat"><i class="fab fa-snapchat"></i></a>
                </div>
            </div>

            <div class="thr-footer__col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('services') }}">Services</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('booking') }}">Book Appointment</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <div class="thr-footer__col">
                <h4>Treatments</h4>
                <ul>
                    <li><a href="{{ route('services') }}">Maternity & Post-Op Care</a></li>
                    <li><a href="{{ route('services') }}">Body Treatments</a></li>
                    <li><a href="{{ route('services') }}">Skin Treatments</a></li>
                    <li><a href="{{ route('services') }}">Rejuvenation</a></li>
                </ul>
            </div>

            <div class="thr-footer__col">
                <h4>Contact Us</h4>
                <ul class="thr-footer__contact">
                    <li><i class="fas fa-phone"></i> <a href="tel:0597173323">0597173323</a></li>
                    <li><i class="fas fa-envelope"></i> <a href="mailto:hello@thehealingroom.com">hello@thehealingroom.com</a></li>
                    <li><i class="fas fa-globe"></i> <a href="https://www.thehealingroom.com">www.thehealingroom.com</a></li>
                    <li><i class="fas fa-map-marker-alt"></i> Accra, Ghana</li>
                </ul>
                <div class="thr-footer__hours">
                    <h5>Business Hours</h5>
                    <p>Mon – Fri: 8:00 AM – 7:00 PM</p>
                    <p>Saturday: 9:00 AM – 5:00 PM</p>
                    <p>Sunday: 10:00 AM – 3:00 PM</p>
                </div>
            </div>
        </div>

        <div class="thr-footer__bottom">
            <p>&copy; {{ date('Y') }} The Healing Room Aesthetic Clinic. All rights reserved.</p>
            <p>Made with <span style="color:#c8972b">♥</span> in Ghana</p>
        </div>
    </div>
</footer>

<script>
// Mobile nav toggle
document.getElementById('navToggle')?.addEventListener('click', function() {
    document.getElementById('navLinks').classList.toggle('open');
    this.classList.toggle('active');
});
// Sticky nav
window.addEventListener('scroll', function() {
    const nav = document.getElementById('mainNav');
    if (window.scrollY > 50) {
        nav.classList.add('scrolled');
    } else {
        nav.classList.remove('scrolled');
    }
});
</script>
@stack('scripts')
</body>
</html>
