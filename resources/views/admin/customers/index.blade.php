@extends('layouts.admin')
@section('title', 'Customers')
@section('page-title', 'Customer Database')

@section('content')

<div class="admin-page-actions">
    <button class="btn btn-gold" onclick="document.getElementById('addCustomerModal').style.display='flex'">
        <i class="fas fa-user-plus"></i> Add Customer
    </button>
</div>

{{-- Filters --}}
<div class="admin-card">
    <div class="admin-card__header">
        <h3><i class="fas fa-filter"></i> Filter Customers</h3>
    </div>
    <form method="GET" class="admin-filter-form">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, phone…">
        <select name="gender">
            <option value="">All Genders</option>
            <option value="female" {{ request('gender') === 'female' ? 'selected' : '' }}>Female</option>
            <option value="male" {{ request('gender') === 'male' ? 'selected' : '' }}>Male</option>
        </select>
        <select name="tier">
            <option value="">All Tiers</option>
            @foreach(['new_client','loyal','special','none'] as $t)
            <option value="{{ $t }}" {{ request('tier') === $t ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$t)) }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-gold btn-sm"><i class="fas fa-search"></i> Search</button>
        <a href="{{ route('admin.customers') }}" class="btn btn-outline btn-sm">Reset</a>
    </form>
</div>

<div class="admin-card">
    <div class="admin-card__header">
        <h3>All Customers ({{ $customers->total() }})</h3>
    </div>
    @if($customers->isEmpty())
    <div class="admin-empty"><i class="fas fa-users"></i> No customers found.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Name</th><th>Phone</th><th>Email</th><th>Gender</th>
                    <th>Bookings</th><th>Last Visit</th><th>Tier</th><th>Points</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $c)
                @php $lastBooking = $c->bookings()->latest('booking_date')->first(); @endphp
                <tr>
                    <td>
                        <a href="{{ route('admin.customers.show', $c->id) }}" class="admin-link">{{ $c->full_name }}</a>
                    </td>
                    <td><a href="tel:{{ $c->phone }}">{{ $c->phone }}</a></td>
                    <td>{{ Str::limit($c->email, 25) }}</td>
                    <td>{{ ucfirst(str_replace('_',' ',$c->gender)) }}</td>
                    <td>{{ $c->total_bookings }}</td>
                    <td>{{ $lastBooking ? $lastBooking->booking_date->format('M d, Y') : 'Never' }}</td>
                    <td>
                        <span class="tier-badge tier-badge--{{ $c->discount_tier }}">
                            {{ ucfirst(str_replace('_',' ',$c->discount_tier)) }}
                        </span>
                    </td>
                    <td>{{ $c->loyalty_points }} pts</td>
                    <td>
                        <a href="{{ route('admin.customers.show', $c->id) }}" class="btn btn-xs btn-outline" title="View"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $customers->links() }}</div>
    @endif
</div>

{{-- Add Customer Modal --}}
<div class="admin-modal" id="addCustomerModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Add New Customer</h3>
            <button onclick="document.getElementById('addCustomerModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.customers.store') }}" class="thr-form">
            @csrf
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>First Name <span class="req">*</span></label>
                    <input type="text" name="first_name" required placeholder="Abena">
                </div>
                <div class="thr-form__group">
                    <label>Last Name <span class="req">*</span></label>
                    <input type="text" name="last_name" required placeholder="Mensah">
                </div>
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Email <span class="req">*</span></label>
                    <input type="email" name="email" required>
                </div>
                <div class="thr-form__group">
                    <label>Phone <span class="req">*</span></label>
                    <input type="tel" name="phone" required>
                </div>
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                        <option value="prefer_not_to_say">Prefer not to say</option>
                    </select>
                </div>
                <div class="thr-form__group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth">
                </div>
            </div>
            <div class="thr-form__group">
                <label>Health/Skin Notes</label>
                <textarea name="health_notes" rows="3" placeholder="Optional notes…"></textarea>
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addCustomerModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Add Customer</button>
            </div>
        </form>
    </div>
</div>

@endsection
