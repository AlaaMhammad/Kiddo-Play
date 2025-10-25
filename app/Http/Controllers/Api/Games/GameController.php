<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * قائمة الألعاب للـ API
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $games = Game::withCount('kids')->latest()->get();
        } elseif ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id');
            $games = Game::whereHas('kids', fn($q) => $q->whereIn('kids.id', $kidsIds))
                ->withCount('kids')
                ->latest()
                ->get();
        } elseif ($user->role->name === 'kid') {
            $games = Game::where('is_active', true)->latest()->get();
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status' => 1,
            'data' => $games
        ]);
    }

    /**
     * عرض تفاصيل لعبة واحدة
     */
    public function show(Game $game)
    {
        /** @var User $user */
        $user = Auth::user();

        // إذا الدور Admin، نعرض كل شيء
        if ($user->role->name === 'admin') {
            $game->load(['kids' => function ($query) {
                $query->select('kids.id', 'kids.display_name')
                    ->withPivot(['score', 'play_count', 'last_played_at']);
            }]);
        }
        // إذا الدور Parent
        elseif ($user->role->name === 'parent') {
            // نحصل على IDs أولاد الأب
            $kidsIds = $user->children()->pluck('kids.id')->toArray();

            // نتأكد أن اللعبة مرتبطة على الأقل مع أحد أولاده
            $gameKidsIds = $game->kids()->pluck('kids.id')->toArray();
            $intersect = array_intersect($kidsIds, $gameKidsIds);
            if (empty($intersect)) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            // نعرض فقط أولاده المرتبطين باللعبة
            $game->load(['kids' => function ($query) use ($kidsIds) {
                $query->whereIn('kids.id', $kidsIds)
                    ->select('kids.id', 'kids.display_name')
                    ->withPivot(['score', 'play_count', 'last_played_at']);
            }]);
        }
        // إذا الدور Kid
        elseif ($user->role->name === 'kid') {
            if (!$game->is_active) {
                return response()->json(['message' => 'Game inactive'], 403);
            }

            // نعرض فقط بيانات الطفل نفسه
            $game->load(['kids' => function ($query) use ($user) {
                $query->where('kids.id', $user->id)
                    ->select('kids.id', 'kids.display_name')
                    ->withPivot(['score', 'play_count', 'last_played_at']);
            }]);
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status' => 1,
            'data' => $game
        ]);
    }


    /**
     * تسجيل لعب اللعبة (لـ kid فقط)
     */
    public function play(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role->name, ['kid', 'parent'])) {
            return response()->json(['message' => 'Only kids and parents can play games'], 403);
        }

        $request->validate([
            'game_id' => 'required|exists:games,id',
        ]);

        $game = Game::findOrFail($request->game_id);

        if (!$game->is_active) {
            return response()->json(['message' => 'Game inactive'], 403);
        }

        $kidId = $user->kid->id;

        $game->kids()->syncWithoutDetaching([
            $kidId => [
                'score' => 0,
                'play_count' => DB::raw('play_count + 1'),
                'last_played_at' => now(),
            ]
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Game played successfully',
        ]);
    }
}
