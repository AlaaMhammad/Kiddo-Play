<?php

namespace App\Http\Controllers\Admin\Lessons;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $quizzes = Quiz::with('lesson')->latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            $quizzes = Quiz::whereHas('lesson', fn($q) => $q->where('is_published', true))
                ->with('lesson')
                ->latest()
                ->paginate(10);
        } elseif ($user->role->name === 'kid') {
            $quizzes = Quiz::whereHas('lesson', fn($q) => $q->where('is_published', true))
                ->where('is_active', true)
                ->with('lesson')
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.Lessons.quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        $user = Auth::user();

        if ($user->role->name === 'parent' && !$quiz->lesson->is_published) {
            abort(403, 'Unauthorized access.');
        }

        if ($user->role->name === 'kid' && (!$quiz->lesson->is_published || !$quiz->is_active)) {
            abort(403, 'Unauthorized access.');
        }

        $quiz->load(['lesson', 'questions']);
        return view('admin.Lessons.quizzes.show', compact('quiz'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        $lessons = Lesson::where('is_published', true)->get(['id', 'title']);
        return view('admin.Lessons.quizzes.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'lesson_id' => 'nullable|exists:lessons,id',
            'title' => 'nullable|string|max:255',
            'time_limit_seconds' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Quiz::create($validated);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz created successfully.');
    }

    public function edit(Quiz $quiz)
    {
        $this->authorizeAdmin();

        $lessons = Lesson::where('is_published', true)->get(['id', 'title']);
        return view('admin.Lessons.quizzes.edit', compact('quiz', 'lessons'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $this->authorizeAdmin();

        $validated = $request->validate([
            'lesson_id' => 'nullable|exists:lessons,id',
            'title' => 'nullable|string|max:255',
            'time_limit_seconds' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $this->authorizeAdmin();

        $quiz->delete();
        return redirect()->route('admin.quizzes.index')->with('success', 'Quiz deleted successfully.');
    }

    private function authorizeAdmin()
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === 'admin', 403, 'Unauthorized action.');
    }
}
