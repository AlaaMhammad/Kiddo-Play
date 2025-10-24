<x-admin title="Edit OTP">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit OTP</h4>
        <a href="{{ route('admin.otps.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.otps.update', $otp->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- User --}}
            <x-form.select name="user_id" label="Select User" :options="$users" optionLabel="name" optionValue="id"
                :selected="$otp->user_id" />

            {{-- Code --}}
            <x-form.input type="text" name="code" label="OTP Code" :value="$otp->code" required />

            {{-- Expires At --}}
            <x-form.input type="datetime-local" name="expires_at" label="Expires At" :value="$otp->expires_at->format('Y-m-d\TH:i')" required />

            {{-- Purpose --}}
            <x-form.input type="text" name="purpose" label="Purpose" :value="$otp->purpose" />

            {{-- Used --}}
            <x-form.select name="used" label="Used" :options="['0' => 'No', '1' => 'Yes']" :selected="$otp->used" required />

            <button class="btn btn-success">Update</button>
        </form>
    </div>
</x-admin>
