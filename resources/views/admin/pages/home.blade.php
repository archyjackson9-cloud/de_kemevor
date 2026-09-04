@extends('layouts.admin')
@section('title', 'Home Page')
@section('page-title', 'Home Page Settings')

@section('content')

<div style="display:flex;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <a href="{{ route('admin.pages.home') }}" class="btn btn-gold btn-sm">
        <i class="fas fa-house"></i> Home Page
    </a>
    <a href="{{ route('admin.pages.about') }}" class="btn btn-outline btn-sm">
        <i class="fas fa-info-circle"></i> About Page
    </a>
    <a href="{{ route('admin.pages.contact') }}" class="btn btn-outline btn-sm">
        <i class="fas fa-envelope"></i> Contact Page
    </a>
    <a href="{{ route('home') }}" target="_blank" class="btn btn-outline btn-sm">
        <i class="fas fa-external-link-alt"></i> Preview Page
    </a>
</div>

<div class="admin-card" style="margin-bottom:1.5rem;background:#f9fafb">
    <div style="padding:1rem 1.5rem;font-size:13px;color:#555;display:flex;align-items:center;gap:.6rem">
        <i class="fas fa-circle-info" style="color:var(--gold)"></i>
        The hero slider (top banner) has its own dedicated section — manage it under
        <a href="{{ route('admin.hero-slides') }}" style="color:var(--gold);font-weight:600">Hero Slider</a>.
        Instagram handle/URL and phone number are shared with the
        <a href="{{ route('admin.pages.contact') }}" style="color:var(--gold);font-weight:600">Contact Page</a> settings.
    </div>
</div>

<form method="POST" action="{{ route('admin.pages.home.update') }}" enctype="multipart/form-data">
@csrf

{{-- ── Story Teaser ─────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-book-open"></i> Story Teaser Section</h3>
        <span style="font-size:13px;color:#888">The "Our Story" block beneath Featured Treatments.</span>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Section Eyebrow</label>
            <input type="text" name="home_story_eyebrow" value="{{ $s->get('home_story_eyebrow','Our Story') }}" placeholder="Our Story">
        </div>
        <div class="thr-form__group">
            <label>Section Title</label>
            <input type="text" name="home_story_title" value="{{ $s->get('home_story_title','A Sanctuary for Restoration & Confidence') }}" placeholder="A Sanctuary for Restoration & Confidence">
        </div>
        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Story Body <span style="font-size:12px;color:#888">(use blank lines to separate paragraphs)</span></label>
            <textarea name="home_story_body" rows="6" placeholder="Tell a short version of your clinic's story...">{{ $s->get('home_story_body', "The Healing Room was founded on a simple belief: every client deserves world-class aesthetic and wellness care, delivered with dignity, expertise, and genuine compassion — right here in Accra.\n\nFrom post-partum recovery to skin rejuvenation and body contouring, our specialists bring clinical expertise and a judgment-free environment to every session, so you always leave feeling seen, cared for, and confident.") }}</textarea>
        </div>

        <div class="thr-form__group">
            <label>Badge Number</label>
            <input type="text" name="home_story_badge_num" value="{{ $s->get('home_story_badge_num','3+') }}" placeholder="3+">
        </div>
        <div class="thr-form__group">
            <label>Badge Label</label>
            <input type="text" name="home_story_badge_label" value="{{ $s->get('home_story_badge_label','Years of Excellence') }}" placeholder="Years of Excellence">
        </div>

        <div class="thr-form__group" style="grid-column:1/-1">
            @if($s->get('home_story_media'))
            <div style="margin-bottom:.75rem;padding:.75rem;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;display:flex;align-items:center;gap:1rem">
                <img src="{{ asset('storage/'.$s->get('home_story_media')) }}" style="height:60px;border-radius:4px;object-fit:cover;max-width:120px" alt="Story photo">
                <div>
                    <div style="font-size:13px;font-weight:600">Current Story Photo (overrides team photo)</div>
                    <label style="display:flex;align-items:center;gap:.4rem;margin-top:.3rem;font-size:12px;cursor:pointer;color:#dc2626;font-weight:400">
                        <input type="checkbox" name="home_remove_story_media" value="1"> Remove — fall back to team photo
                    </label>
                </div>
            </div>
            @else
            <p class="admin-setting-hint" style="margin-bottom:.5rem">No custom photo set — currently showing the first active team member's photo automatically.</p>
            @endif
            <label>Upload Custom Story Photo <span style="font-size:12px;color:#888">(optional — JPG/PNG/WebP, max 50 MB)</span></label>
            <input type="file" name="home_story_media" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
        </div>
    </div>
</div>

{{-- ── Featured Services Header ───────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-spa"></i> Featured Treatments Header</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="home_services_eyebrow" value="{{ $s->get('home_services_eyebrow','What We Offer') }}" placeholder="What We Offer">
        </div>
        <div class="thr-form__group">
            <label>Section Title</label>
            <input type="text" name="home_services_title" value="{{ $s->get('home_services_title','Our Featured Treatments') }}" placeholder="Our Featured Treatments">
        </div>
        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Subtitle</label>
            <input type="text" name="home_services_sub" value="{{ $s->get('home_services_sub','Every treatment is personalized, evidence-based, and delivered with care.') }}" placeholder="Short subtitle...">
        </div>
    </div>
</div>

{{-- ── Why Choose Us Header ─────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-heart"></i> "Why Choose Us" Section</h3>
        <span style="font-size:13px;color:#888">Header text and the dark background photo behind the cards.</span>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="home_why_eyebrow" value="{{ $s->get('home_why_eyebrow','Why The Healing Room') }}" placeholder="Why The Healing Room">
        </div>
        <div class="thr-form__group">
            <label>Section Title</label>
            <input type="text" name="home_why_title" value="{{ $s->get('home_why_title','Excellence in Every Session') }}" placeholder="Excellence in Every Session">
        </div>

        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Background Photo</label>
            @if($s->get('home_why_backdrop'))
            <div style="margin-bottom:.75rem;padding:.75rem;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;display:flex;align-items:center;gap:1rem">
                <img src="{{ asset('storage/'.$s->get('home_why_backdrop')) }}" style="height:60px;border-radius:4px;object-fit:cover;max-width:120px" alt="Why Choose Us backdrop">
                <div>
                    <div style="font-size:13px;font-weight:600">Current Backdrop</div>
                    <label style="display:flex;align-items:center;gap:.4rem;margin-top:.3rem;font-size:12px;cursor:pointer;color:#dc2626;font-weight:400">
                        <input type="checkbox" name="home_remove_why_backdrop" value="1"> Remove — fall back to an auto-picked treatment photo
                    </label>
                </div>
            </div>
            @else
            <p class="admin-setting-hint" style="margin-bottom:.5rem">No custom backdrop set — currently showing a photo automatically picked from your Featured Treatments.</p>
            @endif
            <label>Upload New Backdrop <span style="font-size:12px;color:#888">(JPG/PNG/WebP, max 8 MB — a wide, darker photo works best)</span></label>
            <input type="file" name="home_why_backdrop" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
        </div>
    </div>
</div>

{{-- ── Gallery Header ───────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fab fa-instagram"></i> Gallery Section Header</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="home_gallery_eyebrow" value="{{ $s->get('home_gallery_eyebrow','Follow Our Journey') }}" placeholder="Follow Our Journey">
        </div>
        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Subtitle</label>
            <input type="text" name="home_gallery_sub" value="{{ $s->get('home_gallery_sub','A glimpse into our treatments and the space where your transformation happens.') }}" placeholder="Short subtitle...">
        </div>
        <p class="admin-setting-hint" style="grid-column:1/-1">The Instagram handle shown here is pulled from the Contact Page's social media settings.</p>
    </div>
</div>

{{-- ── CTA Banner ────────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-bullhorn"></i> CTA Banner</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>CTA Title</label>
            <input type="text" name="home_cta_title" value="{{ $s->get('home_cta_title','Ready to Feel Beautiful?') }}" placeholder="Ready to Feel Beautiful?">
        </div>
        <div class="thr-form__group">
            <label>CTA Subtitle</label>
            <input type="text" name="home_cta_sub" value="{{ $s->get('home_cta_sub','Book your session today and take the first step toward renewed confidence.') }}" placeholder="Book your session today...">
        </div>
        <p class="admin-setting-hint" style="grid-column:1/-1">The phone number shown here is pulled from the Contact Page's Phone / WhatsApp setting.</p>
    </div>
</div>

<div style="display:flex;justify-content:flex-end;margin-bottom:2rem">
    <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Save All Home Page Settings</button>
</div>

</form>

{{-- ── Why Choose Us Cards ──────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-star"></i> "Why Choose Us" Cards ({{ $homeValues->count() }})</h3>
        <button class="btn btn-gold btn-sm" onclick="document.getElementById('addHomeValueModal').style.display='flex'">
            <i class="fas fa-plus"></i> Add Card
        </button>
    </div>
    <p style="padding:0 1.5rem 1rem;margin:0;font-size:13px;color:#888">These cards are now featured with a photo on the public site. Upload a clear, well-lit image for each — it's the main visual, so pick something strong.</p>
    @if($homeValues->isEmpty())
    <div class="admin-empty"><i class="fas fa-star"></i> No value cards yet. Add your first one.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Image</th><th>Title</th><th>Body Preview</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($homeValues as $v)
                <tr>
                    <td>
                        @if($v->image)
                        <img src="{{ $v->image_url }}" alt="{{ $v->title }}" style="width:52px;height:52px;border-radius:8px;object-fit:cover">
                        @else
                        <span style="width:52px;height:52px;border-radius:8px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;color:#c8972b">
                            <i class="fas {{ $v->icon ?: 'fa-image' }}"></i>
                        </span>
                        @endif
                    </td>
                    <td>{{ $v->title }}</td>
                    <td class="admin-table__msg">{{ Str::limit($v->body, 70) }}</td>
                    <td>{{ $v->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.pages.home.values.toggle', $v->id) }}" style="display:inline">@csrf
                            <button type="submit" class="btn btn-xs {{ $v->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $v->is_active ? '✓ Visible' : '✗ Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline"
                            onclick="editHomeValue({{ $v->id }},'{{ addslashes($v->icon) }}','{{ addslashes($v->title) }}','{{ addslashes($v->body) }}',{{ $v->sort_order ?? 0 }},'{{ $v->image_url }}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.pages.home.values.destroy', $v->id) }}" style="display:inline"
                              onsubmit="return confirm('Delete this value card?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-red"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- ── Testimonials ─────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-quote-left"></i> Testimonials ({{ $testimonials->count() }})</h3>
        <button class="btn btn-gold btn-sm" onclick="document.getElementById('addTestimonialModal').style.display='flex'">
            <i class="fas fa-plus"></i> Add Testimonial
        </button>
    </div>
    @if($testimonials->isEmpty())
    <div class="admin-empty"><i class="fas fa-quote-left"></i> No testimonials yet. Add your first one.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Name</th><th>Quote Preview</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($testimonials as $t)
                <tr>
                    <td><strong>{{ $t->name }}</strong></td>
                    <td class="admin-table__msg">{{ Str::limit($t->quote, 70) }}</td>
                    <td>{{ $t->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.pages.home.testimonials.toggle', $t->id) }}" style="display:inline">@csrf
                            <button type="submit" class="btn btn-xs {{ $t->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $t->is_active ? '✓ Visible' : '✗ Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline"
                            onclick="editTestimonial({{ $t->id }},'{{ addslashes($t->name) }}','{{ addslashes($t->quote) }}',{{ $t->sort_order ?? 0 }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.pages.home.testimonials.destroy', $t->id) }}" style="display:inline"
                              onsubmit="return confirm('Delete this testimonial?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-red"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- Add Value Modal --}}
<div class="admin-modal" id="addHomeValueModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add "Why Choose Us" Card</h3>
            <button onclick="document.getElementById('addHomeValueModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.pages.home.values.store') }}" class="thr-form" enctype="multipart/form-data">
            @csrf
            <div class="thr-form__group">
                <label>Photo <span class="req">*</span> <span style="font-size:12px;color:#888">(JPG/PNG/WebP, max 2 MB — this is the main visual)</span></label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input" required>
            </div>
            <div class="thr-form__group">
                <label>Title <span class="req">*</span></label>
                <input type="text" name="title" placeholder="Expert Care" required>
            </div>
            <div class="thr-form__group">
                <label>Body <span class="req">*</span></label>
                <textarea name="body" rows="3" required placeholder="Describe this value..."></textarea>
            </div>
            <div class="thr-form__group">
                <label>Icon Badge <span style="font-size:12px;color:#888">(optional — small accent icon over the photo)</span></label>
                <input type="text" name="icon" placeholder="fa-user-md">
                <p class="admin-setting-hint">E.g. fa-user-md, fa-lock, fa-seedling, fa-star, fa-heart. Leave blank for no badge.</p>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" placeholder="0" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addHomeValueModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Card</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Value Modal --}}
<div class="admin-modal" id="editHomeValueModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Edit "Why Choose Us" Card</h3>
            <button onclick="document.getElementById('editHomeValueModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editHomeValueForm" class="thr-form" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="thr-form__group">
                <div id="editHomeValuePreviewWrap" style="margin-bottom:.75rem;display:none">
                    <img id="editHomeValuePreview" src="" alt="Current photo" style="width:100px;height:75px;border-radius:8px;object-fit:cover;border:1px solid #e5e7eb">
                </div>
                <label>Replace Photo <span style="font-size:12px;color:#888">(optional — leave blank to keep current)</span></label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
            </div>
            <div class="thr-form__group">
                <label>Title <span class="req">*</span></label>
                <input type="text" name="title" id="editHomeValueTitle" required>
            </div>
            <div class="thr-form__group">
                <label>Body <span class="req">*</span></label>
                <textarea name="body" id="editHomeValueBody" rows="3" required></textarea>
            </div>
            <div class="thr-form__group">
                <label>Icon Badge <span style="font-size:12px;color:#888">(optional — small accent icon over the photo)</span></label>
                <input type="text" name="icon" id="editHomeValueIcon">
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" id="editHomeValueSort" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editHomeValueModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

{{-- Add Testimonial Modal --}}
<div class="admin-modal" id="addTestimonialModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add Testimonial</h3>
            <button onclick="document.getElementById('addTestimonialModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.pages.home.testimonials.store') }}" class="thr-form">
            @csrf
            <div class="thr-form__group">
                <label>Client Name <span class="req">*</span></label>
                <input type="text" name="name" placeholder="Abena M., Accra" required>
            </div>
            <div class="thr-form__group">
                <label>Quote <span class="req">*</span></label>
                <textarea name="quote" rows="3" required placeholder="Absolutely life-changing experience..."></textarea>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" placeholder="0" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addTestimonialModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Testimonial</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Testimonial Modal --}}
<div class="admin-modal" id="editTestimonialModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Edit Testimonial</h3>
            <button onclick="document.getElementById('editTestimonialModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editTestimonialForm" class="thr-form">
            @csrf @method('PUT')
            <div class="thr-form__group">
                <label>Client Name <span class="req">*</span></label>
                <input type="text" name="name" id="editTestimonialName" required>
            </div>
            <div class="thr-form__group">
                <label>Quote <span class="req">*</span></label>
                <textarea name="quote" id="editTestimonialQuote" rows="3" required></textarea>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" id="editTestimonialSort" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editTestimonialModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editHomeValue(id, icon, title, body, sort, imageUrl) {
    document.getElementById('editHomeValueForm').action = `/admin/pages/home/values/${id}`;
    document.getElementById('editHomeValueIcon').value  = icon;
    document.getElementById('editHomeValueTitle').value = title;
    document.getElementById('editHomeValueBody').value  = body;
    document.getElementById('editHomeValueSort').value  = sort;
    const previewWrap = document.getElementById('editHomeValuePreviewWrap');
    const preview      = document.getElementById('editHomeValuePreview');
    if (imageUrl) {
        preview.src = imageUrl;
        previewWrap.style.display = 'block';
    } else {
        previewWrap.style.display = 'none';
    }
    document.getElementById('editHomeValueModal').style.display = 'flex';
}
function editTestimonial(id, name, quote, sort) {
    document.getElementById('editTestimonialForm').action = `/admin/pages/home/testimonials/${id}`;
    document.getElementById('editTestimonialName').value  = name;
    document.getElementById('editTestimonialQuote').value = quote;
    document.getElementById('editTestimonialSort').value  = sort;
    document.getElementById('editTestimonialModal').style.display = 'flex';
}
</script>
@endpush
