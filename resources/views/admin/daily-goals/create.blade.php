<x-admin title="Add New Daily Goal">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add New Daily Goal</h4>
        <div class="mb-4">
            <a href="{{ route('admin.daily-goals.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.daily-goals.store') }}" method="POST">
            @csrf

            <x-form.select name="kid_id" label="Kid" :options="$kids" required />

            <x-form.select name="game_id" label="Game" :options="$games" placeholder="-- None --" />

            <x-form.input name="title" label="Title" required />
            <x-form.select name="type" label="Goal Type" :options="['game' => 'Game', 'word' => 'Word', 'quiz' => 'Quiz']" />

            <x-form.textarea name="description" label="Description" />

            <x-form.number name="target_points" label="Target Points" value="0" />
            <x-form.input type="number" name="progress" label="Progress" value="0" />


            <x-form.checkbox name="is_completed" label="Completed" />

            <x-form.date name="goal_date" label="Goal Date" required />

            <x-form.button label="Save Daily Goal" />
        </form>
    </div>
</x-admin>
