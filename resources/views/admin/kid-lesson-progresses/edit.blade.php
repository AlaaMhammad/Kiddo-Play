<x-admin title="Edit Kid Lesson Progress">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit kid Lesson Progress</h4>
        <div class="mb-4">
            <a href="{{ route('admin.kid-lesson-progresses.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.kid-lesson-progresses.update', $kidLessonProgress->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="kid_id" label="Kid" :options="$kids->pluck('display_name', 'id')" :selected="$kidLessonProgress->kid_id" required />

            <x-form.select name="lesson_id" label="Lesson" :options="$lessons->pluck('title', 'id')" :selected="$kidLessonProgress->lesson_id" required />

            <x-form.select name="status" label="Status" :options="['not_started' => 'Not Started', 'in_progress' => 'In Progress', 'completed' => 'Completed']" :selected="$kidLessonProgress->status" />

            <x-form.input type="number" name="progress_percent" label="Progress (%)" :value="$kidLessonProgress->progress_percent" />

            <x-form.input type="datetime-local" name="last_accessed_at" label="Last Accessed" :value="optional($kidLessonProgress->last_accessed_at)->format('Y-m-d\TH:i')" />

            <button class="btn btn-success">Update</button>
        </form>
    </div>
</x-admin>
