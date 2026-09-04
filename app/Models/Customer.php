<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'gender',
        'date_of_birth', 'health_notes', 'loyalty_points',
        'discount_tier', 'total_bookings',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(CustomerDiscount::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public static function loyalMinBookings(): int
    {
        return (int) SiteSetting::get('discount_loyal_min_bookings', 5);
    }

    public static function loyalDiscountPct(): int
    {
        return (int) SiteSetting::get('discount_loyal_pct', 15);
    }

    public static function newClientDiscountPct(): int
    {
        return (int) SiteSetting::get('discount_new_client_pct', 10);
    }

    public function getActiveDiscountAttribute(): ?CustomerDiscount
    {
        return $this->discounts()
            ->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                  ->orWhere('expiry_date', '>=', now()->toDateString());
            })
            ->orderByDesc('percentage')
            ->first();
    }

    public function getApplicableDiscountPercentage(): int
    {
        // Auto-upgrade to loyal after the configured number of bookings
        if ($this->total_bookings >= static::loyalMinBookings() && $this->discount_tier !== 'special') {
            return static::loyalDiscountPct();
        }

        $active = $this->activeDiscount;
        if ($active) {
            return $active->percentage;
        }

        if ($this->discount_tier === 'new_client' && $this->total_bookings === 0) {
            return static::newClientDiscountPct();
        }

        return 0;
    }

    public function getDiscountLabelAttribute(): string
    {
        if ($this->total_bookings >= static::loyalMinBookings()) return 'Loyal Client (' . static::loyalDiscountPct() . '% off)';
        if ($this->discount_tier === 'new_client' && $this->total_bookings === 0) return 'New Client (' . static::newClientDiscountPct() . '% off)';
        $active = $this->activeDiscount;
        if ($active) return "Special Offer ({$active->percentage}% off)";
        return 'No Discount';
    }
}
