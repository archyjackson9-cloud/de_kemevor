@extends('layouts.admin')
@section('title', 'Training Page')
@section('page-title', 'Training Page Settings')

@section('content')

<div style="display:flex;gap:1rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <a href="{{ route('admin.pages.home') }}" class="btn btn-outline btn-sm">
        <i class="fas fa-house"></i> Home Page
    </a>
    <a href="{{ route('admin.pages.about') }}" class="btn btn-outline btn-sm">
        <i class="fas fa-info-circle"></i> About Page
    </a>
    <a href="{{ route('admin.pages.contact') }}" class="btn btn-outline btn-sm">
        <i class="fas fa-envelope"></i> Contact Page
    </a>
    <a href="{{ route('admin.pages.training') }}" class="btn btn-gold btn-sm">
        <i class="fas fa-graduation-cap"></i> Training Page
    </a>
    <a href="{{ route('training') }}" target="_blank" class="btn btn-outline btn-sm">
        <i class="fas fa-external-link-alt"></i> Preview Page
    </a>
</div>

<div class="admin-card" style="margin-bottom:1.5rem;background:#f9fafb">
    <div style="padding:1rem 1.5rem;font-size:13px;color:#555;display:flex;align-items:center;gap:.6rem">
        <i class="fas fa-circle-info" style="color:var(--gold)"></i>
        Enrollment inquiries submitted from this page are managed under
        <a href="{{ route('admin.training-inquiries') }}" style="color:var(--gold);font-weight:600">Training Inquiries</a>.
    </div>
</div>

<form method="POST" action="{{ route('admin.pages.training.update') }}" enctype="multipart/form-data">
@csrf

{{-- ── Hero ──────────────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-image"></i> Hero Section</h3>
        <span style="font-size:13px;color:#888">The video/image banner at the top of the Training page.</span>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="training_hero_eyebrow" value="{{ $s->get('training_hero_eyebrow','Learn. Grow. Transform.') }}" placeholder="Learn. Grow. Transform.">
        </div>
        <div class="thr-form__group">
            <label>Hero Title</label>
            <input type="text" name="training_hero_title" value="{{ $s->get('training_hero_title','Esthetic Training Program') }}" placeholder="Esthetic Training Program">
        </div>
        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Subtitle</label>
            <input type="text" name="training_hero_sub" value="{{ $s->get('training_hero_sub','Gain the knowledge, skills and confidence to become a professional esthetician and build a successful career in the beauty & wellness industry.') }}" placeholder="Short subtitle...">
        </div>

        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Hero Background</label>
            <div style="display:flex;gap:1.5rem;margin-top:.5rem;align-items:center;flex-wrap:wrap">
                <label style="display:flex;align-items:center;gap:.5rem;font-weight:400;cursor:pointer">
                    <input type="radio" name="training_hero_type" value="none" {{ !$s->get('training_hero_type') || $s->get('training_hero_type') === 'none' ? 'checked' : '' }}>
                    Default Gradient
                </label>
                <label style="display:flex;align-items:center;gap:.5rem;font-weight:400;cursor:pointer">
                    <input type="radio" name="training_hero_type" value="image" {{ $s->get('training_hero_type') === 'image' ? 'checked' : '' }}>
                    Image
                </label>
                <label style="display:flex;align-items:center;gap:.5rem;font-weight:400;cursor:pointer">
                    <input type="radio" name="training_hero_type" value="video" {{ $s->get('training_hero_type') === 'video' ? 'checked' : '' }}>
                    Video
                </label>
            </div>
            <p class="admin-setting-hint">Choose "Video" and upload training/clinic footage — until you do, the page shows a tasteful dark gradient instead.</p>
        </div>

        <div class="thr-form__group" style="grid-column:1/-1">
            @if($s->get('training_hero_media'))
            <div style="margin-bottom:.75rem;padding:.75rem;background:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;display:flex;align-items:center;gap:1rem">
                @if($s->get('training_hero_type') === 'video')
                <video src="{{ asset('storage/'.$s->get('training_hero_media')) }}" style="height:60px;border-radius:4px" muted></video>
                @else
                <img src="{{ asset('storage/'.$s->get('training_hero_media')) }}" style="height:60px;border-radius:4px;object-fit:cover;max-width:120px" alt="Hero">
                @endif
                <div>
                    <div style="font-size:13px;font-weight:600">Current {{ $s->get('training_hero_type') === 'video' ? 'Video' : 'Image' }}</div>
                    <label style="display:flex;align-items:center;gap:.4rem;margin-top:.3rem;font-size:12px;cursor:pointer;color:#dc2626;font-weight:400">
                        <input type="checkbox" name="training_remove_media" value="1"> Remove current media
                    </label>
                </div>
            </div>
            @endif
            <label>Upload New Media <span style="font-size:12px;color:#888">(Image: JPG/PNG/WebP · Video: MP4/WebM · Max 50 MB)</span></label>
            <input type="file" name="training_hero_media" accept="image/jpeg,image/png,image/jpg,image/webp,video/mp4,video/webm" class="admin-file-input">
        </div>

        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Video Poster Image <span style="font-size:12px;color:#888">(optional — shown while the video loads)</span></label>
            @if($s->get('training_hero_poster'))
            <img src="{{ asset('storage/'.$s->get('training_hero_poster')) }}" style="height:50px;border-radius:4px;object-fit:cover;max-width:100px;display:block;margin-bottom:.5rem" alt="Poster">
            @endif
            <input type="file" name="training_hero_poster" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
        </div>
    </div>
</div>

{{-- ── Program Description ──────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-book-open"></i> Program Description</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="training_description_eyebrow" value="{{ $s->get('training_description_eyebrow','About the Program') }}" placeholder="About the Program">
        </div>
        <div class="thr-form__group">
            <label>Section Title</label>
            <input type="text" name="training_description_title" value="{{ $s->get('training_description_title','From Knowledge to Confidence, From Skills to Success') }}" placeholder="Section title">
        </div>
        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Description Body <span style="font-size:12px;color:#888">(use blank lines to separate paragraphs)</span></label>
            <textarea name="training_description" rows="6" placeholder="Describe the training program...">{{ $s->get('training_description') }}</textarea>
        </div>
    </div>
</div>

{{-- ── Who Is This For Header ───────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-users"></i> "Who Is This For" Header</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="training_who_eyebrow" value="{{ $s->get('training_who_eyebrow','Who Is This For') }}" placeholder="Who Is This For">
        </div>
        <div class="thr-form__group">
            <label>Section Title</label>
            <input type="text" name="training_who_title" value="{{ $s->get('training_who_title','Who Is This Course For?') }}" placeholder="Who Is This Course For?">
        </div>
    </div>
</div>

{{-- ── What You Will Learn Header ───────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-check-double"></i> "What You Will Learn" Header</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="training_learn_eyebrow" value="{{ $s->get('training_learn_eyebrow','Curriculum Highlights') }}" placeholder="Curriculum Highlights">
        </div>
        <div class="thr-form__group">
            <label>Section Title</label>
            <input type="text" name="training_learn_title" value="{{ $s->get('training_learn_title','What You Will Learn') }}" placeholder="What You Will Learn">
        </div>
    </div>
</div>

{{-- ── What You'll Gain Header ──────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-heart"></i> "What You'll Gain" Header</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="training_gain_eyebrow" value="{{ $s->get('training_gain_eyebrow',"What You'll Gain") }}" placeholder="What You'll Gain">
        </div>
        <div class="thr-form__group">
            <label>Section Title</label>
            <input type="text" name="training_gain_title" value="{{ $s->get('training_gain_title','Your Passion. Our Training. Limitless Possibilities.') }}" placeholder="Section title">
        </div>
    </div>
</div>

{{-- ── Course Structure Header ──────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-layer-group"></i> "Course Structure" Header</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="training_structure_eyebrow" value="{{ $s->get('training_structure_eyebrow','Course Structure') }}" placeholder="Course Structure">
        </div>
        <div class="thr-form__group">
            <label>Section Title</label>
            <input type="text" name="training_structure_title" value="{{ $s->get('training_structure_title','Your Learning Journey, Phase by Phase') }}" placeholder="Section title">
        </div>
        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Subtitle</label>
            <input type="text" name="training_structure_sub" value="{{ $s->get('training_structure_sub','Each phase builds on the one before it — from mindset and safety, all the way to running your own successful career.') }}" placeholder="Short subtitle...">
        </div>
    </div>
</div>

{{-- ── Assessment & Certification ───────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-award"></i> Assessment & Certification</h3>
    </div>
    <div style="padding:1.5rem;display:grid;grid-template-columns:1fr 1fr;gap:1.25rem">
        <div class="thr-form__group">
            <label>Eyebrow Text</label>
            <input type="text" name="training_cert_eyebrow" value="{{ $s->get('training_cert_eyebrow','Assessment & Certification') }}" placeholder="Assessment & Certification">
        </div>
        <div class="thr-form__group">
            <label>Section Title</label>
            <input type="text" name="training_cert_title" value="{{ $s->get('training_cert_title','Graduate With a Recognized Certificate') }}" placeholder="Section title">
        </div>
        <div class="thr-form__group" style="grid-column:1/-1">
            <label>Body <span style="font-size:12px;color:#888">(use blank lines to separate paragraphs)</span></label>
            <textarea name="training_cert_body" rows="5" placeholder="Describe assessment & certification...">{{ $s->get('training_cert_body') }}</textarea>
        </div>
    </div>
</div>

{{-- ── Enroll Section ───────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-paper-plane"></i> Enroll Section</h3>
    </div>
    <div style="padding:1.5rem">
        <div class="thr-form__group">
            <label>Form Title</label>
            <input type="text" name="training_enroll_title" value="{{ $s->get('training_enroll_title','Invest In Your Future — Enroll Today') }}" placeholder="Invest In Your Future — Enroll Today">
        </div>
    </div>
</div>

<div style="display:flex;justify-content:flex-end;margin-bottom:2rem">
    <button type="submit" class="btn btn-gold"><i class="fas fa-save"></i> Save All Training Page Settings</button>
</div>

</form>

{{-- ── Course Phases ─────────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-layer-group"></i> Course Phases ({{ $phases->count() }})</h3>
        <button class="btn btn-gold btn-sm" onclick="document.getElementById('addPhaseModal').style.display='flex'">
            <i class="fas fa-plus"></i> Add Phase
        </button>
    </div>
    <p style="padding:0 1.5rem 1rem;margin:0;font-size:13px;color:#888">Each phase gets a large featured photo on the public page. Upload one when ready — a gradient placeholder shows until then.</p>
    @if($phases->isEmpty())
    <div class="admin-empty"><i class="fas fa-layer-group"></i> No phases yet. Add your first one.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Image</th><th>#</th><th>Title</th><th>Topics</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($phases as $p)
                <tr>
                    <td>
                        @if($p->image)
                        <img src="{{ $p->image_url }}" alt="{{ $p->title }}" style="width:52px;height:52px;border-radius:8px;object-fit:cover">
                        @else
                        <span style="width:52px;height:52px;border-radius:8px;background:#f3f4f6;display:flex;align-items:center;justify-content:center;color:#c8972b">
                            <i class="fas fa-image"></i>
                        </span>
                        @endif
                    </td>
                    <td><strong>{{ $p->phase_number }}</strong></td>
                    <td>{{ $p->title }}</td>
                    <td class="admin-table__msg">{{ Str::limit(str_replace("\n", ', ', $p->topics ?? ''), 60) }}</td>
                    <td>{{ $p->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.pages.training.phases.toggle', $p->id) }}" style="display:inline">@csrf
                            <button type="submit" class="btn btn-xs {{ $p->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $p->is_active ? '✓ Visible' : '✗ Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline"
                            onclick="editPhase({{ $p->id }},{{ $p->phase_number }},'{{ addslashes($p->title) }}','{{ addslashes($p->subtitle ?? '') }}','{{ addslashes($p->description ?? '') }}',{{ \Illuminate\Support\Js::from($p->topics ?? '') }},{{ $p->sort_order ?? 0 }},'{{ $p->image_url }}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.pages.training.phases.destroy', $p->id) }}" style="display:inline"
                              onsubmit="return confirm('Delete this phase?')">
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

{{-- ── Who Is This For ──────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-users"></i> "Who Is This For" Items ({{ $whoFor->count() }})</h3>
        <button class="btn btn-gold btn-sm" onclick="document.getElementById('addWhoForModal').style.display='flex'">
            <i class="fas fa-plus"></i> Add Item
        </button>
    </div>
    @if($whoFor->isEmpty())
    <div class="admin-empty"><i class="fas fa-users"></i> No items yet.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Label</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($whoFor as $w)
                <tr>
                    <td>{{ $w->label }}</td>
                    <td>{{ $w->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.pages.training.who-for.toggle', $w->id) }}" style="display:inline">@csrf
                            <button type="submit" class="btn btn-xs {{ $w->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $w->is_active ? '✓ Visible' : '✗ Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline" onclick="editWhoFor({{ $w->id }},'{{ addslashes($w->label) }}',{{ $w->sort_order ?? 0 }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.pages.training.who-for.destroy', $w->id) }}" style="display:inline"
                              onsubmit="return confirm('Delete this item?')">
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

{{-- ── What You Will Learn ──────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-check-double"></i> "What You Will Learn" Points ({{ $learnPoints->count() }})</h3>
        <button class="btn btn-gold btn-sm" onclick="document.getElementById('addLearnModal').style.display='flex'">
            <i class="fas fa-plus"></i> Add Point
        </button>
    </div>
    @if($learnPoints->isEmpty())
    <div class="admin-empty"><i class="fas fa-check-double"></i> No points yet.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Text</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($learnPoints as $l)
                <tr>
                    <td>{{ $l->text }}</td>
                    <td>{{ $l->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.pages.training.learn.toggle', $l->id) }}" style="display:inline">@csrf
                            <button type="submit" class="btn btn-xs {{ $l->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $l->is_active ? '✓ Visible' : '✗ Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline" onclick="editLearn({{ $l->id }},'{{ addslashes($l->text) }}',{{ $l->sort_order ?? 0 }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.pages.training.learn.destroy', $l->id) }}" style="display:inline"
                              onsubmit="return confirm('Delete this point?')">
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

{{-- ── What You'll Gain ─────────────────────────────────────────────── --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-heart"></i> "What You'll Gain" Items ({{ $gainItems->count() }})</h3>
        <button class="btn btn-gold btn-sm" onclick="document.getElementById('addGainModal').style.display='flex'">
            <i class="fas fa-plus"></i> Add Item
        </button>
    </div>
    @if($gainItems->isEmpty())
    <div class="admin-empty"><i class="fas fa-heart"></i> No items yet.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Icon</th><th>Title</th><th>Body Preview</th><th>Order</th><th>Visible</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($gainItems as $g)
                <tr>
                    <td><i class="fas {{ $g->icon }}"></i></td>
                    <td>{{ $g->title }}</td>
                    <td class="admin-table__msg">{{ Str::limit($g->body, 70) }}</td>
                    <td>{{ $g->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.pages.training.gain.toggle', $g->id) }}" style="display:inline">@csrf
                            <button type="submit" class="btn btn-xs {{ $g->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $g->is_active ? '✓ Visible' : '✗ Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline"
                            onclick="editGain({{ $g->id }},'{{ addslashes($g->icon) }}','{{ addslashes($g->title) }}','{{ addslashes($g->body) }}',{{ $g->sort_order ?? 0 }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.pages.training.gain.destroy', $g->id) }}" style="display:inline"
                              onsubmit="return confirm('Delete this item?')">
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

{{-- Add Phase Modal --}}
<div class="admin-modal" id="addPhaseModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add Course Phase</h3>
            <button onclick="document.getElementById('addPhaseModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.pages.training.phases.store') }}" class="thr-form" enctype="multipart/form-data">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 3fr;gap:1rem">
                <div class="thr-form__group">
                    <label>Phase # <span class="req">*</span></label>
                    <input type="number" name="phase_number" min="1" max="99" required placeholder="1">
                </div>
                <div class="thr-form__group">
                    <label>Title <span class="req">*</span></label>
                    <input type="text" name="title" placeholder="Mindset & Safety" required>
                </div>
            </div>
            <div class="thr-form__group">
                <label>Subtitle <span style="font-size:12px;color:#888">(optional)</span></label>
                <input type="text" name="subtitle" placeholder="Before anyone touches a client">
            </div>
            <div class="thr-form__group">
                <label>Description</label>
                <textarea name="description" rows="3" placeholder="Describe what this phase covers..."></textarea>
            </div>
            <div class="thr-form__group">
                <label>Topics <span style="font-size:12px;color:#888">(one per line)</span></label>
                <textarea name="topics" rows="4" placeholder="Professional ethics in esthetics&#10;Hygiene, sanitation and safety"></textarea>
            </div>
            <div class="thr-form__group">
                <label>Featured Photo <span style="font-size:12px;color:#888">(JPG/PNG/WebP, max 4 MB — optional, placeholder shows if empty)</span></label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" placeholder="0" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addPhaseModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Phase</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Phase Modal --}}
<div class="admin-modal" id="editPhaseModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Edit Course Phase</h3>
            <button onclick="document.getElementById('editPhaseModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editPhaseForm" class="thr-form" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 3fr;gap:1rem">
                <div class="thr-form__group">
                    <label>Phase # <span class="req">*</span></label>
                    <input type="number" name="phase_number" id="editPhaseNumber" min="1" max="99" required>
                </div>
                <div class="thr-form__group">
                    <label>Title <span class="req">*</span></label>
                    <input type="text" name="title" id="editPhaseTitle" required>
                </div>
            </div>
            <div class="thr-form__group">
                <label>Subtitle</label>
                <input type="text" name="subtitle" id="editPhaseSubtitle">
            </div>
            <div class="thr-form__group">
                <label>Description</label>
                <textarea name="description" id="editPhaseDescription" rows="3"></textarea>
            </div>
            <div class="thr-form__group">
                <label>Topics <span style="font-size:12px;color:#888">(one per line)</span></label>
                <textarea name="topics" id="editPhaseTopics" rows="4"></textarea>
            </div>
            <div class="thr-form__group">
                <div id="editPhasePreviewWrap" style="margin-bottom:.75rem;display:none">
                    <img id="editPhasePreview" src="" alt="Current photo" style="width:100px;height:75px;border-radius:8px;object-fit:cover;border:1px solid #e5e7eb">
                </div>
                <label>Replace Photo <span style="font-size:12px;color:#888">(optional — leave blank to keep current)</span></label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" id="editPhaseSort" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editPhaseModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

{{-- Add/Edit Who-For Modals --}}
<div class="admin-modal" id="addWhoForModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add Audience Item</h3>
            <button onclick="document.getElementById('addWhoForModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.pages.training.who-for.store') }}" class="thr-form">
            @csrf
            <div class="thr-form__group">
                <label>Label <span class="req">*</span></label>
                <input type="text" name="label" placeholder="Aspiring Estheticians" required>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" placeholder="0" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addWhoForModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Item</button>
            </div>
        </form>
    </div>
</div>

<div class="admin-modal" id="editWhoForModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Edit Audience Item</h3>
            <button onclick="document.getElementById('editWhoForModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editWhoForForm" class="thr-form">
            @csrf @method('PUT')
            <div class="thr-form__group">
                <label>Label <span class="req">*</span></label>
                <input type="text" name="label" id="editWhoForLabel" required>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" id="editWhoForSort" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editWhoForModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

{{-- Add/Edit Learn Point Modals --}}
<div class="admin-modal" id="addLearnModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add Learning Point</h3>
            <button onclick="document.getElementById('addLearnModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.pages.training.learn.store') }}" class="thr-form">
            @csrf
            <div class="thr-form__group">
                <label>Text <span class="req">*</span></label>
                <textarea name="text" rows="2" required placeholder="Skin anatomy, physiology and how to identify skin types"></textarea>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" placeholder="0" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addLearnModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Point</button>
            </div>
        </form>
    </div>
</div>

<div class="admin-modal" id="editLearnModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Edit Learning Point</h3>
            <button onclick="document.getElementById('editLearnModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editLearnForm" class="thr-form">
            @csrf @method('PUT')
            <div class="thr-form__group">
                <label>Text <span class="req">*</span></label>
                <textarea name="text" id="editLearnText" rows="2" required></textarea>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" id="editLearnSort" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editLearnModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

{{-- Add/Edit Gain Item Modals --}}
<div class="admin-modal" id="addGainModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add "What You'll Gain" Item</h3>
            <button onclick="document.getElementById('addGainModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.pages.training.gain.store') }}" class="thr-form">
            @csrf
            <div class="thr-form__group">
                <label>Font Awesome Icon Class <span class="req">*</span></label>
                <input type="text" name="icon" placeholder="fa-graduation-cap" required>
                <p class="admin-setting-hint">E.g. fa-graduation-cap, fa-hands-holding, fa-certificate, fa-chart-line</p>
            </div>
            <div class="thr-form__group">
                <label>Title <span class="req">*</span></label>
                <input type="text" name="title" placeholder="Expert-Led Training" required>
            </div>
            <div class="thr-form__group">
                <label>Body <span class="req">*</span></label>
                <textarea name="body" rows="3" required placeholder="Learn from experienced professionals..."></textarea>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" placeholder="0" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addGainModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Item</button>
            </div>
        </form>
    </div>
</div>

<div class="admin-modal" id="editGainModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Edit "What You'll Gain" Item</h3>
            <button onclick="document.getElementById('editGainModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editGainForm" class="thr-form">
            @csrf @method('PUT')
            <div class="thr-form__group">
                <label>Font Awesome Icon Class <span class="req">*</span></label>
                <input type="text" name="icon" id="editGainIcon" required>
            </div>
            <div class="thr-form__group">
                <label>Title <span class="req">*</span></label>
                <input type="text" name="title" id="editGainTitle" required>
            </div>
            <div class="thr-form__group">
                <label>Body <span class="req">*</span></label>
                <textarea name="body" id="editGainBody" rows="3" required></textarea>
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" id="editGainSort" min="0">
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editGainModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editPhase(id, number, title, subtitle, description, topics, sort, imageUrl) {
    document.getElementById('editPhaseForm').action = `/admin/pages/training/phases/${id}`;
    document.getElementById('editPhaseNumber').value      = number;
    document.getElementById('editPhaseTitle').value       = title;
    document.getElementById('editPhaseSubtitle').value    = subtitle;
    document.getElementById('editPhaseDescription').value = description;
    document.getElementById('editPhaseTopics').value      = topics;
    document.getElementById('editPhaseSort').value        = sort;
    const previewWrap = document.getElementById('editPhasePreviewWrap');
    const preview      = document.getElementById('editPhasePreview');
    if (imageUrl) {
        preview.src = imageUrl;
        previewWrap.style.display = 'block';
    } else {
        previewWrap.style.display = 'none';
    }
    document.getElementById('editPhaseModal').style.display = 'flex';
}
function editWhoFor(id, label, sort) {
    document.getElementById('editWhoForForm').action = `/admin/pages/training/who-for/${id}`;
    document.getElementById('editWhoForLabel').value = label;
    document.getElementById('editWhoForSort').value  = sort;
    document.getElementById('editWhoForModal').style.display = 'flex';
}
function editLearn(id, text, sort) {
    document.getElementById('editLearnForm').action = `/admin/pages/training/learn/${id}`;
    document.getElementById('editLearnText').value  = text;
    document.getElementById('editLearnSort').value  = sort;
    document.getElementById('editLearnModal').style.display = 'flex';
}
function editGain(id, icon, title, body, sort) {
    document.getElementById('editGainForm').action = `/admin/pages/training/gain/${id}`;
    document.getElementById('editGainIcon').value  = icon;
    document.getElementById('editGainTitle').value = title;
    document.getElementById('editGainBody').value  = body;
    document.getElementById('editGainSort').value  = sort;
    document.getElementById('editGainModal').style.display = 'flex';
}
</script>
@endpush
