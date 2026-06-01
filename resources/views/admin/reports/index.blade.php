@extends('layouts.admin')
@section('title', 'Reports')
@section('page-title', 'Reports & Analytics')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')

{{-- Period Selector --}}
<div class="admin-card">
    <div class="admin-card__header">
        <h3><i class="fas fa-calendar-alt"></i> Report Period</h3>
    </div>
    <form method="GET" class="admin-filter-form">
        <select name="month">
            @for($m = 1; $m <= 12; $m++)
            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
            </option>
            @endfor
        </select>
        <select name="year">
            @for($y = now()->year; $y >= now()->year - 3; $y--)
            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button type="submit" class="btn btn-gold btn-sm"><i class="fas fa-filter"></i> Filter</button>
    </form>
</div>

{{-- KPIs --}}
<div class="admin-kpi-grid">
    <div class="admin-kpi-card admin-kpi-card--blue">
        <div class="admin-kpi-card__icon"><i class="fas fa-users"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">{{ $allCustomers }}</div>
            <div class="admin-kpi-card__label">Total Customers</div>
        </div>
    </div>
    <div class="admin-kpi-card admin-kpi-card--green">
        <div class="admin-kpi-card__icon"><i class="fas fa-user-plus"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">{{ $newThisMonth }}</div>
            <div class="admin-kpi-card__label">New This Month</div>
        </div>
    </div>
    <div class="admin-kpi-card admin-kpi-card--gold">
        <div class="admin-kpi-card__icon"><i class="fas fa-redo"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">{{ $retentionRate }}%</div>
            <div class="admin-kpi-card__label">Retention Rate</div>
            <div style="font-size:12px;opacity:.7">{{ $retentionCount }} returning</div>
        </div>
    </div>
    <div class="admin-kpi-card admin-kpi-card--purple">
        <div class="admin-kpi-card__icon"><i class="fas fa-user-check"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">{{ $returning }}</div>
            <div class="admin-kpi-card__label">Returning Customers</div>
        </div>
    </div>
</div>

<div class="admin-two-col">
    {{-- Weekly Bookings Chart --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <h3><i class="fas fa-chart-bar"></i> Weekly Bookings – {{ \Carbon\Carbon::create($year, $month)->format('F Y') }}</h3>
        </div>
        <canvas id="weeklyChart" height="200"></canvas>
    </div>

    {{-- Service Popularity --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <h3><i class="fas fa-chart-pie"></i> Service Popularity (All-Time)</h3>
        </div>
        <canvas id="popularityChart" height="200"></canvas>
    </div>
</div>

<div class="admin-two-col">
    {{-- Revenue Chart --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <h3><i class="fas fa-chart-line"></i> Monthly Revenue (Last 6 Months)</h3>
        </div>
        <canvas id="revenueChart" height="200"></canvas>
    </div>

    {{-- New vs Returning --}}
    <div class="admin-card">
        <div class="admin-card__header">
            <h3><i class="fas fa-user-friends"></i> New vs Returning Customers</h3>
        </div>
        <canvas id="newVsReturningChart" height="200"></canvas>
        <div class="admin-legend">
            <span style="color:#c8972b"><i class="fas fa-circle"></i> New This Month: {{ $newThisMonth }}</span>
            <span style="color:#4f46e5"><i class="fas fa-circle"></i> Returning: {{ $returning }}</span>
        </div>
    </div>
</div>

{{-- Top Customers --}}
<div class="admin-card">
    <div class="admin-card__header"><h3><i class="fas fa-trophy"></i> Top 5 Customers by Bookings</h3></div>
    <table class="admin-table">
        <thead><tr><th>Rank</th><th>Name</th><th>Total Bookings</th><th>Loyalty Points</th><th>Tier</th></tr></thead>
        <tbody>
            @foreach($topCustomers as $i => $c)
            <tr>
                <td><strong>#{{ $i + 1 }}</strong></td>
                <td><a href="{{ route('admin.customers.show', $c->id) }}" class="admin-link">{{ $c->full_name }}</a></td>
                <td>{{ $c->total_bookings }}</td>
                <td>{{ $c->loyalty_points }} pts</td>
                <td><span class="tier-badge tier-badge--{{ $c->discount_tier }}">{{ ucfirst(str_replace('_',' ',$c->discount_tier)) }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('scripts')
<script>
// ── Weekly Bookings Bar Chart ──────────────────────────────────────────────
const weeklyLabels = @json(array_column($weeklyData, 'label'));
const weeklyCounts = @json(array_column($weeklyData, 'count'));

new Chart(document.getElementById('weeklyChart'), {
    type: 'bar',
    data: {
        labels: weeklyLabels,
        datasets: [{
            label: 'Bookings',
            data: weeklyCounts,
            backgroundColor: '#c8972b',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// ── Service Popularity Pie Chart ──────────────────────────────────────────
const popLabels = @json($servicePopularity->pluck('name'));
const popData   = @json($servicePopularity->pluck('total'));
const popColors = ['#c8972b','#4f46e5','#059669','#dc2626','#d97706','#7c3aed','#0891b2','#db2777','#65a30d','#ea580c','#6366f1','#0d9488','#b45309','#9333ea'];

new Chart(document.getElementById('popularityChart'), {
    type: 'doughnut',
    data: {
        labels: popLabels,
        datasets: [{ data: popData, backgroundColor: popColors }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { font: { size: 11 }, boxWidth: 12 } }
        }
    }
});

// ── Revenue Line Chart ────────────────────────────────────────────────────
const revLabels = @json(array_column($revenueData, 'label'));
const revData   = @json(array_column($revenueData, 'revenue'));

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: revLabels,
        datasets: [{
            label: 'Revenue (GHS)',
            data: revData,
            borderColor: '#c8972b',
            backgroundColor: 'rgba(200,151,43,0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#c8972b',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});

// ── New vs Returning Pie ──────────────────────────────────────────────────
new Chart(document.getElementById('newVsReturningChart'), {
    type: 'pie',
    data: {
        labels: ['New This Month', 'Returning'],
        datasets: [{
            data: [{{ $newThisMonth }}, {{ $returning }}],
            backgroundColor: ['#c8972b', '#4f46e5']
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>
@endpush
