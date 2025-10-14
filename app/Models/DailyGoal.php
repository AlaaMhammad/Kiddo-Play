<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyGoal extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'goal_date' => 'datetime',
        'is_completed' => 'boolean',
    ];

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
