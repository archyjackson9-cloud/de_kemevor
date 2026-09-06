<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingGainItem extends Model
{
    protected $fillable = ['icon', 'title', 'body', 'sort_order', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];
}
