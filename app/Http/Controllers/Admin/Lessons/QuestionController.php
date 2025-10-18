<?php

namespace App\Http\Controllers\Admin\Lessons;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $questions = Question::with('quiz')->latest()->paginate(10);
        } else {
            // الأب والطفل يرون فقط الأسئلة المرتبطة بـ Quiz مفعّل
            $questions = Question::whereHas('quiz', fn($q) => $q->where('is_active', true))
                ->with('quiz')
                ->latest()
                ->paginate(10);
        }

        return view('admin.Lessons.questions.index', compact('questions'));
    }

    public function show(Question $question)
    {
        $user = Auth::user();
        $question->load('quiz');

        if ($user->role->name !== 'admin' && !$question->quiz->is_active) {
            abort(403, 'Unauthorized access.');
        }

        return view('admin.Lessons.questions.show', compact('question'));
    }

    public function create()
    {
        $this->authorizeRole('admin');
        $quizzes = Quiz::where('is_active', true)->get(['id', 'title']);
        return view('admin.Lessons.questions.create', compact('quizzes'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

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

        Question::create($validated);

        return redirect()->route('admin.questions.index')->with('success', 'Question created successfully.');
    }

    public function edit(Question $question)
    {
        $this->authorizeRole('admin');
        $quizzes = Quiz::where('is_active', true)->get(['id', 'title']);
        return view('admin.Lessons.questions.edit', compact('question', 'quizzes'));
    }

    public function update(Request $request, Question $question)
    {
        $this->authorizeRole('admin');

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
        $this->authorizeRole('admin');
        $question->delete();
        return redirect()->route('admin.questions.index')->with('success', 'Question deleted successfully.');
    }

    private function authorizeRole($role)
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === $role, 403, 'Unauthorized action.');
    }
}
