<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutCertification extends Model
{
    protected $fillable = ['icon', 'label', 'sort_order', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];
}
