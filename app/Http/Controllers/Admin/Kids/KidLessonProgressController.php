<?php

namespace App\Http\Controllers\Admin\Kids;

use App\Http\Controllers\Controller;
use App\Models\KidLessonProgress;
use App\Models\Kid;
use App\Models\Lesson;
use Illuminate\Http\Request;

class KidLessonProgressController extends Controller
{
    public function index()
    {
        $progresses = KidLessonProgress::with(['kid', 'lesson'])->latest()->paginate(10);
        return view('admin.kid-lesson-progresses.index', compact('progresses'));
    }

    public function create()
    {
        $kids = Kid::all();
        $lessons = Lesson::all();

        return view('admin.kid-lesson-progresses.create', compact('kids', 'lessons'));
    }

    public function store(Request $request)
    {
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

    public function show(KidLessonProgress $kidLessonProgress)
    {
        $kidLessonProgress->load(['kid', 'lesson']);
        return view('admin.kid-lesson-progresses.show', compact('kidLessonProgress'));
    }

    public function edit(KidLessonProgress $kidLessonProgress)
    {
        $kids = Kid::all();
        $lessons = Lesson::all();

        return view('admin.kid-lesson-progresses.edit', compact('kidLessonProgress', 'kids', 'lessons'));
    }

    public function update(Request $request, KidLessonProgress $kidLessonProgress)
    {
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

    public function destroy(KidLessonProgress $kidLessonProgress)
    {
        $kidLessonProgress->delete();
        return redirect()->route('admin.kid-lesson-progresses.index')
            ->with('success', 'Lesson progress deleted successfully.');
    }
}
