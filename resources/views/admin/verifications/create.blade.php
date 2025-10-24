<x-admin title="Add New OTP">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add New OTP</h4>
        <a href="{{ route('admin.otps.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.otps.store') }}" method="POST">
            @csrf

            {{-- User --}}
            <x-form.select name="user_id" label="Select User" :options="$users" optionLabel="name" optionValue="id" />

            {{-- Code --}}
            {{-- <x-form.input type="text" name="code" label="OTP Code" required /> --}}
            <p class="text-muted">OTP سيتم توليده تلقائيًا عند الحفظ.</p>

            {{-- Expires At --}}
            <x-form.input type="datetime-local" name="expires_at" label="Expires At" required />

            {{-- Purpose --}}
            <x-form.input type="text" name="purpose" label="Purpose" />

            {{-- Used --}}
            <x-form.select name="used" label="Used" :options="['0' => 'No', '1' => 'Yes']" required />

            <button class="btn btn-success">Save</button>
        </form>
    </div>
</x-admin>
