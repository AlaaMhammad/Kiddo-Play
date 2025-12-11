<x-admin title="Lesson Details">
    <div class="mb-4">
        <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h4 class="fw-bold mb-3">{{ $lesson->title }}</h4>

        <p><strong>Category:</strong> {{ ucfirst($lesson->category) }}</p>
        <p><strong>Order:</strong> {{ $lesson->order }}</p>
        <p><strong>Status:</strong>
            <span class="badge bg-{{ $lesson->is_published ? 'success' : 'secondary' }}">
                {{ $lesson->is_published ? 'Published' : 'Hidden' }}
            </span>
        </p>

        @if ($lesson->summary)
            <hr>
            <h6>Summary:</h6>
            <p>{{ $lesson->summary }}</p>
        @endif

        {{-- @if ($lesson->content)
            <hr>
            <h6>Visual Representation:</h6>
            <div style="font-size:24px; line-height:36px;">{!! $visual !!}</div>

            <h6 class="mt-3">Original Content:</h6>
            <p>{!! nl2br(e($lesson->content)) !!}</p>
        @endif --}}

        {{-- @if ($lesson->content)
            <hr>
            <h6>Visual Representation:</h6>
            @php
                $lines = explode("\n", $lesson->content);
            @endphp
            @foreach ($visualLines as $index => $line)
                <div style="margin-bottom:20px;">
                    <div>{!! $line !!}</div> {{-- أيقونات السطر
                    <div style="margin-top:5px; font-weight:bold;">{{ $lines[$index] }}</div>  نص السطر الأصلي
                </div>
            @endforeach
        @endif --}}

        @if ($lesson->content)
            <hr>
            <h6>Visual Representation:</h6>

            @foreach ($visualLines as $index => $line)
                <div style="margin-bottom:20px;">
                    <div>{!! $line !!}</div> {{-- السطر الأساسي بأيقونة السطر --}}
                    <div style="margin-top:5px; font-weight:bold;">{!! $textAsIcons[$index] !!}</div>
                    {{-- السطر الأصلي لكن بأيقونات --}}
                </div>
            @endforeach
        @endif





        @if ($lesson->media_url)
            <hr>
            <h6>Media:</h6>
            <a href="{{ $lesson->media_url }}" target="_blank">{{ $lesson->media_url }}</a>
        @endif

        <hr>
        <p class="text-muted small">Created at: {{ $lesson->created_at->format('Y-m-d H:i') }}</p>
    </div>
</x-admin>
