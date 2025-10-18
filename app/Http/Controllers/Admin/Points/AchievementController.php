<?php

namespace App\Http\Controllers\Admin\Points;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $achievements = Achievement::latest()->paginate(10);
        } elseif ($user->role->name === 'parent') {
            // الأب يرى الإنجازات التي حصل عليها أطفاله فقط
            $kidsIds = $user->children()->pluck('kids.id');
            $achievements = Achievement::whereHas('kids', fn($q) => $q->whereIn('kids.id', $kidsIds))
                ->latest()
                ->paginate(10);
        } elseif ($user->role->name === 'kid') {
            $achievements = Achievement::whereHas('kids', fn($q) => $q->where('kids.id', $user->kid?->id))
                ->latest()
                ->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.achievements.index', compact('achievements'));
    }

    public function show(Achievement $achievement)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'parent') {
            $hasAccess = $user->children()->where('kids.id', $achievement->id)->exists();
            abort_unless($hasAccess, 403, 'Unauthorized access.');
        }

        if ($user->role->name === 'kid' && !$achievement->kids->contains($user->kid?->id)) {
            abort(403, 'Unauthorized access.');
        }

        $kids = $achievement->kids()->orderBy('created_at', 'desc')->get();
        return view('admin.achievements.show', compact('achievement', 'kids'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('admin.achievements.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

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

    public function edit(Achievement $achievement)
    {
        $this->authorizeAdmin();
        return view('admin.achievements.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $this->authorizeAdmin();

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
        $this->authorizeAdmin();

        $achievement->delete();
        return back()->with('success', 'Achievement deleted successfully!');
    }

    private function authorizeAdmin()
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === 'admin', 403, 'Unauthorized action.');
    }
}
