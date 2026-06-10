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
        $lesson = Lesson::with([
            'quizzes:id,lesson_id,title,is_active'
        ])->findOrFail($id);

        $contentLines = [];

        if ($lesson->content) {

            $lines = preg_split('/\r\n|\r|\n/', $lesson->content);

            foreach ($lines as $line) {

                preg_match(
                    '/(\d+)\s*([\+\-\*\/])\s*(\d+)\s*=\s*(\d+)/',
                    trim($line),
                    $matches
                );

                if (!empty($matches)) {
                    $contentLines[] = [
                        'first'    => (int) $matches[1],
                        'operator' => $matches[2],
                        'second'   => (int) $matches[3],
                        'answer'   => (int) $matches[4],
                    ];
                }
            }
        }

        return response()->json([
            'status' => 1,
            'data' => [
                'id' => $lesson->id,
                'category' => $lesson->category,
                'title' => $lesson->title,
                'summary' => $lesson->summary,
                'media_url' => $lesson->media_url,
                'order' => $lesson->order,
                'is_published' => $lesson->is_published,
                'line_icons' => $lesson->line_icons,
                'lesson_content' => $contentLines,
                'quizzes' => $lesson->quizzes,
            ]
        ]);
    }
}
