<x-admin title="Edit Question">
    <div class="mb-4">
        <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="quiz_id" label="Quiz" :options="$quizzes->pluck('title', 'id')" :selected="$question->quiz_id" required />

            <x-form.textarea name="content" label="Question Content" required :value="$question->content" />

            <x-form.select name="type" label="Question Type" :options="[
                'mcq' => 'Multiple Choice',
                'true_false' => 'True / False',
                'fill_blank' => 'Fill in the Blank',
                'match' => 'Match Pairs',
            ]" :selected="$question->type" />

            {{-- <x-form.textarea name="options" label="Options (JSON format)" :value="json_encode($question->options)" />
            <x-form.textarea name="correct_answer" label="Correct Answer (JSON)" :value="json_encode($question->correct_answer)" /> --}}

            <x-form.textarea name="options" label="Options (each option on a new line)" :value="implode(PHP_EOL, json_decode($question->options ?? '[]', true))" />

            <x-form.textarea name="correct_answer" label="Correct Answers (each answer on a new line)"
                :value="implode(PHP_EOL, json_decode($question->correct_answer ?? '[]', true))" />


            <x-form.input type="number" name="points" label="Points" value="{{ $question->points }}" required />
            <x-form.input type="number" name="order" label="Order" value="{{ $question->order }}" />

            <button class="btn btn-success">Update Question</button>
        </form>
    </div>
</x-admin>
