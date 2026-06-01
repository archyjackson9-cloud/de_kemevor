@extends('layouts.admin')
@section('title', 'Reminders')
@section('page-title', 'Automated Reminders')

@section('content')

{{-- Settings --}}
<div class="admin-two-col">
    <div class="admin-card">
        <div class="admin-card__header"><h3><i class="fas fa-cog"></i> Reminder Settings</h3></div>
        <div class="admin-reminder-settings">
            <div class="admin-reminder-toggle">
                <div>
                    <strong><i class="fas fa-sms"></i> SMS Reminders</strong>
                    <p class="admin-setting-hint">Sent 24 hours before appointment</p>
                </div>
                <label class="admin-toggle">
                    <input type="checkbox" {{ $smsEnabled ? 'checked' : '' }} id="smsToggle">
                    <span class="admin-toggle__slider"></span>
                </label>
            </div>
            <div class="admin-reminder-toggle">
                <div>
                    <strong><i class="fas fa-envelope"></i> Email Reminders</strong>
                    <p class="admin-setting-hint">Sent 48 hours before appointment</p>
                </div>
                <label class="admin-toggle">
                    <input type="checkbox" {{ $emailEnabled ? 'checked' : '' }} id="emailToggle">
                    <span class="admin-toggle__slider"></span>
                </label>
            </div>
            <form method="POST" action="{{ route('admin.reminders.auto') }}" class="admin-setting-action">
                @csrf
                <button type="submit" class="btn btn-gold btn-sm">
                    <i class="fas fa-sync"></i> Process Auto-Reminders Now
                </button>
            </form>
        </div>
    </div>

    {{-- Send Manual Reminder --}}
    <div class="admin-card">
        <div class="admin-card__header"><h3><i class="fas fa-paper-plane"></i> Send Manual Reminder</h3></div>
        <form method="POST" action="{{ route('admin.reminders.send') }}" class="thr-form">
            @csrf
            <div class="thr-form__group">
                <label>Select Appointment <span class="req">*</span></label>
                <select name="booking_id" required>
                    <option value="">Select upcoming booking…</option>
                    @foreach($pendingBookings as $b)
                    <option value="{{ $b->id }}">
                        {{ $b->confirmation_number }} – {{ $b->customer->full_name }}
                        ({{ $b->service->name }}, {{ $b->booking_date->format('M d') }} {{ substr($b->booking_time,0,5) }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="thr-form__group">
                <label>Reminder Type <span class="req">*</span></label>
                <select name="type" required>
                    <option value="sms">SMS</option>
                    <option value="email">Email</option>
                </select>
            </div>
            <div class="thr-form__group">
                <label>Custom Message (optional)</label>
                <textarea name="message" rows="3" placeholder="Leave blank to use the default reminder message…"></textarea>
            </div>
            <button type="submit" class="btn btn-gold btn-sm">
                <i class="fas fa-paper-plane"></i> Send Reminder
            </button>
        </form>
    </div>
</div>

{{-- Reminder Log --}}
<div class="admin-card">
    <div class="admin-card__header">
        <h3><i class="fas fa-history"></i> Sent Reminders Log ({{ $reminders->total() }})</h3>
    </div>
    @if($reminders->isEmpty())
    <div class="admin-empty"><i class="fas fa-bell-slash"></i> No reminders sent yet.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>Time Sent</th><th>Customer</th><th>Booking Ref</th><th>Service</th><th>Type</th><th>Status</th><th>Message</th></tr>
            </thead>
            <tbody>
                @foreach($reminders as $r)
                <tr>
                    <td>{{ $r->sent_at?->format('M d, Y H:i') ?? '–' }}</td>
                    <td>
                        <a href="{{ route('admin.customers.show', $r->customer_id) }}" class="admin-link">
                            {{ $r->customer->full_name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $r->booking_id) }}" class="admin-link">
                            {{ $r->booking->confirmation_number }}
                        </a>
                    </td>
                    <td>{{ Str::limit($r->booking->service->name, 20) }}</td>
                    <td>
                        <span class="status-badge {{ $r->type === 'sms' ? 'status-badge--confirmed' : 'status-badge--pending' }}">
                            <i class="fas fa-{{ $r->type === 'sms' ? 'sms' : 'envelope' }}"></i>
                            {{ strtoupper($r->type) }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge status-badge--{{ $r->status }}">{{ ucfirst($r->status) }}</span>
                    </td>
                    <td class="admin-table__msg">{{ Str::limit($r->message, 60) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $reminders->links() }}</div>
    @endif
</div>

@endsection
