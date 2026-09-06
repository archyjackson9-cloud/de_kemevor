@extends('layouts.admin')
@section('title', 'Inquiry ' . $inquiry->reference_number)
@section('page-title', 'Training Inquiry Details')

@section('content')
<div class="admin-back">
    <a href="{{ route('admin.training-inquiries') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Inquiries</a>
</div>

<div class="admin-two-col">
    <div>
        {{-- Applicant Info --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><i class="fas fa-user"></i> {{ $inquiry->reference_number }}</h3>
                {!! $inquiry->status_badge !!}
            </div>
            <div class="admin-detail-grid">
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Name</span>
                    <span class="admin-detail-item__value">{{ $inquiry->name }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Email</span>
                    <span class="admin-detail-item__value"><a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a></span>
                </div>
                @if($inquiry->phone)
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Phone</span>
                    <span class="admin-detail-item__value"><a href="tel:{{ $inquiry->phone }}">{{ $inquiry->phone }}</a></span>
                </div>
                @endif
                @if($inquiry->phase_interest)
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Interested Phase</span>
                    <span class="admin-detail-item__value">{{ $inquiry->phase_interest }}</span>
                </div>
                @endif
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Submitted</span>
                    <span class="admin-detail-item__value">{{ $inquiry->created_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
            @if($inquiry->message)
            <div class="admin-detail-notes">
                <strong>Applicant's Message:</strong>
                <p>{{ $inquiry->message }}</p>
            </div>
            @endif
        </div>
    </div>

    <div>
        {{-- Response --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-reply"></i> Respond</h3></div>

            @if($inquiry->status === 'responded')
            <div class="admin-card__section" style="border-top:none">
                <div class="admin-detail-notes" style="margin:-1.25rem -1.5rem 1rem">
                    <strong>Previously sent on {{ $inquiry->responded_at->format('M d, Y H:i') }}@if($inquiry->responded_by) by {{ $inquiry->responded_by }}@endif:</strong>
                    <p>{{ $inquiry->admin_response }}</p>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.training-inquiries.respond', $inquiry) }}" class="thr-form" style="padding:0 1.5rem 1.5rem">
                @csrf
                <div class="thr-form__group">
                    <label>{{ $inquiry->status === 'responded' ? 'Update & Resend Response' : 'Response' }} <span class="req">*</span></label>
                    <textarea name="admin_response" rows="8" required placeholder="Write your response about enrollment, next steps, schedule, or fees. This will be emailed directly to the applicant.">{{ old('admin_response', $inquiry->admin_response) }}</textarea>
                </div>
                <button type="submit" class="btn btn-gold btn-full">
                    <i class="fas fa-paper-plane"></i> Send Response by Email
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
