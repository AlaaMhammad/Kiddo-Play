<x-admin title="Quiz Details">
    <div class="mb-4">
        <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h4 class="fw-bold mb-3">{{ $quiz->title ?? 'Untitled Quiz' }}</h4>

        <p><strong>Lesson:</strong> {{ $quiz->lesson->title ?? '-' }}</p>
        <p><strong>Time Limit:</strong> {{ $quiz->time_limit_seconds ? $quiz->time_limit_seconds . ' sec' : '-' }}</p>
        <p><strong>Status:</strong>
            <span class="badge bg-{{ $quiz->is_active ? 'success' : 'secondary' }}">
                {{ $quiz->is_active ? 'Active' : 'Inactive' }}
            </span>
        </p>

        <hr>
        <h6>Questions ({{ $quiz->questions->count() }})</h6>
        <ul>
            @forelse ($quiz->questions as $q)
                <li>{{ $q->question_text }}</li>
            @empty
                <li class="text-muted">No questions yet.</li>
            @endforelse
        </ul>

        <hr>
        <p class="text-muted small">Created: {{ $quiz->created_at->format('Y-m-d H:i') }}</p>
    </div>
</x-admin>
