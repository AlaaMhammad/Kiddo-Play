<x-admin title="Edit Notification">
    <div class="mb-4">
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.notifications.update', $notification->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- User --}}
            <x-form.select name="user_id" label="User" :options="$users" :selected="$notification->user_id" required />

            {{-- Title --}}
            <x-form.input name="title" label="Title" :value="$notification->title" />

            {{-- Body --}}
            <x-form.textarea name="body" label="Body" :value="$notification->body" rows="4" />

            {{-- Sent At --}}
            <x-form.datetime name="sent_at" label="Sent At" :value="$notification->sent_at" />

            {{-- Is Read --}}
            <x-form.checkbox name="is_read" label="Mark as Read" :checked="$notification->is_read" />

            {{-- Submit --}}
            <x-form.button label="Update Notification" />
        </form>
    </div>
</x-admin>
