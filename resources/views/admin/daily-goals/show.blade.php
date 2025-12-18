<x-admin title="Daily Goal Details">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Daily Goal Details</h4>
        <a href="{{ route('admin.daily-goals.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">{{ $dailyGoal->title }}</h5>
            <h5 class="mb-0">{{ ucfirst($dailyGoal->type ?? '-') }}</h5>
        </div>
        <div class="card-body">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th>Kid</th>
                        <td>{{ $dailyGoal->kid->display_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Game</th>
                        <td>{{ $dailyGoal->game->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $dailyGoal->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Target Points</th>
                        <td>{{ $dailyGoal->target_points }}</td>
                    </tr>
                    <tr>
                        <th>Progress</th>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="progress flex-grow-1 me-2" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $dailyGoal->target_points > 0 ? ($dailyGoal->progress / $dailyGoal->target_points) * 100 : 0 }}%"
                                        aria-valuenow="{{ $dailyGoal->progress }}" aria-valuemin="0"
                                        aria-valuemax="{{ $dailyGoal->target_points }}">
                                        {{ $dailyGoal->progress }}/{{ $dailyGoal->target_points }}
                                    </div>
                                </div>
                                <span>{{ $dailyGoal->target_points > 0 ? round(($dailyGoal->progress / $dailyGoal->target_points) * 100) : 0 }}%</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Completed</th>
                        <td>
                            @if ($dailyGoal->is_completed)
                                <span class="badge bg-success">Yes</span>
                            @else
                                <span class="badge bg-warning">No</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Goal Date</th>
                        <td>{{ $dailyGoal->goal_date->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $dailyGoal->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $dailyGoal->updated_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Rewards</h5>
            <a href="{{ route('admin.rewards.create', ['daily_goal_id' => $dailyGoal->id]) }}"
                class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add Reward
            </a>
        </div>
        <div class="card-body table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Points Required</th>
                        <th>Claimed</th>
                        <th>Claimed At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dailyGoal->rewards as $reward)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reward->title }}</td>
                            <td>{{ $reward->description ?? '-' }}</td>
                            <td>{{ $reward->points_required }}</td>
                            <td>
                                @if ($reward->is_claimed)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-warning">No</span>
                                @endif
                            </td>
                            <td>{{ $reward->claimed_at?->format('Y-m-d H:i') ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No rewards found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin>
