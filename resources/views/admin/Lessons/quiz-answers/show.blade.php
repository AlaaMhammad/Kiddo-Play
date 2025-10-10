<x-admin title="Quiz Answer Details">
    <div class="mb-4">
        <a href="{{ route('admin.quiz-answers.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h4 class="fw-bold mb-3">Quiz Answer #{{ $quizAnswer->id }}</h4>
        <p><strong>Kid:</strong> {{ $quizAnswer->attempt->kid->display_name ?? '-' }}</p>
        <p><strong>Question:</strong> {{ $quizAnswer->question->content ?? '-' }}</p>
        <p><strong>Correct:</strong>
            <span class="badge bg-{{ $quizAnswer->is_correct ? 'success' : 'danger' }}">
                {{ $quizAnswer->is_correct ? 'Yes' : 'No' }}
            </span>
        </p>
        <p><strong>Points Awarded:</strong> {{ $quizAnswer->points_awarded }}</p>

        @if ($quizAnswer->answer)
            <hr>
            <p><strong>Answer:</strong></p>
            <pre>{{ json_encode($quizAnswer->answer, JSON_PRETTY_PRINT) }}</pre>
        @endif
    </div>
</x-admin>
