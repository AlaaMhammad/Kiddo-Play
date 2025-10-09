<x-admin title="Edit Kid Session">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit Kid Session</h4>
        <div class="mb-4">
            <a href="{{ route('admin.kid-sessions.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.kid-sessions.update', $session->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Kid --}}
            <x-form.select name="kid_id" label="Select Kid" :options="$kids" optionLabel="display_name"
                optionValue="id" :selected="$session->kid_id" required />

            {{-- Started At --}}
            <x-form.input type="datetime-local" name="started_at" label="Start Time" :value="$session->started_at?->format('Y-m-d\TH:i')" required />

            {{-- Ended At --}}
            <x-form.input type="datetime-local" name="ended_at" label="End Time" :value="$session->ended_at?->format('Y-m-d\TH:i')" />

            {{-- Duration --}}
            <x-form.input type="number" name="duration_seconds" label="Duration (seconds)" :value="$session->duration_seconds" />

            {{-- Activity --}}
            <x-form.textarea name="activity" label="Activity (JSON data)" rows="4" :value="json_encode($session->activity, JSON_PRETTY_PRINT)" />

            <button class="btn btn-primary">Update</button>
        </form>
    </div>
</x-admin>
