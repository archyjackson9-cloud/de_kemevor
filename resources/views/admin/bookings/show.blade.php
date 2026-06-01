@extends('layouts.admin')
@section('title', 'Booking ' . $booking->confirmation_number)
@section('page-title', 'Booking Details')

@section('content')
<div class="admin-back">
    <a href="{{ route('admin.bookings') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Bookings</a>
</div>

<div class="admin-two-col">
    <div>
        {{-- Booking Info --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><i class="fas fa-calendar-check"></i> Booking #{{ $booking->confirmation_number }}</h3>
                <span class="status-badge status-badge--{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
            </div>
            <div class="admin-detail-grid">
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Service</span>
                    <span class="admin-detail-item__value">{{ $booking->service->name }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Category</span>
                    <span class="admin-detail-item__value">{{ $booking->service->category_label }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Date</span>
                    <span class="admin-detail-item__value">{{ $booking->booking_date->format('l, F j, Y') }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Time</span>
                    <span class="admin-detail-item__value">{{ substr($booking->booking_time, 0, 5) }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Duration</span>
                    <span class="admin-detail-item__value">{{ $booking->service->duration }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Original Price</span>
                    <span class="admin-detail-item__value">GHS {{ number_format($booking->original_price, 2) }}</span>
                </div>
                @if($booking->discount_amount > 0)
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Discount</span>
                    <span class="admin-detail-item__value" style="color:#16a34a">
                        -GHS {{ number_format($booking->discount_amount, 2) }}
                        @if($booking->discount_label)<small>({{ $booking->discount_label }})</small>@endif
                    </span>
                </div>
                @endif
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Final Price</span>
                    <span class="admin-detail-item__value"><strong>GHS {{ number_format($booking->final_price, 2) }}</strong></span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">SMS Reminders</span>
                    <span class="admin-detail-item__value">{{ $booking->consent_reminders ? '✓ Opted In' : '✗ Opted Out' }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Booked On</span>
                    <span class="admin-detail-item__value">{{ $booking->created_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
            @if($booking->notes)
            <div class="admin-detail-notes">
                <strong>Client Notes:</strong>
                <p>{{ $booking->notes }}</p>
            </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-cogs"></i> Actions</h3></div>
            <div class="admin-action-buttons">
                @foreach(['confirmed','completed','cancelled'] as $s)
                @if($booking->status !== $s)
                <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="{{ $s }}">
                    <button type="submit" class="btn btn-{{ $s === 'confirmed' ? 'green' : ($s === 'completed' ? 'blue' : 'red') }}">
                        <i class="fas fa-{{ $s === 'confirmed' ? 'check' : ($s === 'completed' ? 'check-double' : 'times') }}"></i>
                        Mark as {{ ucfirst($s) }}
                    </button>
                </form>
                @endif
                @endforeach
            </div>

            {{-- Reschedule --}}
            <div class="admin-card__section">
                <h4>Reschedule</h4>
                <form method="POST" action="{{ route('admin.bookings.update', $booking->id) }}" class="thr-form">
                    @csrf @method('PUT')
                    <div class="thr-form__row">
                        <div class="thr-form__group">
                            <label>New Date</label>
                            <input type="date" name="booking_date" value="{{ $booking->booking_date->toDateString() }}" required>
                        </div>
                        <div class="thr-form__group">
                            <label>New Time</label>
                            <select name="booking_time">
                                @foreach(['09:00','09:30','10:00','10:30','11:00','11:30','12:00','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00'] as $t)
                                <option value="{{ $t }}" {{ substr($booking->booking_time,0,5) === $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gold btn-sm">Update Schedule</button>
                </form>
            </div>
        </div>

        {{-- Reminder --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-bell"></i> Send Reminder</h3></div>
            <form method="POST" action="{{ route('admin.reminders.send') }}" class="thr-form">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                <div class="thr-form__row">
                    <div class="thr-form__group">
                        <label>Type</label>
                        <select name="type" required>
                            <option value="sms">SMS</option>
                            <option value="email">Email</option>
                        </select>
                    </div>
                </div>
                <div class="thr-form__group">
                    <label>Message (optional)</label>
                    <textarea name="message" rows="3" placeholder="Leave blank for default reminder message…"></textarea>
                </div>
                <button type="submit" class="btn btn-gold btn-sm"><i class="fas fa-paper-plane"></i> Send Reminder</button>
            </form>
        </div>
    </div>

    <div>
        {{-- Customer Info --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><i class="fas fa-user"></i> Customer</h3>
                <a href="{{ route('admin.customers.show', $booking->customer_id) }}" class="admin-card__action">Full Profile</a>
            </div>
            <div class="admin-detail-grid">
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Name</span>
                    <span class="admin-detail-item__value">{{ $booking->customer->full_name }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Phone</span>
                    <span class="admin-detail-item__value"><a href="tel:{{ $booking->customer->phone }}">{{ $booking->customer->phone }}</a></span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Email</span>
                    <span class="admin-detail-item__value"><a href="mailto:{{ $booking->customer->email }}">{{ $booking->customer->email }}</a></span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Gender</span>
                    <span class="admin-detail-item__value">{{ ucfirst(str_replace('_',' ',$booking->customer->gender)) }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Total Bookings</span>
                    <span class="admin-detail-item__value">{{ $booking->customer->total_bookings }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Loyalty Points</span>
                    <span class="admin-detail-item__value">{{ $booking->customer->loyalty_points }} pts</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Discount Tier</span>
                    <span class="admin-detail-item__value">{{ ucfirst(str_replace('_',' ', $booking->customer->discount_tier)) }}</span>
                </div>
            </div>
            @if($booking->customer->health_notes)
            <div class="admin-detail-notes">
                <strong>Health Notes:</strong>
                <p>{{ $booking->customer->health_notes }}</p>
            </div>
            @endif
        </div>

        {{-- Reminder History --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-history"></i> Reminder History</h3></div>
            @if($booking->reminders->isEmpty())
            <div class="admin-empty">No reminders sent for this booking.</div>
            @else
            <div class="admin-reminder-list">
                @foreach($booking->reminders as $r)
                <div class="admin-reminder-item">
                    <span class="admin-reminder-item__icon admin-reminder-item__icon--{{ $r->type }}">
                        <i class="fas fa-{{ $r->type === 'sms' ? 'sms' : 'envelope' }}"></i>
                    </span>
                    <div>
                        <div class="admin-reminder-title">{{ strtoupper($r->type) }} – {{ ucfirst($r->status) }}</div>
                        <div class="admin-reminder-date">{{ $r->sent_at?->format('M d, Y H:i') ?? 'N/A' }}</div>
                        @if($r->message)<div class="admin-reminder-msg">{{ $r->message }}</div>@endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
