<x-admin title="Kids Sessions Management">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Kids Sessions Management</h4>

        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Kids Sessions</h5>
            <a href="{{ route('admin.kid-sessions.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kid</th>
                            <th>Started At</th>
                            <th>Ended At</th>
                            <th>Duration (sec)</th>
                            <th>Activity</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sessions as $session)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $session->kid->display_name ?? '—' }}</td>
                                <td>{{ $session->started_at ? $session->started_at->format('Y-m-d H:i') : '-' }}</td>
                                <td>{{ $session->ended_at ? $session->ended_at->format('Y-m-d H:i') : '-' }}</td>
                                <td>{{ $session->duration_seconds ?? '-' }}</td>
                                <td>
                                    @if ($session->activity)
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#activityModal{{ $session->id }}">
                                            View
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="activityModal{{ $session->id }}" tabindex="-1"
                                            aria-labelledby="activityModalLabel{{ $session->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Session Activity</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <pre>{{ json_encode($session->activity, JSON_PRETTY_PRINT) }}</pre>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.kid-sessions.edit', $session->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.kid-sessions.destroy', $session->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this session?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No sessions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $sessions->links() }}
            </div>
        </div>
    </div>
</x-admin>
