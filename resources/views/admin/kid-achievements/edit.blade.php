<x-admin title="Edit Kid Achievement">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit kid Achievements</h4>
        <div class="mb-4">
            <a href="{{ route('admin.kid-achievements.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.kid-achievements.update', $kidAchievement->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="kid_id" label="Kid" :options="$kids->map(fn($k) => ['id' => $k->id, 'name' => $k->display_name]))" :selected="$kidAchievement->kid_id" required />

            <x-form.select name="achievement_id" label="Achievement" :options="$achievements->map(fn($a) => ['id' => $a->id, 'name' => $a->title]))" :selected="$kidAchievement->achievement_id" required />

            <x-form.date name="awarded_at" label="Awarded At" :value="$kidAchievement->awarded_at?->format('Y-m-d')" />

            <x-form.button label="Update Achievement" />
        </form>
    </div>
</x-admin>
