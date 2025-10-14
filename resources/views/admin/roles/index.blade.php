<x-admin title="Roles">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Roles Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    @if ('success' == session('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>All Roles</h5>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Add
                Role</a>
        </div>

        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Label</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->lable }}</td>
                            <td>
                                <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-warning"><i
                                        class="bx bx-edit"></i></a>
                                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                    style="display:inline-block" onsubmit="return confirm('Delete this role?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
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
                {{ $roles->links() }}
            </div>

            <!-- Page info -->
            <div class="text-muted">
                Page {{ $roles->currentPage() }} of {{ $roles->lastPage() }}
                - Total items: {{ $roles->total() }}
            </div>
            Remaining items: {{ $roles->total() - $roles->currentPage() * $roles->perPage() }}
        </div>
    </div>
</x-admin>
