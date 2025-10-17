<x-guest title="Welcome to KiddoPlay">

    {{-- 🔹 Hero Section --}}
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">Welcome to KiddoPlay</h1>
        <p class="lead text-secondary">Learn, play, and explore exciting games and lessons!</p>
        <a href="{{ route('guest.about') }}" class="btn btn-gradient-primary btn-lg fw-bold">
            <i class="bx bx-info-circle"></i> About Us
        </a>
    </div>

    {{-- 🔹 Alerts --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 🔹 Featured Games --}}
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-primary">🎮 Featured Games</h3>
            <a href="{{ route('guest.games.preview') }}" class="btn btn-light btn-sm fw-bold">
                View All <i class="bx bx-joystick"></i>
            </a>
        </div>
        <div class="row g-3">
            @foreach ($featuredGames ?? [] as $game)
                <div class="col-sm-6 col-md-4">
                    <div class="card h-100 shadow game-card">
                        <img src="{{ $game->thumbnail ? Storage::url($game->thumbnail) : asset('dashboard/assets/img/default-game.png') }}"
                            class="card-img-top" alt="{{ $game->title }}" style="height:180px; object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary fw-bold">{{ $game->title }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($game->description, 60) }}</p>
                            <a href="{{ route('guest.games.preview') }}"
                                class="btn btn-gradient-primary mt-auto fw-bold">
                                <i class="bx bx-play"></i> Play Demo
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- 🔹 Sample Lessons --}}
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-info">📚 Sample Lessons</h3>
            <a href="{{ route('guest.lessons.sample') }}" class="btn btn-light btn-sm fw-bold">
                Explore <i class="bx bx-book-open"></i>
            </a>
        </div>
        <div class="row g-3">
            @foreach ($sampleLessons ?? [] as $lesson)
                <div class="col-sm-6 col-md-4">
                    <div class="card h-100 shadow lesson-card">
                        <img src="{{ $lesson->thumbnail ? Storage::url($lesson->thumbnail) : asset('dashboard/assets/img/default-lesson.png') }}"
                            class="card-img-top" alt="{{ $lesson->title }}" style="height:180px; object-fit:cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-info fw-bold">{{ $lesson->title }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($lesson->summary, 60) }}</p>
                            <a href="{{ route('guest.lessons.sample') }}"
                                class="btn btn-gradient-success mt-auto fw-bold">
                                <i class="bx bx-show"></i> View Sample
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</x-guest>

{{-- 🔹 Styles --}}
<style>
    /* Gradient buttons */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #ff6a00, #ffb347);
        color: #fff;
        border: none;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(135deg, #ff8c42, #ffc97b);
        color: #fff;
    }

    .btn-gradient-success {
        background: linear-gradient(135deg, #43e97b, #38f9d7);
        color: #fff;
        border: none;
    }

    .btn-gradient-success:hover {
        background: linear-gradient(135deg, #6ef2a0, #64f5e3);
        color: #fff;
    }

    /* Cards hover effect */
    .game-card,
    .lesson-card {
        border-radius: 20px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .game-card:hover,
    .lesson-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    /* Responsive paddings */
    @media (max-width: 576px) {
        .card-body {
            padding: 1rem;
        }
    }
</style>
