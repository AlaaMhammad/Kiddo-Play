<x-admin title="Notifications">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Notifications Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Notifications</h5>
            <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Title</th>
                            <th>Read</th>
                            <th>Sent At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notifications as $notification)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $notification->user->name ?? '-' }}</td>
                                <td>{{ $notification->title ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $notification->is_read ? 'success' : 'secondary' }}">
                                        {{ $notification->is_read ? 'Read' : 'Unread' }}
                                    </span>
                                </td>
                                <td>{{ $notification->sent_at ? $notification->sent_at->format('Y-m-d H:i') : '-' }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.notifications.show', $notification->id) }}"
                                        class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.notifications.edit', $notification->id) }}"
                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.notifications.destroy', $notification->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this notification?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No notifications found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $notifications->links() }}</div>
        </div>
    </div>
</x-admin>
