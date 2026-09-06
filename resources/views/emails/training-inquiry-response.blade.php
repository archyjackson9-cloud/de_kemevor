<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#faf7f4; padding:2rem; color:#3d2e1e; margin:0;">
    <div style="max-width:560px;margin:0 auto;background:#ffffff;border-radius:12px;padding:2rem;border:1px solid #e8ddd0">
        <h2 style="color:#c8972b;margin-top:0">The Healing Room — Esthetic Training Program</h2>
        <p>Dear {{ $inquiry->name }},</p>
        <p>Thank you for your interest in our Esthetic Training Program (Reference <strong>{{ $inquiry->reference_number }}</strong>). Here's our response to your enquiry:</p>

        <div style="background:#fdf6e9;border-left:4px solid #c8972b;border-radius:8px;padding:1.25rem;margin:1.5rem 0;white-space:pre-line">
            {{ $inquiry->admin_response }}
        </div>

        <p style="color:#9d8e80;font-size:.85rem">If you have further questions, please reply to this email or contact us directly.</p>

        @if($inquiry->message)
        <hr style="border:none;border-top:1px solid #e8ddd0;margin:1.5rem 0">
        <p style="font-size:.85rem;color:#6b5a4a"><strong>Your original message:</strong><br>{{ $inquiry->message }}</p>
        @endif
    </div>
</body>
</html>
