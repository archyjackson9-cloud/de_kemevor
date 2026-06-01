<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – The Healing Room</title>
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

            <h2 class="admin-login-card__title">Sign In</h2>
            <p class="admin-login-card__sub">Access the clinic management dashboard.</p>

            @if(session('success'))
            <div class="admin-flash admin-flash--success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="admin-flash admin-flash--error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="admin-login-form">
                @csrf
                <div class="thr-form__group">
                    <label>Email Address</label>
                    <div class="thr-input-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="admin@thehealingroom.com" autocomplete="email">
                    </div>
                    @error('email')<p class="thr-form__error">{{ $message }}</p>@enderror
                </div>
                <div class="thr-form__group">
                    <label>Password</label>
                    <div class="thr-input-icon thr-input-icon--pass">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" required placeholder="••••••••" id="loginPass">
                        <button type="button" class="thr-pass-toggle" onclick="togglePass()">
                            <i class="fas fa-eye" id="passIcon"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-gold btn-full">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>

            <div class="admin-login-card__back">
                <a href="{{ route('home') }}"><i class="fas fa-arrow-left"></i> Back to website</a>
            </div>
        </div>
    </div>
    @vite(['resources/js/app.js'])
    <script>
    function togglePass() {
        const inp = document.getElementById('loginPass');
        const ico = document.getElementById('passIcon');
        if (inp.type === 'password') { inp.type = 'text'; ico.classList.replace('fa-eye','fa-eye-slash'); }
        else { inp.type = 'password'; ico.classList.replace('fa-eye-slash','fa-eye'); }
    }
    </script>
</body>
</html>
