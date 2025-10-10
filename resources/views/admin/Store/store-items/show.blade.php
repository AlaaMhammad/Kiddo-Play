<x-admin title="View Store Item">
    <div class="mb-4">
        <a href="{{ route('admin.store-items.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h4>{{ $store_item->title }}</h4>
        <p><strong>Type:</strong> {{ $store_item->type ?? '-' }}</p>
        <p><strong>Cost Points:</strong> {{ $store_item->cost_points }}</p>
        <p><strong>Status:</strong>
            <span class="badge bg-{{ $store_item->is_active ? 'success' : 'secondary' }}">
                {{ $store_item->is_active ? 'Active' : 'Inactive' }}
            </span>
        </p>
        <p><strong>Description:</strong><br>{{ $store_item->description ?? '-' }}</p>
        <p><strong>Metadata:</strong><br><code>{{ json_encode($store_item->metadata, JSON_PRETTY_PRINT) }}</code></p>
        <p><strong>Created:</strong> {{ $store_item->created_at->format('Y-m-d H:i') }}</p>
    </div>
</x-admin>
