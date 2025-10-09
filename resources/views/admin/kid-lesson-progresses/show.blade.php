<x-admin title="Lesson Progress Details">
    <div class="mb-4">
        <a href="{{ route('admin.kid-lesson-progresses.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h5>Kid: {{ $kidLessonProgress->kid->display_name }}</h5>
        <p>Lesson: {{ $kidLessonProgress->lesson->title ?? '-' }}</p>
        <p>Status: {{ ucfirst(str_replace('_', ' ', $kidLessonProgress->status)) }}</p>
        <p>Progress: {{ $kidLessonProgress->progress_percent }}%</p>
        <p>Last Accessed: {{ $kidLessonProgress->last_accessed_at ?? '-' }}</p>
        <p>Created At: {{ $kidLessonProgress->created_at->format('Y-m-d H:i') }}</p>
    </div>
</x-admin>
