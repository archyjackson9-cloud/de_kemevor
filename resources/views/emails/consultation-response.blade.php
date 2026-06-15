<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#faf7f4; padding:2rem; color:#3d2e1e; margin:0;">
    <div style="max-width:560px;margin:0 auto;background:#ffffff;border-radius:12px;padding:2rem;border:1px solid #e8ddd0">
        <h2 style="color:#c8972b;margin-top:0">The Healing Room — E-Consultation</h2>
        <p>Dear {{ $consultation->name }},</p>
        <p>Thank you for submitting your e-consultation request (Reference <strong>{{ $consultation->reference_number }}</strong>). One of our specialists has reviewed your case and provided the following response:</p>

        <div style="background:#fdf6e9;border-left:4px solid #c8972b;border-radius:8px;padding:1.25rem;margin:1.5rem 0;white-space:pre-line">
            {{ $consultation->admin_response }}
        </div>

        <p style="color:#9d8e80;font-size:.85rem">This recommendation is provided based on the information and images you submitted. If you have further questions or your condition changes, please reply to this email or contact us directly.</p>

        <hr style="border:none;border-top:1px solid #e8ddd0;margin:1.5rem 0">
        <p style="font-size:.85rem;color:#6b5a4a"><strong>Your original concern:</strong><br>{{ $consultation->problem_description }}</p>
    </div>
</body>
</html>
