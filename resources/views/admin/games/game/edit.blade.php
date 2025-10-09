<x-admin title="Edit Game">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit Game</h4>
        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.games.update', $game->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.textarea name="description" label="Description" rows="3" :value="$game->description" />

            <x-form.select name="category" label="Category" :options="['educational' => 'Educational', 'fun' => 'Fun', 'mixed' => 'Mixed']" :selected="$game->category" required />

            <x-form.select name="difficulty_level" label="Difficulty Level" :options="['easy' => 'Easy', 'medium' => 'Medium', 'hard' => 'Hard']" :selected="$game->difficulty_level"
                required />

            <x-form.input type="url" name="media_url" label="Media URL (image/video)" :value="$game->media_url" />

            <x-form.checkbox name="is_active" label="Active" :checked="$game->is_active" />

            <button class="btn btn-success mt-3">Update</button>
        </form>
    </div>

</x-admin>
