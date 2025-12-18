<?php

namespace App\Http\Controllers\Admin\DailyGoals;

use App\Http\Controllers\Controller;
use App\Models\DailyGoal;
use App\Models\Kid;
use App\Models\Game;
use App\Models\User;
use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DailyGoalController extends Controller
{
    public function index()
    {
        /**  @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $dailyGoals = DailyGoal::with(['kid', 'game'])->orderBy('goal_date', 'desc')->latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id'); // علاقة parent → children
            $dailyGoals = DailyGoal::with(['kid', 'game'])
                ->whereIn('kid_id', $kidsIds)
                ->orderBy('goal_date', 'desc')
                ->latest()
                ->paginate(10);
        } elseif ($user->role->name === 'kid') {
            $kidId = $user->kid?->id;
            $dailyGoals = DailyGoal::with(['kid', 'game'])
                ->where('kid_id', $kidId)
                ->orderBy('goal_date', 'desc')
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.daily-goals.index', compact('dailyGoals'));
    }

    public function show(DailyGoal $dailyGoal)
    {
        $this->checkAccess($dailyGoal);
        return view('admin.daily-goals.show', compact('dailyGoal'));
    }

    // الأدمن فقط يستطيع إنشاء
    public function create()
    {
        $this->authorizeRole('admin');

        $kids = Kid::all()->map(fn($kid) => ['id' => $kid->id, 'name' => $kid->display_name])->toArray();
        $games = Game::all()->map(fn($game) => ['id' => $game->id, 'name' => $game->description])->toArray();
        $parents = User::whereHas('role', fn($q) => $q->where('name', 'parent'))->get()
            ->map(fn($user) => ['id' => $user->id, 'name' => $user->name])->toArray();
        $avatars = Avatar::all()->map(fn($avatar) => ['id' => $avatar->id, 'name' => $avatar->name])->toArray();

        return view('admin.daily-goals.create', compact('kids', 'games', 'parents', 'avatars'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $data = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'game_id' => 'nullable|exists:games,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_points' => 'nullable|integer|min:0',
            'progress' => 'nullable|integer|min:0',  // الجديد
            'type' => 'nullable|string|in:game,word,quiz', // الجديد
            'is_completed' => 'nullable|boolean',
            'goal_date' => 'required|date',
        ]);

        $data['is_completed'] = $request->has('is_completed');
        DailyGoal::create($data);

        return redirect()->route('admin.daily-goals.index')->with('success', 'Daily Goal created successfully.');
    }

    // الأدمن فقط يستطيع تعديل
    public function edit(DailyGoal $dailyGoal)
    {
        $this->authorizeRole('admin');

        $kids = Kid::all()->map(fn($kid) => ['id' => $kid->id, 'name' => $kid->display_name])->toArray();
        $games = Game::all()->map(fn($game) => ['id' => $game->id, 'name' => $game->description])->toArray();

        return view('admin.daily-goals.edit', compact('dailyGoal', 'kids', 'games'));
    }

    public function update(Request $request, DailyGoal $dailyGoal)
    {
        $this->authorizeRole('admin');

        $data = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'game_id' => 'nullable|exists:games,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_points' => 'nullable|integer|min:0',
            'progress' => 'nullable|integer|min:0',  // الجديد
            'type' => 'nullable|string|in:game,word,quiz', // الجديد
            'is_completed' => 'nullable|boolean',
            'goal_date' => 'required|date',
        ]);

        $data['is_completed'] = $request->has('is_completed');
        $dailyGoal->update($data);

        return redirect()->route('admin.daily-goals.index')->with('success', 'Daily Goal updated successfully.');
    }

    public function destroy(DailyGoal $dailyGoal)
    {
        $this->authorizeRole('admin');

        $dailyGoal->delete();
        return redirect()->route('admin.daily-goals.index')->with('success', 'Daily Goal deleted successfully.');
    }

    /**
     * دالة لفحص الوصول بالنسبة للوالد أو الطفل
     */
    private function checkAccess(DailyGoal $dailyGoal)
    {
        /**  @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') return;

        if ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            abort_unless(in_array($dailyGoal->kid_id, $kidsIds->toArray()), 403, 'Unauthorized access');
        }

        if ($user->role->name === 'kid') {
            $kidId = $user->kid?->id;
            abort_unless($dailyGoal->kid_id === $kidId, 403, 'Unauthorized access');
        }
    }

    private function authorizeRole($role)
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === $role, 403, 'Unauthorized action.');
    }
}
