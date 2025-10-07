<x-admin title="Avatars">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Avatars Management</h4>
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
            <h5>All Avatars</h5>
            <a href="{{ route('admin.avatars.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Add
                Avatar</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-center align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Points</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($avatars as $avatar)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ asset('storage/' . $avatar->image_url) }}" width="60"
                                        height="60" class="rounded-circle"></td>
                                <td>{{ $avatar->name }}</td>
                                <td>{{ $avatar->cost_points }}</td>
                                <td>{!! $avatar->is_active
                                    ? '<span class="badge bg-label-success">Active</span>'
                                    : '<span class="badge bg-label-danger">Inactive</span>' !!}
                                </td>
                                <td>
                                    <a href="{{ route('admin.avatars.edit', $avatar) }}"
                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.avatars.destroy', $avatar) }}" method="POST"
                                        style="display:inline-block" onsubmit="return confirm('Delete avatar?')">
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

            <div class="mt-3">{{ $avatars->links() }}</div>
        </div>
    </div>
</x-admin>
