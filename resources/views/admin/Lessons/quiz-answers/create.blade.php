<x-admin title="Add New Quiz Answer">
    <div class="mb-4">
        <a href="{{ route('admin.quiz-answers.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.quiz-answers.store') }}" method="POST">
            @csrf

            <x-form.select name="attempt_id" label="Quiz Attempt (Kid)" :options="$attempts->pluck('kid.display_name', 'id')" required placeholder="Select Quiz Attempt (Kid)" />

            <x-form.select name="question_id" label="Question" :options="$questions->mapWithKeys(
                fn($q) => [$q->id => $q->quiz->title . ' - ' . Str::limit($q->content, 30)],
            )" required placeholder="Select Question" />

            <x-form.textarea name="answer" label="Answer (JSON)" placeholder='{"option":"A"}' />
            <x-form.select name="is_correct" label="Is Correct" :options="['1' => 'Yes', '0' => 'No']" required />
            <x-form.input type="number" name="points_awarded" label="Points Awarded" value="0" />

            <button class="btn btn-primary">Save Answer</button>
        </form>
    </div>
</x-admin>
