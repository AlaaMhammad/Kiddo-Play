<?php

namespace App\Http\Controllers\Admin\Kids;

use App\Http\Controllers\Controller;
use App\Models\KidLessonProgress;
use App\Models\Kid;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KidLessonProgressController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $progresses = KidLessonProgress::with(['kid', 'lesson'])->latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            $kidId = $user->kid?->id;
            $progresses = KidLessonProgress::with(['kid', 'lesson'])
                ->where('kid_id', $kidId)
                ->latest()
                ->paginate(10);
        } elseif ($user->role->name === 'kid') {
            $kidId = $user->kid?->id;
            $progresses = KidLessonProgress::with(['kid', 'lesson'])
                ->where('kid_id', $kidId)
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.kid-lesson-progresses.index', compact('progresses'));
    }

    public function show(KidLessonProgress $kidLessonProgress)
    {
        $user = Auth::user();
        $kidLessonProgress->load(['kid', 'lesson']);

        if ($user->role->name === 'admin') {
            return view('admin.kid-lesson-progresses.show', compact('kidLessonProgress'));
        }

        if (in_array($user->role->name, ['parent', 'kid'])) {
            $kidId = $user->kid?->id;
            abort_unless($kidLessonProgress->kid_id === $kidId, 403, 'You do not have access to this progress.');
            return view('admin.kid-lesson-progresses.show', compact('kidLessonProgress'));
        }

        abort(403, 'Unauthorized');
    }

    // الأدمن فقط يستطيع إنشاء
    public function create()
    {
        $this->authorizeRole('admin');
        $kids = Kid::all();
        $lessons = Lesson::all();
        return view('admin.kid-lesson-progresses.create', compact('kids', 'lessons'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'lesson_id' => 'required|exists:lessons,id',
            'status' => 'required|in:not_started,in_progress,completed',
            'progress_percent' => 'nullable|integer|min:0|max:100',
            'last_accessed_at' => 'nullable|date',
        ]);

        KidLessonProgress::create($validated);

        return redirect()->route('admin.kid-lesson-progresses.index')
            ->with('success', 'Lesson progress created successfully.');
    }

    // الأدمن فقط يستطيع تعديل
    public function edit(KidLessonProgress $kidLessonProgress)
    {
        $this->authorizeRole('admin');
        $kids = Kid::all();
        $lessons = Lesson::all();
        return view('admin.kid-lesson-progresses.edit', compact('kidLessonProgress', 'kids', 'lessons'));
    }

    public function update(Request $request, KidLessonProgress $kidLessonProgress)
    {
        $this->authorizeRole('admin');

        $validated = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'lesson_id' => 'required|exists:lessons,id',
            'status' => 'required|in:not_started,in_progress,completed',
            'progress_percent' => 'nullable|integer|min:0|max:100',
            'last_accessed_at' => 'nullable|date',
        ]);

        $kidLessonProgress->update($validated);

        return redirect()->route('admin.kid-lesson-progresses.index')
            ->with('success', 'Lesson progress updated successfully.');
    }

    // الأدمن فقط يستطيع حذف
    public function destroy(KidLessonProgress $kidLessonProgress)
    {
        $this->authorizeRole('admin');
        $kidLessonProgress->delete();

        return redirect()->route('admin.kid-lesson-progresses.index')
            ->with('success', 'Lesson progress deleted successfully.');
    }

    // دالة مساعدة لفحص الدور
    private function authorizeRole($role)
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === $role, 403, 'Unauthorized action.');
    }
}
