<?php

namespace App\Http\Controllers\Api\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Game, Kid, KidSession, KidAchievement, Notification, Achievement, User};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * 🧩 List of games
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
            $games = Game::where('is_active', true)->latest()->get()->map(function ($game) use ($user) {
                return [
                    'id' => $game->id,
                    'title' => $game->title,
                    'description' => $game->description,
                    'category' => $game->category,
                    'difficulty_level' => $game->difficulty_level,
                    'media_url' => $game->media_url,
                    'game_url' => $game->game_url,
                    'required_points' => $game->required_points,
                    'entry_cost' => $game->entry_cost,
                    'is_locked' => $user->points < $game->required_points,
                ];
            });
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json([
            'status' => 1,
            'data' => $games
        ]);
    }

//////////////////////////////////////////////////////
    // public function index()
    // {
    //     /** @var User $user */
    //     $user = Auth::user();

    //     if ($user->role->name === 'admin') {
    //         $games = Game::withCount('kids')->latest()->get();
    //     } elseif ($user->role->name === 'parent') {
    //         $kidsIds = $user->children()->pluck('kids.id');
    //         $games = Game::whereHas('kids', fn($q) => $q->whereIn('kids.id', $kidsIds))
    //             ->withCount('kids')
    //             ->latest()
    //             ->get();
    //     } elseif ($user->role->name === 'kid') {
    //         $games = Game::where('is_active', true)->latest()->get();
    //     } else {
    //         return response()->json(['message' => 'Unauthorized'], 403);
    //     }

    //     return response()->json([
    //         'status' => 1,
    //         'data' => $games
    //     ]);
    // }

    /**
     * 🎮 Show details for a single game
     */
    public function show(Game $game)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->role->name === 'admin') {
            $game->load(['kids' => function ($query) {
                $query->select('kids.id', 'kids.display_name')
                    ->withPivot(['score', 'play_count', 'last_played_at']);
            }]);
        } elseif ($user->role->name === 'parent') {
            $kidsIds = $user->children()->pluck('kids.id')->toArray();
            $gameKidsIds = $game->kids()->pluck('kids.id')->toArray();
            $intersect = array_intersect($kidsIds, $gameKidsIds);
            if (empty($intersect)) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $game->load(['kids' => function ($query) use ($kidsIds) {
                $query->whereIn('kids.id', $kidsIds)
                    ->select('kids.id', 'kids.display_name')
                    ->withPivot(['score', 'play_count', 'last_played_at']);
            }]);
        } elseif ($user->role->name === 'kid') {
            if (!$game->is_active) {
                return response()->json(['message' => 'Game inactive'], 403);
            }

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
     * 🕹️ Record gameplay (for kids only)
     */

    public function play(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->role->name !== 'kid') {
            return response()->json(['message' => 'Only kids can play games'], 403);
        }

        $request->validate([
            'game_id' => 'required|exists:games,id',
            'score'   => 'nullable|integer|min:0',
        ]);

        $game = Game::findOrFail($request->game_id);
        if (!$game->is_active) {
            return response()->json(['message' => 'Game inactive'], 403);
        }

        // تحقق من فتح اللعبة حسب required_points
        if ($user->points < $game->required_points) {
            return response()->json(['message' => 'Not enough points to open this game'], 403);
        }

        DB::transaction(function () use ($user, $game, $request) {
            // خصم نقاط الدخول تلقائيًا
            if ($game->entry_cost > 0) {
                if ($user->points < $game->entry_cost) {
                    abort(403, 'Not enough points to play this game');
                }
                $user->decrement('points', $game->entry_cost);
            }

            // تحديث سجل اللعب
            $game->kids()->syncWithoutDetaching([
                $user->id => [
                    'score' => DB::raw('GREATEST(score, ' . ($request->score ?? 0) . ')'),
                    'play_count' => DB::raw('play_count + 1'),
                    'last_played_at' => now(),
                ],
            ]);

            // إنشاء جلسة لعب
            KidSession::create([
                'kid_id' => $user->id,
                'started_at' => now(),
                'ended_at' => now(),
                'duration_seconds' => rand(30, 300),
                'activity' => json_encode(['game_id' => $game->id]),
            ]);
        });

        return response()->json([
            'status' => 1,
            'message' => 'Game started and points deducted successfully',
            'current_points' => $user->fresh()->points,
            'game_url' => $game->game_url,
        ]);
    }

    /////////////////////////////////////
    // public function play(Request $request)
    // {
    //     /** @var User $user */
    //     $user = Auth::user();
    //     if (!in_array($user->role->name, ['kid'])) {
    //         return response()->json(['message' => 'Only kids can play games'], 403);
    //     }

    //     $request->validate([
    //         'game_id' => 'required|exists:games,id',
    //         'score'   => 'nullable|integer|min:0',
    //     ]);

    //     $game = Game::findOrFail($request->game_id);
    //     if (!$game->is_active) {
    //         return response()->json(['message' => 'Game inactive'], 403);
    //     }

    //     $kid = $user; // Current user is a kid

    //     DB::transaction(function () use ($kid, $game, $request) {
    //         // 🎯 Update play data in pivot table
    //         $game->kids()->syncWithoutDetaching([
    //             $kid->id => [
    //                 'score' => DB::raw('GREATEST(score, ' . ($request->score ?? 0) . ')'),
    //                 'play_count' => DB::raw('play_count + 1'),
    //                 'last_played_at' => now(),
    //             ],
    //         ]);

    //         // 🧾 Create a new play session
    //         $session = KidSession::create([
    //             'kid_id' => $kid->id,
    //             'started_at' => now(),
    //             'ended_at' => now(),
    //             'duration_seconds' => rand(30, 300), // Temporary — to be replaced with real duration
    //             'activity' => json_encode(['game_id' => $game->id]),
    //         ]);

    //         // 🏅 Check achievement “Play 10 times”
    //         $pivot = DB::table('game_kid')
    //             ->where('game_id', $game->id)
    //             ->where('kid_id', $kid->id)
    //             ->first();

    //         if ($pivot && $pivot->play_count >= 10) {
    //             $achievement = Achievement::where('slug', 'play_10_times')->first();
    //             if ($achievement) {
    //                 KidAchievement::firstOrCreate([
    //                     'kid_id' => $kid->id,
    //                     'achievement_id' => $achievement->id,
    //                 ], [
    //                     'awarded_at' => now(),
    //                 ]);

    //                 // 🔔 Notify the kid
    //                 $kid->notifications()->create([
    //                     'title' => '🏆 New Achievement!',
    //                     'body' => "You’ve earned the {$achievement->title} achievement in {$game->name}!",
    //                     'payload' => ['type' => 'achievement', 'game_id' => $game->id],
    //                     'sent_at' => now(),
    //                 ]);

    //                 // 🔔 Notify the parent (if any)
    //                 if ($kid->parent) {
    //                     $kid->parent->notifications()->create([
    //                         'title' => '🎉 Your child achieved something new!',
    //                         'body' => "{$kid->display_name} earned the {$achievement->title} achievement in {$game->name}!",
    //                         'payload' => ['type' => 'child_achievement', 'kid_id' => $kid->id],
    //                         'sent_at' => now(),
    //                     ]);
    //                 }
    //             }
    //         }
    //     });

    //     return response()->json([
    //         'status' => 1,
    //         'message' => 'Game progress recorded successfully',
    //     ]);
    // }
}
