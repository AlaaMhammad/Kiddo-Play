<?php

namespace App\Http\Controllers\Admin\Lessons;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use App\Models\Kid;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    public function index()
    {
        $attempts = QuizAttempt::with(['kid', 'quiz'])->latest()->paginate(10);
        return view('admin.Lessons.quiz-attempts.index', compact('attempts'));
    }

    public function create()
    {
        $kids = Kid::select('id', 'display_name')->get();
        $quizzes = Quiz::select('id', 'title')->get();
        return view('admin.Lessons.quiz-attempts.create', compact('kids', 'quizzes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'quiz_id' => 'required|exists:quizzes,id',
            'score' => 'nullable|integer|min:0',
            'status' => 'required|in:started,completed,abandoned',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date',
            'meta' => 'nullable|array',
        ]);

        QuizAttempt::create([
            ...$validated,
            'meta' => $request->meta ? json_encode($request->meta) : null,
        ]);

        return redirect()->route('admin.quiz-attempts.index')->with('success', 'Quiz attempt created successfully.');
    }

    public function show(QuizAttempt $quizAttempt)
    {
        $quizAttempt->load(['kid', 'quiz', 'answers']);
        return view('admin.Lessons.quiz-attempts.show', compact('quizAttempt'));
    }

    public function edit(QuizAttempt $quizAttempt)
    {
        $kids = Kid::select('id', 'display_name')->get();
        $quizzes = Quiz::select('id', 'title')->get();
        return view('admin.Lessons.quiz-attempts.edit', compact('quizAttempt', 'kids', 'quizzes'));
    }

    public function update(Request $request, QuizAttempt $quizAttempt)
    {
        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'quiz_id' => 'required|exists:quizzes,id',
            'score' => 'nullable|integer|min:0',
            'status' => 'required|in:started,completed,abandoned',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date',
            'meta' => 'nullable|array',
        ]);

        $quizAttempt->update([
            ...$validated,
            'meta' => $request->meta ? json_encode($request->meta) : null,
        ]);

        return redirect()->route('admin.quiz-attempts.index')->with('success', 'Quiz attempt updated successfully.');
    }

    public function destroy(QuizAttempt $quizAttempt)
    {
        $quizAttempt->delete();
        return redirect()->route('admin.quiz-attempts.index')->with('success', 'Quiz attempt deleted successfully.');
    }
}
