<x-admin title="Game-Kid Record Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Record Details</h4>
        <a href="{{ route('admin.game-kids.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <p><strong>Kid:</strong> {{ $record->kid_name ?? '-' }}</p>
        <p><strong>Game:</strong> {{ $record->game_desc ?? '-' }}</p>
        <p><strong>Score:</strong> {{ $record->score }}</p>
        <p><strong>Play Count:</strong> {{ $record->play_count }}</p>
        <p><strong>Last Played At:</strong>
            {{ $record->last_played_at ? \Carbon\Carbon::parse($record->last_played_at)->format('Y-m-d H:i') : '-' }}
        </p>
        <p><strong>Created At:</strong> {{ \Carbon\Carbon::parse($record->created_at)->format('Y-m-d H:i') }}</p>
        <p><strong>Updated At:</strong> {{ \Carbon\Carbon::parse($record->updated_at)->format('Y-m-d H:i') }}</p>
    </div>

</x-admin>
