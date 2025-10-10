<x-admin title="Edit Quiz Answer">
    <div class="mb-4">
        <a href="{{ route('admin.quiz-answers.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.quiz-answers.update', $quizAnswer->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="attempt_id" label="Quiz Attempt (Kid)" :options="$attempts->pluck('kid.display_name', 'id')" :selected="$quizAnswer->attempt_id" required />

            <x-form.select name="question_id" label="Question" :options="$questions->mapWithKeys(
                fn($q) => [$q->id => $q->quiz->title . ' - ' . Str::limit($q->content, 30)],
            )" :selected="$quizAnswer->question_id" required />

            <x-form.textarea name="answer" label="Answer (JSON)" :value="json_encode($quizAnswer->answer, JSON_PRETTY_PRINT)" />
            <x-form.select name="is_correct" label="Is Correct" :options="['1' => 'Yes', '0' => 'No']" :selected="$quizAnswer->is_correct ? 1 : 0" required />
            <x-form.input type="number" name="points_awarded" label="Points Awarded" :value="$quizAnswer->points_awarded" />

            <button class="btn btn-success">Update Answer</button>
        </form>
    </div>
</x-admin>
