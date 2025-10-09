<x-admin title="Edit Reward">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit Reward</h4>
        <a href="{{ route('admin.rewards.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.rewards.update', $reward) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="daily_goal_id" label="Daily Goal" :options="$dailyGoals" :selected="$reward->daily_goal_id" required />

            <x-form.input name="title" label="Title" :value="$reward->title" required />

            <x-form.textarea name="description" label="Description">{{ $reward->description }}</x-form.textarea>

            <x-form.number name="points_required" label="Points Required" :value="$reward->points_required" required />

            <x-form.checkbox name="is_claimed" label="Claimed" :checked="$reward->is_claimed" />

            <x-form.button label="Update Reward" />
        </form>
    </div>
</x-admin>
