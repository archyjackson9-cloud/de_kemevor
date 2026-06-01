@extends('layouts.admin')
@section('title', $customer->full_name)
@section('page-title', 'Customer Profile')

@section('content')
<div class="admin-back">
    <a href="{{ route('admin.customers') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Customers</a>
</div>

<div class="admin-two-col">
    <div>
        {{-- Profile --}}
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><i class="fas fa-user-circle"></i> {{ $customer->full_name }}</h3>
                <span class="tier-badge tier-badge--{{ $customer->discount_tier }}">
                    {{ ucfirst(str_replace('_',' ',$customer->discount_tier)) }}
                </span>
            </div>
            <div class="admin-detail-grid">
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Phone</span>
                    <span class="admin-detail-item__value"><a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a></span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Email</span>
                    <span class="admin-detail-item__value"><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Gender</span>
                    <span class="admin-detail-item__value">{{ ucfirst(str_replace('_',' ',$customer->gender)) }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Date of Birth</span>
                    <span class="admin-detail-item__value">{{ $customer->date_of_birth?->format('M d, Y') ?? 'Not provided' }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Total Bookings</span>
                    <span class="admin-detail-item__value">{{ $customer->total_bookings }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Loyalty Points</span>
                    <span class="admin-detail-item__value">{{ $customer->loyalty_points }} pts</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Member Since</span>
                    <span class="admin-detail-item__value">{{ $customer->created_at->format('M d, Y') }}</span>
                </div>
                <div class="admin-detail-item">
                    <span class="admin-detail-item__label">Active Discount</span>
                    <span class="admin-detail-item__value">{{ $customer->discount_label }}</span>
                </div>
            </div>
            @if($customer->health_notes)
            <div class="admin-detail-notes">
                <strong>Skin/Health Profile:</strong>
                <p>{{ $customer->health_notes }}</p>
            </div>
            @endif
        </div>

        {{-- Edit Customer --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-edit"></i> Edit Profile</h3></div>
            <form method="POST" action="{{ route('admin.customers.update', $customer->id) }}" class="thr-form">
                @csrf @method('PUT')
                <div class="thr-form__row">
                    <div class="thr-form__group">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="{{ $customer->first_name }}">
                    </div>
                    <div class="thr-form__group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ $customer->last_name }}">
                    </div>
                </div>
                <div class="thr-form__row">
                    <div class="thr-form__group">
                        <label>Phone</label>
                        <input type="tel" name="phone" value="{{ $customer->phone }}">
                    </div>
                    <div class="thr-form__group">
                        <label>Discount Tier</label>
                        <select name="discount_tier">
                            @foreach(['none','new_client','loyal','special'] as $t)
                            <option value="{{ $t }}" {{ $customer->discount_tier === $t ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_',' ',$t)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="thr-form__group">
                    <label>Health/Skin Notes</label>
                    <textarea name="health_notes" rows="3">{{ $customer->health_notes }}</textarea>
                </div>
                <button type="submit" class="btn btn-gold btn-sm">Save Changes</button>
            </form>
        </div>
    </div>

    <div>
        {{-- Booking History --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-calendar-alt"></i> Booking History</h3></div>
            @if($customer->bookings->isEmpty())
            <div class="admin-empty">No bookings yet.</div>
            @else
            <table class="admin-table admin-table--compact">
                <thead><tr><th>Ref</th><th>Service</th><th>Date</th><th>Price</th><th>Status</th></tr></thead>
                <tbody>
                    @foreach($customer->bookings->sortByDesc('booking_date') as $b)
                    <tr>
                        <td><a href="{{ route('admin.bookings.show', $b->id) }}" class="admin-link">{{ $b->confirmation_number }}</a></td>
                        <td>{{ Str::limit($b->service->name, 22) }}</td>
                        <td>{{ $b->booking_date->format('M d, Y') }}</td>
                        <td>GHS {{ number_format($b->final_price, 0) }}</td>
                        <td><span class="status-badge status-badge--{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- Active Discounts --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-tags"></i> Assigned Discounts</h3></div>
            @if($customer->discounts->isEmpty())
            <div class="admin-empty">No special discounts assigned.</div>
            @else
            @foreach($customer->discounts as $d)
            <div class="admin-discount-item {{ !$d->is_active ? 'admin-discount-item--inactive' : '' }}">
                <div>
                    <strong>{{ $d->percentage }}% {{ ucfirst($d->type) }} Discount</strong><br>
                    <small>
                        {{ $d->is_active ? '✓ Active' : '✗ Inactive' }}
                        @if($d->expiry_date) · Expires {{ $d->expiry_date->format('M d, Y') }} @endif
                    </small>
                </div>
                @if($d->is_active)
                <form method="POST" action="{{ route('admin.discounts.revoke', $d->id) }}">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-red" onclick="return confirm('Revoke this discount?')">Revoke</button>
                </form>
                @endif
            </div>
            @endforeach
            @endif
            <div class="admin-card__section">
                <a href="{{ route('admin.discounts') }}" class="btn btn-outline btn-sm">
                    <i class="fas fa-plus"></i> Assign Discount
                </a>
            </div>
        </div>

        {{-- Quick Book --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-calendar-plus"></i> New Booking for This Customer</h3></div>
            <form method="POST" action="{{ route('admin.bookings.store') }}" class="thr-form">
                @csrf
                <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                <div class="thr-form__group">
                    <label>Service</label>
                    <select name="service_id" required>
                        <option value="">Select…</option>
                        @foreach(\App\Models\Service::where('is_active',true)->orderBy('name')->get() as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="thr-form__row">
                    <div class="thr-form__group">
                        <label>Date</label>
                        <input type="date" name="booking_date" required min="{{ date('Y-m-d') }}">
                    </div>
                    <div class="thr-form__group">
                        <label>Time</label>
                        <select name="booking_time" required>
                            @foreach(['09:00','09:30','10:00','10:30','11:00','11:30','12:00','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00'] as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-gold btn-sm">Create Booking</button>
            </form>
        </div>
    </div>
</div>
@endsection
