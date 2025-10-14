<x-admin title="Quiz Attempts">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Quiz Attempts Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Quiz Attempts</h5>
            <a href="{{ route('admin.quiz-attempts.create') }}" class="btn btn-primary btn-sm">
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
                            <th>Quiz</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Started</th>
                            <th>Finished</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($attempts as $attempt)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attempt->kid->display_name ?? '-' }}</td>
                                <td>{{ $attempt->quiz->title ?? '-' }}</td>
                                <td>{{ $attempt->score ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $attempt->status == 'completed' ? 'success' : ($attempt->status == 'started' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst($attempt->status) }}
                                    </span>
                                </td>
                                <td>{{ $attempt->started_at ? $attempt->started_at->format('Y-m-d H:i') : '-' }}</td>
                                <td>{{ $attempt->finished_at ? $attempt->finished_at->format('Y-m-d H:i') : '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.quiz-attempts.show', $attempt->id) }}"
                                        class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.quiz-attempts.edit', $attempt->id) }}"
                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.quiz-attempts.destroy', $attempt->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this attempt?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No quiz attempts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Pagination links -->
                <div>
                    {{ $attempts->links() }}
                </div>

                <!-- Page info -->
                <div class="text-muted">
                    Page {{ $attempts->currentPage() }} of {{ $attempts->lastPage() }}
                    - Total items: {{ $attempts->total() }}
                </div>
                Remaining items: {{ $attempts->total() - $attempts->currentPage() * $attempts->perPage() }}
            </div>
        </div>
    </div>
</x-admin>
