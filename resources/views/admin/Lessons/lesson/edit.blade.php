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
                // raw محتوى الداتا القادمة
                $rawContent = old('content', $lesson->content ?? '');

                // إذا كان Array (من الفورم)، استخدمه كما هو
                // إذا كان نص من قاعدة البيانات → حوله لأسطر باستخدام explode
                $lines = is_array($rawContent) ? $rawContent : explode("\n", $rawContent);

                // الأيقونات المختارة
                $lineIcons = old('line_icons', $lesson->line_icons ?? []);

                // مسار الملفات
                $iconFiles = glob(public_path('icons/*.png'));
            @endphp

            <div id="lines-container">
                @foreach ($lines as $index => $line)
                    <div class="mb-3 line-item">
                        <label>Line {{ $index + 1 }}</label>
                        <input type="text" name="content[]" value="{{ $line }}" class="form-control mb-1">

                        <div class="d-flex flex-wrap gap-2 icon-options">
                            @foreach ($iconFiles as $file)
                                @php
                                    $relativePath = str_replace(public_path() . DIRECTORY_SEPARATOR, '', $file);
                                    $relativePath = str_replace('\\', '/', $relativePath);
                                    $iconUrl = asset($relativePath);
                                @endphp

                                <label class="icon-label"
                                    style="cursor:pointer; display:inline-block; border:1px solid #ccc; padding:2px;">
                                    <input type="radio" name="line_icons[{{ $index }}]"
                                        value="{{ $iconUrl }}"
                                        {{ isset($lineIcons[$index]) && $lineIcons[$index] == $iconUrl ? 'checked' : '' }}
                                        style="display:none;">
                                    <img src="{{ $iconUrl }}" style="width:40px; height:40px;">
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="button" id="add-line" class="btn btn-sm btn-secondary mb-3">+ Add Line</button>

            <x-form.input name="media_url" label="Media URL" value="{{ $lesson->media_url }}" />

            <x-form.input type="number" name="order" label="Order" value="{{ $lesson->order }}" />

            <x-form.checkbox name="is_published" label="Published" :checked="$lesson->is_published" />

            <button class="btn btn-success">Update Lesson</button>
        </form>
    </div>
</x-admin>
