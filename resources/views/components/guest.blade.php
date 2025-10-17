@props(['title' => 'KiddoPlay'])

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | KiddoPlay</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('dashboard/assets/img/kiddo.png') }}" />

    {{-- Bootstrap & Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f5f7fa;
            font-family: 'Poppins', sans-serif;
        }

        nav.navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: 700;
            color: #3b82f6 !important;
            letter-spacing: 0.5px;
        }

        footer {
            background: #fff;
            border-top: 1px solid #e3e3e3;
            color: #777;
            padding: 15px 0;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .btn-primary {
            background-color: #3b82f6;
            border: none;
        }

        .btn-label-primary {
            color: #3b82f6;
            border: 1px solid #3b82f6;
            background: transparent;
        }

        .btn-label-primary:hover {
            background: #3b82f6;
            color: #fff;
        }
    </style>
</head>

<body>

    {{-- 🔹 Navbar --}}
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('guest.home') }}">
                <img src="{{ asset('dashboard/assets/img/kiddo.png') }}" alt="icon"
                    style="height: 50px; width: 50px; object-fit: contain;"> KiddoPlay
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarGuest"
                aria-controls="navbarGuest" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarGuest">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('guest.home') ? 'fw-bold text-primary' : '' }}"
                            href="{{ route('guest.home') }}">Home</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('guest.games.preview') ? 'fw-bold text-primary' : '' }}"
                            href="{{ route('guest.games.preview') }}">Games</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('guest.lessons.sample') ? 'fw-bold text-primary' : '' }}"
                            href="{{ route('guest.lessons.sample') }}">Lessons</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('guest.about') ? 'fw-bold text-primary' : '' }}"
                            href="{{ route('guest.about') }}">About</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('guest.contact') ? 'fw-bold text-primary' : '' }}"
                            href="{{ route('guest.contact') }}">Contact</a></li>
                    <li class="nav-item"><a
                            class="nav-link {{ request()->routeIs('login') ? 'fw-bold text-primary' : '' }}"
                            href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- 🔹 Main Content --}}
    <main class="container py-5">
        {{ $slot }}
    </main>

    {{-- 🔹 Footer --}}
    <footer class="text-center mt-5">
        <div class="container">
            <p class="mb-0 small">&copy; {{ date('Y') }} KiddoPlay — All Rights Reserved</p>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
