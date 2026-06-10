<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#faf7f4; padding:2rem; color:#3d2e1e; margin:0;">
    <div style="max-width:480px;margin:0 auto;background:#ffffff;border-radius:12px;padding:2rem;border:1px solid #e8ddd0">
        <h2 style="color:#c8972b;margin-top:0">The Healing Room — Admin Panel</h2>
        <p>You requested to reset your admin password. Use the code below to continue:</p>
        <div style="font-size:2rem;font-weight:700;letter-spacing:.3em;text-align:center;background:#fdf6e9;border-radius:8px;padding:1rem;margin:1.5rem 0;color:#9a7220">
            {{ $code }}
        </div>
        <p>This code will expire in <strong>15 minutes</strong>.</p>
        <p style="color:#9d8e80;font-size:.85rem">If you did not request a password reset, you can safely ignore this email.</p>
    </div>
</body>
</html>
