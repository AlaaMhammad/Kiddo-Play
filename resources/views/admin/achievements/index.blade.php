<x-admin title="Achievements List">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Achievements Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Achievements</h5>
            <a href="{{ route('admin.achievements.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add Achievement
            </a>

        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Title</th>
                            <th>Points</th>
                            <th>Icon</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($achievements as $a)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $a->code }}</td>
                                <td>{{ $a->title }}</td>
                                <td>{{ $a->points_award }}</td>
                                <td>
                                    @if ($a->icon_url)
                                        <img src="{{ $a->icon_url }}" alt="icon" width="40" height="40">
                                    @else
                                        <span class="text-muted">No Icon</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.achievements.show', $a->id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="{{ route('admin.achievements.edit', $a->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.achievements.destroy', $a->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Delete this achievement?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No achievements found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            <!-- Pagination links -->
            <div class="mt-4">
                {{ $achievements->links() }}
            </div>

        </div>
    </div>
</x-admin>
