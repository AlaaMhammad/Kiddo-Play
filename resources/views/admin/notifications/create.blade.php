<x-admin title="Add New Notification">
    <div class="mb-4">
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.notifications.store') }}" method="POST">
            @csrf

            {{-- User --}}
            <x-form.select name="user_id" label="User" :options="$users" required  placeholder="Select User"/>

            {{-- Title --}}
            <x-form.input name="title" label="Title" />

            {{-- Body --}}
            <x-form.textarea name="body" label="Body" rows="4" />

            {{-- Sent At --}}
            <x-form.datetime name="sent_at" label="Sent At" />

            {{-- Is Read --}}
            <x-form.checkbox name="is_read" label="Mark as Read" />

            {{-- Submit --}}
            <x-form.button label="Create Notification" />
        </form>
    </div>
</x-admin>
