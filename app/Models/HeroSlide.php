<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'image', 'eyebrow', 'title', 'title_gold', 'subtitle', 'sort_order', 'is_active',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) return '';

        return str_starts_with($this->image, 'http')
            ? $this->image
            : asset('storage/' . $this->image);
    }
}
