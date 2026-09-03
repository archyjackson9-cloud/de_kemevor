@extends('layouts.admin')
@section('title', 'About Page')
@section('page-title', 'About Page Settings')

@section('content')

<div style="display:flex;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <a href="{{ route('admin.pages.about') }}" class="btn btn-gold btn-sm">
        <i class="fas fa-info-circle"></i> About Page
    </a>
    <a href="{{ route('admin.pages.contact') }}" class="btn btn-outline btn-sm">
        <i class="fas fa-envelope"></i> Contact Page
    </a>
    <a href="{{ route('about') }}" target="_blank" class="btn btn-outline btn-sm">
        <i class="fas fa-external-link-alt"></i> Preview Page
    </a>
</div>

<form method="POST" action="{{ route('admin.pages.about.update') }}" enctype="multipart/form-data">
@csrf

{{-- ── Hero Settings ────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-image"></i> Hero Section</h3>
        <span style="font-size:13px;color:#888">The banner at the top of the About page.</span>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="about_hero_eyebrow" value="{{ $s->get('about_hero_eyebrow','Our Story') }}" placeholder="Our Story">
        </div>
        <div class="thr-form__group">
            <label>Hero Title</label>
            <input type="text" name="about_hero_title" value="{{ $s->get('about_hero_title','About The Healing Room') }}" placeholder="About The Healing Room">
        </div>
        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Subtitle</label>
            <input type="text" name="about_hero_sub" value="{{ $s->get('about_hero_sub','A sanctuary built on expertise, compassion, and results.') }}" placeholder="Short subtitle...">
        </div>

        {{-- Hero Media Type --}}
        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Hero Background</label>
            <div style="display:flex;gap:1.5rem;margin-top:.5rem;align-items:center;flex-wrap:wrap">
                <label style="display:flex;align-items:center;gap:.5rem;font-weight:400;cursor:pointer">
                    <input type="radio" name="about_hero_type" value="none" {{ $s->get('about_hero_type','none') === 'none' || !$s->get('about_hero_type') ? 'checked' : '' }}>
                    Default Gradient
                </label>
                <label style="display:flex;align-items:center;gap:.5rem;font-weight:400;cursor:pointer">
                    <input type="radio" name="about_hero_type" value="image" {{ $s->get('about_hero_type') === 'image' ? 'checked' : '' }}>
                    Image
                </label>
                <label style="display:flex;align-items:center;gap:.5rem;font-weight:400;cursor:pointer">
                    <input type="radio" name="about_hero_type" value="video" {{ $s->get('about_hero_type') === 'video' ? 'checked' : '' }}>
                    Video
                </label>
            </div>
            <p class="admin-setting-hint">Choose "Image" or "Video" to upload custom background media. Otherwise the default dark gradient is used.</p>
        </div>

        <div class="thr-form__group" style="grid-column:1/-1" id="aboutHeroMediaWrap">
            @if($s->get('about_hero_media'))
            <div style="margin-bottom:.75rem;padding:.75rem;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;display:flex;align-items:center;gap:1rem">
                @if($s->get('about_hero_type') === 'video')
                <video src="{{ asset('storage/'.$s->get('about_hero_media')) }}" style="height:60px;border-radius:4px" muted></video>
                @else
                <img src="{{ asset('storage/'.$s->get('about_hero_media')) }}" style="height:60px;border-radius:4px;object-fit:cover;max-width:120px" alt="Hero">
                @endif
                <div>
                    <div style="font-size:13px;font-weight:600">Current {{ $s->get('about_hero_type') === 'video' ? 'Video' : 'Image' }}</div>
                    <label style="display:flex;align-items:center;gap:.4rem;margin-top:.3rem;font-size:12px;cursor:pointer;color:#dc2626;font-weight:400">
                        <input type="checkbox" name="about_remove_media" value="1"> Remove current media
                    </label>
                </div>
            </div>
            @endif
            <label>Upload New Media <span style="font-size:12px;color:#888">(Image: JPG/PNG/WebP · Video: MP4/WebM · Max 50 MB)</span></label>
            <input type="file" name="about_hero_media" accept="image/jpeg,image/png,image/jpg,image/webp,video/mp4,video/webm" class="admin-file-input">
        </div>
    </div>
</div>

{{-- ── Story Section ─────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-book-open"></i> Clinic Story</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Section Eyebrow</label>
            <input type="text" name="about_story_eyebrow" value="{{ $s->get('about_story_eyebrow','How It All Began') }}" placeholder="How It All Began">
        </div>
        <div class="thr-form__group">
            <label>Section Title</label>
            <input type="text" name="about_story_title" value="{{ $s->get('about_story_title','Our Clinic Story') }}" placeholder="Our Clinic Story">
        </div>
        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Story Body <span style="font-size:12px;color:#888">(Use blank lines to separate paragraphs)</span></label>
            <textarea name="about_story_body" rows="7" placeholder="Tell your clinic's story...">{{ $s->get('about_story_body') }}</textarea>
        </div>

        <div style="grid-column:1/-1">
            <div style="font-size:.85rem;font-weight:700;color:#374151;margin-bottom:.75rem;padding-bottom:.5rem;border-bottom:1px solid #f3f4f6">
                Stat Badges (shown beside the story text)
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:1rem">
                @for($i = 1; $i <= 4; $i++)
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;padding:1rem">
                    <div class="thr-form__group" style="margin-bottom:.5rem">
                        <label>Stat {{ $i }} — Number</label>
                        <input type="text" name="about_stat_{{ $i }}_num" value="{{ $s->get('about_stat_'.$i.'_num') }}" placeholder="500+">
                    </div>
                    <div class="thr-form__group" style="margin-bottom:0">
                        <label>Stat {{ $i }} — Label</label>
                        <input type="text" name="about_stat_{{ $i }}_label" value="{{ $s->get('about_stat_'.$i.'_label') }}" placeholder="Happy Clients">
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

{{-- ── Mission ───────────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-heart"></i> Mission Statement</h3>
    </div>
    <div style="padding:1.5rem">
        <div class="thr-form__group">
            <label>Mission Statement <span style="font-size:12px;color:#888">(displayed as a highlighted quote)</span></label>
            <textarea name="about_mission" rows="3" placeholder="To restore and maintain...">{{ $s->get('about_mission') }}</textarea>
        </div>
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
            <input type="text" name="about_cta_title" value="{{ $s->get('about_cta_title','Ready to Begin Your Journey?') }}" placeholder="Ready to Begin Your Journey?">
        </div>
        <div class="thr-form__group">
            <label>CTA Subtitle</label>
            <input type="text" name="about_cta_sub" value="{{ $s->get('about_cta_sub') }}" placeholder="Book a consultation...">
        </div>
    </div>
</div>

<div style="display:flex;justify-content:flex-end;margin-bottom:2rem">
    <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Save All About Page Settings</button>
</div>

</form>

{{-- ── Core Values ──────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-star"></i> Core Values ({{ $values->count() }})</h3>
        <button class="btn btn-gold btn-sm" onclick="document.getElementById('addValueModal').style.display='flex'">
            <i class="fas fa-plus"></i> Add Value
        </button>
    </div>
    @if($values->isEmpty())
    <div class="admin-empty"><i class="fas fa-star"></i> No core values yet. Add your first one.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>#</th><th>Title</th><th>Body Preview</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($values as $v)
                <tr>
                    <td><strong>{{ $v->number }}</strong></td>
                    <td>{{ $v->title }}</td>
                    <td class="admin-table__msg">{{ Str::limit($v->body, 70) }}</td>
                    <td>{{ $v->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.pages.about.values.toggle', $v->id) }}" style="display:inline">@csrf
                            <button type="submit" class="btn btn-xs {{ $v->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $v->is_active ? '✓ Visible' : '✗ Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline"
                            onclick="editValue({{ $v->id }},'{{ addslashes($v->number) }}','{{ addslashes($v->title) }}','{{ addslashes($v->body) }}',{{ $v->sort_order ?? 0 }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.pages.about.values.destroy', $v->id) }}" style="display:inline"
                              onsubmit="return confirm('Delete this core value?')">
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

{{-- ── Certifications ───────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-certificate"></i> Certifications ({{ $certs->count() }})</h3>
        <button class="btn btn-gold btn-sm" onclick="document.getElementById('addCertModal').style.display='flex'">
            <i class="fas fa-plus"></i> Add Certification
        </button>
    </div>
    @if($certs->isEmpty())
    <div class="admin-empty"><i class="fas fa-certificate"></i> No certifications yet.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Icon</th><th>Label</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($certs as $c)
                <tr>
                    <td><i class="fas {{ $c->icon }}"></i></td>
                    <td>{{ $c->label }}</td>
                    <td>{{ $c->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.pages.about.certs.toggle', $c->id) }}" style="display:inline">@csrf
                            <button type="submit" class="btn btn-xs {{ $c->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $c->is_active ? '✓ Visible' : '✗ Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline"
                            onclick="editCert({{ $c->id }},'{{ addslashes($c->icon) }}','{{ addslashes($c->label) }}',{{ $c->sort_order ?? 0 }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.pages.about.certs.destroy', $c->id) }}" style="display:inline"
                              onsubmit="return confirm('Delete this certification?')">
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
<div class="admin-modal" id="addValueModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add Core Value</h3>
            <button onclick="document.getElementById('addValueModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.pages.about.values.store') }}" class="thr-form">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 2fr;gap:1rem">
                <div class="thr-form__group">
                    <label>Number <span class="req">*</span></label>
                    <input type="text" name="number" placeholder="01" maxlength="5" required>
                </div>
                <div class="thr-form__group">
                    <label>Title <span class="req">*</span></label>
                    <input type="text" name="title" placeholder="Compassion First" required>
                </div>
            </div>
            <div class="thr-form__group">
                <label>Body <span class="req">*</span></label>
                <textarea name="body" rows="3" required placeholder="Describe this core value..."></textarea>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" placeholder="0" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addValueModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Value</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Value Modal --}}
<div class="admin-modal" id="editValueModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Edit Core Value</h3>
            <button onclick="document.getElementById('editValueModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editValueForm" class="thr-form">
            @csrf @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 2fr;gap:1rem">
                <div class="thr-form__group">
                    <label>Number <span class="req">*</span></label>
                    <input type="text" name="number" id="editValueNumber" maxlength="5" required>
                </div>
                <div class="thr-form__group">
                    <label>Title <span class="req">*</span></label>
                    <input type="text" name="title" id="editValueTitle" required>
                </div>
            </div>
            <div class="thr-form__group">
                <label>Body <span class="req">*</span></label>
                <textarea name="body" id="editValueBody" rows="3" required></textarea>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" id="editValueSort" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editValueModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

{{-- Add Cert Modal --}}
<div class="admin-modal" id="addCertModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add Certification</h3>
            <button onclick="document.getElementById('addCertModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.pages.about.certs.store') }}" class="thr-form">
            @csrf
            <div class="thr-form__group">
                <label>Font Awesome Icon Class <span class="req">*</span></label>
                <input type="text" name="icon" placeholder="fa-certificate" required>
                <p class="admin-setting-hint">E.g. fa-certificate, fa-shield-alt, fa-star, fa-leaf, fa-graduation-cap</p>
            </div>
            <div class="thr-form__group">
                <label>Label <span class="req">*</span></label>
                <input type="text" name="label" placeholder="Certified Aesthetic Practitioners" required>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" placeholder="0" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addCertModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Certification</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Cert Modal --}}
<div class="admin-modal" id="editCertModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Edit Certification</h3>
            <button onclick="document.getElementById('editCertModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editCertForm" class="thr-form">
            @csrf @method('PUT')
            <div class="thr-form__group">
                <label>Font Awesome Icon Class <span class="req">*</span></label>
                <input type="text" name="icon" id="editCertIcon" required>
            </div>
            <div class="thr-form__group">
                <label>Label <span class="req">*</span></label>
                <input type="text" name="label" id="editCertLabel" required>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" id="editCertSort" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editCertModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editValue(id, number, title, body, sort) {
    document.getElementById('editValueForm').action = `/admin/pages/about/values/${id}`;
    document.getElementById('editValueNumber').value = number;
    document.getElementById('editValueTitle').value  = title;
    document.getElementById('editValueBody').value   = body;
    document.getElementById('editValueSort').value   = sort;
    document.getElementById('editValueModal').style.display = 'flex';
}
function editCert(id, icon, label, sort) {
    document.getElementById('editCertForm').action = `/admin/pages/about/certs/${id}`;
    document.getElementById('editCertIcon').value  = icon;
    document.getElementById('editCertLabel').value = label;
    document.getElementById('editCertSort').value  = sort;
    document.getElementById('editCertModal').style.display = 'flex';
}
</script>
@endpush
