<x-admin title="Add New Quiz">
    <div class="mb-4">
        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.quizzes.store') }}" method="POST">
            @csrf

            <x-form.select
                name="lesson_id"
                label="Lesson"
                :options="$lessons->pluck('title','id')"
                placeholder="Select Lesson"
            />

            <x-form.input name="title" label="Quiz Title" required placeholder="Enter quiz title" />

            <x-form.input
                type="number"
                name="time_limit_seconds"
                label="Time Limit (seconds)"
                placeholder="Optional"
            />

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input" checked>
                <label for="is_active" class="form-check-label">Active</label>
            </div>

            <button class="btn btn-primary">Save Quiz</button>
        </form>
    </div>
</x-admin>
