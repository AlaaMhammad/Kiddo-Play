<x-admin title="Edit Game-Kid Record">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit Record</h4>
        <a href="{{ route('admin.game-kids.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.game-kids.update', $record->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="kid_id" label="Select Kid" :options="$kids" optionLabel="display_name" optionValue="id"
                :selected="$record->kid_id" required />

            <x-form.select name="game_id" label="Select Game" :options="$games" optionLabel="description"
                optionValue="id" :selected="$record->game_id" required />

            <x-form.input type="number" name="score" label="Score" :value="$record->score" min="0" />

            <x-form.input type="number" name="play_count" label="Play Count" :value="$record->play_count" min="0" />

            <x-form.input type="datetime-local" name="last_played_at" label="Last Played At" :value="$record->last_played_at" />

            <button class="btn btn-success mt-3">Update</button>
        </form>
    </div>

</x-admin>
