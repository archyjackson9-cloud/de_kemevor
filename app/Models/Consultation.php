<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consultation extends Model
{
    protected $fillable = [
        'reference_number', 'name', 'email', 'phone', 'age', 'gender',
        'concern_area', 'problem_description', 'status',
        'admin_response', 'responded_by', 'responded_at',
    ];

    protected $casts = [
        'age'          => 'integer',
        'responded_at' => 'datetime',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ConsultationImage::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'   => '<span class="status-badge status-badge--pending">Pending</span>',
            'responded' => '<span class="status-badge status-badge--confirmed">Responded</span>',
            default     => $this->status,
        };
    }

    public function getConcernAreaLabelAttribute(): string
    {
        return match ($this->concern_area) {
            'maternity_postop' => 'Maternity & Post-Op Care',
            'body_treatments'  => 'Body Treatments',
            'skin_treatments'  => 'Skin Treatments',
            'rejuvenation'     => 'Rejuvenation',
            default            => 'General / Other',
        };
    }

    public static function generateReferenceNumber(): string
    {
        do {
            $number = 'ECO-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (static::where('reference_number', $number)->exists());

        return $number;
    }
}
