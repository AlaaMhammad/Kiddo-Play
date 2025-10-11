<x-admin title="Create Parental Control">
    <div class="mb-4">
        <a href="{{ route('admin.parental-controls.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.parental-controls.store') }}" method="POST">
            @csrf

            <x-form.select name="parent_id" label="Parent" :options="$parents" required placeholder="Select Parent" />
            <x-form.select name="kid_id" label="Kid" :options="$kids" required placeholder="Select Kid" />
            <x-form.input name="daily_play_minutes_limit" label="Daily Play Minutes Limit" type="number"
                min="0" />
            <x-form.select name="content_level" label="Content Level" :options="['all' => 'All', 'age_appropriate' => 'Age Appropriate', 'restricted' => 'Restricted']" required placeholder="Select Content Level"/>
            <x-form.checkbox name="purchases_enabled" label="Allow Purchases" />
            <x-form.textarea name="rules" label="Rules (JSON or array)" rows="3" />

            <x-form.button label="Save Control" />
        </form>
    </div>
</x-admin>
