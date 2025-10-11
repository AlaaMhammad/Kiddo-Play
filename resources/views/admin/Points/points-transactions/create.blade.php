<x-admin title="Add Points Transaction">
    <div class="mb-4">
        <a href="{{ route('admin.points-transactions.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <form action="{{ route('admin.points-transactions.store') }}" method="POST">
            @csrf

            <x-form.select name="kid_id" label="Kid" :options="$kids->pluck('display_name', 'id')" required placeholder="Select Kid" />

            <x-form.select name="type" label="Type" :options="['earn' => 'Earn', 'spend' => 'Spend', 'adjust' => 'Adjust']" required placeholder="Select Type" />

            <x-form.input type="number" name="amount" label="Amount" required />
            <x-form.input type="text" name="source" label="Source (optional)" />
            <x-form.input type="number" name="reference_id" label="Reference ID (optional)" />
            <x-form.textarea name="meta" label="Meta (JSON)" placeholder='{"reason": "Rewarded for quiz"}' />

            <button class="btn btn-primary">Save Transaction</button>
        </form>
    </div>
</x-admin>
