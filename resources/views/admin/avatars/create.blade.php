<x-admin title="Add Avatar">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Add New Avatar</h4>
        <a href="{{ route('admin.avatars.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.avatars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid
                    @enderror">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image_url" class="form-control @error('image_url') is-invalid
                    @enderror" required>
                    @error('image_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Cost Points</label>
                    <input type="number" name="cost_points" class="form-control @error('cost_points') is-invalid
                    @enderror" min="0" required>
                    @error('cost_points')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="is_active" class="form-check-input @error('is_active') is-invalid
                    @enderror" checked>
                    <label class="form-check-label">Active</label>
                    @error('is_active')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</x-admin>
