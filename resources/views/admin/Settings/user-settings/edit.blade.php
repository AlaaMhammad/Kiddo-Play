<x-admin title="Edit User Setting">
    <div class="mb-4">
        <a href="{{ route('admin.user-settings.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.user-settings.update', $userSetting->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="user_id" label="User" :options="$users" :selected="$userSetting->user_id" required />
            <x-form.checkbox name="sound_enabled" label="Enable Sound" :checked="$userSetting->sound_enabled" />
            <x-form.checkbox name="music_enabled" label="Enable Music" :checked="$userSetting->music_enabled" />
            <x-form.input name="theme" label="Theme" :value="$userSetting->theme" required />
            <x-form.textarea name="extra" label="Extra (JSON Data)" :value="json_encode($userSetting->extra)" rows="3" />

            <x-form.button label="Update Setting" />
        </form>
    </div>
</x-admin>
