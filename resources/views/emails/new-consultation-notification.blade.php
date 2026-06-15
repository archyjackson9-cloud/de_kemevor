<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#faf7f4; padding:2rem; color:#3d2e1e; margin:0;">
    <div style="max-width:560px;margin:0 auto;background:#ffffff;border-radius:12px;padding:2rem;border:1px solid #e8ddd0">
        <h2 style="color:#c8972b;margin-top:0">New E-Consultation Request</h2>
        <p>A new e-consultation request has been submitted and is awaiting review.</p>

        <div style="background:#fdf6e9;border-radius:8px;padding:1.25rem;margin:1.5rem 0">
            <p style="margin:.25rem 0"><strong>Reference:</strong> {{ $consultation->reference_number }}</p>
            <p style="margin:.25rem 0"><strong>Name:</strong> {{ $consultation->name }}</p>
            <p style="margin:.25rem 0"><strong>Email:</strong> {{ $consultation->email }}</p>
            @if($consultation->phone)<p style="margin:.25rem 0"><strong>Phone:</strong> {{ $consultation->phone }}</p>@endif
            <p style="margin:.25rem 0"><strong>Concern Area:</strong> {{ $consultation->concern_area_label }}</p>
        </div>

        <p style="white-space:pre-line">{{ $consultation->problem_description }}</p>

        <p style="margin-top:1.5rem">
            <a href="{{ route('admin.consultations.show', $consultation) }}" style="background:#c8972b;color:#fff;text-decoration:none;padding:.7rem 1.4rem;border-radius:6px;font-weight:600;display:inline-block">
                View &amp; Respond
            </a>
        </p>
    </div>
</body>
</html>
