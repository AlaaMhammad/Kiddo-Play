<?php

namespace App\Http\Controllers\Admin\DailyGoals;

use App\Http\Controllers\Controller;
use App\Models\Avatar;
use App\Models\DailyGoal;
use App\Models\Kid;
use App\Models\Game;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class DailyGoalController extends Controller
{
    public function index()
    {
        $dailyGoals = DailyGoal::with(['kid', 'game'])->orderBy('goal_date', 'desc')->latest()->paginate(10);
        return view('admin.daily-goals.index', compact('dailyGoals'));
    }

    public function create()
    {
        $kids = Kid::all();
        $games = Game::all();
        $parents = User::whereHas('role', fn($q) => $q->where('name', 'parent'))
            ->get()
            ->map(fn($user) => ['id' => $user->id, 'name' => $user->name]);
        $avatars = Avatar::all(); // جلب كل الصور/أفاتار
        return view('admin.daily-goals.create', compact('kids', 'games', 'parents', 'avatars'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'game_id' => 'nullable|exists:games,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_points' => 'nullable|integer|min:0',
            'is_completed' => 'nullable|boolean',
            'goal_date' => 'required|date',
        ]);

        $data['is_completed'] = $request->has('is_completed');
        DailyGoal::create($data);

        return redirect()->route('daily-goals.index')->with('success', 'Daily Goal created successfully.');
    }

    public function edit(DailyGoal $dailyGoal)
    {
        $kids = Kid::all();
        $games = Game::all();
        return view('admin.daily-goals.edit', compact('dailyGoal', 'kids', 'games'));
    }

    public function update(Request $request, DailyGoal $dailyGoal)
    {
        $data = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'game_id' => 'nullable|exists:games,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_points' => 'nullable|integer|min:0',
            'is_completed' => 'nullable|boolean',
            'goal_date' => 'required|date',
        ]);

        $data['is_completed'] = $request->has('is_completed');
        $dailyGoal->update($data);

        return redirect()->route('daily-goals.index')->with('success', 'Daily Goal updated successfully.');
    }

    public function show(DailyGoal $dailyGoal)
    {
        return view('admin.daily-goals.show', compact('dailyGoal'));
    }

    public function destroy(DailyGoal $dailyGoal)
    {
        $dailyGoal->delete();
        return redirect()->route('daily-goals.index')->with('success', 'Daily Goal deleted successfully.');
    }
}
