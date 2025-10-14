<x-admin title="Quizzes">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Quizzes Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Quizzes</h5>
            <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Lesson</th>
                            <th>Time Limit (sec)</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quizzes as $quiz)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $quiz->title ?? '-' }}</td>
                                <td>{{ $quiz->lesson->title ?? '-' }}</td>
                                <td>{{ $quiz->time_limit_seconds ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-{{ $quiz->is_active ? 'success' : 'secondary' }}">
                                        {{ $quiz->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $quiz->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.quizzes.show', $quiz->id) }}"
                                        class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.quizzes.edit', $quiz->id) }}"
                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this quiz?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No quizzes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Pagination links -->
                <div>
                    {{ $quizzes->links() }}
                </div>

                <!-- Page info -->
                <div class="text-muted">
                    Page {{ $quizzes->currentPage() }} of {{ $quizzes->lastPage() }}
                    - Total items: {{ $quizzes->total() }}
                </div>
                Remaining items: {{ $quizzes->total() - $quizzes->currentPage() * $quizzes->perPage() }}
            </div>
        </div>
    </div>
</x-admin>
