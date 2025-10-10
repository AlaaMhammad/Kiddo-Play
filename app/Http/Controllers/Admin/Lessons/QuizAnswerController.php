<?php

namespace App\Http\Controllers\Admin\Lessons;

use App\Http\Controllers\Controller;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\Question;
use Illuminate\Http\Request;

class QuizAnswerController extends Controller
{
    public function index()
    {
        $answers = QuizAnswer::with(['attempt.kid', 'question.quiz'])->latest()->paginate(10);
        return view('admin.lessons.quiz-answers.index', compact('answers'));
    }

    public function create()
    {
        $attempts = QuizAttempt::with('kid')->get();
        $questions = Question::with('quiz')->get();

        return view('admin.lessons.quiz-answers.create', compact('attempts', 'questions'));
    }

    public function store(Request $request)
    {
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

    public function show(QuizAnswer $quizAnswer)
    {
        $quizAnswer->load(['attempt.kid', 'question.quiz']);
        return view('admin.lessons.quiz-answers.show', compact('quizAnswer'));
    }

    public function edit(QuizAnswer $quizAnswer)
    {
        $attempts = QuizAttempt::with('kid')->get();
        $questions = Question::with('quiz')->get();

        return view('admin.lessons.quiz-answers.edit', compact('quizAnswer', 'attempts', 'questions'));
    }

    public function update(Request $request, QuizAnswer $quizAnswer)
    {
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
        $quizAnswer->delete();
        return redirect()->route('admin.quiz-answers.index')->with('success', 'Quiz answer deleted successfully.');
    }
}
