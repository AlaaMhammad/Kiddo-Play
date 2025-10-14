<x-admin title="Kid Achievements">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Kid Achievements</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Kid Achievements</h5>
            <a href="{{ route('admin.kid-achievements.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add Kid Achievement
            </a>

        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kid</th>
                            <th>Achievement</th>
                            <th>Points</th>
                            <th>Awarded At</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kidAchievements as $ka)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ka->kid->display_name ?? '-' }}</td>
                                <td>{{ $ka->achievement->title ?? '-' }}</td>
                                <td>{{ $ka->achievement->points_award ?? 0 }}</td>
                                <td>{{ $ka->awarded_at ? $ka->awarded_at->format('Y-m-d') : '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.kid-achievements.show', $ka->id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="{{ route('admin.kid-achievements.edit', $ka->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.kid-achievements.destroy', $ka->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this record?')">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No achievements assigned.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Pagination links -->
                <div>
                    {{ $kidAchievements->links() }}
                </div>

                <!-- Page info -->
                <div class="text-muted">
                    Page {{ $kidAchievements->currentPage() }} of {{ $kidAchievements->lastPage() }}
                    - Total items: {{ $kidAchievements->total() }}
                </div>
                Remaining items:
                {{ $kidAchievements->total() - $kidAchievements->currentPage() * $kidAchievements->perPage() }}
            </div>
        </div>
    </div>
</x-admin>
