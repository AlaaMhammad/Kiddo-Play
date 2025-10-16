<?php

namespace App\Http\Controllers\Admin\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::latest()->paginate(15);
        return view('admin.games.game.index', compact('games'));
    }

    public function create()
    {
        return view('admin.games.game.create');
    }

    public function store(Request $request)
    {
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

    public function edit(Game $game)
    {
        return view('admin.games.game.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
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

    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.games.index')->with([
            'success' => 'Game deleted successfully.',
            'action' => 'delete',
        ]);
    }
}
