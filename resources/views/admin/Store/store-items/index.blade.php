<x-admin title="Store Items">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Store Items Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Store Items</h5>
            <a href="{{ route('admin.store-items.create') }}" class="btn btn-primary btn-sm">
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
                            <th>Type</th>
                            <th>Cost Points</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->type ?? '-' }}</td>
                                <td>{{ $item->cost_points }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->is_active ? 'success' : 'secondary' }}">
                                        {{ $item->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.store-items.show', $item->id) }}"
                                        class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.store-items.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.store-items.destroy', $item->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete item?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</x-admin>
