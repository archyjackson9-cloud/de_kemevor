<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutValue extends Model
{
    protected $fillable = ['number', 'title', 'body', 'sort_order', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];
}
