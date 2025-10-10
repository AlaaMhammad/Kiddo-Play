<x-admin title="Edit Purchase">
    <div class="mb-4">
        <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.purchases.update', $purchase->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select2 name="kid_id" label="Select Kid" :options="$kids" optionLabel="display_name" optionValue="id"
                :selected="$purchase->kid_id" placeholder="-- Choose Kid --" required />

            <x-form.select2 name="store_item_id" label="Select Store Item" :options="$items" optionLabel="title"
                optionValue="id" :selected="$purchase->store_item_id" placeholder="-- Choose Item --" required />

            <x-form.input type="number" name="points_used" label="Points Used"
                value="{{ old('points_used', $purchase->points_used) }}" min="0" required />

            <x-form.textarea name="details" label="Details (optional)" :value="json_encode($purchase->details, JSON_PRETTY_PRINT)" rows="3" />

            <button class="btn btn-success">Update Purchase</button>
        </form>
    </div>
</x-admin>
