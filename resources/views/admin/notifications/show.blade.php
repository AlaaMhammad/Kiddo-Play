<x-admin title="Notification Details">
    <div class="mb-4">
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h4 class="mb-3">{{ $notification->title ?? 'Untitled' }}</h4>

        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>User:</strong> {{ $notification->user->name ?? '-' }}</li>
            <li class="list-group-item"><strong>Body:</strong> {{ $notification->body ?? '-' }}</li>
            <li class="list-group-item"><strong>Read:</strong>
                <span class="badge bg-{{ $notification->is_read ? 'success' : 'secondary' }}">
                    {{ $notification->is_read ? 'Yes' : 'No' }}
                </span>
            </li>
            <li class="list-group-item"><strong>Sent At:</strong>
                {{ $notification->sent_at ? $notification->sent_at->format('Y-m-d H:i') : '-' }}
            </li>
            <li class="list-group-item"><strong>Created At:</strong>
                {{ $notification->created_at->format('Y-m-d H:i') }}</li>
        </ul>

        <hr>

        <div class="mt-3">
            <a href="{{ route('admin.notifications.edit', $notification->id) }}" class="btn btn-warning">
                <i class="bx bx-edit"></i> Edit
            </a>
            <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST"
                class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Delete this notification?')">
                    <i class="bx bx-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
</x-admin>
