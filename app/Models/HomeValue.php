<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeValue extends Model
{
    protected $fillable = ['icon', 'image', 'title', 'body', 'sort_order', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    public function getImageUrlAttribute(): string
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : '';
    }
}
