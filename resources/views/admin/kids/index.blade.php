<x-admin title="Kids List">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Kids Management</h4>

        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>


    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Kids</h5>
            <a href="{{ route('admin.kids.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add New Kid
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Display Name</th>
                            <th>Parent</th>
                            <th>Gender</th>
                            <th>Points</th>
                            <th>Avatar</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kids as $kid)
                            <tr>
                                <td>{{ $kids->firstItem() + $loop->index }}</td>
                                <td>{{ $kid->display_name }}</td>
                                <td>{{ $kid->user->name ?? '-' }}</td>
                                <td>{{ ucfirst($kid->gender ?? '-') }}</td>
                                <td>{{ $kid->points }}</td>
                                <td>
                                    @if ($kid->avatar)
                                        <img src="{{ asset($kid->avatar->image_url) }}" alt="avatar" width="40"
                                            height="40" class="rounded-circle">
                                    @else
                                        <span class="text-muted">No Avatar</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <!-- زر عرض الحساب -->
                                    <button class="btn btn-sm btn-secondary show-auth-btn" data-id="{{ $kid->id }}">
                                        <i class="bx bx-user-circle"></i>
                                    </button>
                                    <a href="{{ route('admin.kids.show', $kid->id) }}" class="btn btn-sm btn-info"><i
                                            class="bx bx-show"></i></a>
                                    <a href="{{ route('admin.kids.edit', $kid->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i></a>
                                    <form action="{{ route('admin.kids.destroy', $kid->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this kid?')"><i
                                                class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">No kids found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Modal for Kid Account -->
                <div class="modal fade" id="kidAuthModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Kid Authentication Info</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Name:</strong> <span id="kidName"></span></p>
                                <p><strong>Email:</strong> <span id="kidEmail"></span></p>
                                <p><strong>Password:</strong> <span id="kidPassword"></span></p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="mt-4">
                {{ $kids->links() }}
            </div>
        </div>
    </div>

    @section('js')
        <script>
            $(document).ready(function() {
                $('.show-auth-btn').click(function() {
                    let kidId = $(this).data('id');
                    $.get('/admin/kids/' + kidId + '/show-auth', function(res) {
                        if (res.success) {
                            $('#kidName').text(res.kid_name);
                            $('#kidEmail').text(res.email);
                            $('#kidPassword').text(res.password);
                            $('#kidAuthModal').modal('show');
                        } else {
                            alert(res.error);
                        }
                    });
                });
            });
        </script>
    @endsection
</x-admin>
