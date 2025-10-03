<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KidLessonProgress extends Model
{
    protected $guarded = [];

    protected $casts = [
        'last_accessed_at' => 'datetime',
    ];

    public function kid()
    {
        return $this->belongsTo(Kid::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
