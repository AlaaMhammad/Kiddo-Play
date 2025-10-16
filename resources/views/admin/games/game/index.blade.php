<x-admin title="Games Management">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Games Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    @if (session('success'))
        @php
            $action = session('action');
            $alertClass = match ($action) {
                'create' => 'alert-success', // أخضر
                'update' => 'alert-primary', // أزرق
                'delete' => 'alert-danger', // أحمر
                default => 'alert-secondary', // رمادي افتراضي
            };
        @endphp

        <div class="alert {{ $alertClass }} alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>All Games</h5>
            <a href="{{ route('admin.games.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Add
                New</a>
        </div>

        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Difficulty</th>
                        <th>Active</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($games as $game)
                        <tr>
                            <td>{{ $games->firstItem() + $loop->index }}</td>
                            <td>{{ $game->description }}</td>
                            <td>{{ ucfirst($game->category) }}</td>
                            <td>{{ ucfirst($game->difficulty_level) }}</td>
                            <td>
                                @if ($game->is_active)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-danger">No</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.games.show', $game->id) }}" class="btn btn-sm btn-info"><i
                                        class="bx bx-show"></i></a>
                                <a href="{{ route('admin.games.edit', $game->id) }}" class="btn btn-sm btn-warning"><i
                                        class="bx bx-edit"></i></a>
                                <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this game?')"><i
                                            class="bx bx-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No games found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination links -->
            <div class="mt-4">
                {{ $games->links() }}
            </div>

        </div>
    </div>
</x-admin>
