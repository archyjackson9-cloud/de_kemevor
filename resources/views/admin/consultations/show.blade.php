@extends('layouts.admin')
@section('title', 'Consultation ' . $consultation->reference_number)
@section('page-title', 'E-Consultation Details')

@section('content')
<div class="admin-back">
    <a href="{{ route('admin.consultations') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Consultations</a>
</div>

<div class="admin-two-col">
    <div>
        {{-- Client Info --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><i class="fas fa-user"></i> {{ $consultation->reference_number }}</h3>
                {!! $consultation->status_badge !!}
            </div>
            <div class="admin-detail-grid">
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Name</span>
                    <span class="admin-detail-item__value">{{ $consultation->name }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Email</span>
                    <span class="admin-detail-item__value"><a href="mailto:{{ $consultation->email }}">{{ $consultation->email }}</a></span>
                </div>
                @if($consultation->phone)
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Phone</span>
                    <span class="admin-detail-item__value"><a href="tel:{{ $consultation->phone }}">{{ $consultation->phone }}</a></span>
                </div>
                @endif
                @if($consultation->age)
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Age</span>
                    <span class="admin-detail-item__value">{{ $consultation->age }}</span>
                </div>
                @endif
                @if($consultation->gender)
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Gender</span>
                    <span class="admin-detail-item__value">{{ ucfirst($consultation->gender) }}</span>
                </div>
                @endif
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Concern Area</span>
                    <span class="admin-detail-item__value">{{ $consultation->concern_area_label }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Submitted</span>
                    <span class="admin-detail-item__value">{{ $consultation->created_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
            <div class="admin-detail-notes">
                <strong>Client's Description:</strong>
                <p>{{ $consultation->problem_description }}</p>
            </div>
        </div>

        {{-- Attached Images --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-images"></i> Attached Photos ({{ $consultation->images->count() }})</h3></div>
            @if($consultation->images->isEmpty())
            <div class="admin-empty"><i class="fas fa-image"></i> No photos were attached to this request.</div>
            @else
            <div class="admin-image-gallery">
                @foreach($consultation->images as $img)
                <a href="{{ $img->url }}" target="_blank" class="admin-image-gallery__item">
                    <img src="{{ $img->url }}" alt="Attached photo">
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <div>
        {{-- Response --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-prescription"></i> Prescribe a Solution</h3></div>

            @if($consultation->status === 'responded')
            <div class="admin-card__section" style="border-top:none">
                <div class="admin-detail-notes" style="margin:-1.25rem -1.5rem 1rem">
                    <strong>Previously sent on {{ $consultation->responded_at->format('M d, Y H:i') }}@if($consultation->responded_by) by {{ $consultation->responded_by }}@endif:</strong>
                    <p>{{ $consultation->admin_response }}</p>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('admin.consultations.respond', $consultation) }}" class="thr-form" style="padding:0 1.5rem 1.5rem">
                @csrf
                <div class="thr-form__group">
                    <label>{{ $consultation->status === 'responded' ? 'Update & Resend Response' : 'Response / Recommendation' }} <span class="req">*</span></label>
                    <textarea name="admin_response" rows="8" required placeholder="Write your recommended treatment, advice, or next steps. This will be emailed directly to the client.">{{ old('admin_response', $consultation->admin_response) }}</textarea>
                </div>
                <button type="submit" class="btn btn-gold btn-full">
                    <i class="fas fa-paper-plane"></i> Send Response by Email
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
