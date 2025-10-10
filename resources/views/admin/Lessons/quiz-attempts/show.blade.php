<x-admin title="Quiz Attempt Details">
    <div class="mb-4">
        <a href="{{ route('admin.quiz-attempts.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h4 class="fw-bold mb-3">Quiz Attempt #{{ $quizAttempt->id }}</h4>
        <p><strong>Kid:</strong> {{ $quizAttempt->kid->display_name ?? '-' }}</p>
        <p><strong>Quiz:</strong> {{ $quizAttempt->quiz->title ?? '-' }}</p>
        <p><strong>Score:</strong> {{ $quizAttempt->score ?? '-' }}</p>
        <p><strong>Status:</strong> <span class="badge bg-info">{{ ucfirst($quizAttempt->status) }}</span></p>
        <p><strong>Started At:</strong>
            {{ $quizAttempt->started_at ? $quizAttempt->started_at->format('Y-m-d H:i') : '-' }}</p>
        <p><strong>Finished At:</strong>
            {{ $quizAttempt->finished_at ? $quizAttempt->finished_at->format('Y-m-d H:i') : '-' }}</p>

        @if ($quizAttempt->meta)
            <hr>
            <p><strong>Meta:</strong></p>
            <pre>{{ json_encode($quizAttempt->meta, JSON_PRETTY_PRINT) }}</pre>
        @endif
    </div>
</x-admin>
