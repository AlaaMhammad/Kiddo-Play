<x-admin title="Assign Achievement to Kid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add New kid Achievements</h4>
        <div class="mb-4">
            <a href="{{ route('admin.kid-achievements.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.kid-achievements.store') }}" method="POST">
            @csrf

            <x-form.select name="kid_id" label="Kid" :options="$kids->map(fn($k) => ['id' => $k->id, 'name' => $k->display_name])" required />

            <x-form.select name="achievement_id" label="Achievement" :options="$achievements->map(fn($a) => ['id' => $a->id, 'name' => $a->title])" required />

            <x-form.date name="awarded_at" label="Awarded At" />

            <x-form.button label="Assign Achievement" />
        </form>
    </div>
</x-admin>
