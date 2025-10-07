<x-admin title="Achievement Details">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Achievements Management</h4>
        <div class="mb-4">
            <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <h4>{{ $achievement->title }}</h4>
        <p><strong>Code:</strong> {{ $achievement->code }}</p>
        <p><strong>Description:</strong> {{ $achievement->description ?? 'N/A' }}</p>
        <p><strong>Points Awarded:</strong> {{ $achievement->points_award }}</p>
        @if ($achievement->icon_url)
            <p><strong>Icon:</strong> <img src="{{ $achievement->icon_url }}" alt="icon" width="50"></p>
        @endif

        <hr>

        <h5>Kids who earned this achievement:</h5>
        @if ($kids->count())
            <ul>
                @foreach ($kids as $kid)
                    <li>{{ $kid->display_name }}</li>
                @endforeach
            </ul>
        @else
            <p>No kids have earned this achievement yet.</p>
        @endif
    </div>
</x-admin>
