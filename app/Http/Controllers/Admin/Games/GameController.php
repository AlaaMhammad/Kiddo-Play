<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * عرض قائمة الألعاب
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            // الأدمن يرى كل الألعاب
            $games = Game::withCount('kids')->latest()->paginate(15);
        } elseif ($user->role->name === 'parent') {
            // الأب يرى فقط الألعاب التي لعبها أطفاله
            $kidsIds = $user->children()->pluck('kids.id');
            $games = Game::whereHas('kids', fn($q) => $q->whereIn('kids.id', $kidsIds))
                ->withCount('kids')
                ->latest()
                ->paginate(15);
        } elseif ($user->role->name === 'kid') {
            // الطفل يرى الألعاب النشطة فقط
            $games = Game::where('is_active', true)->latest()->paginate(15);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.games.game.index', compact('games'));
    }

    /**
     * عرض تفاصيل لعبة معينة
     */
    public function show(Game $game)
    {
        /** @var User $user */
        $user = Auth::user();

        // تحميل الأطفال الذين لعبوا هذه اللعبة
        $game->load(['kids' => function ($query) {
            $query->select('kids.id', 'kids.display_name')
                ->withPivot(['score', 'play_count', 'last_played_at']);
        }]);

        if ($user->role->name === 'admin') {
            // الأدمن يرى كل التفاصيل
            return view('admin.games.game.show', compact('game'));
        }

        if ($user->role->name === 'parent') {
            // الأب لا يرى إلا إذا أحد أطفاله لعب اللعبة
            $kidsIds = $user->children()->pluck('kids.id');
            $hasAccess = $game->kids()->whereIn('kids.id', $kidsIds)->exists();

            abort_unless($hasAccess, 403, 'You do not have access to this game.');

            return view('admin.games.game.show', compact('game'));
        }

        if ($user->role->name === 'kid') {
            // الطفل يرى فقط اللعبة المفعلة
            abort_unless($game->is_active, 403, 'You cannot access inactive games.');

            return view('admin.games.game.show', compact('game'));
        }

        abort(403, 'Unauthorized');
    }

    /**
     * إنشاء لعبة جديدة (للأدمن فقط)
     */
    public function create()
    {
        $this->authorizeRole('admin');
        return view('admin.games.game.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $data = $request->validate([
            'description' => 'nullable|string',
            'category' => 'required|in:educational,fun,mixed',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'media_url' => 'nullable|url',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');

        Game::create($data);

        return redirect()->route('admin.games.index')->with([
            'success' => 'Game created successfully.',
            'action' => 'create',
        ]);
    }

    /**
     * تعديل لعبة (للأدمن فقط)
     */
    public function edit(Game $game)
    {
        $this->authorizeRole('admin');
        return view('admin.games.game.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        $this->authorizeRole('admin');

        $data = $request->validate([
            'description' => 'nullable|string',
            'category' => 'required|in:educational,fun,mixed',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'media_url' => 'nullable|url',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        $game->update($data);

        return redirect()->route('admin.games.index')->with([
            'success' => 'Game updated successfully.',
            'action' => 'update',
        ]);
    }

    /**
     * حذف لعبة (للأدمن فقط)
     */
    public function destroy(Game $game)
    {
        $this->authorizeRole('admin');

        $game->delete();

        return redirect()->route('admin.games.index')->with([
            'success' => 'Game deleted successfully.',
            'action' => 'delete',
        ]);
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
