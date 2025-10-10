<?php

namespace App\Http\Controllers\Admin\Lessons;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('quiz')->latest()->paginate(10);
        return view('admin.Lessons.questions.index', compact('questions'));
    }

    public function create()
    {
        $quizzes = Quiz::where('is_active', true)->get(['id', 'title']);
        return view('admin.Lessons.questions.create', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'content' => 'required|string',
            'type' => 'required|in:mcq,true_false,fill_blank,match',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|array',
            'points' => 'required|integer|min:1',
            'order' => 'nullable|integer|min:0',
        ]);

        // Encode JSON fields manually (if necessary)
        $validated['options'] = $request->options ? json_encode($request->options) : null;
        $validated['correct_answer'] = $request->correct_answer ? json_encode($request->correct_answer) : null;

        Question::create($validated);

        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully.');
    }

    public function show(Question $question)
    {
        $question->load('quiz');
        return view('admin.Lessons.questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $quizzes = Quiz::where('is_active', true)->get(['id', 'title']);
        return view('admin.Lessons.questions.edit', compact('question', 'quizzes'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'content' => 'required|string',
            'type' => 'required|in:mcq,true_false,fill_blank,match',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|array',
            'points' => 'required|integer|min:1',
            'order' => 'nullable|integer|min:0',
        ]);

        $validated['options'] = $request->options ? json_encode($request->options) : null;
        $validated['correct_answer'] = $request->correct_answer ? json_encode($request->correct_answer) : null;

        $question->update($validated);

        return redirect()->route('admin.questions.index')->with('success', 'Question updated successfully.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully.');
    }
}
