<?php

namespace App\Http\Controllers\Api\Lessons;

use App\Http\Controllers\Controller;
use App\Models\KidLessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonProgressController extends Controller
{
    public function update(Request $request)
    {
        $kid = Auth::user();
        $data = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'progress_percent' => 'required|integer|min:0|max:100',
        ]);

        $progress = KidLessonProgress::updateOrCreate(
            ['kid_id' => $kid->id, 'lesson_id' => $data['lesson_id']],
            [
                'status' => $data['progress_percent'] == 100 ? 'completed' : 'in_progress',
                'progress_percent' => $data['progress_percent'],
                'last_accessed_at' => now(),
            ]
        );

        return response()->json(['status' => 1, 'data' => $progress]);
    }
}
