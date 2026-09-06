<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingPhase extends Model
{
    protected $fillable = [
        'phase_number', 'title', 'subtitle', 'description', 'topics',
        'image', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'phase_number' => 'integer',
    ];

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : '';
    }

    public function getTopicListAttribute(): array
    {
        return $this->topics
            ? array_values(array_filter(array_map('trim', explode("\n", $this->topics))))
            : [];
    }
}
