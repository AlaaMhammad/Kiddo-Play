<x-admin title="Parent-Child Relations">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Parent-Child Relations</h4>
        <a href="{{ route('admin.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Relations</h5>
            {{-- <a href="{{ route('admin.parent-children.create') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-plus"></i> Add Relation
            </a> --}}
        </div>

        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Parent</th>
                            <th>Kid</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($parentChildren as $relation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $relation->parent->name }}</td>
                                <td>{{ $relation->kid->display_name }}</td>
                                <td>
                                    <a href="{{ route('admin.parent-children.show', $relation) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    {{-- <a href="{{ route('admin.parent-children.edit', $relation) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.parent-children.destroy', $relation) }}"
                                        method="POST" style="display:inline-block"
                                        onsubmit="return confirm('Delete this relation?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bx bx-trash"></i></button>
                                    </form> --}}

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $parentChildren->links() }}
            </div>
        </div>
    </div>

</x-admin>
