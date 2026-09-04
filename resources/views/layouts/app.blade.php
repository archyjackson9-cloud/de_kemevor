<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'The Healing Room – Advanced Esthetic Clinic. Restore and Maintain Your Confidence. Premium wellness & aesthetic treatments in Ghana.')">
    <link rel="canonical" href="@yield('canonical', url()->current())">
    <title>@yield('title', 'The Healing Room | Esthetic Clinic')</title>

    {{-- Open Graph / Social --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    @hasSection('og_title')
    <meta property="og:title" content="@yield('og_title')">
    @else
    <meta property="og:title" content="@yield('title', 'The Healing Room | Aesthetic Clinic')">
    @endif
    @hasSection('og_description')
    <meta property="og:description" content="@yield('og_description')">
    @else
    <meta property="og:description" content="@yield('meta_description', 'The Healing Room – Advanced Esthetic Clinic. Restore and Maintain Your Confidence.')">
    @endif
    <meta property="og:url" content="@yield('canonical', url()->current())">
    @hasSection('og_image')
    <meta property="og:image" content="@yield('og_image')">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    @stack('schema')
</head>
<body class="antialiased">

{{-- Navigation --}}
<nav class="thr-nav" id="mainNav">
    <div class="thr-nav__container">
        <a href="{{ route('home') }}" class="thr-nav__brand">
            @if($siteLogo = \App\Models\SiteSetting::get('site_logo'))
            <img src="{{ asset('storage/'.$siteLogo) }}" alt="The Healing Room" class="thr-nav__brand-logo">
             <span class="thr-nav__brand-main">The Healing Room |</span>
                <span class="thr-nav__brand-sub">Esthetic Clinic</span>
         
            @endif
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
                    @if($siteLogo)
                    <img src="{{ asset('storage/'.$siteLogo) }}" alt="The Healing Room" class="thr-footer__logo-img">
                    @else
                    <span>🌿</span>
                    <div>
                        <div class="thr-footer__logo-main">The Healing Room</div>
                        <div class="thr-footer__logo-sub">Esthetic Clinic</div>
                    </div>
                    @endif
                </div>
                <p class="thr-footer__tagline">Restore and Maintain Your Confidence.</p>
                <div class="thr-footer__social">
                    <a href="https://www.instagram.com/thehealing_room26?igsh=M3dodGxxYjFybzRi" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://vm.tiktok.com/ZS9ktYUVHgLrB-jCW5R/" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=61578467157568" target="_blank" title="Facebook"><i class="fab fa-facebook"></i></a>
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
                    <li><a href="{{ route('econsultation') }}">E-Consultation</a></li>
                </ul>
            </div>

            <div class="thr-footer__col">
                <h4>Treatments</h4>
                <ul>
                    <li><a href="{{ route('services') }}">Maternity & Post-Op Care</a></li>
                    <li><a href="{{ route('services') }}">Body Treatments</a></li>
                    <li><a href="{{ route('services') }}">Skin Treatments</a></li>
                    <li><a href="{{ route('services') }}">Rejuvenation</a></li>
                    <li><a href="{{ route('services') }}">Body Enhancement</a></li>
                </ul>
            </div>

            <div class="thr-footer__col">
                <h4>Contact Us</h4>
                <ul class="thr-footer__contact">
                    <li><i class="fas fa-phone"></i> <a href="tel:0597173323">0597173323</a></li>
                    <li><i class="fas fa-envelope"></i> <a href="mailto:info@thehealingrooms1.com">info@thehealingrooms1.com</a></li>
                    <li><i class="fas fa-globe"></i> <a href="https://www.thehealingrooms1.com">www.thehealingrooms1.com</a></li>
                    <li><i class="fas fa-map-marker-alt"> <a href="https://www.google.com/maps/place/The+Healing+Room/@5.6399814,-0.0602728,17z/data=!4m14!1m7!3m6!1s0xfdf8700418d0eaf:0xc9a843fe256cb2e8!2sThe+Healing+Room!8m2!3d5.6399814!4d-0.0576979!16s%2Fg%2F11zdt9xzxs!3m5!1s0xfdf8700418d0eaf:0xc9a843fe256cb2e8!8m2!3d5.6399814!4d-0.0576979!16s%2Fg%2F11zdt9xzxs?entry=ttu&g_ep=EgoyMDI2MDkwMS4wIKXMDSoASAFQAw%3D%3D"></i> Lashibi, Ghana</a></li>
                </ul>
                <div class="thr-footer__hours">
                    <h5>Business Hours</h5>
                    <p>Mon – Fri: 8:00 AM – 7:00 PM</p>
                    <p>Saturday: 9:00 AM – 5:00 PM</p>
                    
                </div>
            </div>
        </div>

        <div class="thr-footer__bottom">
            <p>&copy; {{ date('Y') }} The Healing Room Esthetic Clinic. All rights reserved.</p>
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
