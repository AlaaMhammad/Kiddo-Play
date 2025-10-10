<x-admin title="Edit Lesson">
    <div class="mb-4">
        <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.lessons.update', $lesson->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="category" label="Category" :options="[
                'numbers' => 'Numbers',
                'letters' => 'Letters',
                'animals' => 'Animals',
                'arithmetic' => 'Arithmetic',
            ]" :selected="$lesson->category" required />

            <x-form.input name="title" label="Title" value="{{ $lesson->title }}" required />

            <x-form.textarea name="summary" label="Summary" rows="3" value="{{ $lesson->summary }}" />

            <x-form.textarea name="content" label="Content" rows="5" value="{{ $lesson->content }}" />

            <x-form.input name="media_url" label="Media URL" value="{{ $lesson->media_url }}" />

            <x-form.input type="number" name="order" label="Order" value="{{ $lesson->order }}" />

            <div class="mb-3 form-check">
                <input type="checkbox" name="is_published" id="is_published" value="1" class="form-check-input"
                    {{ $lesson->is_published ? 'checked' : '' }}>
                <label for="is_published" class="form-check-label">Published</label>
            </div>

            <button class="btn btn-success">Update Lesson</button>
        </form>
    </div>
</x-admin>
