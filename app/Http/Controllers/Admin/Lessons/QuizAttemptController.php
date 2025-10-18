<?php

namespace App\Http\Controllers\Admin\Lessons;

use App\Http\Controllers\Controller;
use App\Models\QuizAttempt;
use App\Models\Kid;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizAttemptController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $attempts = QuizAttempt::with(['kid', 'quiz'])->latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            $attempts = QuizAttempt::with(['kid', 'quiz'])
                ->whereIn('kid_id', $kidsIds)
                ->latest()
                ->paginate(10);
        } elseif ($user->role->name === 'kid') {
            $attempts = QuizAttempt::with(['kid', 'quiz'])
                ->where('kid_id', $user->kid?->id)
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.Lessons.quiz-attempts.index', compact('attempts'));
    }

    public function show(QuizAttempt $quizAttempt)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            abort_unless(in_array($quizAttempt->kid_id, $kidsIds), 403, 'Unauthorized access.');
        } elseif ($user->role->name === 'kid') {
            abort_unless($quizAttempt->kid_id === $user->kid?->id, 403, 'Unauthorized access.');
        }

        $quizAttempt->load(['kid', 'quiz', 'answers']);
        return view('admin.Lessons.quiz-attempts.show', compact('quizAttempt'));
    }

    public function create()
    {
        $this->authorizeAdmin();

        $kids = Kid::select('id', 'display_name')->get();
        $quizzes = Quiz::select('id', 'title')->get();
        return view('admin.Lessons.quiz-attempts.create', compact('kids', 'quizzes'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

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

    public function edit(QuizAttempt $quizAttempt)
    {
        $this->authorizeAdmin();

        $kids = Kid::select('id', 'display_name')->get();
        $quizzes = Quiz::select('id', 'title')->get();
        return view('admin.Lessons.quiz-attempts.edit', compact('quizAttempt', 'kids', 'quizzes'));
    }

    public function update(Request $request, QuizAttempt $quizAttempt)
    {
        $this->authorizeAdmin();

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
        $this->authorizeAdmin();

        $quizAttempt->delete();
        return redirect()->route('admin.quiz-attempts.index')->with('success', 'Quiz attempt deleted successfully.');
    }

    private function authorizeAdmin()
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === 'admin', 403, 'Unauthorized action.');
    }
}
