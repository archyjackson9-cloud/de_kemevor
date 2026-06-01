@extends('layouts.app')
@section('title', 'Booking Confirmed | The Healing Room')

@section('content')
<section class="thr-section thr-section--light" style="min-height:70vh;display:flex;align-items:center">
    <div class="thr-container thr-container--narrow">
        <div class="thr-success-card">
            <div class="thr-success-card__icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="thr-success-card__title">Booking Received!</h1>
            <p class="thr-success-card__sub">
                We'll confirm your appointment within 2 hours via SMS and email.
            </p>

            <div class="thr-success-card__confnum">
                <span class="thr-success-card__confnum-label">Confirmation Number</span>
                <span class="thr-success-card__confnum-val">{{ $booking->confirmation_number }}</span>
            </div>

            <div class="thr-review-card thr-review-card--success">
                <div class="thr-review-card__row">
                    <span class="thr-review-card__label"><i class="fas fa-spa"></i> Service</span>
                    <span class="thr-review-card__value">{{ $booking->service->name }}</span>
                </div>
                <div class="thr-review-card__row">
                    <span class="thr-review-card__label"><i class="fas fa-calendar"></i> Date</span>
                    <span class="thr-review-card__value">{{ $booking->booking_date->format('l, F j, Y') }}</span>
                </div>
                <div class="thr-review-card__row">
                    <span class="thr-review-card__label"><i class="fas fa-clock"></i> Time</span>
                    <span class="thr-review-card__value">{{ substr($booking->booking_time, 0, 5) }}</span>
                </div>
                <div class="thr-review-card__row">
                    <span class="thr-review-card__label"><i class="fas fa-user"></i> Name</span>
                    <span class="thr-review-card__value">{{ $booking->customer->full_name }}</span>
                </div>
                @if($booking->discount_amount > 0)
                <div class="thr-review-card__row thr-review-card__row--discount">
                    <span class="thr-review-card__label"><i class="fas fa-tags"></i> Discount</span>
                    <span class="thr-review-card__value">
                        <span style="text-decoration:line-through;opacity:.6">GHS {{ number_format($booking->original_price, 0) }}</span>
                        → <strong>GHS {{ number_format($booking->final_price, 0) }}</strong>
                        <span class="thr-discount-badge">{{ $booking->discount_label }}</span>
                    </span>
                </div>
                @else
                <div class="thr-review-card__row">
                    <span class="thr-review-card__label"><i class="fas fa-tag"></i> Price</span>
                    <span class="thr-review-card__value">From GHS {{ number_format($booking->final_price, 0) }}</span>
                </div>
                @endif
            </div>

            <div class="thr-success-card__info">
                <p><i class="fas fa-info-circle"></i>
                    Please save your confirmation number. Our team will reach out to you on
                    <strong>{{ $booking->customer->phone }}</strong> and
                    <strong>{{ $booking->customer->email }}</strong> to confirm.
                </p>
            </div>

            <div class="thr-success-card__actions">
                <a href="{{ route('home') }}" class="btn btn-outline">
                    <i class="fas fa-home"></i> Return Home
                </a>
                <a href="{{ route('booking') }}" class="btn btn-gold">
                    <i class="fas fa-plus"></i> Book Another
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
