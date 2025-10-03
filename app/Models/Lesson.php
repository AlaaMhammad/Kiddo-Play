<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function kidProgress()
    {
        return $this->hasMany(KidLessonProgress::class);
    }
}
