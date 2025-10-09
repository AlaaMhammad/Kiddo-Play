<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Kid;
use Illuminate\Support\Facades\DB;

class GameKidController extends Controller
{
    public function index()
    {
        $gameKids = DB::table('game_kids')
            ->join('games', 'game_kids.game_id', '=', 'games.id')
            ->join('kids', 'game_kids.kid_id', '=', 'kids.id')
            ->select('game_kids.*', 'games.description as game_desc', 'kids.display_name as kid_name')
            ->latest('game_kids.created_at')
            ->paginate(15);

        return view('admin.games.game-kids.index', compact('gameKids'));
    }

    public function create()
    {
        $games = Game::where('is_active', true)->get();
        $kids = Kid::all()->toArray();
        return view('admin.games.game-kids.create', compact('games', 'kids'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'game_id' => 'required|exists:games,id',
            'score' => 'nullable|integer|min:0',
            'play_count' => 'nullable|integer|min:0',
            'last_played_at' => 'nullable|date',
        ]);

        DB::table('game_kids')->insert($data);

        return redirect()->route('game-kids.index')->with('success', 'Game-Kid record created.');
    }

    public function edit($id)
    {
        $record = DB::table('game_kids')->where('id', $id)->first();
        $games = Game::where('is_active', true)->get();
        $kids = Kid::all()->toArray();
        return view('admin.games.game-kids.edit', compact('record', 'games', 'kids'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'kid_id' => 'required|exists:kids,id',
            'game_id' => 'required|exists:games,id',
            'score' => 'nullable|integer|min:0',
            'play_count' => 'nullable|integer|min:0',
            'last_played_at' => 'nullable|date',
        ]);

        DB::table('game_kids')->where('id', $id)->update($data);

        return redirect()->route('game-kids.index')->with('success', 'Record updated successfully.');
    }

    public function destroy($id)
    {
        DB::table('game_kids')->where('id', $id)->delete();
        return redirect()->route('game-kids.index')->with('success', 'Record deleted successfully.');
    }
}
