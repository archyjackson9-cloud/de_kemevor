@extends('layouts.admin')
@section('title', 'Contact Page')
@section('page-title', 'Contact Page Settings')

@section('content')

<div style="display:flex;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <a href="{{ route('admin.pages.about') }}" class="btn btn-outline btn-sm">
        <i class="fas fa-info-circle"></i> About Page
    </a>
    <a href="{{ route('admin.pages.contact') }}" class="btn btn-gold btn-sm">
        <i class="fas fa-envelope"></i> Contact Page
    </a>
    <a href="{{ route('contact') }}" target="_blank" class="btn btn-outline btn-sm">
        <i class="fas fa-external-link-alt"></i> Preview Page
    </a>
</div>

<form method="POST" action="{{ route('admin.pages.contact.update') }}" enctype="multipart/form-data">
@csrf

{{-- ── Hero Settings ─────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-image"></i> Hero Section</h3>
        <span style="font-size:13px;color:#888">The banner at the top of the Contact page.</span>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="contact_hero_eyebrow" value="{{ $s->get('contact_hero_eyebrow', "We're Here For You") }}" placeholder="We're Here For You">
        </div>
        <div class="thr-form__group">
            <label>Hero Title</label>
            <input type="text" name="contact_hero_title" value="{{ $s->get('contact_hero_title','Get In Touch') }}" placeholder="Get In Touch">
        </div>
        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Subtitle</label>
            <input type="text" name="contact_hero_sub" value="{{ $s->get('contact_hero_sub','Questions? We\'d love to hear from you.') }}" placeholder="Short subtitle...">
        </div>

        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Hero Background</label>
            <div style="display:flex;gap:1.5rem;margin-top:.5rem;align-items:center;flex-wrap:wrap">
                <label style="display:flex;align-items:center;gap:.5rem;font-weight:400;cursor:pointer">
                    <input type="radio" name="contact_hero_type" value="none" {{ !$s->get('contact_hero_type') || $s->get('contact_hero_type') === 'none' ? 'checked' : '' }}>
                    Default Gradient
                </label>
                <label style="display:flex;align-items:center;gap:.5rem;font-weight:400;cursor:pointer">
                    <input type="radio" name="contact_hero_type" value="image" {{ $s->get('contact_hero_type') === 'image' ? 'checked' : '' }}>
                    Image
                </label>
                <label style="display:flex;align-items:center;gap:.5rem;font-weight:400;cursor:pointer">
                    <input type="radio" name="contact_hero_type" value="video" {{ $s->get('contact_hero_type') === 'video' ? 'checked' : '' }}>
                    Video
                </label>
            </div>
            <p class="admin-setting-hint">Choose "Image" or "Video" to upload custom background media.</p>
        </div>

        <div class="thr-form__group" style="grid-column:1/-1">
            @if($s->get('contact_hero_media'))
            <div style="margin-bottom:.75rem;padding:.75rem;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;display:flex;align-items:center;gap:1rem">
                @if($s->get('contact_hero_type') === 'video')
                <video src="{{ asset('storage/'.$s->get('contact_hero_media')) }}" style="height:60px;border-radius:4px" muted></video>
                @else
                <img src="{{ asset('storage/'.$s->get('contact_hero_media')) }}" style="height:60px;border-radius:4px;object-fit:cover;max-width:120px" alt="Hero">
                @endif
                <div>
                    <div style="font-size:13px;font-weight:600">Current {{ $s->get('contact_hero_type') === 'video' ? 'Video' : 'Image' }}</div>
                    <label style="display:flex;align-items:center;gap:.4rem;margin-top:.3rem;font-size:12px;cursor:pointer;color:#dc2626;font-weight:400">
                        <input type="checkbox" name="contact_remove_media" value="1"> Remove current media
                    </label>
                </div>
            </div>
            @endif
            <label>Upload New Media <span style="font-size:12px;color:#888">(Image: JPG/PNG/WebP · Video: MP4/WebM · Max 50 MB)</span></label>
            <input type="file" name="contact_hero_media" accept="image/jpeg,image/png,image/jpg,image/webp,video/mp4,video/webm" class="admin-file-input">
        </div>
    </div>
</div>

{{-- ── Contact Info ──────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-address-card"></i> Contact Information</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label><i class="fas fa-phone" style="color:var(--gold)"></i> Phone / WhatsApp</label>
            <input type="text" name="contact_phone" value="{{ $s->get('contact_phone','0597173323') }}" placeholder="0597173323">
        </div>
        <div class="thr-form__group">
            <label><i class="fas fa-globe" style="color:var(--gold)"></i> Website URL</label>
            <input type="url" name="contact_website" value="{{ $s->get('contact_website') }}" placeholder="https://www.thehealingroom.com">
        </div>
        <div class="thr-form__group">
            <label><i class="fas fa-map-marker-alt" style="color:var(--gold)"></i> Location</label>
            <input type="text" name="contact_location" value="{{ $s->get('contact_location','Accra, Ghana') }}" placeholder="Accra, Ghana">
        </div>
        <div class="thr-form__group">
            <label><i class="fas fa-clock" style="color:var(--gold)"></i> Business Hours <span style="font-size:12px;color:#888">(use line breaks)</span></label>
            <textarea name="contact_hours" rows="3" placeholder="Mon – Fri: 8:00 AM – 7:00 PM&#10;Saturday: 9:00 AM – 5:00 PM&#10;Sunday: 10:00 AM – 3:00 PM">{{ $s->get('contact_hours') }}</textarea>
        </div>
    </div>
</div>

{{-- ── Social Media ─────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-share-alt"></i> Social Media Links</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label><i class="fab fa-instagram" style="color:#E1306C"></i> Instagram Handle</label>
            <input type="text" name="contact_ig_handle" value="{{ $s->get('contact_ig_handle','@thehealing_room26') }}" placeholder="@thehealing_room26">
        </div>
        <div class="thr-form__group">
            <label><i class="fab fa-instagram" style="color:#E1306C"></i> Instagram URL</label>
            <input type="url" name="contact_ig_url" value="{{ $s->get('contact_ig_url') }}" placeholder="https://instagram.com/thehealing_room26">
        </div>
        <div class="thr-form__group">
            <label><i class="fab fa-tiktok"></i> TikTok Handle</label>
            <input type="text" name="contact_tt_handle" value="{{ $s->get('contact_tt_handle','@thehealing_room26') }}" placeholder="@thehealing_room26">
        </div>
        <div class="thr-form__group">
            <label><i class="fab fa-tiktok"></i> TikTok URL</label>
            <input type="url" name="contact_tt_url" value="{{ $s->get('contact_tt_url') }}" placeholder="https://tiktok.com/@thehealing_room26">
        </div>
        <div class="thr-form__group">
            <label><i class="fab fa-facebook" style="color:#1877F2"></i> Facebook Handle</label>
            <input type="text" name="contact_fb_handle" value="{{ $s->get('contact_fb_handle','@thehealing_room') }}" placeholder="@thehealing_room">
        </div>
        <div class="thr-form__group">
            <label><i class="fab fa-facebook" style="color:#1877F2"></i> Facebook URL</label>
            <input type="url" name="contact_fb_url" value="{{ $s->get('contact_fb_url') }}" placeholder="https://facebook.com/thehealing_room">
        </div>
        <div class="thr-form__group">
            <label><i class="fab fa-snapchat" style="color:#FFFC00"></i> Snapchat Handle</label>
            <input type="text" name="contact_sc_handle" value="{{ $s->get('contact_sc_handle','@thehealingroom2') }}" placeholder="@thehealingroom2">
        </div>
        <div class="thr-form__group">
            <label><i class="fab fa-snapchat" style="color:#FFFC00"></i> Snapchat URL</label>
            <input type="url" name="contact_sc_url" value="{{ $s->get('contact_sc_url') }}" placeholder="https://snapchat.com/add/thehealingroom2">
        </div>
    </div>
</div>

{{-- ── Map Embed ─────────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-map-marked-alt"></i> Google Maps Embed</h3>
    </div>
    <div style="padding:1.5rem">
        <div class="thr-form__group">
            <label>Embed Code <span style="font-size:12px;color:#888">(paste the full &lt;iframe&gt; from Google Maps "Share → Embed a map")</span></label>
            <textarea name="contact_map_embed" rows="5" placeholder='&lt;iframe src="https://www.google.com/maps/embed?pb=..." ...&gt;&lt;/iframe&gt;'>{{ $s->get('contact_map_embed') }}</textarea>
        </div>
        @if($s->get('contact_map_embed'))
        <div style="margin-top:1rem;border:1px solid #e5e7eb;border-radius:8px;overflow:hidden;max-height:300px">
            {!! $s->get('contact_map_embed') !!}
        </div>
        @endif
    </div>
</div>

<div style="display:flex;justify-content:flex-end;margin-bottom:2rem">
    <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Save All Contact Page Settings</button>
</div>

</form>

@endsection
