<x-admin title="Add New Kid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add New kid</h4>
        <div class="mb-4">
            <a href="{{ route('admin.kids.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.kids.store') }}" method="POST">
            @csrf

            {{-- Parent --}}
            @if ($parents)
                <x-form.select name="parent_id" label="Parent" :options="$parents" required />
            @else
                <input type="hidden" name="parent_id" value="{{ $parentId }}">
            @endif

            {{-- Display Name --}}
            <x-form.input name="display_name" label="Display Name" required />

            {{-- Date of Birth --}}
            <x-form.date name="dob" label="Date of Birth" />

            {{-- Gender --}}
            <x-form.select name="gender" label="Gender" :options="[
                ['id' => 'male', 'name' => 'Male'],
                ['id' => 'female', 'name' => 'Female'],
                ['id' => 'other', 'name' => 'Other'],
            ]" />

            {{-- Avatar --}}
            <x-form.select name="avatar_id" label="Avatar" :options="$avatars" placeholder="-- None --" />

            {{-- Points --}}
            <x-form.number name="points" label="Points" value="0" />

            <hr>

            {{-- Child Account --}}
            <h5>Child Login Account</h5>
            <x-form.input name="email" label="Email" type="email" required />
            <x-form.input name="password" label="Password" type="password" required />
            <x-form.input name="password_confirmation" label="Confirm Password" type="password" required />

            {{-- Submit --}}
            <x-form.button label="Save Kid" />
        </form>
    </div>
</x-admin>
