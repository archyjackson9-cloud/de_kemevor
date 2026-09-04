@extends('layouts.admin')
@section('title', 'Discounts & Loyalty')
@section('page-title', 'Discount & Loyalty Engine')

@section('content')

{{-- Tier Overview --}}
<div class="admin-kpi-grid">
    <div class="admin-kpi-card admin-kpi-card--blue">
        <div class="admin-kpi-card__icon"><i class="fas fa-user-plus"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">{{ $tiers['new_client_pct'] }}%</div>
            <div class="admin-kpi-card__label">New Client Discount</div>
            <div style="font-size:12px;opacity:.7">Auto-applied on first booking</div>
        </div>
    </div>
    <div class="admin-kpi-card admin-kpi-card--green">
        <div class="admin-kpi-card__icon"><i class="fas fa-star"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">{{ $tiers['loyal_pct'] }}%</div>
            <div class="admin-kpi-card__label">Loyal Client Discount</div>
            <div style="font-size:12px;opacity:.7">Unlocked after {{ $tiers['loyal_min_bookings'] }}+ visits</div>
        </div>
    </div>
    <div class="admin-kpi-card admin-kpi-card--gold">
        <div class="admin-kpi-card__icon"><i class="fas fa-crown"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">1–50%</div>
            <div class="admin-kpi-card__label">Special Offer</div>
            <div style="font-size:12px;opacity:.7">Admin-assigned, custom %</div>
        </div>
    </div>
    <div class="admin-kpi-card admin-kpi-card--purple">
        <div class="admin-kpi-card__icon"><i class="fas fa-ticket-alt"></i></div>
        <div class="admin-kpi-card__body">
            <div class="admin-kpi-card__value">{{ $promoCodes->where('is_active', true)->count() }}</div>
            <div class="admin-kpi-card__label">Active Promo Codes</div>
        </div>
    </div>
</div>

{{-- Automatic Discount Tiers --}}
<div class="admin-card">
    <div class="admin-card__header"><h3><i class="fas fa-sliders-h"></i> Automatic Discount Tiers</h3></div>
    <form method="POST" action="{{ route('admin.discounts.tiers.update') }}" class="thr-form">
        @csrf
        <div class="thr-form__row">
            <div class="thr-form__group">
                <label>New Client Discount % <span class="req">*</span></label>
                <input type="number" name="new_client_pct" min="0" max="100" required value="{{ old('new_client_pct', $tiers['new_client_pct']) }}">
                <span style="font-size:12px;color:#888">Auto-applied on a customer's first booking.</span>
            </div>
            <div class="thr-form__group">
                <label>Loyal Client Discount % <span class="req">*</span></label>
                <input type="number" name="loyal_pct" min="0" max="100" required value="{{ old('loyal_pct', $tiers['loyal_pct']) }}">
                <span style="font-size:12px;color:#888">Auto-applied once the visit threshold below is reached.</span>
            </div>
            <div class="thr-form__group">
                <label>Loyal Threshold (visits) <span class="req">*</span></label>
                <input type="number" name="loyal_min_bookings" min="1" max="100" required value="{{ old('loyal_min_bookings', $tiers['loyal_min_bookings']) }}">
            </div>
        </div>
        <button type="submit" class="btn btn-gold btn-sm">
            <i class="fas fa-check"></i> Save Tiers
        </button>
    </form>
</div>

<div class="admin-two-col">
    {{-- Promo Codes --}}
    <div>
        <div class="admin-card">
            <div class="admin-card__header">
                <h3><i class="fas fa-ticket-alt"></i> Promo Codes</h3>
                <button class="btn btn-gold btn-sm" onclick="document.getElementById('addPromoModal').style.display='flex'">
                    <i class="fas fa-plus"></i> New Code
                </button>
            </div>
            @if($promoCodes->isEmpty())
            <div class="admin-empty">No promo codes yet.</div>
            @else
            <table class="admin-table">
                <thead><tr><th>Code</th><th>%</th><th>Expiry</th><th>Used / Limit</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($promoCodes as $p)
                    <tr>
                        <td><strong>{{ $p->code }}</strong></td>
                        <td>{{ $p->percentage }}%</td>
                        <td>{{ $p->expiry_date?->format('M d, Y') ?? '–' }}</td>
                        <td>{{ $p->used_count }} / {{ $p->usage_limit ?? '∞' }}</td>
                        <td>
                            <span class="{{ $p->isValid() ? 'status-badge status-badge--confirmed' : 'status-badge status-badge--cancelled' }}">
                                {{ $p->isValid() ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="admin-table__actions">
                            <form method="POST" action="{{ route('admin.discounts.promo.toggle', $p->id) }}" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-xs btn-outline" title="{{ $p->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="fas fa-{{ $p->is_active ? 'pause' : 'play' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.discounts.promo.destroy', $p->id) }}" style="display:inline"
                                  onsubmit="return confirm('Delete this promo code?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-red"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- Assign Special Discount --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-crown"></i> Assign Special Discount</h3></div>
            <form method="POST" action="{{ route('admin.discounts.assign') }}" class="thr-form">
                @csrf
                <div class="thr-form__group">
                    <label>Customer <span class="req">*</span></label>
                    <select name="customer_id" required>
                        <option value="">Select customer…</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->full_name }} ({{ $c->phone }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="thr-form__row">
                    <div class="thr-form__group">
                        <label>Discount % <span class="req">*</span></label>
                        <input type="number" name="percentage" min="1" max="50" required placeholder="e.g. 25">
                    </div>
                    <div class="thr-form__group">
                        <label>Expiry Date (optional)</label>
                        <input type="date" name="expiry_date" min="{{ date('Y-m-d') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-gold btn-sm">
                    <i class="fas fa-check"></i> Assign Discount
                </button>
            </form>
        </div>
    </div>

    {{-- Customer Discounts --}}
    <div>
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-users"></i> Customer Special Discounts</h3></div>
            @if($customerDiscounts->isEmpty())
            <div class="admin-empty">No special discounts assigned yet.</div>
            @else
            <table class="admin-table">
                <thead><tr><th>Customer</th><th>%</th><th>Type</th><th>Expiry</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    @foreach($customerDiscounts as $d)
                    <tr>
                        <td>
                            <a href="{{ route('admin.customers.show', $d->customer_id) }}" class="admin-link">
                                {{ $d->customer->full_name }}
                            </a>
                        </td>
                        <td><strong>{{ $d->percentage }}%</strong></td>
                        <td>{{ ucfirst($d->type) }}</td>
                        <td>{{ $d->expiry_date?->format('M d, Y') ?? '–' }}</td>
                        <td>
                            <span class="{{ $d->is_active ? 'status-badge status-badge--confirmed' : 'status-badge status-badge--cancelled' }}">
                                {{ $d->is_active ? 'Active' : 'Revoked' }}
                            </span>
                        </td>
                        <td>
                            @if($d->is_active)
                            <form method="POST" action="{{ route('admin.discounts.revoke', $d->id) }}" style="display:inline"
                                  onsubmit="return confirm('Revoke this discount?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-xs btn-red">Revoke</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- Loyalty Overview --}}
        <div class="admin-card">
            <div class="admin-card__header"><h3><i class="fas fa-chart-bar"></i> Loyalty Overview</h3></div>
            <div class="admin-loyalty-stats">
                @foreach(['new_client','loyal','special','none'] as $tier)
                @php $count = \App\Models\Customer::where('discount_tier', $tier)->count(); @endphp
                <div class="admin-loyalty-stat">
                    <span class="tier-badge tier-badge--{{ $tier }}">{{ ucfirst(str_replace('_',' ',$tier)) }}</span>
                    <strong>{{ $count }}</strong> customers
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Add Promo Modal --}}
<div class="admin-modal" id="addPromoModal" style="display:none">
    <div class="admin-modal__box">
        <div class="admin-modal__header">
            <h3>Create Promo Code</h3>
            <button onclick="document.getElementById('addPromoModal').style.display='none'" class="admin-modal__close">×</button>
        </div>
        <form method="POST" action="{{ route('admin.discounts.promo.store') }}" class="thr-form">
            @csrf
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Code <span class="req">*</span></label>
                    <input type="text" name="code" required placeholder="SUMMER25" style="text-transform:uppercase">
                </div>
                <div class="thr-form__group">
                    <label>Discount % <span class="req">*</span></label>
                    <input type="number" name="percentage" min="1" max="100" required placeholder="25">
                </div>
            </div>
            <div class="thr-form__row">
                <div class="thr-form__group">
                    <label>Expiry Date</label>
                    <input type="date" name="expiry_date" min="{{ date('Y-m-d') }}">
                </div>
                <div class="thr-form__group">
                    <label>Usage Limit</label>
                    <input type="number" name="usage_limit" min="1" placeholder="Leave blank for unlimited">
                </div>
            </div>
            <div class="admin-modal__actions">
                <button type="button" class="btn btn-outline" onclick="document.getElementById('addPromoModal').style.display='none'">Cancel</button>
                <button type="submit" class="btn btn-gold">Create Code</button>
            </div>
        </form>
    </div>
</div>

@endsection
