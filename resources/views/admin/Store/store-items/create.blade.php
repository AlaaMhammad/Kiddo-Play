<x-admin title="Add Store Item">
    <div class="mb-4">
        <a href="{{ route('admin.store-items.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.store-items.store') }}" method="POST">
            @csrf

            <x-form.input name="title" label="Title" required />
            <x-form.textarea name="description" label="Description" rows="3" />
            <x-form.input name="cost_points" label="Cost Points" type="number" required />
            <x-form.input name="type" label="Type" />
            <x-form.textarea name="metadata" label="Metadata (JSON)" rows="3" />
            <x-form.checkbox name="is_active" label="Is Active" />

            {{-- <div class="mb-3 form-check">

                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                <label class="form-check-label" for="is_active">Active</label>
            </div> --}}

            <button class="btn btn-primary">Save Item</button>
        </form>
    </div>
</x-admin>
