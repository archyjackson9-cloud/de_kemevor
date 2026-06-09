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
                        <button class="btn btn-xs btn-outline"
                            onclick="editService({{ $s->id }}, '{{ addslashes($s->name) }}', '{{ $s->category }}', '{{ addslashes($s->short_description) }}', '{{ $s->duration }}', {{ $s->price_from }}, {{ $s->sort_order }}, '{{ $s->image ? $s->image_url : '' }}')">
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
                    </select>
                </div>
            </div>
            <div class="thr-form__group">
                <label>Short Description <span class="req">*</span></label>
                <textarea name="short_description" rows="2" required placeholder="2 sentences describing the service…"></textarea>
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
                <label>Service Image <span style="font-size:12px;color:#888">(JPEG/PNG/WebP, max 2MB)</span></label>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
            </div>
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
                    </select>
                </div>
            </div>
            <div class="thr-form__group">
                <label>Short Description</label>
                <textarea name="short_description" id="editDesc" rows="2"></textarea>
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
function editService(id, name, category, desc, duration, price, sort, imageUrl) {
    document.getElementById('editServiceForm').action = `/admin/services/${id}`;
    document.getElementById('editName').value     = name;
    document.getElementById('editCategory').value = category;
    document.getElementById('editDesc').value     = desc;
    document.getElementById('editDuration').value = duration;
    document.getElementById('editPrice').value    = price;
    document.getElementById('editSort').value     = sort;

    const imgWrap = document.getElementById('editCurrentImage');
    const imgEl   = document.getElementById('editImagePreview');
    if (imageUrl) {
        imgEl.src = imageUrl;
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
