<x-admin title="Verification Emails">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Verification Emails</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Verification Emails</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Token</th>
                            <th>OTP</th>
                            <th>Expire</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($verifications as $v)
                            <tr>
                                <td>{{ $verifications->firstItem() + $loop->index }}</td>
                                <td>{{ $v->email }}</td>
                                <td>{{ $v->token }}</td>
                                <td>{{ $v->otp }}</td>
                                <td>{{ $v->expire }}</td>
                                <td>{{ $v->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $v->updated_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $verifications->links() }}
            </div>
        </div>
    </div>
</x-admin>
