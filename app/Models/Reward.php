<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $guarded = [];

    public function dailyGoal()
    {
        return $this->belongsTo(DailyGoal::class);
    }
}
