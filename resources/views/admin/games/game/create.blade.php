<x-admin title="Add New Game">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add New Game</h4>
        <a href="{{ route('admin.games.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.games.store') }}" method="POST">
            @csrf

            <x-form.textarea name="description" label="Description" rows="3" />

            <x-form.select name="category" label="Category" :options="['educational' => 'Educational', 'fun' => 'Fun', 'mixed' => 'Mixed']" required />

            <x-form.select name="difficulty_level" label="Difficulty Level" :options="['easy' => 'Easy', 'medium' => 'Medium', 'hard' => 'Hard']" required />

            <x-form.input type="url" name="media_url" label="Media URL (image/video)" />

            <x-form.checkbox name="is_active" label="Active" checked />

            <button class="btn btn-success mt-3">Save</button>
        </form>
    </div>

</x-admin>
