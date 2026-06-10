@extends('layouts.admin')
@section('title', 'Admin Users')
@section('page-title', 'Admin Accounts')

@section('content')

<div class="admin-page-actions">
    <button class="btn btn-gold" onclick="document.getElementById('addUserModal').style.display='flex'">
        <i class="fas fa-plus"></i> Add Admin User
    </button>
</div>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><i class="fas fa-user-shield"></i> Admin Users ({{ $users->count() }})</h3>
        <span style="font-size:13px;color:#888">Accounts that can sign in to this admin panel.</span>
    </div>
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead><tr><th>Name</th><th>Email</th><th>Joined</th><th>Actions</th></tr></thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td>
                        <strong>{{ $u->name }}</strong>
                        @if($u->id === session('admin_user_id'))
                        <div class="admin-table__sub">You</div>
                        @endif
                    </td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->created_at->format('M j, Y') }}</td>
                    <td class="admin-table__actions">
                        <button class="btn btn-xs btn-outline"
                            onclick="editUser({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ addslashes($u->email) }}')">
                            <i class="fas fa-edit"></i>
                        </button>
                        @if($users->count() > 1)
                        <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" style="display:inline"
                              onsubmit="return confirm('Remove {{ addslashes($u->name) }} as an admin user?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-red"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Add User Modal --}}
<div class="admin-modal" id="addUserModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add Admin User</h3>
            <button onclick="document.getElementById('addUserModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}" class="thr-form">
            @csrf
            <div class="thr-form__group">
                <label>Full Name <span class="req">*</span></label>
                <input type="text" name="name" required placeholder="Jane Doe">
            </div>
            <div class="thr-form__group">
                <label>Email Address <span class="req">*</span></label>
                <input type="email" name="email" required placeholder="jane@thehealingroom.com">
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Password <span class="req">*</span></label>
                    <input type="password" name="password" required minlength="8" placeholder="••••••••">
                </div>
                <div class="thr-form__group">
                    <label>Confirm Password <span class="req">*</span></label>
                    <input type="password" name="password_confirmation" required minlength="8" placeholder="••••••••">
                </div>
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addUserModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add User</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit User Modal --}}
<div class="admin-modal" id="editUserModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Edit Admin User</h3>
            <button onclick="document.getElementById('editUserModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" id="editUserForm" class="thr-form">
            @csrf @method('PUT')
            <div class="thr-form__group">
                <label>Full Name <span class="req">*</span></label>
                <input type="text" name="name" id="editUserName" required>
            </div>
            <div class="thr-form__group">
                <label>Email Address <span class="req">*</span></label>
                <input type="email" name="email" id="editUserEmail" required>
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>New Password <span style="font-size:12px;color:#888">(leave blank to keep current)</span></label>
                    <input type="password" name="password" minlength="8" placeholder="••••••••">
                </div>
                <div class="thr-form__group">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmation" minlength="8" placeholder="••••••••">
                </div>
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('editUserModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Save Changes</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editUser(id, name, email) {
    document.getElementById('editUserForm').action = `/admin/users/${id}`;
    document.getElementById('editUserName').value  = name;
    document.getElementById('editUserEmail').value = email;
    document.querySelector('#editUserForm input[name="password"]').value = '';
    document.querySelector('#editUserForm input[name="password_confirmation"]').value = '';
    document.getElementById('editUserModal').style.display = 'flex';
}
</script>
@endpush
