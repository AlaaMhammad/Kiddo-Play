<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameKid;
use App\Models\Game;
use App\Models\Kid;
use Illuminate\Support\Facades\Auth;

class GameKidController extends Controller
{
    /**
     * عرض جميع سجلات الألعاب للأطفال مع صلاحيات
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            // الأدمن يرى كل السجلات
            $gameKids = GameKid::with(['game:id,description', 'kid:id,display_name'])
                ->latest()
                ->paginate(15);
        } elseif ($user->role->name === 'parent') {
            // الأب يرى سجلات أطفاله فقط
            $kidsIds = $user->children()->pluck('kids.id');
            $gameKids = GameKid::with(['game:id,description', 'kid:id,display_name'])
                ->whereIn('kid_id', $kidsIds)
                ->latest()
                ->paginate(15);
        } elseif ($user->role->name === 'kid') {
            // الطفل يرى سجله فقط
            $gameKids = GameKid::with(['game:id,description', 'kid:id,display_name'])
                ->where('kid_id', $user->kid?->id)
                ->latest()
                ->paginate(15);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('admin.games.game-kids.index', compact('gameKids'));
    }

    /**
     * إنشاء سجل جديد (الأدمن فقط)
     */
    public function create()
    {
        $this->authorizeAdmin();

        $games = Game::where('is_active', true)->get();
        $kids = Kid::all();
        return view('admin.games.game-kids.create', compact('games', 'kids'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'game_id' => 'required|exists:games,id',
            'score' => 'nullable|integer|min:0',
            'play_count' => 'nullable|integer|min:0',
            'last_played_at' => 'nullable|date',
        ]);

        GameKid::create($data);

        return redirect()->route('game-kids.index')->with('success', 'Game-Kid record created successfully.');
    }

    /**
     * تعديل سجل (الأدمن فقط)
     */
    public function edit(GameKid $gameKid)
    {
        $this->authorizeAdmin();

        $games = Game::where('is_active', true)->get();
        $kids = Kid::all();
        return view('admin.games.game-kids.edit', compact('gameKid', 'games', 'kids'));
    }

    public function update(Request $request, GameKid $gameKid)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'game_id' => 'required|exists:games,id',
            'score' => 'nullable|integer|min:0',
            'play_count' => 'nullable|integer|min:0',
            'last_played_at' => 'nullable|date',
        ]);

        $gameKid->update($data);

        return redirect()->route('game-kids.index')->with('success', 'Record updated successfully.');
    }

    /**
     * حذف سجل (الأدمن فقط)
     */
    public function destroy(GameKid $gameKid)
    {
        $this->authorizeAdmin();

        $gameKid->delete();
        return redirect()->route('game-kids.index')->with('success', 'Record deleted successfully.');
    }

    /**
     * دالة مساعدة لفحص صلاحية الأدمن
     */
    private function authorizeAdmin()
    {
        $user = Auth::user();
        abort_unless($user && $user->role->name === 'admin', 403, 'Unauthorized action.');
    }
}
