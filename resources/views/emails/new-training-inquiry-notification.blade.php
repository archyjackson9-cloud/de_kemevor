<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; background:#faf7f4; padding:2rem; color:#3d2e1e; margin:0;">
    <div style="max-width:560px;margin:0 auto;background:#ffffff;border-radius:12px;padding:2rem;border:1px solid #e8ddd0">
        <h2 style="color:#c8972b;margin-top:0">New Training Enrollment Inquiry</h2>
        <p>A new Esthetic Training Program inquiry has been submitted and is awaiting review.</p>

        <div style="background:#fdf6e9;border-radius:8px;padding:1.25rem;margin:1.5rem 0">
            <p style="margin:.25rem 0"><strong>Reference:</strong> {{ $inquiry->reference_number }}</p>
            <p style="margin:.25rem 0"><strong>Name:</strong> {{ $inquiry->name }}</p>
            <p style="margin:.25rem 0"><strong>Email:</strong> {{ $inquiry->email }}</p>
            @if($inquiry->phone)<p style="margin:.25rem 0"><strong>Phone:</strong> {{ $inquiry->phone }}</p>@endif
            @if($inquiry->phase_interest)<p style="margin:.25rem 0"><strong>Interested Phase:</strong> {{ $inquiry->phase_interest }}</p>@endif
        </div>

        @if($inquiry->message)
        <p style="white-space:pre-line">{{ $inquiry->message }}</p>
        @endif

        <p style="margin-top:1.5rem">
            <a href="{{ route('admin.training-inquiries.show', $inquiry) }}" style="background:#c8972b;color:#fff;text-decoration:none;padding:.7rem 1.4rem;border-radius:6px;font-weight:600;display:inline-block">
                View &amp; Respond
            </a>
        </p>
    </div>
</body>
</html>
