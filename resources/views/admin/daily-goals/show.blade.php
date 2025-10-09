<x-admin title="Kid Details">
    <div class="mb-4">
        <a href="{{ route('admin.kids.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h4 class="mb-3">{{ $kid->display_name }}</h4>

        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>User:</strong> {{ $kid->user->name ?? '-' }}</li>
            <li class="list-group-item"><strong>Date of Birth:</strong> {{ $kid->dob ?? '-' }}</li>
            <li class="list-group-item"><strong>Gender:</strong> {{ ucfirst($kid->gender ?? '-') }}</li>
            <li class="list-group-item"><strong>Points:</strong> {{ $kid->points }}</li>
            <li class="list-group-item"><strong>Avatar:</strong>
                @if($kid->avatar)
                    <img src="{{ asset($kid->avatar->image_url) }}" alt="" width="50" class="rounded-circle">
                    {{ $kid->avatar->name }}
                @else
                    <span class="text-muted">None</span>
                @endif
            </li>
        </ul>

        <hr>

        <h5 class="mt-4">Related Data</h5>
        <ul>
            <li>Achievements: {{ $kid->achievements->count() }}</li>
            <li>Lesson Progress: {{ $kid->lessonProgress->count() }}</li>
            <li>Daily Goals: {{ $kid->dailyGoals->count() }}</li>
            <li>Sessions: {{ $kid->sessions->count() }}</li>
            <li>Points Transactions: {{ $kid->pointsTransactions->count() }}</li>
        </ul>
    </div>
</x-admin>
