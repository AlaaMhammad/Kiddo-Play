<x-admin title="Rewards Management">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Rewards Management</h4>

        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <!-- Display success/error messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Rewards</h5>
            <a href="{{ route('admin.rewards.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Daily Goal</th>
                            <th>Title</th>
                            <th>Points Required</th>
                            <th>Claimed</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rewards as $reward)
                            <tr>
                                <td>{{ $reward->id }}</td>
                                <td>{{ $reward->dailyGoal->title ?? '-' }}</td>
                                <td>{{ $reward->title }}</td>
                                <td>{{ $reward->points_required }}</td>
                                <td class="text-center">
                                    @if ($reward->is_claimed)
                                        <i class="bx bx-check-circle text-success fs-3" title="Claimed"></i>
                                    @else
                                        <i class="bx bx-x-circle text-danger fs-3" title="Not Claimed"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.rewards.show', $reward->id) }}"
                                        class="btn btn-sm btn-info"><i class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.rewards.edit', $reward) }}"
                                        class="btn btn-sm btn-warning"><i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.rewards.destroy', $reward) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No rewards found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $rewards->links() }}
            </div>

        </div>
    </div>
</x-admin>
