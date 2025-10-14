<x-admin title="Game-Kids Records">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Game-Kids Records</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>


    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>All Game-Kids Records</h5>
            <a href="{{ route('admin.game-kids.create') }}" class="btn btn-primary btn-sm"><i class="bx bx-plus"></i> Add
                New</a>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kid</th>
                        <th>Game</th>
                        <th>Score</th>
                        <th>Play Count</th>
                        <th>Last Played</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gameKids as $gk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $gk->kid_name }}</td>
                            <td>{{ $gk->game_desc }}</td>
                            <td>{{ $gk->score }}</td>
                            <td>{{ $gk->play_count }}</td>
                            <td>{{ $gk->last_played_at ? \Carbon\Carbon::parse($gk->last_played_at)->format('Y-m-d H:i') : '-' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.game-kids.show', $goal->id) }}" class="btn btn-sm btn-info"><i
                                        class=""></i><i class="bx bx-show"></a>
                                <a href="{{ route('admin.game-kids.edit', $gk->id) }}" class="btn btn-sm btn-warning"><i
                                        class="bx bx-edit"></a>
                                <form action="{{ route('admin.game-kids.destroy', $gk->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this record?')"><i
                                            class="bx bx-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Pagination links -->
                <div>
                    {{ $gameKids->links() }}
                </div>

                <!-- Page info -->
                <div class="text-muted">
                    Page {{ $gameKids->currentPage() }} of {{ $gameKids->lastPage() }}
                    - Total items: {{ $gameKids->total() }}
                </div>
                Remaining items: {{ $gameKids->total() - $gameKids->currentPage() * $gameKids->perPage() }}
            </div>
        </div>
    </div>
</x-admin>
