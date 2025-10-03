<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyGoal extends Model
{
    protected $guarded = [];

    public function kid()
    {
        return $this->belongsTo(Kid::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function rewards()
    {
        return $this->hasMany(Reward::class);
    }
}
