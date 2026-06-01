@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')

{{-- KPI Cards --}}
<div class="admin-kpi-grid">
    <div class="admin-kpi-card admin-kpi-card--gold">
        <div class="admin-kpi-card__icon"><i class="fas fa-calendar-day"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">{{ $todayBookings }}</div>
            <div class="admin-kpi-card__label">Today's Appointments</div>
        </div>
    </div>
    <div class="admin-kpi-card admin-kpi-card--blue">
        <div class="admin-kpi-card__icon"><i class="fas fa-calendar-week"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">{{ $weekBookings }}</div>
            <div class="admin-kpi-card__label">This Week's Bookings</div>
        </div>
    </div>
    <div class="admin-kpi-card admin-kpi-card--green">
        <div class="admin-kpi-card__icon"><i class="fas fa-users"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">{{ $totalCustomers }}</div>
            <div class="admin-kpi-card__label">Total Customers</div>
        </div>
    </div>
    <div class="admin-kpi-card admin-kpi-card--purple">
        <div class="admin-kpi-card__icon"><i class="fas fa-coins"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">GHS {{ number_format($revenueThisMonth, 0) }}</div>
            <div class="admin-kpi-card__label">Revenue This Month</div>
        </div>
    </div>
</div>

{{-- Status Row --}}
<div class="admin-kpi-grid admin-kpi-grid--sm">
    <div class="admin-status-card admin-status-card--pending">
        <i class="fas fa-hourglass-half"></i>
        <span>{{ $pendingBookings }}</span>
        <span>Pending</span>
    </div>
    <div class="admin-status-card admin-status-card--confirmed">
        <i class="fas fa-check"></i>
        <span>{{ $confirmedBookings }}</span>
        <span>Confirmed</span>
    </div>
    <div class="admin-status-card admin-status-card--completed">
        <i class="fas fa-check-double"></i>
        <span>{{ $completedBookings }}</span>
        <span>Completed</span>
    </div>
</div>

{{-- Quick Actions --}}
<div class="admin-card">
    <div class="admin-card__header">
        <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
    </div>
    <div class="admin-quick-actions">
        <a href="{{ route('admin.bookings') }}" class="admin-quick-action">
            <i class="fas fa-plus-circle"></i>
            <span>New Booking</span>
        </a>
        <a href="{{ route('admin.bookings') }}" class="admin-quick-action">
            <i class="fas fa-calendar-alt"></i>
            <span>All Bookings</span>
        </a>
        <a href="{{ route('admin.customers') }}" class="admin-quick-action">
            <i class="fas fa-user-plus"></i>
            <span>Add Customer</span>
        </a>
        <a href="{{ route('admin.discounts') }}" class="admin-quick-action">
            <i class="fas fa-gift"></i>
            <span>Send Discount</span>
        </a>
        <a href="{{ route('admin.reminders') }}" class="admin-quick-action">
            <i class="fas fa-bell"></i>
            <span>Send Reminder</span>
        </a>
        <a href="{{ route('admin.reports') }}" class="admin-quick-action">
            <i class="fas fa-chart-line"></i>
            <span>View Reports</span>
        </a>
    </div>
</div>

<div class="admin-two-col">
    {{-- Upcoming Appointments --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <h3><i class="fas fa-calendar-check"></i> Upcoming Appointments</h3>
            <a href="{{ route('admin.bookings') }}" class="admin-card__action">View All</a>
        </div>
        @if($upcomingBookings->isEmpty())
        <div class="admin-empty"><i class="fas fa-calendar"></i> No upcoming appointments.</div>
        @else
        <div class="admin-upcoming-list">
            @foreach($upcomingBookings as $b)
            <a href="{{ route('admin.bookings.show', $b->id) }}" class="admin-upcoming-item">
                <div class="admin-upcoming-item__date">
                    <span>{{ $b->booking_date->format('M') }}</span>
                    <strong>{{ $b->booking_date->format('d') }}</strong>
                </div>
                <div class="admin-upcoming-item__body">
                    <div class="admin-upcoming-item__name">{{ $b->customer->full_name }}</div>
                    <div class="admin-upcoming-item__service">{{ $b->service->name }}</div>
                    <div class="admin-upcoming-item__time"><i class="fas fa-clock"></i> {{ substr($b->booking_time, 0, 5) }}</div>
                </div>
                <div class="status-badge status-badge--{{ $b->status }}">{{ ucfirst($b->status) }}</div>
            </a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Recent Bookings --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <h3><i class="fas fa-history"></i> Recent Bookings</h3>
            <a href="{{ route('admin.bookings') }}" class="admin-card__action">View All</a>
        </div>
        @if($recentBookings->isEmpty())
        <div class="admin-empty">No bookings yet.</div>
        @else
        <table class="admin-table admin-table--compact">
            <thead>
                <tr>
                    <th>Ref</th><th>Customer</th><th>Service</th><th>Date</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentBookings as $b)
                <tr>
                    <td><a href="{{ route('admin.bookings.show', $b->id) }}" class="admin-link">{{ $b->confirmation_number }}</a></td>
                    <td>{{ $b->customer->full_name }}</td>
                    <td>{{ Str::limit($b->service->name, 22) }}</td>
                    <td>{{ $b->booking_date->format('M d') }}</td>
                    <td><span class="status-badge status-badge--{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection
