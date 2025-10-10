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

        @if ($lesson->content)
            <hr>
            <h6>Content:</h6>
            <p>{!! nl2br(e($lesson->content)) !!}</p>
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
