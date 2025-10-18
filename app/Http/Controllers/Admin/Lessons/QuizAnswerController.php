<?php

namespace App\Http\Controllers\Admin\Lessons;

use App\Http\Controllers\Controller;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizAnswerController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $answers = QuizAnswer::with(['attempt.kid', 'question.quiz'])
                ->latest()
                ->paginate(10);
        } elseif ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            $answers = QuizAnswer::whereHas('attempt', fn($q) => $q->whereIn('kid_id', $kidsIds))
                ->with(['attempt.kid', 'question.quiz'])
                ->latest()
                ->paginate(10);
        } elseif ($user->role->name === 'kid') {
            $answers = QuizAnswer::whereHas('attempt', fn($q) => $q->where('kid_id', $user->kid->id))
                ->with(['attempt.kid', 'question.quiz'])
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.Lessons.quiz-answers.index', compact('answers'));
    }

    public function show(QuizAnswer $quizAnswer)
    {
        /** @var User $user */

        $user = Auth::user();
        $quizAnswer->load(['attempt.kid', 'question.quiz']);

        if ($user->role->name === 'admin') {
            // كل التفاصيل
        } elseif ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            abort_unless(in_array($quizAnswer->attempt->kid_id, $kidsIds), 403, 'Unauthorized');
        } elseif ($user->role->name === 'kid') {
            abort_unless($quizAnswer->attempt->kid_id === $user->kid->id, 403, 'Unauthorized');
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.Lessons.quiz-answers.show', compact('quizAnswer'));
    }

    public function create()
    {
        $this->authorizeRole('admin');

        $attempts = QuizAttempt::with('kid')->get();
        $questions = Question::with('quiz')->get();

        return view('admin.Lessons.quiz-answers.create', compact('attempts', 'questions'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $validated = $request->validate([
            'attempt_id' => 'required|exists:quiz_attempts,id',
            'question_id' => 'required|exists:questions,id',
            'answer' => 'nullable|array',
            'is_correct' => 'nullable|boolean',
            'points_awarded' => 'nullable|integer|min:0',
        ]);

        QuizAnswer::create([
            ...$validated,
            'answer' => $request->answer ? json_encode($request->answer) : null,
        ]);

        return redirect()->route('admin.quiz-answers.index')->with('success', 'Quiz answer created successfully.');
    }

    public function edit(QuizAnswer $quizAnswer)
    {
        $this->authorizeRole('admin');

        $attempts = QuizAttempt::with('kid')->get();
        $questions = Question::with('quiz')->get();

        return view('admin.Lessons.quiz-answers.edit', compact('quizAnswer', 'attempts', 'questions'));
    }

    public function update(Request $request, QuizAnswer $quizAnswer)
    {
        $this->authorizeRole('admin');

        $validated = $request->validate([
            'attempt_id' => 'required|exists:quiz_attempts,id',
            'question_id' => 'required|exists:questions,id',
            'answer' => 'nullable|array',
            'is_correct' => 'nullable|boolean',
            'points_awarded' => 'nullable|integer|min:0',
        ]);

        $quizAnswer->update([
            ...$validated,
            'answer' => $request->answer ? json_encode($request->answer) : null,
        ]);

        return redirect()->route('admin.quiz-answers.index')->with('success', 'Quiz answer updated successfully.');
    }

    public function destroy(QuizAnswer $quizAnswer)
    {
        $this->authorizeRole('admin');

        $quizAnswer->delete();
        return redirect()->route('admin.quiz-answers.index')->with('success', 'Quiz answer deleted successfully.');
    }

    private function authorizeRole($role)
    {
        /** @var User $user */

        $user = Auth::user();
        abort_unless($user && $user->role->name === $role, 403, 'Unauthorized action.');
    }
}
