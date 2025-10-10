<?php

namespace App\Http\Controllers\Admin\Lessons;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with('lesson')->latest()->paginate(10);
        return view('admin.Lessons.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $lessons = Lesson::where('is_published', true)->get(['id', 'title']);
        return view('admin.Lessons.quizzes.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'nullable|exists:lessons,id',
            'title' => 'nullable|string|max:255',
            'time_limit_seconds' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        Quiz::create($validated);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz created successfully.');
    }

    public function show(Quiz $quiz)
    {
        $quiz->load(['lesson', 'questions']);
        return view('admin.Lessons.quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz)
    {
        $lessons = Lesson::where('is_published', true)->get(['id', 'title']);
        return view('admin.Lessons.quizzes.edit', compact('quiz', 'lessons'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'lesson_id' => 'nullable|exists:lessons,id',
            'title' => 'nullable|string|max:255',
            'time_limit_seconds' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}
