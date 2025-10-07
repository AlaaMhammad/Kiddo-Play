<x-admin title="View Kid Achievement">
    <div class="mb-4">
        <a href="{{ route('admin.kid-achievements.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <ul class="list-group">
            <li class="list-group-item"><strong>Kid:</strong> {{ $kidAchievement->kid->display_name ?? '-' }}</li>
            <li class="list-group-item"><strong>Achievement:</strong> {{ $kidAchievement->achievement->title ?? '-' }}
            </li>
            <li class="list-group-item"><strong>Points:</strong> {{ $kidAchievement->achievement->points_award ?? 0 }}
            </li>
            <li class="list-group-item"><strong>Awarded At:</strong>
                {{ $kidAchievement->awarded_at?->format('Y-m-d') ?? '-' }}</li>
            <li class="list-group-item"><strong>Meta:</strong> {{ json_encode($kidAchievement->meta) ?? '-' }}</li>
        </ul>
    </div>
</x-admin>
