<x-admin title="Edit Store Item">
    <div class="mb-4">
        <a href="{{ route('admin.store-items.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.store-items.update', $store_item->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.input name="title" label="Title" value="{{ $store_item->title }}" required />
            <x-form.textarea name="description" label="Description" value="{{ $store_item->description }}"
                rows="3" />
            <x-form.input name="cost_points" label="Cost Points" type="number" value="{{ $store_item->cost_points }}"
                required />
            <x-form.input name="type" label="Type" value="{{ $store_item->type }}" />
            <x-form.textarea name="metadata" label="Metadata (JSON)" rows="3"
                value="{{ json_encode($store_item->metadata) }}" />

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                    {{ $store_item->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Active</label>
            </div>

            <button class="btn btn-success">Update Item</button>
        </form>
    </div>
</x-admin>
