<x-admin title="Kids Lesson Progresses">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Kids Lesson Progresses Management</h4>

        <a href="{{ route('admin.kid-lesson-progresses.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Kids Lesson Progresses</h5>
            <a href="{{ route('admin.kid-lesson-progresses.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kid</th>
                            <th>Lesson</th>
                            <th>Status</th>
                            <th>Progress %</th>
                            <th>Last Accessed</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($progresses as $progress)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $progress->kid->display_name }}</td>
                                <td>{{ $progress->lesson->title ?? '-' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $progress->status)) }}</td>
                                <td>{{ $progress->progress_percent }}%</td>
                                <td>{{ $progress->last_accessed_at ? $progress->last_accessed_at->format('Y-m-d H:i') : '-' }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.kid-lesson-progresses.edit', $progress->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.kid-lesson-progresses.destroy', $progress->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this record?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No kids found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $progresses->links() }}
            </div>
        </div>
    </div>
</x-admin>
