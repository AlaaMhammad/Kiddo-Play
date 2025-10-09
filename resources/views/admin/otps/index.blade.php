<x-admin title="OTPs Management">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">OTPs Management</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All OTPs</h5>
            <a href="{{ route('admin.otps.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>User</th>
                            <th>Purpose</th>
                            <th>Expires At</th>
                            <th>Used</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($otps as $otp)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $otp->code }}</td>
                                <td>{{ $otp->user?->name ?? '—' }}</td>
                                <td>{{ $otp->purpose ?? '—' }}</td>
                                <td>{{ $otp->expires_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $otp->used ? 'Yes' : 'No' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.otps.show', $otp->id) }}" class="btn btn-sm btn-info"><i
                                            class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.otps.edit', $otp->id) }}" class="btn btn-sm btn-warning"><i
                                            class="bx bx-edit"></a>
                                    <form action="{{ route('admin.otps.destroy', $otp->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this OTP?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No OTPs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $otps->links() }}
            </div>
        </div>
    </div>
</x-admin>
