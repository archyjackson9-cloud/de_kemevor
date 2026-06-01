<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerDiscount extends Model
{
    protected $fillable = [
        'customer_id', 'type', 'percentage', 'expiry_date', 'is_active',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'is_active'   => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
