<?php

namespace App\Http\Controllers\Admin\Kids;

use App\Http\Controllers\Controller;
use App\Models\Kid;
use App\Models\Achievement;
use App\Models\KidAchievement;
use Illuminate\Http\Request;

class KidAchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kidAchievements = KidAchievement::with(['kid', 'achievement'])->latest()->paginate(10);
        return view('admin.kid-achievements.index', compact('kidAchievements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kids = Kid::all();
        $achievements = Achievement::all();
        return view('admin.kid-achievements.create', compact('kids', 'achievements'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'achievement_id' => 'required|exists:achievements,id',
            'awarded_at' => 'nullable|date',
        ]);

        KidAchievement::create($request->all());

        return redirect()->route('admin.kid-achievements.index')->with('success', 'Achievement awarded to kid successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KidAchievement $kidAchievement)
    {
        $kidAchievement->load(['kid', 'achievement']);
        return view('admin.kid-achievements.show', compact('kidAchievement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KidAchievement $kidAchievement)
    {
        $kids = Kid::all();
        $achievements = Achievement::all();
        return view('admin.kid-achievements.edit', compact('kidAchievement', 'kids', 'achievements'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, KidAchievement $kidAchievement)
    {
        $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'achievement_id' => 'required|exists:achievements,id',
            'awarded_at' => 'nullable|date',
        ]);

        $kidAchievement->update($request->all());

        return redirect()->route('admin.kid-achievements.index')->with('success', 'Kid achievement updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KidAchievement $kidAchievement)
    {
        $kidAchievement->delete();
        return back()->with('success', 'Kid achievement deleted successfully!');
    }
}
