<?php

namespace App\Http\Controllers\Admin\Points;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::latest()->paginate(10);
        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('admin.achievements.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:achievements,code|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_award' => 'sometimes|integer|min:0',
            'icon_url' => 'nullable|string|max:255',
        ]);

        Achievement::create($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement created successfully!');
    }

    public function show(Achievement $achievement)
    {
        $kids = $achievement->kids()->orderBy('created_at', 'desc')->get();
        return view('admin.achievements.show', compact('achievement', 'kids'));
    }

    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:achievements,code,' . $achievement->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_award' => 'sometimes|integer|min:0',
            'icon_url' => 'nullable|string|max:255',
        ]);

        $achievement->update($validated);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement updated successfully!');
    }

    public function destroy(Achievement $achievement)
    {
        $achievement->delete();
        return back()->with('success', 'Achievement deleted successfully!');
    }
}
