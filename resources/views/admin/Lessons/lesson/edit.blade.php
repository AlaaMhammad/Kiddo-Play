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
                // المحتوى القادم: إذا دخل من الـ form يكون array
                // وإذا من الداتابيز يكون string → نحوله إلى array
                $rawContent = old('content', $lesson->content ?? '');
                $lines = is_array($rawContent) ? $rawContent : explode("\n", $rawContent);

                // الأيقونات المختارة (من old أو من قاعدة البيانات)
                $lineIcons = old('line_icons', $lesson->line_icons ?? []);

                // جلب كل الصور
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
                                    $checked = isset($lineIcons[$index]) && $lineIcons[$index] == $iconUrl;
                                @endphp

                                <label class="icon-label"
                                    style="cursor:pointer; display:inline-block; border:{{ $checked ? '2px solid #007bff' : '1px solid #ccc' }}; padding:2px;">
                                    <input type="radio" name="line_icons[{{ $index }}]"
                                        value="{{ $iconUrl }}" {{ $checked ? 'checked' : '' }}
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let linesContainer = document.getElementById('lines-container');

            // عند اختيار أيقونة
            linesContainer.addEventListener('click', function(e) {
                if (e.target.tagName === 'IMG') {

                    let iconLabel = e.target.closest('.icon-label');
                    let container = e.target.closest('.icon-options');

                    if (!container) return;

                    container.querySelectorAll('.icon-label').forEach(label => {
                        label.style.border = '1px solid #ccc';
                    });

                    iconLabel.style.border = '2px solid #007bff';

                    iconLabel.querySelector('input[type=radio]').checked = true;
                }
            });

            // إضافة سطر جديد
            document.getElementById('add-line').addEventListener('click', function() {
                let index = linesContainer.querySelectorAll('.line-item').length;

                let newLine = `
            <div class="mb-3 line-item">
                <label>Line ${index + 1}</label>
                <input type="text" name="content[]" class="form-control mb-1">
                <div class="d-flex flex-wrap gap-2 icon-options">
                    @foreach ($iconFiles as $file)
                        @php
                            $relativePath = str_replace(public_path() . DIRECTORY_SEPARATOR, '', $file);
                            $relativePath = str_replace('\\\\', '/', $relativePath);
                            $iconUrl = asset($relativePath);
                        @endphp
                        <label class="icon-label" style="cursor:pointer; display:inline-block; border:1px solid #ccc; padding:2px;">
                            <input type="radio" name="line_icons[${index}]" value="{{ $iconUrl }}" style="display:none;">
                            <img src="{{ $iconUrl }}" style="width:40px; height:40px;">
                        </label>
                    @endforeach
                </div>
            </div>
        `;

                linesContainer.insertAdjacentHTML('beforeend', newLine);
            });
        });
    </script>
</x-admin>
