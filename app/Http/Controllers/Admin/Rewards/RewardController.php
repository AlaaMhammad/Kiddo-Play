<?php

namespace App\Http\Controllers\Admin\Rewards;

use App\Http\Controllers\Controller;
use App\Models\Reward;
use App\Models\DailyGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{
    public function index()
    {
        /**  @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $rewards = Reward::with('dailyGoal')->latest()->paginate(15);
        } elseif ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            $rewards = Reward::whereHas('dailyGoal', fn($q) => $q->whereIn('kid_id', $kidsIds))
                ->with('dailyGoal')
                ->latest()
                ->paginate(15);
        } elseif ($user->role->name === 'kid') {
            $kidId = $user->kid?->id;
            $rewards = Reward::whereHas('dailyGoal', fn($q) => $q->where('kid_id', $kidId))
                ->with('dailyGoal')
                ->latest()
                ->paginate(15);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.rewards.index', compact('rewards'));
    }

    public function show(Reward $reward)
    {
        $this->checkAccess($reward);
        return view('admin.rewards.show', compact('reward'));
    }

    // الأدمن فقط يستطيع CRUD
    public function create()
    {
        $this->authorizeRole('admin');

        $dailyGoals = DailyGoal::all()->map(fn($goal) => ['id' => $goal->id, 'name' => $goal->title]);
        return view('admin.rewards.create', compact('dailyGoals'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $data = $request->validate([
            'daily_goal_id' => 'required|exists:daily_goals,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_required' => 'required|integer|min:0',
        ]);

        Reward::create($data);

        return redirect()->route('admin.rewards.index')->with('success', 'Reward created successfully.');
    }

    public function edit(Reward $reward)
    {
        $this->authorizeRole('admin');

        $dailyGoals = DailyGoal::all()->map(fn($goal) => ['id' => $goal->id, 'name' => $goal->title]);
        return view('admin.rewards.edit', compact('reward', 'dailyGoals'));
    }

    public function update(Request $request, Reward $reward)
    {
        $this->authorizeRole('admin');

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
        $this->authorizeRole('admin');

        $reward->delete();
        return redirect()->route('admin.rewards.index')->with('success', 'Reward deleted successfully.');
    }

    /**
     * دالة لفحص الوصول بالنسبة للوالد أو الطفل
     */
    private function checkAccess(Reward $reward)
    {
        /**  @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') return;

        if ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            abort_unless(in_array($reward->dailyGoal->kid_id, $kidsIds->toArray()), 403, 'Unauthorized access');
        }

        if ($user->role->name === 'kid') {
            $kidId = $user->kid?->id;
            abort_unless($reward->dailyGoal->kid_id === $kidId, 403, 'Unauthorized access');
        }
    }

    private function authorizeRole($role)
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === $role, 403, 'Unauthorized action.');
    }
}
