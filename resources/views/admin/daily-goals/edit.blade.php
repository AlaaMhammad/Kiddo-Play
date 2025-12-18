<x-admin title="Edit Daily Goal">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit Daily Goal</h4>
        <div class="mb-4">
            <a href="{{ route('admin.daily-goals.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.daily-goals.update', $dailyGoal->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="kid_id" label="Kid" :options="$kids" :selected="$dailyGoal->kid_id" required />

            <x-form.select name="game_id" label="Game" :options="$games" :selected="$dailyGoal->game_id" placeholder="-- None --" />

            <x-form.input name="title" label="Title" :value="$dailyGoal->title" required />

            <x-form.select name="type" label="Goal Type" :options="['game' => 'Game', 'word' => 'Word', 'quiz' => 'Quiz']" :selected="$dailyGoal->type" />

            <x-form.textarea name="description" label="Description" :value="$dailyGoal->description" />

            <x-form.number name="target_points" label="Target Points" :value="$dailyGoal->target_points ?? 0" />

            <x-form.input type="number" name="progress" label="Progress" :value="$dailyGoal->progress" />

            <x-form.checkbox name="is_completed" label="Completed" :checked="$dailyGoal->is_completed" />

            <x-form.date name="goal_date" label="Goal Date" :value="$dailyGoal->goal_date->format('Y-m-d')" required />

            <x-form.button label="Update Daily Goal" />
        </form>
    </div>
</x-admin>
