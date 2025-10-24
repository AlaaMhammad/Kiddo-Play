<x-admin title="OTP Details">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">OTP Details</h4>
        <a href="{{ route('admin.otps.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card p-4">
        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $otp->id }}</td>
            </tr>
            <tr>
                <th>Code</th>
                <td>{{ $otp->code }}</td>
            </tr>
            <tr>
                <th>User</th>
                <td>{{ $otp->user?->name ?? '—' }}</td>
            </tr>
            <tr>
                <th>Purpose</th>
                <td>{{ $otp->purpose ?? '—' }}</td>
            </tr>
            <tr>
                <th>Expires At</th>
                <td>{{ $otp->expires_at->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <th>Used</th>
                <td>{{ $otp->used ? 'Yes' : 'No' }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $otp->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $otp->updated_at->format('Y-m-d H:i') }}</td>
            </tr>
        </table>
    </div>

</x-admin>
