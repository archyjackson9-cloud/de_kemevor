@extends('layouts.admin')
@section('title', 'Bookings')
@section('page-title', 'Appointments Manager')

@push('styles')
<style>
.cal-event { font-size:11px; padding:2px 5px; border-radius:3px; margin:1px 0; cursor:pointer; overflow:hidden; white-space:nowrap; }
.cal-event--maternity_postop { background:#fce7f3; color:#9d174d; }
.cal-event--body_treatments  { background:#ccfbf1; color:#115e59; }
.cal-event--skin_treatments  { background:#fef3c7; color:#92400e; }
.cal-event--rejuvenation     { background:#f3e8ff; color:#6b21a8; }
</style>
@endpush

@section('content')

{{-- Add Booking Modal Trigger --}}
<div class="admin-page-actions">
    <button class="btn btn-gold" onclick="document.getElementById('addBookingModal').style.display='flex'">
        <i class="fas fa-plus"></i> New Booking
    </button>
</div>

{{-- Calendar View --}}
<div class="admin-card" style="margin-bottom:1.5rem">
    <div class="admin-card__header">
        <h3><i class="fas fa-calendar-alt"></i> Calendar View</h3>
        <div class="admin-cal-nav">
            <a href="?month={{ now()->subMonth()->month }}&year={{ now()->subMonth()->year }}" class="btn btn-sm btn-outline"><i class="fas fa-chevron-left"></i></a>
            <span class="admin-cal-nav__label">{{ now()->format('F Y') }}</span>
            <a href="?month={{ now()->addMonth()->month }}&year={{ now()->addMonth()->year }}" class="btn btn-sm btn-outline"><i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
    <div class="mini-calendar">
        @php
        $month = request('month', now()->month);
        $year  = request('year', now()->year);
        $firstDay = \Carbon\Carbon::create($year, $month, 1)->dayOfWeek;
        $daysInMonth = \Carbon\Carbon::create($year, $month, 1)->daysInMonth;
        $eventsByDate = collect($calendarBookings)->groupBy('date');
        @endphp
        <div class="mini-cal-header">
            @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
            <div>{{ $d }}</div>
            @endforeach
        </div>
        <div class="mini-cal-grid">
            @for($i = 0; $i < $firstDay; $i++)<div></div>@endfor
            @for($d = 1; $d <= $daysInMonth; $d++)
            @php $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $d); $isToday = $dateStr === now()->toDateString(); @endphp
            <div class="mini-cal-cell {{ $isToday ? 'mini-cal-cell--today' : '' }}">
                <div class="mini-cal-cell__num {{ $isToday ? 'today' : '' }}">{{ $d }}</div>
                @if(isset($eventsByDate[$dateStr]))
                @foreach($eventsByDate[$dateStr] as $ev)
                <a href="{{ $ev['url'] }}" class="cal-event cal-event--{{ $ev['category'] }}" title="{{ $ev['title'] }}">
                    {{ $ev['time'] }} {{ Str::limit(explode(' – ', $ev['title'])[0], 12) }}
                </a>
                @endforeach
                @endif
            </div>
            @endfor
        </div>
    </div>
</div>

{{-- Filters --}}
<div class="admin-card">
    <div class="admin-card__header">
        <h3><i class="fas fa-filter"></i> Filter Appointments</h3>
    </div>
    <form method="GET" class="admin-filter-form">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, ref#...">
        <select name="status">
            <option value="">All Statuses</option>
            @foreach(['pending','confirmed','completed','cancelled'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <select name="service_id">
            <option value="">All Services</option>
            @foreach($services as $svc)
            <option value="{{ $svc->id }}" {{ request('service_id') == $svc->id ? 'selected' : '' }}>{{ $svc->name }}</option>
            @endforeach
        </select>
        <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="From">
        <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="To">
        <button type="submit" class="btn btn-gold btn-sm"><i class="fas fa-search"></i> Filter</button>
        <a href="{{ route('admin.bookings') }}" class="btn btn-outline btn-sm">Reset</a>
    </form>
</div>

{{-- Bookings Table --}}
<div class="admin-card">
    <div class="admin-card__header">
        <h3>All Bookings ({{ $bookings->total() }})</h3>
    </div>
    @if($bookings->isEmpty())
    <div class="admin-empty"><i class="fas fa-calendar"></i> No bookings found.</div>
    @else
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Ref #</th>
                    <th>Customer</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bookings as $b)
                <tr>
                    <td><a href="{{ route('admin.bookings.show', $b->id) }}" class="admin-link">{{ $b->confirmation_number }}</a></td>
                    <td>
                        <a href="{{ route('admin.customers.show', $b->customer_id) }}" class="admin-link">
                            {{ $b->customer->full_name }}
                        </a>
                        <div class="admin-table__sub">{{ $b->customer->phone }}</div>
                    </td>
                    <td>{{ Str::limit($b->service->name, 28) }}</td>
                    <td>{{ $b->booking_date->format('M d, Y') }}</td>
                    <td>{{ substr($b->booking_time, 0, 5) }}</td>
                    <td>
                        @if($b->discount_amount > 0)
                        <span style="text-decoration:line-through;color:#999;font-size:12px">{{ number_format($b->original_price, 0) }}</span><br>
                        <strong>GHS {{ number_format($b->final_price, 0) }}</strong>
                        @else
                        GHS {{ number_format($b->final_price, 0) }}
                        @endif
                    </td>
                    <td><span class="status-badge status-badge--{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                    <td class="admin-table__actions">
                        <a href="{{ route('admin.bookings.show', $b->id) }}" class="btn btn-xs btn-outline" title="View"><i class="fas fa-eye"></i></a>
                        @foreach(['confirmed','completed','cancelled'] as $s)
                        @if($b->status !== $s)
                        <form method="POST" action="{{ route('admin.bookings.update', $b->id) }}" style="display:inline">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="{{ $s }}">
                            <button type="submit" class="btn btn-xs btn-{{ $s === 'confirmed' ? 'green' : ($s === 'completed' ? 'blue' : 'red') }}"
                                title="{{ ucfirst($s) }}">
                                <i class="fas fa-{{ $s === 'confirmed' ? 'check' : ($s === 'completed' ? 'check-double' : 'times') }}"></i>
                            </button>
                        </form>
                        @endif
                        @endforeach
                        <form method="POST" action="{{ route('admin.bookings.destroy', $b->id) }}" style="display:inline"
                              onsubmit="return confirm('Delete this booking?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-xs btn-red" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="admin-pagination">{{ $bookings->links() }}</div>
    @endif
</div>

{{-- Add Booking Modal --}}
<div class="admin-modal" id="addBookingModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>New Booking</h3>
            <button onclick="document.getElementById('addBookingModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.bookings.store') }}" class="thr-form">
            @csrf
            <div class="thr-form__group">
                <label>Customer</label>
                <select name="customer_id" required>
                    <option value="">Select customer…</option>
                    @foreach(\App\Models\Customer::orderBy('first_name')->get() as $c)
                    <option value="{{ $c->id }}">{{ $c->full_name }} ({{ $c->phone }})</option>
                    @endforeach
                </select>
            </div>
            <div class="thr-form__group">
                <label>Service</label>
                <select name="service_id" required>
                    <option value="">Select service…</option>
                    @foreach($services as $svc)
                    <option value="{{ $svc->id }}">{{ $svc->name }} – GHS {{ number_format($svc->price_from, 0) }}</option>
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
            <div class="thr-form__group">
                <label>Notes</label>
                <textarea name="notes" rows="3" placeholder="Optional notes…"></textarea>
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addBookingModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Create Booking</button>
            </div>
        </form>
    </div>
</div>

@endsection
