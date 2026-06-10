<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password – The Healing Room</title>
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

            <h2 class="admin-login-card__title">Reset Password</h2>
            <p class="admin-login-card__sub">Enter the 6-digit code sent to your email and choose a new password.</p>

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

            <form method="POST" action="{{ route('admin.password.update') }}" class="admin-login-form">
                @csrf
                <div class="thr-form__group">
                    <label>Email Address</label>
                    <div class="thr-input-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email', $email) }}" required
                               placeholder="admin@thehealingroom.com" autocomplete="email">
                    </div>
                </div>
                <div class="thr-form__group">
                    <label>6-Digit Reset Code</label>
                    <div class="thr-input-icon">
                        <i class="fas fa-key"></i>
                        <input type="text" name="code" required maxlength="6" pattern="[0-9]{6}"
                               placeholder="123456" inputmode="numeric" autocomplete="one-time-code">
                    </div>
                </div>
                <div class="thr-form__group">
                    <label>New Password</label>
                    <div class="thr-input-icon thr-input-icon--pass">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" required placeholder="••••••••" minlength="8">
                    </div>
                </div>
                <div class="thr-form__group">
                    <label>Confirm New Password</label>
                    <div class="thr-input-icon thr-input-icon--pass">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password_confirmation" required placeholder="••••••••" minlength="8">
                    </div>
                </div>
                <button type="submit" class="btn btn-gold btn-full">
                    <i class="fas fa-check-circle"></i> Reset Password
                </button>
            </form>

            <div class="admin-login-card__back">
                <a href="{{ route('admin.login') }}"><i class="fas fa-arrow-left"></i> Back to login</a>
                &nbsp;·&nbsp;
                <a href="{{ route('admin.password.request') }}">Resend code</a>
            </div>
        </div>
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>
