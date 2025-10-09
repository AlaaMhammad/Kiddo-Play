<x-admin title="Add Lesson Progress">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add New kid Lesson Progresses</h4>
        <div class="mb-4">
            <a href="{{ route('admin.kid-lesson-progresses.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.kid-lesson-progresses.store') }}" method="POST">
            @csrf

            <x-form.select name="kid_id" label="Kid" :options="$kids->pluck('display_name', 'id')" required />

            <x-form.select name="lesson_id" label="Lesson" :options="$lessons->pluck('title', 'id')" required />

            <x-form.select name="status" label="Status" :options="['not_started' => 'Not Started', 'in_progress' => 'In Progress', 'completed' => 'Completed']" />

            <x-form.input type="number" name="progress_percent" label="Progress (%)" value="0" />

            <x-form.input type="datetime-local" name="last_accessed_at" label="Last Accessed" />

            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</x-admin>
