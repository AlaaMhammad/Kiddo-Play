<x-admin title="Edit Parent-Child Relation">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Edit Relation</h4>
        <a href="{{ route('admin.parent-children.index') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.parent-children.update', $parentChild) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="parent_id" class="form-label">Parent</label>
                    <select name="parent_id" id="parent_id"
                        class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">Select Parent</option>
                        @foreach($parents as $id => $name)
                            <option value="{{ $id }}" {{ old('parent_id', $parentChild->parent_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kid_id" class="form-label">Kid</label>
                    <select name="kid_id" id="kid_id" class="form-select @error('kid_id') is-invalid @enderror">
                        <option value="">Select Kid</option>
                        @foreach($kids as $id => $display_name)
                            <option value="{{ $id }}" {{ old('kid_id', $parentChild->kid_id) == $id ? 'selected' : '' }}>
                                {{ $display_name }}</option>
                        @endforeach
                    </select>
                    @error('kid_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Relation</button>
            </form>
        </div>
    </div>

</x-admin>
