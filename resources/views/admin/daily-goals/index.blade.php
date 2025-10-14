<x-admin title="Daily Goals Management">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Daily Goals Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Daily Goals</h5>
            <a href="{{ route('admin.kids.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="card-body table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kid</th>
                            <th>Game</th>
                            <th>Title</th>
                            <th>Target Points</th>
                            <th>Completed</th>
                            {{-- <th>Goal Date</th> --}}
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dailyGoals as $goal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $goal->kid->display_name ?? '-' }}</td>
                                <td>{{ $goal->game->description ?? '-' }}</td>
                                <td>{{ $goal->title }}</td>
                                <td>{{ $goal->target_points }}</td>
                                <td>
                                    <span class="badge bg-{{ $goal->is_completed ? 'success' : 'danger' }}">
                                        {{ $goal->is_completed ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                {{-- <td>{{ $goal->goal_date->format('Y-m-d') }}</td> --}}
                                <td class="text-center">
                                    <a href="{{ route('admin.daily-goals.show', $goal->id) }}"
                                        class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.daily-goals.edit', $goal->id) }}"
                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.daily-goals.destroy', $goal->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this goal?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No daily goals found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Pagination links -->
                <div>
                    {{ $dailyGoals->links() }}
                </div>

                <!-- Page info -->
                <div class="text-muted">
                    Page {{ $dailyGoals->currentPage() }} of {{ $dailyGoals->lastPage() }}
                    - Total items: {{ $dailyGoals->total() }}
                </div>
                Remaining items: {{ $dailyGoals->total() - $dailyGoals->currentPage() * $dailyGoals->perPage() }}
            </div>
        </div>
    </div>
</x-admin>
