<x-admin title="Add New Purchase">
    <div class="mb-4">
        <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.purchases.store') }}" method="POST">
            @csrf

            <x-form.select2 name="kid_id" label="Select Kid" :options="$kids" optionLabel="display_name" optionValue="id"
                placeholder="-- Choose Kid --" required />

            <x-form.select2 name="store_item_id" label="Select Store Item" :options="$items" optionLabel="title"
                optionValue="id" placeholder="-- Choose Item --" required />

            <x-form.input type="number" name="points_used" label="Points Used" value="{{ old('points_used', 0) }}"
                min="0" required />

            <x-form.textarea name="details" label="Details (optional)" rows="3" />

            <button class="btn btn-primary">Save Purchase</button>
        </form>
    </div>
</x-admin>
