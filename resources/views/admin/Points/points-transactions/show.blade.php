<x-admin title="Transaction Details">
    <div class="mb-4">
        <a href="{{ route('admin.points-transactions.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <h4 class="fw-bold mb-3">Transaction #{{ $pointsTransaction->id }}</h4>
        <p><strong>Kid:</strong> {{ $pointsTransaction->kid->display_name ?? '-' }}</p>
        <p><strong>Type:</strong> {{ ucfirst($pointsTransaction->type) }}</p>
        <p><strong>Amount:</strong> {{ $pointsTransaction->amount }}</p>
        <p><strong>Source:</strong> {{ $pointsTransaction->source ?? '-' }}</p>
        <p><strong>Reference ID:</strong> {{ $pointsTransaction->reference_id ?? '-' }}</p>

        @if ($pointsTransaction->meta)
            <hr>
            <p><strong>Meta:</strong></p>
            <pre>{{ json_encode($pointsTransaction->meta, JSON_PRETTY_PRINT) }}</pre>
        @endif
    </div>
</x-admin>
