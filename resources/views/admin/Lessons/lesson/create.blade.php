<x-admin title="Add New Lesson">
    <div class="mb-4">
        <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.lessons.store') }}" method="POST">
            @csrf

            <x-form.select name="category" label="Category" :options="[
                'numbers' => 'Numbers',
                'letters' => 'Letters',
                'animals' => 'Animals',
                'arithmetic' => 'Arithmetic',
            ]" required />

            <x-form.input name="title" label="Title" required placeholder="Enter lesson title" />

            <x-form.textarea name="summary" label="Summary" rows="3"
                placeholder="Short description about the lesson" />

            <x-form.textarea name="content" label="Content" rows="5"
                placeholder="Full lesson content or details" />

            <x-form.input name="media_url" label="Media URL" placeholder="https://example.com/media.mp4" />

            <x-form.input type="number" name="order" label="Order" value="0" />

            <x-form.checkbox name="is_published" label="Published" checked />

            <button class="btn btn-primary">Save Lesson</button>
        </form>
    </div>
</x-admin>
