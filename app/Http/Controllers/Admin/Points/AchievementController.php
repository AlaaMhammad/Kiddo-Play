<?php

namespace App\Http\Controllers\Admin\Points;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $achievements = Achievement::latest()->paginate(10);
        return view('admin.achievements.index', compact('achievements'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.achievements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:achievements,code|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_award' => 'nullable|integer|min:0',
            'icon_url' => 'nullable|url',
        ]);

        Achievement::create($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement created successfully!');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Display the specified resource.
     */
    public function show(Achievement $achievement)
    {
        // لو أردت، يمكن تحميل الأطفال الذين حصلوا على هذا الإنجاز
        $kids = $achievement->kids()->get();

        return view('admin.achievements.show', compact('achievement', 'kids'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Achievement $achievement)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:achievements,code,' . $achievement->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_award' => 'nullable|integer|min:0',
            'icon_url' => 'nullable|url',
        ]);

        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();

        return back()->with('success', 'Achievement deleted successfully!');
    }
}
