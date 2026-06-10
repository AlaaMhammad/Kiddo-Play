<x-admin title="Question Details">
    <div class="mb-4">
        <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h4 class="fw-bold mb-3">Question #{{ $question->id }}</h4>

        <p><strong>Quiz:</strong> {{ $question->quiz->title ?? '-' }}</p>
        <p><strong>Type:</strong> {{ ucfirst(str_replace('_', ' ', $question->type)) }}</p>
        <p><strong>Points:</strong> {{ $question->points }}</p>
        <p><strong>Order:</strong> {{ $question->order }}</p>
        <hr>

        <p><strong>Content:</strong></p>
        <div class="border rounded p-2 bg-light">{!! nl2br(e($question->content)) !!}</div>

        {{-- @if ($question->options)
            <hr>
            <p><strong>Options:</strong></p>
            <pre>{{ json_encode($question->options, JSON_PRETTY_PRINT) }}</pre>
        @endif

        @if ($question->correct_answer)
            <p><strong>Correct Answer:</strong></p>
            <pre>{{ json_encode($question->correct_answer, JSON_PRETTY_PRINT) }}</pre>
        @endif --}}

        @if ($question->options)
            <hr>
            <p><strong>Options:</strong></p>
            <pre>{{ json_encode(json_decode($question->options, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        @endif

        @if ($question->correct_answer)
            <p><strong>Correct Answer:</strong></p>
            <pre>{{ json_encode(json_decode($question->correct_answer, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
        @endif

        {{-- @dd($question->correct_answer); --}}
        <p class="text-muted mt-3 small">Created: {{ $question->created_at->format('Y-m-d H:i') }}</p>
    </div>
</x-admin>
