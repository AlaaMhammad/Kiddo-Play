<x-admin title="Add New Kid Session">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add New Kid Session</h4>
        <div class="mb-4">
            <a href="{{ route('admin.kid-sessions.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.kid-sessions.store') }}" method="POST">
            @csrf

            {{-- Kid --}}
            <x-form.select name="kid_id" label="Select Kid" :options="$kids" optionLabel="display_name"
                optionValue="id" required />

            {{-- Started At --}}
            <x-form.input type="datetime-local" name="started_at" label="Start Time" required />

            {{-- Ended At --}}
            <x-form.input type="datetime-local" name="ended_at" label="End Time" />

            {{-- Duration --}}
            <x-form.input type="number" name="duration_seconds" label="Duration (seconds)" />

            {{-- Activity --}}
            <x-form.textarea name="activity" label="Activity (JSON data)" rows="4" />

            <button class="btn btn-success">Save</button>
        </form>
    </div>
</x-admin>
