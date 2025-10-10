<x-admin title="Purchase Details">
    <div class="mb-4">
        <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h4 class="mb-4 fw-bold">Purchase Information</h4>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Kid:</strong>
                <p class="mb-0">{{ $purchase->kid->display_name ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <strong>Store Item:</strong>
                <p class="mb-0">{{ $purchase->storeItem->title ?? '-' }}</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <strong>Points Used:</strong>
                <p class="mb-0">{{ $purchase->points_used }}</p>
            </div>
            <div class="col-md-6">
                <strong>Created At:</strong>
                <p class="mb-0">{{ $purchase->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        @if ($purchase->details)
            <div class="mb-3">
                <strong>Details:</strong>
                <pre class="bg-light p-3 rounded">{{ json_encode($purchase->details, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        @endif
    </div>
</x-admin>
