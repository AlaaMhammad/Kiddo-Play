<x-admin title="Add New Game">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add New Game</h4>
        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.games.store') }}" method="POST">
            @csrf

            <!-- Title -->
            <x-form.input type="text" name="title" label="Game Title" required />

            <!-- Description -->
            <x-form.textarea name="description" label="Description" rows="3" />

            <!-- Category -->
            <x-form.select name="category" label="Category" :options="['educational' => 'Educational', 'fun' => 'Fun', 'mixed' => 'Mixed']" required />

            <!-- Difficulty Level -->
            <x-form.select name="difficulty_level" label="Difficulty Level" :options="['easy' => 'Easy', 'medium' => 'Medium', 'hard' => 'Hard']" required />

            <!-- Media URL -->
            <x-form.input type="url" name="media_url" label="Media URL (image/video)" />

            <!-- Game URL -->
            <x-form.input type="url" name="game_url" label="Game URL" required />

            <!-- Required Points -->
            <x-form.input type="number" name="required_points" label="Required Points to Unlock" min="0"
                value="0" required />

            <!-- Entry Cost -->
            <x-form.input type="number" name="entry_cost" label="Points Deducted on Play" min="0" value="0"
                required />

            <!-- Active Checkbox -->
            <x-form.checkbox name="is_active" label="Active" checked />

            <button class="btn btn-success mt-3">Save</button>
        </form>
    </div>

</x-admin>
