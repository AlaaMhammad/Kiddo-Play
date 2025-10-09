<?php

namespace App\Http\Controllers\Admin\Rewards;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\DailyGoal;
use Illuminate\Http\Request;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::with('dailyGoal')->latest()->paginate(15);
        return view('admin.rewards.index', compact('rewards'));
    }

    public function create()
    {
        $dailyGoals = DailyGoal::all()->map(fn($goal) => ['id' => $goal->id, 'name' => $goal->title]);
        return view('admin.rewards.create', compact('dailyGoals'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'daily_goal_id' => 'required|exists:daily_goals,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:0',
        ]);

        Reward::create($data);

        return redirect()->route('admin.rewards.index')->with('success', 'Reward created successfully.');
    }

    public function show(Reward $reward)
    {
        return view('admin.rewards.show', compact('reward'));
    }

    public function edit(Reward $reward)
    {
        $dailyGoals = DailyGoal::all()->map(fn($goal) => ['id' => $goal->id, 'name' => $goal->title]);
        return view('admin.rewards.edit', compact('reward', 'dailyGoals'));
    }

    public function update(Request $request, Reward $reward)
    {
        $data = $request->validate([
            'daily_goal_id' => 'required|exists:daily_goals,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:0',
            'is_claimed' => 'nullable|boolean',
        ]);

        $reward->update($data);

        return redirect()->route('admin.rewards.index')->with('success', 'Reward updated successfully.');
    }

    public function destroy(Reward $reward)
    {
        $reward->delete();
        return redirect()->route('admin.rewards.index')->with('success', 'Reward deleted successfully.');
    }
}
