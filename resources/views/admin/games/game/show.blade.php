<x-admin title="Game Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Game Details</h4>
        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <p><strong>Title:</strong> {{ $game->title ?? '-' }}</p>
        <p><strong>Description:</strong> {{ $game->description ?? '-' }}</p>
        <p><strong>Category:</strong> {{ ucfirst($game->category) }}</p>
        <p><strong>Difficulty Level:</strong> {{ ucfirst($game->difficulty_level) }}</p>
        <p><strong>Media:</strong>
            @if ($game->media_url)
                <a href="{{ $game->media_url }}" target="_blank">View</a>
            @else
                -
            @endif
        </p>
        <p><strong>Game URL:</strong>
            @if ($game->game_url)
                <a href="{{ $game->game_url }}" target="_blank">Play</a>
            @else
                -
            @endif
        </p>
        <p><strong>Required Points:</strong> {{ $game->required_points }}</p>
        <p><strong>Entry Cost:</strong> {{ $game->entry_cost }}</p>
        <p><strong>Active:</strong> {{ $game->is_active ? 'Yes' : 'No' }}</p>
        <p><strong>Created At:</strong> {{ $game->created_at->format('Y-m-d H:i') }}</p>
        <p><strong>Updated At:</strong> {{ $game->updated_at->format('Y-m-d H:i') }}</p>
    </div>

</x-admin>
