<?php

namespace App\Http\Controllers\Admin\Kids;

use App\Http\Controllers\Controller;
use App\Models\Kid;
use App\Models\Achievement;
use App\Models\KidAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KidAchievementController extends Controller
{
    /**
     * عرض قائمة الإنجازات
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();


        if ($user->role->name === 'admin') {
            $kidAchievements = KidAchievement::with(['kid', 'achievement'])->latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            // الأب يرى فقط إنجازات أطفاله
            $kidsIds = $user->children()->pluck('kids.id');
            $kidAchievements = KidAchievement::with(['kid', 'achievement'])
                ->whereIn('kid_id', $kidsIds)
                ->latest()
                ->paginate(10);
        } elseif ($user->role->name === 'kid') {
            // الطفل يرى إنجازاته فقط
            $kidAchievements = KidAchievement::with(['kid', 'achievement'])
                ->where('kid_id', $user->kid->id)
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.kid-achievements.index', compact('kidAchievements'));
    }

    /**
     * عرض تفاصيل إنجاز
     */
    public function show(KidAchievement $kidAchievement)
    {
        /** @var User $user */
        $user = Auth::user();

        $kidAchievement->load(['kid', 'achievement']);

        if ($user->role->name === 'admin') {
            return view('admin.kid-achievements.show', compact('kidAchievement'));
        }

        if ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            abort_unless(in_array($kidAchievement->kid_id, $kidsIds->toArray()), 403, 'You do not have access to this achievement.');
            return view('admin.kid-achievements.show', compact('kidAchievement'));
        }

        if ($user->role->name === 'kid') {
            abort_unless($kidAchievement->kid_id === $user->kid->id, 403, 'You cannot view this achievement.');
            return view('admin.kid-achievements.show', compact('kidAchievement'));
        }

        abort(403, 'Unauthorized');
    }

    /**
     * إنشاء إنجاز (للأدمن فقط)
     */
    public function create()
    {
        $this->authorizeRole('admin');
        $kids = Kid::all();
        $achievements = Achievement::all();
        return view('admin.kid-achievements.create', compact('kids', 'achievements'));
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'achievement_id' => 'required|exists:achievements,id',
            'awarded_at' => 'nullable|date',
        ]);

        KidAchievement::create($request->all());

        return redirect()->route('admin.kid-achievements.index')->with('success', 'Achievement awarded successfully!');
    }

    /**
     * تعديل إنجاز (للأدمن فقط)
     */
    public function edit(KidAchievement $kidAchievement)
    {
        $this->authorizeRole('admin');
        $kids = Kid::all();
        $achievements = Achievement::all();
        return view('admin.kid-achievements.edit', compact('kidAchievement', 'kids', 'achievements'));
    }

    public function update(Request $request, KidAchievement $kidAchievement)
    {
        $this->authorizeRole('admin');

        $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'achievement_id' => 'required|exists:achievements,id',
            'awarded_at' => 'nullable|date',
        ]);

        $kidAchievement->update($request->all());

        return redirect()->route('admin.kid-achievements.index')->with('success', 'Kid achievement updated successfully!');
    }

    /**
     * حذف إنجاز (للأدمن فقط)
     */
    public function destroy(KidAchievement $kidAchievement)
    {
        $this->authorizeRole('admin');

        $kidAchievement->delete();

        return redirect()->route('admin.kid-achievements.index')->with('success', 'Kid achievement deleted successfully!');
    }

    /**
     * دالة مساعدة لفحص الدور
     */
    private function authorizeRole($role)
    {
        $user = Auth::user();

        abort_unless($user && $user->role->name === $role, 403, 'Unauthorized action.');
    }
}
