<x-admin title="View Kid Session">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.kid-sessions.index') }}" class="btn btn-secondary">
            ← Back
        </a>

        <a href="{{ route('admin.kid-sessions.edit', $kidSession->id) }}" class="btn btn-warning">
            <i class="bx bx-edit"></i> Edit
        </a>
    </div>

    <div class="card p-4">
        <h5 class="fw-bold mb-3">Session Details</h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <strong>Kid:</strong> {{ $kidSession->kid->display_name ?? '-' }}
            </div>
            <div class="col-md-6 mb-3">
                <strong>Started At:</strong>
                {{ $kidSession->started_at ? $kidSession->started_at->format('Y-m-d H:i') : '-' }}
            </div>

            <div class="col-md-6 mb-3">
                <strong>Ended At:</strong>
                {{ $kidSession->ended_at ? $kidSession->ended_at->format('Y-m-d H:i') : '-' }}
            </div>

            <div class="col-md-6 mb-3">
                <strong>Duration (seconds):</strong>
                {{ $kidSession->duration_seconds ?? '-' }}
            </div>

            <div class="col-md-12 mb-3">
                <strong>Activity:</strong>
                @if ($kidSession->activity)
                    <pre class="bg-light p-3 rounded">{{ json_encode($kidSession->activity, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                @else
                    <span class="text-muted">No activity data</span>
                @endif
            </div>

            <div class="col-md-12">
                <strong>Created At:</strong> {{ $kidSession->created_at->format('Y-m-d H:i') }}
            </div>
        </div>
    </div>
</x-admin>
