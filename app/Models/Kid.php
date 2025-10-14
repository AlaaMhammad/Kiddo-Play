<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kid extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'preferences' => 'array',
        'dob' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function avatar()
    {
        return $this->belongsTo(Avatar::class);
    }

    public function sessions()
    {
        return $this->hasMany(KidSession::class);
    }

    public function pointsTransactions()
    {
        return $this->hasMany(PointsTransaction::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function lessonProgress()
    {
        return $this->hasMany(KidLessonProgress::class);
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'kid_achievements');
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function parents()
    {
        return $this->belongsToMany(User::class, 'parent_children', 'kid_id', 'parent_id');
    }

    public function parentalControls()
    {
        return $this->hasMany(ParentalControl::class);
    }

    public function dailyGoals()
    {
        return $this->hasMany(DailyGoal::class);
    }
}
