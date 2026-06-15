@extends('layouts.app')
@section('title', 'E-Consultation | The Healing Room Aesthetic Clinic')

@section('content')

{{-- ── PAGE HERO ────────────────────────────────────────────────────── --}}
<section class="thr-page-hero">
    <div class="thr-page-hero__content">
        <p class="thr-page-hero__eyebrow">Online Consultation</p>
        <h1 class="thr-page-hero__title">E-Consultation</h1>
        <p class="thr-page-hero__sub">Describe your concern, attach a few photos, and one of our specialists will review your case and email you a personalized recommendation.</p>
    </div>
</section>

<section class="thr-section thr-section--light">
    <div class="thr-container" style="max-width:760px">

        @if(session('success'))
        <div class="thr-alert thr-alert--success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif
        @if($errors->any())
        <div class="thr-alert thr-alert--error">
            @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
        </div>
        @endif

        <div class="thr-contact-form-wrap">
            <h2 class="thr-contact-form-wrap__title">Tell Us About Your Concern</h2>
            <form method="POST" action="{{ route('econsultation.store') }}" class="thr-form" enctype="multipart/form-data">
                @csrf
                <div class="thr-form__row">
                    <div class="thr-form__group">
                        <label>Full Name <span class="req">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Abena Mensah">
                    </div>
                    <div class="thr-form__group">
                        <label>Email Address <span class="req">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="you@email.com">
                    </div>
                </div>
                <div class="thr-form__row">
                    <div class="thr-form__group">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="0244 000 000">
                    </div>
                    <div class="thr-form__group">
                        <label>Age</label>
                        <input type="number" name="age" value="{{ old('age') }}" min="0" max="120" placeholder="28">
                    </div>
                </div>
                <div class="thr-form__row">
                    <div class="thr-form__group">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Prefer not to say</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="thr-form__group">
                        <label>Area of Concern</label>
                        <select name="concern_area">
                            <option value="">Select an option</option>
                            <option value="maternity_postop" {{ old('concern_area') === 'maternity_postop' ? 'selected' : '' }}>Maternity & Post-Op Care</option>
                            <option value="body_treatments" {{ old('concern_area') === 'body_treatments' ? 'selected' : '' }}>Body Treatments</option>
                            <option value="skin_treatments" {{ old('concern_area') === 'skin_treatments' ? 'selected' : '' }}>Skin Treatments</option>
                            <option value="rejuvenation" {{ old('concern_area') === 'rejuvenation' ? 'selected' : '' }}>Rejuvenation</option>
                            <option value="other" {{ old('concern_area') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>
                <div class="thr-form__group">
                    <label>Describe Your Concern <span class="req">*</span></label>
                    <textarea name="problem_description" rows="6" required placeholder="Please describe your concern in as much detail as possible — when it started, any symptoms, and what you'd like help with.">{{ old('problem_description') }}</textarea>
                </div>
                <div class="thr-form__group">
                    <label>Attach Photos <span style="font-size:.8rem;color:#888">(optional, up to 5 images, 5MB each)</span></label>
                    <input type="file" name="images[]" id="econsultImages" accept="image/*" multiple>
                    <div class="thr-image-preview" id="econsultPreview"></div>
                </div>
                <p style="font-size:.8rem;color:#9d8e80;margin-bottom:1.25rem">
                    <i class="fas fa-lock"></i> Your information and images are kept confidential and only shared with our clinical team.
                </p>
                <button type="submit" class="btn btn-gold btn-full">
                    <i class="fas fa-paper-plane"></i> Submit Consultation
                </button>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.getElementById('econsultImages')?.addEventListener('change', function (e) {
    const preview = document.getElementById('econsultPreview');
    preview.innerHTML = '';
    Array.from(e.target.files).slice(0, 5).forEach(file => {
        if (!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = ev => {
            const img = document.createElement('img');
            img.src = ev.target.result;
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
