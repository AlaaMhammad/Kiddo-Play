<x-admin title="Edit Avatar">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit Avatar</h4>
        <a href="{{ route('admin.avatars.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.avatars.update', $avatar) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="{{ $avatar->name }}" class="form-control @error('name') is-invalid
                    @enderror">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Current Image</label><br>
                    <img src="{{ asset('storage/' . $avatar->image_url) }}" width="80" height="80" class="rounded mb-2">
                    <input type="file" name="image_url" class="form-control mt-2 @error('image_url') is-invalid
                    @enderror">
                    @error('image_url')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Cost Points</label>
                    <input type="number" name="cost_points" value="{{ $avatar->cost_points }}" class="form-control @error('cost_points') is-invalid
                    @enderror" min="0">
                    @error('cost_points')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-check form-switch mb-3">
                    <input type="checkbox" name="is_active" class="form-check-input @error('is_active') is-invalid
                    @enderror" {{ $avatar->is_active ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                    @error('is_active')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</x-admin>
