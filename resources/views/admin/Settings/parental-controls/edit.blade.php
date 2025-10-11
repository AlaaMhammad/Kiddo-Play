<x-admin title="Edit Parental Control">
    <div class="mb-4">
        <a href="{{ route('admin.parental-controls.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.parental-controls.update', $parentalControl->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="parent_id" label="Parent" :options="$parents" :selected="$parentalControl->parent_id" required />
            <x-form.select name="kid_id" label="Kid" :options="$kids" :selected="$parentalControl->kid_id" required />
            <x-form.input name="daily_play_minutes_limit" label="Daily Play Minutes Limit" type="number"
                :value="$parentalControl->daily_play_minutes_limit" min="0" />
            <x-form.select name="content_level" label="Content Level" :options="['all' => 'All', 'age_appropriate' => 'Age Appropriate', 'restricted' => 'Restricted']" :selected="$parentalControl->content_level" required />
            <x-form.checkbox name="purchases_enabled" label="Allow Purchases" :checked="$parentalControl->purchases_enabled" />
            <x-form.textarea name="rules" label="Rules (JSON or array)" :value="json_encode($parentalControl->rules)" rows="3" />

            <x-form.button label="Update Control" />
        </form>
    </div>
</x-admin>
