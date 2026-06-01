<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'customer_id', 'service_id', 'booking_date', 'booking_time',
        'status', 'confirmation_number', 'notes', 'consent_reminders',
        'original_price', 'discount_amount', 'final_price', 'discount_label',
    ];

    protected $casts = [
        'booking_date'      => 'date',
        'consent_reminders' => 'boolean',
        'original_price'    => 'decimal:2',
        'discount_amount'   => 'decimal:2',
        'final_price'       => 'decimal:2',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'   => '<span class="badge badge-pending">Pending</span>',
            'confirmed' => '<span class="badge badge-confirmed">Confirmed</span>',
            'completed' => '<span class="badge badge-completed">Completed</span>',
            'cancelled' => '<span class="badge badge-cancelled">Cancelled</span>',
            default     => $this->status,
        };
    }

    public static function generateConfirmationNumber(): string
    {
        do {
            $number = 'THR-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (static::where('confirmation_number', $number)->exists());

        return $number;
    }
}
