<?php

namespace App\Http\Controllers\Api\Lessons;

use App\Http\Controllers\Controller;
use App\Models\{Quiz, Question, QuizAttempt, QuizAnswer};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/// ⛔⛔⛔ يحتاج تعديل⛔⛔⛔

class QuizController extends Controller
{
    // GET /lessons/{lesson_id}/quizzes
    public function byLesson($lesson_id)
    {
        $quizzes = Quiz::where('lesson_id', $lesson_id)
            ->where('is_active', true)
            ->get(['id', 'title', 'time_limit_seconds']);

        return response()->json(['status' => 1, 'data' => $quizzes]);
    }

    // GET /quizzes/{id}
    public function show($id)
    {
        $quiz = Quiz::with(['questions' => function ($q) {
            $q->select('id', 'quiz_id', 'content', 'type', 'options', 'points', 'order');
        }])->findOrFail($id);

        return response()->json(['status' => 1, 'data' => $quiz]);
    }

    // POST /quizzes/{id}/start
    public function startAttempt($id)
    {
        $user = Auth::user();
        if ($user->role->name !== 'kid') {
            return response()->json(['message' => 'Only kids can start a quiz'], 403);
        }

        $quiz = Quiz::findOrFail($id);

        $attempt = QuizAttempt::create([
            'kid_id' => $user->id,
            'quiz_id' => $quiz->id,
            'started_at' => now(),
            'status' => 'started',
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Quiz attempt started',
            'data' => ['attempt_id' => $attempt->id]
        ]);
    }

    // POST /quizzes/{id}/submit
    public function submitAttempt(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user->role->name !== 'kid') {
            return response()->json(['message' => 'Only kids can submit answers'], 403);
        }
        /** @var \App\Models\Quiz $quiz */
        $quiz = Quiz::with('questions')->findOrFail($id);
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('kid_id', $user->id)
            ->where('status', 'started')
            ->latest()
            ->firstOrFail();

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|integer|exists:questions,id',
            'answers.*.answer' => 'required',
        ]);

        $score = 0;
        $correct = 0;

        DB::transaction(function () use ($validated, $attempt, $quiz, &$score, &$correct) {
            foreach ($validated['answers'] as $item) {
                $question = $quiz->questions->where('id', $item['question_id'])->first();
                if (!$question) continue;

                $isCorrect = false;
                $points = 0;

                // مقارنة الإجابة
                if ($question->type === 'mcq' || $question->type === 'true_false') {
                    $isCorrect = in_array($item['answer'], (array)$question->correct_answer);
                } else {
                    // يمكنك توسيع المنطق للأنواع الأخرى لاحقاً
                    $isCorrect = strtolower(trim($item['answer'])) == strtolower(trim($question->correct_answer[0] ?? ''));
                }

                if ($isCorrect) {
                    $points = $question->points;
                    $score += $points;
                    $correct++;
                }

                QuizAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'answer' => (array)$item['answer'],
                    'is_correct' => $isCorrect,
                    'points_awarded' => $points,
                ]);
            }

            $attempt->update([
                'score' => $score,
                'status' => 'completed',
                'finished_at' => now(),
                'meta' => ['correct' => $correct, 'total' => count($quiz->questions)],
            ]);
        });

        return response()->json([
            'status' => 1,
            'message' => 'Quiz submitted successfully',
            'data' => [
                'score' => $score,
                'correct' => $correct,
                'total' => count($quiz->questions),
            ]
        ]);
    }

    // GET /quizzes/attempts
    public function attempts()
    {
        $user = Auth::user();
        $attempts = QuizAttempt::with('quiz:id,title')
            ->where('kid_id', $user->id)
            ->latest()
            ->get();

        return response()->json(['status' => 1, 'data' => $attempts]);
    }
}
