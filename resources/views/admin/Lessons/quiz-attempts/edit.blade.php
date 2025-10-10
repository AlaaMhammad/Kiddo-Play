<x-admin title="Edit Quiz Attempt">
    <div class="mb-4">
        <a href="{{ route('admin.quiz-attempts.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.quiz-attempts.update', $quizAttempt->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="kid_id" label="Kid" :options="$kids->pluck('display_name', 'id')" :selected="$quizAttempt->kid_id" required />
            <x-form.select name="quiz_id" label="Quiz" :options="$quizzes->pluck('title', 'id')" :selected="$quizAttempt->quiz_id" required />
            <x-form.input type="number" name="score" label="Score" :value="$quizAttempt->score" />

            <x-form.select name="status" label="Status" :options="['started' => 'Started', 'completed' => 'Completed', 'abandoned' => 'Abandoned']" :selected="$quizAttempt->status" required />

            <x-form.input type="datetime-local" name="started_at" label="Started At" :value="$quizAttempt->started_at?->format('Y-m-d\TH:i')" />
            <x-form.input type="datetime-local" name="finished_at" label="Finished At" :value="$quizAttempt->finished_at?->format('Y-m-d\TH:i')" />
            <x-form.textarea name="meta" label="Meta Data (JSON)" :value="json_encode($quizAttempt->meta, JSON_PRETTY_PRINT)" />

            <button class="btn btn-success">Update Attempt</button>
        </form>
    </div>
</x-admin>
