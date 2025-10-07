<x-admin title="View Parent-Child Relation">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">View Relation</h4>
        <a href="{{ route('admin.parent-children.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <p><strong>Parent:</strong> {{ $parentChild->parent->name }}</p>
            <p><strong>Kid:</strong> {{ $parentChild->kid->display_name }}</p>
        </div>
    </div>

</x-admin>
