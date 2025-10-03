<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KidAchievement extends Model
{
    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
        'awarded_at' => 'datetime'
    ];
}
