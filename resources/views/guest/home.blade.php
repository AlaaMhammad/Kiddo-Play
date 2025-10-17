<x-guest title="Welcome to KiddoPlay">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Welcome to KiddoPlay</h4>
        <a href="{{ route('guest.about') }}" class="btn btn-label-primary">
            <i class="bx bx-info-circle"></i> About Us
        </a>
    </div>

    {{-- تنبيهات --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- قسم الألعاب --}}
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Featured Games</h5>
            <a href="{{ route('guest.games.preview') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-joystick"></i> View All
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                @foreach ($featuredGames ?? [] as $game)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 text-center shadow-sm">
                            <img src="{{ asset($game->thumbnail ?? 'dashboard/assets/img/default-game.png') }}"
                                alt="Game" class="card-img-top" style="height:180px;object-fit:cover;">
                            <div class="card-body">
                                <h6 class="fw-bold">{{ $game->title }}</h6>
                                <p class="text-muted small">{{ Str::limit($game->description, 60) }}</p>
                                <a href="{{ route('guest.games.preview') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-play"></i> Play Demo
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- قسم الدروس --}}
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Sample Lessons</h5>
            <a href="{{ route('guest.lessons.sample') }}" class="btn btn-primary btn-sm">
                <i class="bx bx-book-open"></i> Explore
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                @foreach ($sampleLessons ?? [] as $lesson)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <h6 class="fw-bold">{{ $lesson->title }}</h6>
                                <p class="text-muted small">{{ Str::limit($lesson->summary, 60) }}</p>
                                <a href="{{ route('guest.lessons.sample') }}" class="btn btn-outline-success btn-sm">
                                    <i class="bx bx-show"></i> View Sample
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</x-guest>
