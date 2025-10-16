<x-admin title="Questions">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Questions Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Questions</h5>
            <a href="{{ route('admin.questions.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Quiz</th>
                            <th>Type</th>
                            <th>Points</th>
                            <th>Order</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($questions as $question)
                            <tr>
                                <td>{{ $questions->firstItem() + $loop->index }}</td>
                                <td>{{ $question->quiz->title ?? '-' }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $question->type)) }}</td>
                                <td>{{ $question->points }}</td>
                                <td>{{ $question->order }}</td>
                                <td>{{ $question->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.questions.show', $question->id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="{{ route('admin.questions.edit', $question->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this question?')">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No questions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $questions->links() }}
            </div>
        </div>
    </div>
</x-admin>
