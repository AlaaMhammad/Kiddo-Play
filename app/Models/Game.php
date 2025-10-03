<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $guarded = [];

    public function kids()
    {
        return $this->belongsToMany(Kid::class, 'game_kid')
            ->withPivot(['score', 'play_count', 'last_played_at'])
            ->withTimestamps();
    }

    public function dailyGoals()
    {
        return $this->hasMany(DailyGoal::class);
    }
}
