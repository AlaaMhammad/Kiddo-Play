<?php

namespace App\Http\Controllers\Admin\Lessons;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::latest()->paginate(10);
        return view('admin.Lessons.lesson.index', compact('lessons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.Lessons.lesson.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:numbers,letters,animals,arithmetic',
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'media_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        Lesson::create($validated);

        return redirect()->route('admin.lesson.index')->with('success', 'Lesson created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        return view('admin.Lessons.lesson.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        return view('admin.Lessons.lesson.edit', compact('lesson'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'category' => 'required|in:numbers,letters,animals,arithmetic',
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'media_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'boolean',
        ]);

        $lesson->update($validated);

        return redirect()->route('admin.lesson.index')->with('success', 'Lesson updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('admin.lesson.index')->with('success', 'Lesson deleted successfully.');
    }
}
