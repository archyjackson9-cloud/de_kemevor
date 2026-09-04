@extends('layouts.admin')
@section('title', 'Branding')
@section('page-title', 'Site Branding')

@section('content')

<div class="admin-card" style="max-width:560px">
    <div class="admin-card__header"><h3><i class="fas fa-image"></i> Site Logo</h3></div>
    <form method="POST" action="{{ route('admin.settings.update') }}" class="thr-form" enctype="multipart/form-data">
        @csrf
        <div class="thr-form__group">
            <label>Logo</label>
            @if($logo)
            <div style="margin-bottom:.75rem">
                <img src="{{ asset('storage/'.$logo) }}" alt="Current logo" style="height:60px;max-width:220px;object-fit:contain;border:1px solid #e5e7eb;padding:8px;border-radius:6px">
                <label style="display:flex;align-items:center;gap:.4rem;margin-top:.5rem;font-size:13px;cursor:pointer;color:#dc2626">
                    <input type="checkbox" name="remove_logo" value="1"> Remove current logo
                </label>
            </div>
            @else
            <p style="font-size:13px;color:#888;margin-bottom:.5rem">No logo uploaded yet — the site shows the 🌿 text mark by default.</p>
            @endif
            <input type="file" name="logo" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml" class="admin-file-input">
            <span style="font-size:12px;color:#888">PNG or SVG with a transparent background recommended, max 1MB.</span>
        </div>
        <button type="submit" class="btn btn-gold">
            <i class="fas fa-check"></i> Save
        </button>
    </form>
</div>

@endsection
