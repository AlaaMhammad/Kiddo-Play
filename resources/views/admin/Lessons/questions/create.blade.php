<x-admin title="Add New Question">
    <div class="mb-4">
        <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.questions.store') }}" method="POST">
            @csrf

            <x-form.select name="quiz_id" label="Quiz" :options="$quizzes->pluck('title', 'id')" required placeholder="Select Quiz" />

            <x-form.textarea name="content" label="Question Content" required />

            <x-form.select name="type" label="Question Type" :options="[
                'mcq' => 'Multiple Choice',
                'true_false' => 'True / False',
                'fill_blank' => 'Fill in the Blank',
                'match' => 'Match Pairs',
            ]" required placeholder="Select Question Type" />

            {{-- <x-form.textarea name="options" label="Options (JSON format)" placeholder='e.g. ["A","B","C"]' /> --}}
            <x-form.textarea name="options" label="Options (JSON format)" placeholder="Option 1&#10;Option 2&#10;Option 3"/>
            {{-- <x-form.textarea name="correct_answer" label="Correct Answer (JSON)" placeholder='e.g. ["A"]' /> --}}
            <x-form.textarea name="correct_answer" label="Correct Answer (JSON)" placeholder="Option 1" />

            <x-form.input type="number" name="points" label="Points" required min="1" value="1" />
            <x-form.input type="number" name="order" label="Order" value="0" />

            <button class="btn btn-primary">Save Question</button>
        </form>
    </div>
</x-admin>
