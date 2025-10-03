<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    protected $guarded = [];

    protected $casts = [
        'answer' => 'array',
        'is_correct' => 'boolean',
    ];

    public function attempt()
    {
        return $this->belongsTo(QuizAttempt::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
