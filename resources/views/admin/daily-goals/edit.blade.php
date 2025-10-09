<x-admin title="Edit Kid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit kid</h4>
        <div class="mb-4">
            <a href="{{ route('admin.daily-goals.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.daily-goals.update', $kid->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Parent --}}
            <x-form.select name="parent_id" label="Parent" :options="$parents" :selected="$kid->user_id" required />

            {{-- Display Name --}}
            <x-form.input name="display_name" label="Display Name" :value="$kid->display_name" />

            {{-- Date of Birth --}}
            <x-form.date name="dob" label="Date of Birth" :value="$kid->dob" />

            {{-- Gender --}}
            <x-form.select name="gender" label="Gender" :options="[
                ['id' => 'male', 'name' => 'Male'],
                ['id' => 'female', 'name' => 'Female'],
                ['id' => 'other', 'name' => 'Other'],
            ]" :selected="$kid->gender" />

            {{-- Avatar --}}
            <x-form.select name="avatar_id" label="Avatar" :options="$avatars" :selected="$kid->avatar_id"
                placeholder="-- None --" />

            {{-- Points --}}
            <x-form.number name="points" label="Points" :value="$kid->points" />

            {{-- Submit Button --}}
            <x-form.button label="Update Kid" />
        </form>
    </div>
</x-admin>
