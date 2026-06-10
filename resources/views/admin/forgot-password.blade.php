<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password – The Healing Room</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css'])
</head>
<body class="admin-login-body">
    <div class="admin-login-wrap">
        <div class="admin-login-card">
            <div class="admin-login-card__brand">
                <span>🌿</span>
                <div>
                    <div class="admin-login-card__brand-main">The Healing Room</div>
                    <div class="admin-login-card__brand-sub">Admin Panel</div>
                </div>
            </div>

            <h2 class="admin-login-card__title">Forgot Password</h2>
            <p class="admin-login-card__sub">Enter your admin email and we'll send a 6-digit reset code.</p>

            @if(session('success'))
            <div class="admin-flash admin-flash--success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div class="admin-flash admin-flash--error">
                <i class="fas fa-exclamation-circle"></i>
                @foreach($errors->all() as $error) {{ $error }} @endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}" class="admin-login-form">
                @csrf
                <div class="thr-form__group">
                    <label>Email Address</label>
                    <div class="thr-input-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="admin@thehealingroom.com" autocomplete="email">
                    </div>
                </div>
                <button type="submit" class="btn btn-gold btn-full">
                    <i class="fas fa-paper-plane"></i> Send Reset Code
                </button>
            </form>

            <div class="admin-login-card__back">
                <a href="{{ route('admin.login') }}"><i class="fas fa-arrow-left"></i> Back to login</a>
            </div>
        </div>
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>
