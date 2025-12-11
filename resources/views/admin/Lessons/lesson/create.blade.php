<x-admin title="Add New Lesson">
    <div class="mb-4">
        <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary">
            ← Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>


    @endif

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

            {{-- <x-form.textarea name="content" label="Content" rows="5"
                placeholder="Full lesson content or details" /> --}}
            {{-- @php
                $lines = explode("\n", old('content', $lesson->content ?? ''));
                $lineIcons = old('line_icons', $lesson->line_icons ?? []);
                $iconFiles = glob(public_path('icons/*.png'));
            @endphp

            <div id="lines-container">
                @foreach ($lines as $index => $line)
                    <div class="mb-3 line-item">
                        <label>Line {{ $index + 1 }}</label>
                        <input type="text" name="content" value="{{ $line }}" class="form-control mb-1">

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

            <button type="button" id="add-line" class="btn btn-sm btn-secondary mb-3">+ Add Line</button> --}}
            {{--
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
            </div> --}}

            {{-- <button type="button" id="add-line" class="btn btn-sm btn-secondary mb-3">+ Add Line</button> --}}

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


            <x-form.input name="media_url" label="Media URL" placeholder="https://example.com/media.mp4" />

            <x-form.input type="number" name="order" label="Order" value="0" />

            <x-form.checkbox name="is_published" label="Published" checked />

            <button class="btn btn-primary">Save Lesson</button>
        </form>
    </div>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // تظليل الصورة عند تحديدها
            document.querySelectorAll('.icon-options').forEach(function(container) {
                container.addEventListener('click', function(e) {
                    if (e.target.tagName === 'IMG') {
                        let labels = container.querySelectorAll('.icon-label');
                        labels.forEach(l => l.style.border =
                        '1px solid #ccc'); // إزالة التحديد من الكل
                        e.target.parentElement.style.border =
                        '2px solid #007bff'; // تحديد الصورة المختارة
                        e.target.previousElementSibling.checked = true; // تفعيل الـ radio
                    }
                });
            });

            // إضافة سطر جديد ديناميكيًا
            let addBtn = document.getElementById('add-line');
            let linesContainer = document.getElementById('lines-container');

            addBtn.addEventListener('click', function() {
                let index = linesContainer.querySelectorAll('.line-item').length;

                let div = document.createElement('div');
                div.classList.add('mb-3', 'line-item');
                div.innerHTML = `
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
        `;
                linesContainer.appendChild(div);
            });
        });
    </script> --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            let linesContainer = document.getElementById('lines-container');

            // Delegation: نسمع على كل النقرات داخل الحاوية
            linesContainer.addEventListener('click', function(e) {
                if (e.target.tagName === 'IMG') {
                    let container = e.target.closest('.icon-options');
                    if (!container) return;

                    // إزالة التحديد من كل الأيقونات في هذا السطر
                    container.querySelectorAll('.icon-label').forEach(l => l.style.border =
                        '1px solid #ccc');

                    // تفعيل التحديد على الصورة المختارة
                    e.target.parentElement.style.border = '2px solid #007bff';
                    e.target.previousElementSibling.checked = true;
                }
            });

            // إضافة سطر جديد
            let addBtn = document.getElementById('add-line');

            addBtn.addEventListener('click', function() {
                let index = linesContainer.querySelectorAll('.line-item').length;

                let div = document.createElement('div');
                div.classList.add('mb-3', 'line-item');
                div.innerHTML = `
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
        `;
                linesContainer.appendChild(div);
            });
        });
    </script> --}}

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
