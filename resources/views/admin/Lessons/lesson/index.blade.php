<x-admin title="Lessons">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Lessons Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Lessons</h5>
            <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lessons as $lesson)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucfirst($lesson->category) }}</td>
                                <td>{{ $lesson->title }}</td>
                                <td>{{ $lesson->order }}</td>
                                <td>
                                    <span class="badge bg-{{ $lesson->is_published ? 'success' : 'secondary' }}">
                                        {{ $lesson->is_published ? 'Published' : 'Hidden' }}
                                    </span>
                                </td>
                                <td>{{ $lesson->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.lessons.show', $lesson->id) }}"
                                        class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.lessons.edit', $lesson->id) }}"
                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this lesson?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No lessons found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $lessons->links() }}
            </div>
        </div>
    </div>
</x-admin>
