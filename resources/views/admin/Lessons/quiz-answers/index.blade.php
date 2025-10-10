<x-admin title="Quiz Answers">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Quiz Answers Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Quiz Answers</h5>
            <a href="{{ route('admin.quiz-answers.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Attempt (Kid)</th>
                            <th>Question</th>
                            <th>Is Correct</th>
                            <th>Points</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($answers as $answer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $answer->attempt->kid->display_name ?? '-' }}</td>
                                <td>{{ Str::limit($answer->question->content, 50) }}</td>
                                <td>
                                    <span class="badge bg-{{ $answer->is_correct ? 'success' : 'danger' }}">
                                        {{ $answer->is_correct ? 'Correct' : 'Wrong' }}
                                    </span>
                                </td>
                                <td>{{ $answer->points_awarded }}</td>
                                <td>{{ $answer->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.quiz-answers.show', $answer->id) }}"
                                        class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.quiz-answers.edit', $answer->id) }}"
                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.quiz-answers.destroy', $answer->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this answer?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No quiz answers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $answers->links() }}</div>
        </div>
    </div>
</x-admin>
