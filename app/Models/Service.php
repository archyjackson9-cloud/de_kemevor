<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'short_description', 'description',
        'meta_title', 'meta_description',
        'ideal_for', 'highlights',
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
            'body_enhancement'  => 'Body Enhancement',
            'massage'           => 'Massage Therapy',
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
            'body_enhancement'  => 'green',
            'massage'           => 'indigo',
            default             => 'gold',
        };
    }

    public function getHasPriceAttribute(): bool
    {
        return (float) $this->price_from > 0;
    }

    /** "GHS 250", or "Price on request" while pricing is on hold (price_from = 0). */
    public function getPriceLabelAttribute(): string
    {
        return $this->has_price
            ? 'GHS ' . number_format($this->price_from, 0)
            : 'Price on request';
    }

    public function getIdealForListAttribute(): array
    {
        return self::splitLines($this->ideal_for);
    }

    public function getHighlightListAttribute(): array
    {
        return self::splitLines($this->highlights);
    }

    private static function splitLines(?string $text): array
    {
        return $text
            ? array_values(array_filter(array_map('trim', preg_split('/\R/', $text))))
            : [];
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : '';
    }

    /**
     * The long-form article body (from `description`), split into paragraphs
     * for rendering as individual <p> tags on the service landing page.
     */
    public function getArticleParagraphsAttribute(): array
    {
        if (!$this->description) {
            return [];
        }

        $normalized = str_replace(["\r\n", "\r"], "\n", trim($this->description));
        $paragraphs = preg_split('/\n\s*\n/', $normalized);

        return array_values(array_filter(array_map('trim', $paragraphs)));
    }

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: "{$this->name} | The Healing Room Esthetic Clinic";
    }

    public function getSeoDescriptionAttribute(): string
    {
        return $this->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($this->short_description), 155);
    }

    public static function getCategoryIcon(string $category): string
    {
        return match($category) {
            'maternity_postop'  => '🤱',
            'body_treatments'   => '💆',
            'skin_treatments'   => '✨',
            'rejuvenation'      => '🌸',
            'body_enhancement'  => '💪',
            'massage'           => '🧖',
            default             => '💎',
        };
    }
}
