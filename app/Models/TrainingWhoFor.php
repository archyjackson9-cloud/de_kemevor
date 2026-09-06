<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingWhoFor extends Model
{
    protected $table = 'training_who_for';

    protected $fillable = ['label', 'sort_order', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];
}
