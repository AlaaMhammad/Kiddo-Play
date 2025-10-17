<x-guest title="Sample Lessons">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Sample Lessons</h4>
        <a href="{{ route('guest.home') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Available Lessons</h5>
        </div>

        <div class="card-body">
            <div class="row">
                @forelse($lessons ?? [] as $lesson)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-bold">{{ $lesson->title }}</h6>
                                <p class="text-muted small">{{ Str::limit($lesson->summary, 60) }}</p>
                                <a href="#" class="btn btn-outline-success btn-sm">
                                    <i class="bx bx-book-reader"></i> Read
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">No lessons to show.</div>
                @endforelse
            </div>
        </div>
    </div>

</x-guest>
