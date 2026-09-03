@extends('layouts.admin')
@section('title', 'Team Members')
@section('page-title', 'Meet the Team Manager')

@section('content')

<div class="admin-page-actions">
    <button class="btn btn-gold" onclick="document.getElementById('addMemberModal').style.display='flex'">
        <i class="fas fa-user-plus"></i> Add Team Member
    </button>
</div>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><i class="fas fa-users"></i> Team Members ({{ $members->count() }})</h3>
    </div>
    @if($members->isEmpty())
    <div class="admin-empty"><i class="fas fa-users"></i> No team members yet. Add your first team member above.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>Photo</th><th>Name</th><th>Role</th><th>Bio Preview</th><th>Visible</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($members as $m)
                <tr>
                    <td>
                        @if($m->image)
                        <img src="{{ $m->image_url }}" alt="{{ $m->name }}" class="admin-thumb admin-thumb--round">
                        @else
                        <div class="admin-thumb-empty admin-thumb--round"><i class="fas fa-user"></i></div>
                        @endif
                    </td>
                    <td><strong>{{ $m->name }}</strong></td>
                    <td style="color:#c8972b;font-size:13px">{{ $m->role }}</td>
                    <td style="font-size:12px;color:#888;max-width:240px">{{ Str::limit($m->bio, 70) }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.team.toggle', $m->id) }}" style="display:inline">
                            @csrf
                            <button type="submit" class="btn btn-xs {{ $m->is_active ? 'btn-green' : 'btn-outline' }}">
                                {{ $m->is_active ? '✓ Visible' : '✗ Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline"
                            onclick="editMember({{ $m->id }}, '{{ addslashes($m->name) }}', '{{ addslashes($m->role) }}', '{{ addslashes($m->bio ?? '') }}', {{ $m->sort_order ?? 0 }}, '{{ $m->image ? $m->image_url : '' }}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" action="{{ route('admin.team.destroy', $m->id) }}" style="display:inline"
                              onsubmit="return confirm('Remove {{ addslashes($m->name) }} from the team?')">
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

{{-- Add Member Modal --}}
<div class="admin-modal" id="addMemberModal" style="display:none">
    <div class="admin-modal__box admin-modal__box--lg">
        <div class="admin-modal__header">
            <h3>Add Team Member</h3>
            <button onclick="document.getElementById('addMemberModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.team.store') }}" class="thr-form" enctype="multipart/form-data">
            @csrf
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Full Name <span class="req">*</span></label>
                    <input type="text" name="name" required placeholder="e.g. Dr. Akua Sarpong">
                </div>
                <div class="thr-form__group">
                    <label>Role / Title <span class="req">*</span></label>
                    <input type="text" name="role" required placeholder="e.g. Founder & Lead Esthetician">
                </div>
            </div>
            <div class="thr-form__group">
                <label>Bio</label>
                <textarea name="bio" rows="3" placeholder="Short biography…" maxlength="600"></textarea>
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" placeholder="1" min="0">
                </div>
                <div class="thr-form__group">
                    <label>Photo <span style="font-size:12px;color:#888">(JPEG/PNG/WebP, max 2MB)</span></label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
                </div>
            </div>
            <div style="display:flex;gap:1rem;justify-content:flex-end;margin-top:1rem">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addMemberModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Member</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Member Modal --}}
<div class="admin-modal" id="editMemberModal" style="display:none">
    <div class="admin-modal__box admin-modal__box--lg">
        <div class="admin-modal__header">
            <h3>Edit Team Member</h3>
            <button onclick="document.getElementById('editMemberModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editMemberForm" class="thr-form" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Full Name <span class="req">*</span></label>
                    <input type="text" name="name" id="editMemberName" required>
                </div>
                <div class="thr-form__group">
                    <label>Role / Title <span class="req">*</span></label>
                    <input type="text" name="role" id="editMemberRole" required>
                </div>
            </div>
            <div class="thr-form__group">
                <label>Bio</label>
                <textarea name="bio" id="editMemberBio" rows="3" maxlength="600"></textarea>
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" id="editMemberSort" min="0">
                </div>
            </div>
            <div class="thr-form__group">
                <label>Photo</label>
                <div id="editMemberImageWrap" style="display:none;margin-bottom:.75rem">
                    <img id="editMemberImagePreview" src="" alt="" style="height:80px;width:80px;border-radius:50%;object-fit:cover;border:2px solid #c8972b">
                    <label style="display:flex;align-items:center;gap:.4rem;margin-top:.5rem;font-size:13px;cursor:pointer;color:#dc2626">
                        <input type="checkbox" name="remove_image" value="1"> Remove current photo
                    </label>
                </div>
                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" class="admin-file-input">
                <span style="font-size:12px;color:#888">Upload a new photo to replace the current one.</span>
            </div>
            <div style="display:flex;gap:1rem;justify-content:flex-end;margin-top:1rem">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editMemberModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editMember(id, name, role, bio, sort, imageUrl) {
    document.getElementById('editMemberForm').action = `/admin/team/${id}`;
    document.getElementById('editMemberName').value = name;
    document.getElementById('editMemberRole').value = role;
    document.getElementById('editMemberBio').value  = bio;
    document.getElementById('editMemberSort').value = sort;

    const wrap = document.getElementById('editMemberImageWrap');
    const img  = document.getElementById('editMemberImagePreview');
    if (imageUrl) {
        img.src = imageUrl;
        wrap.style.display = 'block';
    } else {
        wrap.style.display = 'none';
    }
    document.querySelector('#editMemberForm input[name="image"]').value = '';
    const cb = document.querySelector('#editMemberForm input[name="remove_image"]');
    if (cb) cb.checked = false;

    document.getElementById('editMemberModal').style.display = 'flex';
}
</script>
@endpush
