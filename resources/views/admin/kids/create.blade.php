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

            <x-form.select name="parent_id" label="Parent" :options="$parents" required />

            <x-form.input name="display_name" label="Display Name" />

            <x-form.date name="dob" label="Date of Birth" />

            <x-form.select name="gender" label="Gender" :options="[
                ['id' => 'male', 'name' => 'Male'],
                ['id' => 'female', 'name' => 'Female'],
                ['id' => 'other', 'name' => 'Other'],
            ]" />

            <x-form.select name="avatar_id" label="Avatar" :options="$avatars" placeholder="-- None --" />

            <x-form.number name="points" label="Points" value="0" />

            <x-form.button label="Save Kid" />
        </form>
    </div>
</x-admin>
