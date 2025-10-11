<x-admin title="Create User Setting">
    <div class="mb-4">
        <a href="{{ route('admin.user-settings.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.user-settings.store') }}" method="POST">
            @csrf

            <x-form.select name="user_id" label="User" :options="$users" required placeholder="Select User" />
            <x-form.checkbox name="sound_enabled" label="Enable Sound" />
            <x-form.checkbox name="music_enabled" label="Enable Music" />
            <x-form.input name="theme" label="Theme" placeholder="e.g., dark / light" required />
            <x-form.textarea name="extra" label="Extra (JSON Data)" rows="3" />

            <x-form.button label="Save Setting" />
        </form>
    </div>
</x-admin>
