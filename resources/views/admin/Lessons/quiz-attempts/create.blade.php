<x-admin title="Add New Quiz Attempt">
    <div class="mb-4">
        <a href="{{ route('admin.quiz-attempts.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.quiz-attempts.store') }}" method="POST">
            @csrf

            <x-form.select name="kid_id" label="Kid" :options="$kids->pluck('display_name', 'id')" required placeholder="Select Kid" />
            <x-form.select name="quiz_id" label="Quiz" :options="$quizzes->pluck('title', 'id')" required placeholder="Select Quiz" />
            <x-form.input type="number" name="score" label="Score" placeholder="Enter score" />

            <x-form.select name="status" label="Status" :options="['started' => 'Started', 'completed' => 'Completed', 'abandoned' => 'Abandoned']" required placeholder="Select Status"/>

            <x-form.input type="datetime-local" name="started_at" label="Started At" />
            <x-form.input type="datetime-local" name="finished_at" label="Finished At" />
            <x-form.textarea name="meta" label="Meta Data (JSON)" placeholder='{"key":"value"}' />

            <button class="btn btn-primary">Save Attempt</button>
        </form>
    </div>
</x-admin>
