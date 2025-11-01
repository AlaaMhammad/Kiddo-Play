<?php

namespace App\Http\Controllers\Api\Lessons;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    // GET /lessons
    public function index()
    {
        $lessons = Lesson::where('is_published', true)
            ->orderBy('order')
            ->get(['id', 'category', 'title', 'summary', 'media_url']);

        return response()->json([
            'status' => 1,
            'data' => $lessons
        ]);
    }

    // GET /lessons/{id}
    public function show($id)
    {
        $lesson = Lesson::with('quizzes:id,lesson_id,title,is_active')
            ->findOrFail($id);

        return response()->json([
            'status' => 1,
            'data' => $lesson
        ]);
    }
}
