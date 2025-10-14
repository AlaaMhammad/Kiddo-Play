<x-admin title="Parental Controls">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Parental Controls Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Parental Controls</h5>
            <a href="{{ route('admin.parental-controls.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Parent</th>
                            <th>Kid</th>
                            <th>Daily Play Limit</th>
                            <th>Content Level</th>
                            <th>Purchases Enabled</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($controls as $control)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $control->parent->name ?? '-' }}</td>
                                <td>{{ $control->kid->display_name ?? '-' }}</td>
                                <td>{{ $control->daily_play_minutes_limit ?? 'Unlimited' }} min</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $control->content_level)) }}</td>
                                <td>
                                    <span class="badge bg-{{ $control->purchases_enabled ? 'success' : 'secondary' }}">
                                        {{ $control->purchases_enabled ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td>{{ $control->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.parental-controls.show', $control->id) }}"
                                        class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.parental-controls.edit', $control->id) }}"
                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.parental-controls.destroy', $control->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this parental control?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No parental controls found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Pagination links -->
                <div>
                    {{ $controls->links() }}
                </div>

                <!-- Page info -->
                <div class="text-muted">
                    Page {{ $controls->currentPage() }} of {{ $controls->lastPage() }}
                    - Total items: {{ $controls->total() }}
                </div>
                Remaining items: {{ $controls->total() - $controls->currentPage() * $controls->perPage() }}
            </div>
        </div>
    </div>
</x-admin>
