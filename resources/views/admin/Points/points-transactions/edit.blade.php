<x-admin title="Edit Points Transaction">
    <div class="mb-4">
        <a href="{{ route('admin.points-transactions.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.points-transactions.update', $pointsTransaction->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.select name="kid_id" label="Kid" :options="$kids->pluck('display_name', 'id')" :selected="$pointsTransaction->kid_id" required />

            <x-form.select name="type" label="Type" :options="['earn' => 'Earn', 'spend' => 'Spend', 'adjust' => 'Adjust']" :selected="$pointsTransaction->type" required />

            <x-form.input type="number" name="amount" label="Amount" :value="$pointsTransaction->amount" required />
            <x-form.input type="text" name="source" label="Source" :value="$pointsTransaction->source" />
            <x-form.input type="number" name="reference_id" label="Reference ID" :value="$pointsTransaction->reference_id" />
            <x-form.textarea name="meta" label="Meta (JSON)" :value="json_encode($pointsTransaction->meta, JSON_PRETTY_PRINT)" />

            <button class="btn btn-success">Update Transaction</button>
        </form>
    </div>
</x-admin>
