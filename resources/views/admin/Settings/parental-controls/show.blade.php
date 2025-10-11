<x-admin title="View Parental Control">
    <div class="mb-4">
        <a href="{{ route('admin.parental-controls.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <table class="table table-borderless">
            <tr>
                <th>Parent:</th>
                <td>{{ $parentalControl->parent->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Kid:</th>
                <td>{{ $parentalControl->kid->display_name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Daily Play Minutes Limit:</th>
                <td>{{ $parentalControl->daily_play_minutes_limit ?? 'Unlimited' }} min</td>
            </tr>
            <tr>
                <th>Content Level:</th>
                <td>{{ ucfirst(str_replace('_', ' ', $parentalControl->content_level)) }}</td>
            </tr>
            <tr>
                <th>Purchases Enabled:</th>
                <td>{{ $parentalControl->purchases_enabled ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th>Rules:</th>
                <td>
                    <pre>{{ json_encode($parentalControl->rules, JSON_PRETTY_PRINT) }}</pre>
                </td>
            </tr>
            <tr>
                <th>Created At:</th>
                <td>{{ $parentalControl->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <th>Updated At:</th>
                <td>{{ $parentalControl->updated_at->format('Y-m-d H:i') }}</td>
            </tr>
        </table>
    </div>
</x-admin>
