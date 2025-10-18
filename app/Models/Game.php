<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kids()
    {
        return $this->belongsToMany(Kid::class, 'game_kids', 'game_id', 'kid_id')
            ->withPivot(['score', 'play_count', 'last_played_at'])
            ->withTimestamps();
    }

    public function dailyGoals()
    {
        return $this->hasMany(DailyGoal::class);
    }
}
