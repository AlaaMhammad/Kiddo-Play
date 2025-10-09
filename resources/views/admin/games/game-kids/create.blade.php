<x-admin title="Add New Game-Kid Record">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add New Record</h4>
        <a href="{{ route('admin.game-kids.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.game-kids.store') }}" method="POST">
            @csrf

            <x-form.select name="kid_id" label="Select Kid" :options="$kids" optionLabel="display_name" optionValue="id"
                required />

            <x-form.select name="game_id" label="Select Game" :options="$games" optionLabel="description"
                optionValue="id" required />

            <x-form.input type="number" name="score" label="Score" min="0" />

            <x-form.input type="number" name="play_count" label="Play Count" min="0" />

            <x-form.input type="datetime-local" name="last_played_at" label="Last Played At" />

            <button class="btn btn-success mt-3">Save</button>
        </form>
    </div>

</x-admin>
