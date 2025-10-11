<x-admin title="User Setting Details">
    <div class="mb-4">
        <a href="{{ route('admin.user-settings.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h4 class="mb-3">Settings for {{ $userSetting->user->name ?? 'Unknown User' }}</h4>

        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Sound Enabled:</strong> {{ $userSetting->sound_enabled ? 'Yes' : 'No' }}
            </li>
            <li class="list-group-item"><strong>Music Enabled:</strong> {{ $userSetting->music_enabled ? 'Yes' : 'No' }}
            </li>
            <li class="list-group-item"><strong>Theme:</strong> {{ $userSetting->theme }}</li>
            <li class="list-group-item"><strong>Extra:</strong>
                <pre class="bg-light p-2 rounded">{{ json_encode($userSetting->extra, JSON_PRETTY_PRINT) }}</pre>
            </li>
        </ul>
    </div>
</x-admin>
