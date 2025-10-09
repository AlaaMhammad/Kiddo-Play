<x-admin title="Add Reward">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add Reward</h4>
        <a href="{{ route('admin.rewards.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.rewards.store') }}" method="POST">
            @csrf

            <x-form.select name="daily_goal_id" label="Daily Goal" :options="$dailyGoals" required />

            <x-form.input name="title" label="Title" required />

            <x-form.textarea name="description" label="Description" />

            <x-form.number name="points_required" label="Points Required" value="0" required />

            <x-form.button label="Save Reward" />
        </form>
    </div>
</x-admin>
