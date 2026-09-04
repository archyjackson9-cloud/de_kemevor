@extends('layouts.admin')
@section('title', 'Services')
@section('page-title', 'Services Manager')

@section('content')

<div class="admin-page-actions">
    <button class="btn btn-gold" onclick="document.getElementById('addServiceModal').style.display='flex'">
        <i class="fas fa-plus"></i> Add Service
    </button>
</div>

<div class="admin-card">
    <div class="admin-card__header">
        <h3>All Services ({{ $services->count() }})</h3>
    </div>
    @if($services->isEmpty())
    <div class="admin-empty">No services found.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th><th>Image</th><th>Name</th><th>Category</th><th>Duration</th><th>Price From</th><th>Status</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $s)
                @php
                    $editPayload = \Illuminate\Support\Arr::only($s->toArray(), [
                        'id', 'name', 'category', 'short_description', 'description',
                        'meta_title', 'meta_description', 'duration', 'price_from', 'sort_order',
                    ]);
                    $editPayload['image_url'] = $s->image ? $s->image_url : '';
                    $editPayloadJson = json_encode($editPayload);
                @endphp
                <tr>
                    <td>{{ $s->sort_order }}</td>
                    <td>
                        @if($s->image)
                        <img src="{{ $s->image_url }}" alt="{{ $s->name }}" class="admin-thumb">
                        @else
                        <div class="admin-thumb-empty"><i class="fas fa-image"></i></div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $s->name }}</strong>
                        <div style="font-size:12px;color:#888;max-width:280px">{{ Str::limit($s->short_description, 55) }}</div>
                    </td>
                    <td>
                        <span class="category-badge category-badge--{{ $s->category }}">
                            {{ \App\Models\Service::getCategoryIcon($s->category) }} {{ $s->category_label }}
                        </span>
                    </td>
                    <td>{{ $s->duration }}</td>
                    <td>GHS {{ number_format($s->price_from, 0) }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.services.toggle', $s->id) }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-xs {{ $s->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $s->is_active ? '✓ Active' : '✗ Inactive' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        @if($s->is_active)
                        <a href="{{ route('services.show', $s->slug) }}" target="_blank" class="btn btn-xs btn-outline" title="View live page">
                            <i class="fas fa-eye"></i>
                        </a>
                        @endif
                        <button type="button" class="btn btn-xs btn-outline"
                            data-service='{{ $editPayloadJson }}'
                            onclick="editService(this)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.services.destroy', $s->id) }}" style="display:inline"
                              onsubmit="return confirm('Delete this service? This cannot be undone.')">
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

{{-- Add Service Modal --}}
<div class="admin-modal" id="addServiceModal" style="display:none">
    <div class="admin-modal__box admin-modal__box--lg">
        <div class="admin-modal__header">
            <h3>Add New Service</h3>
            <button onclick="document.getElementById('addServiceModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.services.store') }}" class="thr-form" enctype="multipart/form-data">
            @csrf
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Service Name <span class="req">*</span></label>
                    <input type="text" name="name" required placeholder="e.g. Deep Hydration Facial">
                </div>
                <div class="thr-form__group">
                    <label>Category <span class="req">*</span></label>
                    <select name="category" required>
                        <option value="">Select…</option>
                        <option value="maternity_postop">Maternity & Post-Op Care</option>
                        <option value="body_treatments">Body Treatments</option>
                        <option value="skin_treatments">Skin Treatments</option>
                        <option value="rejuvenation">Rejuvenation</option>
                        <option value="body_enhancement">Body Enhancement</option>
                    </select>
                </div>
            </div>
            <div class="thr-form__group">
                <label>Short Description <span class="req">*</span></label>
                <textarea name="short_description" rows="2" required placeholder="1-2 sentences — used on listing cards and as the SEO fallback description…" maxlength="300"></textarea>
            </div>
            <div class="thr-form__group">
                <label>Full Article <span style="font-size:12px;color:#888">(shown on the service's own page — explain why clients should book this treatment at The Healing Room. Separate paragraphs with a blank line.)</span></label>
                <textarea name="description" rows="6" placeholder="Write 2-4 paragraphs about this treatment: what it addresses, what to expect, and why The Healing Room…" maxlength="4000"></textarea>
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Duration <span class="req">*</span></label>
                    <input type="text" name="duration" required placeholder="60 minutes">
                </div>
                <div class="thr-form__group">
                    <label>Price From (GHS) <span class="req">*</span></label>
                    <input type="number" name="price_from" required min="0" step="0.01" placeholder="250.00">
                </div>
                <div class="thr-form__group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" placeholder="15">
                </div>
            </div>
            <div class="thr-form__group">
                <label>Service Image <span style="font-size:12px;color:#888">(JPEG/PNG/WebP, max 2MB — used as the page's hero banner)</span></label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
            </div>
            <fieldset style="border:1px dashed #d1d5db;border-radius:8px;padding:1rem;margin-top:1rem">
                <legend style="font-size:.8rem;color:#888;padding:0 .5rem">SEO (optional — falls back to name / short description)</legend>
                <div class="thr-form__group">
                    <label>Meta Title <span style="font-size:12px;color:#888">(max 160 chars)</span></label>
                    <input type="text" name="meta_title" maxlength="160" placeholder="e.g. Non-Invasive Lipo 380 in Accra | The Healing Room">
                </div>
                <div class="thr-form__group">
                    <label>Meta Description <span style="font-size:12px;color:#888">(max 300 chars)</span></label>
                    <textarea name="meta_description" rows="2" maxlength="300" placeholder="Shown in Google search results…"></textarea>
                </div>
            </fieldset>
            <div style="display:flex;gap:1rem;justify-content:flex-end;margin-top:1rem">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addServiceModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Service</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Service Modal --}}
<div class="admin-modal" id="editServiceModal" style="display:none">
    <div class="admin-modal__box admin-modal__box--lg">
        <div class="admin-modal__header">
            <h3>Edit Service</h3>
            <button onclick="document.getElementById('editServiceModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editServiceForm" class="thr-form" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Service Name</label>
                    <input type="text" name="name" id="editName" required>
                </div>
                <div class="thr-form__group">
                    <label>Category</label>
                    <select name="category" id="editCategory">
                        <option value="maternity_postop">Maternity & Post-Op Care</option>
                        <option value="body_treatments">Body Treatments</option>
                        <option value="skin_treatments">Skin Treatments</option>
                        <option value="rejuvenation">Rejuvenation</option>
                        <option value="body_enhancement">Body Enhancement</option>
                    </select>
                </div>
            </div>
            <div class="thr-form__group">
                <label>Short Description</label>
                <textarea name="short_description" id="editDesc" rows="2" maxlength="300"></textarea>
            </div>
            <div class="thr-form__group">
                <label>Full Article <span style="font-size:12px;color:#888">(shown on the service's own page. Separate paragraphs with a blank line.)</span></label>
                <textarea name="description" id="editArticle" rows="6" maxlength="4000"></textarea>
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Duration</label>
                    <input type="text" name="duration" id="editDuration">
                </div>
                <div class="thr-form__group">
                    <label>Price From (GHS)</label>
                    <input type="number" name="price_from" id="editPrice" min="0" step="0.01">
                </div>
                <div class="thr-form__group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" id="editSort">
                </div>
            </div>
            <div class="thr-form__group">
                <label>Service Image</label>
                <div id="editCurrentImage" style="display:none;margin-bottom:.75rem">
                    <img id="editImagePreview" src="" alt="" style="height:80px;border-radius:8px;object-fit:cover;border:1px solid #e5e7eb">
                    <label style="display:flex;align-items:center;gap:.4rem;margin-top:.5rem;font-size:13px;cursor:pointer;color:#dc2626">
                        <input type="checkbox" name="remove_image" value="1"> Remove current image
                    </label>
                </div>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
                <span style="font-size:12px;color:#888">Upload a new image to replace the current one.</span>
            </div>
            <fieldset style="border:1px dashed #d1d5db;border-radius:8px;padding:1rem;margin-top:1rem">
                <legend style="font-size:.8rem;color:#888;padding:0 .5rem">SEO (optional — falls back to name / short description)</legend>
                <div class="thr-form__group">
                    <label>Meta Title <span style="font-size:12px;color:#888">(max 160 chars)</span></label>
                    <input type="text" name="meta_title" id="editMetaTitle" maxlength="160">
                </div>
                <div class="thr-form__group">
                    <label>Meta Description <span style="font-size:12px;color:#888">(max 300 chars)</span></label>
                    <textarea name="meta_description" id="editMetaDesc" rows="2" maxlength="300"></textarea>
                </div>
            </fieldset>
            <div style="display:flex;gap:1rem;justify-content:flex-end;margin-top:1rem">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editServiceModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editService(btn) {
    const s = JSON.parse(btn.dataset.service);

    document.getElementById('editServiceForm').action = `/admin/services/${s.id}`;
    document.getElementById('editName').value        = s.name ?? '';
    document.getElementById('editCategory').value     = s.category ?? '';
    document.getElementById('editDesc').value         = s.short_description ?? '';
    document.getElementById('editArticle').value      = s.description ?? '';
    document.getElementById('editDuration').value     = s.duration ?? '';
    document.getElementById('editPrice').value        = s.price_from ?? '';
    document.getElementById('editSort').value         = s.sort_order ?? 0;
    document.getElementById('editMetaTitle').value    = s.meta_title ?? '';
    document.getElementById('editMetaDesc').value     = s.meta_description ?? '';

    const imgWrap = document.getElementById('editCurrentImage');
    const imgEl   = document.getElementById('editImagePreview');
    if (s.image_url) {
        imgEl.src = s.image_url;
        imgWrap.style.display = 'block';
    } else {
        imgWrap.style.display = 'none';
    }
    // Reset file input and checkbox
    document.querySelector('#editServiceForm input[name="image"]').value = '';
    const cb = document.querySelector('#editServiceForm input[name="remove_image"]');
    if (cb) cb.checked = false;

    document.getElementById('editServiceModal').style.display = 'flex';
}
</script>
@endpush
