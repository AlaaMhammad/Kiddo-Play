<x-admin title="Kids List">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Kids Management</h4>

        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Kids</h5>
            <a href="{{ route('admin.kids.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New Kid
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Display Name</th>
                            <th>User</th>
                            <th>Gender</th>
                            <th>Points</th>
                            <th>Avatar</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kids as $kid)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kid->display_name }}</td>
                                <td>{{ $kid->user->name ?? '-' }}</td>
                                <td>{{ ucfirst($kid->gender ?? '-') }}</td>
                                <td>{{ $kid->points }}</td>
                                <td>
                                    @if ($kid->avatar)
                                        <img src="{{ asset($kid->avatar->image_url) }}" alt="avatar" width="40"
                                            height="40" class="rounded-circle">
                                    @else
                                        <span class="text-muted">No Avatar</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.kids.show', $kid->id) }}" class="btn btn-sm btn-info"><i
                                            class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.kids.edit', $kid->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.kids.destroy', $kid->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this kid?')"><i
                                                class="bx bx-trash"></i></button>
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

            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Pagination links -->
                <div>
                    {{ $kids->links() }}
                </div>

                <!-- Page info -->
                <div class="text-muted">
                    Page {{ $kids->currentPage() }} of {{ $kids->lastPage() }}
                    - Total items: {{ $kids->total() }}
                </div>
                Remaining items: {{ $kids->total() - $kids->currentPage() * $kids->perPage() }}
            </div>
        </div>
    </div>
</x-admin>
