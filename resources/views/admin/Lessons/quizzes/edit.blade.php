<x-admin title="Edit Quiz">
    <div class="mb-4">
        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.quizzes.update', $quiz->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="lesson_id" label="Lesson" :options="$lessons->pluck('title', 'id')" :selected="$quiz->lesson_id"
                placeholder="-- Select Lesson --" />

            <x-form.input name="title" label="Quiz Title" value="{{ $quiz->title }}" required />

            <x-form.input type="number" name="time_limit_seconds" label="Time Limit (seconds)"
                value="{{ $quiz->time_limit_seconds }}" />

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input"
                    {{ $quiz->is_active ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Active</label>
            </div>

            <button class="btn btn-success">Update Quiz</button>
        </form>
    </div>
</x-admin>
