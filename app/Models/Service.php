<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'short_description', 'description',
        'duration', 'price_from', 'is_active', 'sort_order', 'image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_from' => 'decimal:2',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'maternity_postop'  => 'Maternity & Post-Op Care',
            'body_treatments'   => 'Body Treatments',
            'skin_treatments'   => 'Skin Treatments',
            'rejuvenation'      => 'Rejuvenation',
            default             => $this->category,
        };
    }

    public function getCategoryColorAttribute(): string
    {
        return match($this->category) {
            'maternity_postop'  => 'pink',
            'body_treatments'   => 'teal',
            'skin_treatments'   => 'amber',
            'rejuvenation'      => 'purple',
            default             => 'gold',
        };
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : '';
    }

    public static function getCategoryIcon(string $category): string
    {
        return match($category) {
            'maternity_postop'  => '🤱',
            'body_treatments'   => '💆',
            'skin_treatments'   => '✨',
            'rejuvenation'      => '🌸',
            default             => '💎',
        };
    }
}
