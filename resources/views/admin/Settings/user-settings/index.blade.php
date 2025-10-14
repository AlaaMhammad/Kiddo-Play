<x-admin title="User Settings">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">User Settings Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All User Settings</h5>
            <a href="{{ route('admin.user-settings.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Sound</th>
                            <th>Music</th>
                            <th>Theme</th>
                            <th>Created</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($settings as $setting)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $setting->user->name ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $setting->sound_enabled ? 'success' : 'secondary' }}">
                                        {{ $setting->sound_enabled ? 'On' : 'Off' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $setting->music_enabled ? 'success' : 'secondary' }}">
                                        {{ $setting->music_enabled ? 'On' : 'Off' }}
                                    </span>
                                </td>
                                <td>{{ ucfirst($setting->theme) }}</td>
                                <td>{{ $setting->created_at->format('Y-m-d') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.user-settings.show', $setting->id) }}"
                                        class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.user-settings.edit', $setting->id) }}"
                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.user-settings.destroy', $setting->id) }}"
                                        method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this setting?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No user settings found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <!-- Pagination links -->
                <div>
                    {{ $settings->links() }}
                </div>

                <!-- Page info -->
                <div class="text-muted">
                    Page {{ $settings->currentPage() }} of {{ $settings->lastPage() }}
                    - Total settings: {{ $settings->total() }}
                </div>
                Remaining settings: {{ $settings->total() - $settings->currentPage() * $settings->perPage() }}
            </div>
        </div>
    </div>
</x-admin>
