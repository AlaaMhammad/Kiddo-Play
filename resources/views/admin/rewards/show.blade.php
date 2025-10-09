<x-admin title="Reward Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Reward Details</h4>
        <a href="{{ route('admin.rewards.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $reward->id }}</td>
            </tr>
            <tr>
                <th>Daily Goal</th>
                <td>{{ $reward->dailyGoal->title ?? '-' }}</td>
            </tr>
            <tr>
                <th>Title</th>
                <td>{{ $reward->title }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $reward->description ?? '-' }}</td>
            </tr>
            <tr>
                <th>Points Required</th>
                <td>{{ $reward->points_required }}</td>
            </tr>
            <tr>
                <th>Claimed</th>
                <td>{{ $reward->is_claimed ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th>Claimed At</th>
                <td>{{ $reward->claimed_at ?? '-' }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $reward->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $reward->updated_at->format('Y-m-d H:i') }}</td>
            </tr>
        </table>

        <div class="mt-3">
            <a href="{{ route('admin.rewards.edit', $reward) }}" class="btn btn-warning">Edit</a>
            <form action="{{ route('admin.rewards.destroy', $reward) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</x-admin>
