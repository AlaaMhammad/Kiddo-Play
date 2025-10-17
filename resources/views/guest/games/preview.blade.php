<x-guest title="Games Preview">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Games Preview</h4>
        <a href="{{ route('guest.home') }}" class="btn btn-label-primary">
            <i class="bx bx-arrow-back"></i> Back
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Available Games</h5>
        </div>

        <div class="card-body">
            <div class="row">
                @forelse($games ?? [] as $game)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 text-center shadow-sm">
                            <img src="{{ asset($game->thumbnail ?? 'dashboard/assets/img/default-game.png') }}"
                                class="card-img-top" style="height:180px;object-fit:cover;">
                            <div class="card-body">
                                <h6 class="fw-bold">{{ $game->title }}</h6>
                                <p class="text-muted small">{{ Str::limit($game->description, 70) }}</p>
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-play"></i> Try Demo
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">No games available yet.</div>
                @endforelse
            </div>
        </div>
    </div>

</x-guest>
