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

            {{-- <x-form.textarea name="content" label="Content" rows="5" value="{{ $lesson->content }}" /> --}}

            @php
                $lines = explode("\n", old('content', $lesson->content ?? ''));
                $lineIcons = old('line_icons', $lesson->line_icons ?? []);
                $iconFiles = glob(public_path('icons/*.png'));
            @endphp

            @foreach ($lines as $index => $line)
                <div class="mb-3">
                    <label>Line {{ $index + 1 }}</label>
                    <input type="text" name="content[]" value="{{ $line }}" class="form-control mb-1">

                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($iconFiles as $file)
                            @php
                                $iconUrl = str_replace(public_path(), '', $file);
                                $iconUrl = asset($iconUrl);
                            @endphp
                            <label style="cursor:pointer; display:inline-block;">
                                <input type="radio" name="line_icons[{{ $index }}]" value="{{ $iconUrl }}"
                                    {{ isset($lineIcons[$index]) && $lineIcons[$index] == $iconUrl ? 'checked' : '' }}
                                    style="display:none;">
                                <img src="{{ $iconUrl }}"
                                    style="width:40px; height:40px; border:1px solid #ccc; padding:2px;">
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <x-form.input name="media_url" label="Media URL" value="{{ $lesson->media_url }}" />

            <x-form.input type="number" name="order" label="Order" value="{{ $lesson->order }}" />

            <x-form.checkbox name="is_published" label="Published" :checked="$lesson->is_published" />

            <button class="btn btn-success">Update Lesson</button>
        </form>
    </div>
</x-admin>
