@extends('layouts.admin')
@section('title', 'Hero Slider')
@section('page-title', 'Hero Slider Manager')

@section('content')

<div class="admin-page-actions">
    <button class="btn btn-gold" onclick="document.getElementById('addSlideModal').style.display='flex'">
        <i class="fas fa-plus"></i> Add Slide
    </button>
</div>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><i class="fas fa-images"></i> Slides ({{ $slides->count() }})</h3>
        <span style="font-size:13px;color:#888">Slides rotate on the homepage hero, in order.</span>
    </div>
    @if($slides->isEmpty())
    <div class="admin-empty"><i class="fas fa-images"></i> No slides yet. The homepage will show a default hero until you add one.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>Image</th><th>Eyebrow</th><th>Title</th><th>Subtitle</th><th>Order</th><th>Visible</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($slides as $s)
                <tr>
                    <td>
                        <img src="{{ $s->image_url }}" alt="" style="height:44px;width:80px;object-fit:cover;border-radius:4px">
                    </td>
                    <td>{{ $s->eyebrow }}</td>
                    <td><strong>{{ $s->title }}</strong>{{ $s->title_gold ? ' '.$s->title_gold : '' }}</td>
                    <td>{{ Str::limit($s->subtitle, 40) }}</td>
                    <td>{{ $s->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.hero-slides.toggle', $s->id) }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-xs {{ $s->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $s->is_active ? '✓ Visible' : '✗ Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline"
                            onclick="editSlide({{ $s->id }}, '{{ addslashes($s->eyebrow ?? '') }}', '{{ addslashes($s->title ?? '') }}', '{{ addslashes($s->title_gold ?? '') }}', '{{ addslashes($s->subtitle ?? '') }}', {{ $s->sort_order }}, '{{ $s->image_url }}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.hero-slides.destroy', $s->id) }}" style="display:inline"
                              onsubmit="return confirm('Remove this slide?')">
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

{{-- Add Slide Modal --}}
<div class="admin-modal" id="addSlideModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add Slide</h3>
            <button onclick="document.getElementById('addSlideModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.hero-slides.store') }}" class="thr-form" enctype="multipart/form-data">
            @csrf
            <div class="thr-form__group">
                <label>Background Image <span class="req">*</span> <span style="font-size:12px;color:#888">(1600px+ wide recommended)</span></label>
                <input type="file" name="image" required accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
            </div>
            <div class="thr-form__group">
                <label>Eyebrow</label>
                <input type="text" name="eyebrow" placeholder="e.g. Advanced Aesthetic Clinic · Accra, Ghana">
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Title</label>
                    <input type="text" name="title" placeholder="e.g. Restore and Maintain">
                </div>
                <div class="thr-form__group">
                    <label>Title (gold accent line)</label>
                    <input type="text" name="title_gold" placeholder="e.g. Your Confidence">
                </div>
            </div>
            <div class="thr-form__group">
                <label>Subtitle</label>
                <input type="text" name="subtitle" placeholder="Short supporting line">
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" placeholder="1" min="0">
            </div>
            <div style="display:flex;gap:1rem;justify-content:flex-end;margin-top:1rem">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addSlideModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Slide</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Slide Modal --}}
<div class="admin-modal" id="editSlideModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Edit Slide</h3>
            <button onclick="document.getElementById('editSlideModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editSlideForm" class="thr-form" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="thr-form__group">
                <label>Current Image</label>
                <div>
                    <img id="editSlideImagePreview" src="" alt="" style="height:60px;width:110px;object-fit:cover;border:1px solid #e5e7eb;padding:4px;border-radius:6px">
                </div>
            </div>
            <div class="thr-form__group">
                <label>Replace Image <span style="font-size:12px;color:#888">(leave blank to keep current)</span></label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
            </div>
            <div class="thr-form__group">
                <label>Eyebrow</label>
                <input type="text" name="eyebrow" id="editSlideEyebrow">
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Title</label>
                    <input type="text" name="title" id="editSlideTitle">
                </div>
                <div class="thr-form__group">
                    <label>Title (gold accent line)</label>
                    <input type="text" name="title_gold" id="editSlideTitleGold">
                </div>
            </div>
            <div class="thr-form__group">
                <label>Subtitle</label>
                <input type="text" name="subtitle" id="editSlideSubtitle">
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" id="editSlideSort" min="0">
            </div>
            <div style="display:flex;gap:1rem;justify-content:flex-end;margin-top:1rem">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editSlideModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editSlide(id, eyebrow, title, titleGold, subtitle, sort, imageUrl) {
    document.getElementById('editSlideForm').action = `/admin/hero-slides/${id}`;
    document.getElementById('editSlideEyebrow').value   = eyebrow;
    document.getElementById('editSlideTitle').value     = title;
    document.getElementById('editSlideTitleGold').value = titleGold;
    document.getElementById('editSlideSubtitle').value  = subtitle;
    document.getElementById('editSlideSort').value      = sort;
    document.getElementById('editSlideImagePreview').src = imageUrl;
    document.querySelector('#editSlideForm input[name="image"]').value = '';

    document.getElementById('editSlideModal').style.display = 'flex';
}
</script>
@endpush
