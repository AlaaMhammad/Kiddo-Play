<?php

namespace App\Http\Controllers\Api\Lessons;

use App\Http\Controllers\Controller;
use App\Models\{Quiz, Question, QuizAttempt, QuizAnswer};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



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
            $q->orderBy('order');
        }])->findOrFail($id);

        return response()->json([
            'status' => 1,
            'data' => [
                'id' => $quiz->id,
                'lesson_id' => $quiz->lesson_id,
                'title' => $quiz->title,
                'time_limit_seconds' => $quiz->time_limit_seconds,
                'is_active' => $quiz->is_active,

                'questions' => $quiz->questions->values()->map(function ($q, $index) {

                    // تفكيك العملية الحسابية
                    preg_match('/(\d+)\s*([\+\-\*\/])\s*(\d+)/', $q->content, $matches);

                    return [
                        'id' => $q->id,
                        'number' => $index + 1,

                        'first' => $matches[1] ?? null,
                        'operator' => $matches[2] ?? null,
                        'second' => $matches[3] ?? null,

                        // الإجابة الصحيحة
                        'correct_answer' => $q->correct_answer ?? null,

                        // خيارات الإجابة
                        'options' => $q->options,

                        'points' => $q->points,
                    ];
                }),
            ]
        ]);
    }

    // POST /quizzes/{id}/start
    public function startAttempt($id)
    {
        $user = Auth::user();

        if ($user->role->name !== 'kid') {
            return response()->json([
                'message' => 'Only kids can start a quiz'
            ], 403);
        }

        $kid = $user->kid;

        if (!$kid) {
            return response()->json([
                'message' => 'Kid profile not found'
            ], 404);
        }

        $quiz = Quiz::findOrFail($id);

        $attempt = QuizAttempt::create([
            'kid_id' => $kid->id,
            'quiz_id' => $quiz->id,
            'started_at' => now(),
            'status' => 'started',
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Quiz attempt started successfully',
            'data' => [
                'quiz_attempt_id' => $attempt->id,
                'quiz' => [
                    'id' => $quiz->id,
                    'title' => $quiz->title,
                ],
                'kid' => [
                    'id' => $kid->id,
                    'name' => $kid->name,
                ],
                'attempt_status' => $attempt->status,
                'started_at' => $attempt->started_at,
            ]
        ]);
    }


    // POST /quizzes/{id}/submit
    public function submitAttempt(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role->name !== 'kid') {
            return response()->json([
                'message' => 'Only kids can submit answers'
            ], 403);
        }

        $kid = $user->kid;

        if (!$kid) {
            return response()->json([
                'message' => 'Kid profile not found'
            ], 404);
        }

        /** @var Quiz $quiz */
        $quiz = Quiz::with('questions')->findOrFail($id);

        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('kid_id', $kid->id)
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
        $totalQuestions = $quiz->questions->count();

        DB::transaction(function () use (
            $validated,
            $attempt,
            $quiz,
            &$score,
            &$correct,
            $totalQuestions
        ) {
            foreach ($validated['answers'] as $item) {

                $question = $quiz->questions
                    ->where('id', $item['question_id'])
                    ->first();

                if (!$question) {
                    continue;
                }

                $isCorrect = false;
                $points = 0;

                if (
                    $question->type === 'mcq' ||
                    $question->type === 'true_false'
                ) {
                    $isCorrect = in_array(
                        $item['answer'],
                        (array) $question->correct_answer
                    );
                } else {
                    $isCorrect =
                        strtolower(trim($item['answer']))
                        ==
                        strtolower(trim($question->correct_answer[0] ?? ''));
                }

                if ($isCorrect) {
                    $points = $question->points;
                    $score += $points;
                    $correct++;
                }

                QuizAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'answer' => (array) $item['answer'],
                    'is_correct' => $isCorrect,
                    'points_awarded' => $points,
                ]);
            }

            $attempt->update([
                'score' => $score,
                'status' => 'completed',
                'finished_at' => now(),
                'meta' => [
                    'correct' => $correct,
                    'total' => $totalQuestions,
                ],
            ]);
        });

        return response()->json([
            'status' => 1,
            'message' => 'Quiz submitted successfully',
            'data' => [
                'quiz' => [
                    'id' => $quiz->id,
                    'title' => $quiz->title,
                ],
                'result' => [
                    'score' => $score,
                    'correct_answers' => $correct,
                    'total_questions' => $totalQuestions,
                    'wrong_answers' => $totalQuestions - $correct,
                ],
            ],
        ]);
    }


    // GET /quizzes/attempts
    public function attempts()
    {
        $user = Auth::user();

        $kid = $user->kid;

        if (!$kid) {
            return response()->json([
                'message' => 'Kid profile not found'
            ], 404);
        }

        $attempts = QuizAttempt::with('quiz:id,title')
            ->where('kid_id', $kid->id)
            ->latest()
            ->get()
            ->map(function ($attempt) {

                return [
                    'quiz_attempt_id' => $attempt->id,

                    'quiz' => [
                        'id' => $attempt->quiz?->id,
                        'title' => $attempt->quiz?->title,
                    ],

                    'score' => $attempt->score,

                    'status' => $attempt->status,

                    'correct_answers' =>
                    $attempt->meta['correct'] ?? 0,

                    'total_questions' =>
                    $attempt->meta['total'] ?? 0,

                    'wrong_answers' => ($attempt->meta['total'] ?? 0)
                        -
                        ($attempt->meta['correct'] ?? 0),

                    'started_at' => $attempt->started_at,

                    'finished_at' => $attempt->finished_at,
                ];
            });

        return response()->json([
            'status' => 1,
            'data' => $attempts,
        ]);
    }
}
