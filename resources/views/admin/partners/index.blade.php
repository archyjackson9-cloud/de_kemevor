@extends('layouts.admin')
@section('title', 'Partners')
@section('page-title', 'Partners Manager')

@section('content')

<div class="admin-page-actions">
    <button class="btn btn-gold" onclick="document.getElementById('addPartnerModal').style.display='flex'">
        <i class="fas fa-plus"></i> Add Partner
    </button>
</div>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><i class="fas fa-handshake"></i> Partners ({{ $partners->count() }})</h3>
        <span style="font-size:13px;color:#888">Partners are displayed on the home page.</span>
    </div>
    @if($partners->isEmpty())
    <div class="admin-empty"><i class="fas fa-handshake"></i> No partners yet. Add your first partner above.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>Logo</th><th>Name</th><th>Website</th><th>Order</th><th>Visible</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($partners as $p)
                <tr>
                    <td>
                        @if($p->logo)
                        <img src="{{ $p->logo_url }}" alt="{{ $p->name }}" style="height:40px;max-width:100px;object-fit:contain">
                        @else
                        <div class="admin-thumb-empty"><i class="fas fa-image"></i></div>
                        @endif
                    </td>
                    <td><strong>{{ $p->name }}</strong></td>
                    <td>
                        @if($p->website_url)
                        <a href="{{ $p->website_url }}" target="_blank" class="admin-link" style="font-size:13px">
                            {{ Str::limit($p->website_url, 35) }}
                        </a>
                        @else
                        <span style="color:#ccc">—</span>
                        @endif
                    </td>
                    <td>{{ $p->sort_order }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.partners.toggle', $p->id) }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-xs {{ $p->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $p->is_active ? '✓ Visible' : '✗ Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline"
                            onclick="editPartner({{ $p->id }}, '{{ addslashes($p->name) }}', '{{ addslashes($p->website_url ?? '') }}', {{ $p->sort_order }}, '{{ $p->logo ? $p->logo_url : '' }}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.partners.destroy', $p->id) }}" style="display:inline"
                              onsubmit="return confirm('Remove {{ addslashes($p->name) }} as a partner?')">
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

{{-- Add Partner Modal --}}
<div class="admin-modal" id="addPartnerModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add Partner</h3>
            <button onclick="document.getElementById('addPartnerModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.partners.store') }}" class="thr-form" enctype="multipart/form-data">
            @csrf
            <div class="thr-form__group">
                <label>Partner Name <span class="req">*</span></label>
                <input type="text" name="name" required placeholder="e.g. Ghana Health Service">
            </div>
            <div class="thr-form__group">
                <label>Website URL</label>
                <input type="url" name="website_url" placeholder="https://example.com">
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" placeholder="1" min="0">
                </div>
                <div class="thr-form__group">
                    <label>Logo <span style="font-size:12px;color:#888">(PNG/WebP recommended)</span></label>
                    <input type="file" name="logo" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml" class="admin-file-input">
                </div>
            </div>
            <div style="display:flex;gap:1rem;justify-content:flex-end;margin-top:1rem">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addPartnerModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Partner</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Partner Modal --}}
<div class="admin-modal" id="editPartnerModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Edit Partner</h3>
            <button onclick="document.getElementById('editPartnerModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editPartnerForm" class="thr-form" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="thr-form__group">
                <label>Partner Name <span class="req">*</span></label>
                <input type="text" name="name" id="editPartnerName" required>
            </div>
            <div class="thr-form__group">
                <label>Website URL</label>
                <input type="url" name="website_url" id="editPartnerUrl">
            </div>
            <div class="thr-form__group">
                <label>Sort Order</label>
                <input type="number" name="sort_order" id="editPartnerSort" min="0">
            </div>
            <div class="thr-form__group">
                <label>Logo</label>
                <div id="editPartnerLogoWrap" style="display:none;margin-bottom:.75rem">
                    <img id="editPartnerLogoPreview" src="" alt="" style="height:50px;max-width:150px;object-fit:contain;border:1px solid #e5e7eb;padding:4px;border-radius:6px">
                    <label style="display:flex;align-items:center;gap:.4rem;margin-top:.5rem;font-size:13px;cursor:pointer;color:#dc2626">
                        <input type="checkbox" name="remove_logo" value="1"> Remove current logo
                    </label>
                </div>
                <input type="file" name="logo" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml" class="admin-file-input">
            </div>
            <div style="display:flex;gap:1rem;justify-content:flex-end;margin-top:1rem">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editPartnerModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editPartner(id, name, url, sort, logoUrl) {
    document.getElementById('editPartnerForm').action = `/admin/partners/${id}`;
    document.getElementById('editPartnerName').value  = name;
    document.getElementById('editPartnerUrl').value   = url;
    document.getElementById('editPartnerSort').value  = sort;

    const wrap = document.getElementById('editPartnerLogoWrap');
    const img  = document.getElementById('editPartnerLogoPreview');
    if (logoUrl) {
        img.src = logoUrl;
        wrap.style.display = 'block';
    } else {
        wrap.style.display = 'none';
    }
    document.querySelector('#editPartnerForm input[name="logo"]').value = '';
    const cb = document.querySelector('#editPartnerForm input[name="remove_logo"]');
    if (cb) cb.checked = false;

    document.getElementById('editPartnerModal').style.display = 'flex';
}
</script>
@endpush
