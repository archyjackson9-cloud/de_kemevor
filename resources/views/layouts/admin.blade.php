<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') – The Healing Room</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="admin-body">

<div class="admin-layout">
    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar__brand">
            <span>🌿</span>
            <div>
                <div class="admin-sidebar__brand-main">The Healing Room</div>
                <div class="admin-sidebar__brand-sub">Admin Panel</div>
            </div>
        </div>

        <nav class="admin-sidebar__nav">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard*') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.bookings') }}" class="admin-nav-item {{ request()->routeIs('admin.bookings*') ? 'active' : '' }}">
                <i class="fas fa-calendar-check"></i> <span>Bookings</span>
            </a>
            <a href="{{ route('admin.customers') }}" class="admin-nav-item {{ request()->routeIs('admin.customers*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> <span>Customers</span>
            </a>
            <a href="{{ route('admin.services') }}" class="admin-nav-item {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
                <i class="fas fa-spa"></i> <span>Services</span>
            </a>
            <a href="{{ route('admin.discounts') }}" class="admin-nav-item {{ request()->routeIs('admin.discounts*') ? 'active' : '' }}">
                <i class="fas fa-tags"></i> <span>Discounts</span>
            </a>
            <a href="{{ route('admin.reminders') }}" class="admin-nav-item {{ request()->routeIs('admin.reminders*') ? 'active' : '' }}">
                <i class="fas fa-bell"></i> <span>Reminders</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="admin-nav-item {{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> <span>Reports</span>
            </a>
            <a href="{{ route('admin.team') }}" class="admin-nav-item {{ request()->routeIs('admin.team*') ? 'active' : '' }}">
                <i class="fas fa-user-friends"></i> <span>Team Members</span>
            </a>
            <a href="{{ route('admin.partners') }}" class="admin-nav-item {{ request()->routeIs('admin.partners*') ? 'active' : '' }}">
                <i class="fas fa-handshake"></i> <span>Partners</span>
            </a>
            <a href="{{ route('admin.pages.about') }}" class="admin-nav-item {{ request()->routeIs('admin.pages*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> <span>Pages</span>
            </a>
        </nav>

        <div class="admin-sidebar__footer">
            <a href="{{ route('home') }}" class="admin-nav-item" target="_blank">
                <i class="fas fa-external-link-alt"></i> <span>View Site</span>
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="admin-nav-item admin-nav-item--logout w-full">
                    <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="admin-main">
        <header class="admin-header">
            <button class="admin-header__toggle" id="sidebarToggle" aria-label="Toggle sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <div class="admin-header__title">@yield('page-title', 'Dashboard')</div>
            <div class="admin-header__meta">
                <span class="admin-header__date"><i class="fas fa-calendar"></i> {{ now()->format('D, M j Y') }}</span>
                <span class="admin-header__user"><i class="fas fa-user-circle"></i> Administrator</span>
            </div>
        </header>

        {{-- Flash --}}
        @if(session('success'))
        <div class="admin-flash admin-flash--success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button onclick="this.parentElement.remove()">×</button>
        </div>
        @endif
        @if(session('error'))
        <div class="admin-flash admin-flash--error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button onclick="this.parentElement.remove()">×</button>
        </div>
        @endif
        @if($errors->any())
        <div class="admin-flash admin-flash--error">
            <i class="fas fa-exclamation-circle"></i>
            @foreach($errors->all() as $error) {{ $error }} @endforeach
            <button onclick="this.parentElement.remove()">×</button>
        </div>
        @endif

        <div class="admin-content">
            @yield('content')
        </div>
    </div>
</div>

<script>
document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.getElementById('adminSidebar').classList.toggle('open');
});
</script>
@stack('scripts')
</body>
</html>
