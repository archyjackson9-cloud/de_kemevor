<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'image', 'video', 'eyebrow', 'title', 'title_gold', 'subtitle', 'sort_order', 'is_active',
    ];

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) return '';

        return str_starts_with($this->image, 'http')
            ? $this->image
            : asset('storage/' . $this->image);
    }

    public function getVideoUrlAttribute(): ?string
    {
        if (!$this->video) return null;

        return str_starts_with($this->video, 'http')
            ? $this->video
            : asset('storage/' . $this->video);
    }

    public function getHasVideoAttribute(): bool
    {
        return (bool) $this->video;
    }
}
