<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingInquiry extends Model
{
    protected $fillable = [
        'reference_number', 'name', 'email', 'phone', 'phase_interest',
        'message', 'status', 'admin_response', 'responded_by', 'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'   => '<span class="status-badge status-badge--pending">Pending</span>',
            'responded' => '<span class="status-badge status-badge--confirmed">Responded</span>',
            default     => $this->status,
        };
    }

    public static function generateReferenceNumber(): string
    {
        do {
            $number = 'TRN-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (static::where('reference_number', $number)->exists());

        return $number;
    }
}
