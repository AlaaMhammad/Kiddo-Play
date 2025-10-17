@props(['title' => 'KiddoPlay'])

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | KiddoPlay</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('dashboard/assets/img/kiddo.png') }}" />

    <!-- Bootstrap & Boxicons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f0f4f8;
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar */
        nav.navbar {
            background: linear-gradient(90deg, #3b82f6, #60a5fa);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
        }

        .navbar-brand {
            font-weight: 700;
            color: #fff !important;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.3rem;
        }

        .navbar-brand img {
            height: 50px;
            width: 100px;
            object-fit: cover;
            border-radius: 10px;
            background-color: #f0f4f8;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .nav-link {
            color: #fff !important;
            font-weight: 500;
            margin: 0 0.3rem;
            transition: 0.3s;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #ffd166 !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0%;
            height: 3px;
            bottom: -5px;
            left: 0;
            background-color: #ffd166;
            transition: width 0.3s;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .btn-login {
            background-color: #ff7f50;
            color: #fff;
            font-weight: 600;
            border-radius: 8px;
            padding: 6px 18px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #ff6333;
            color: #fff;
        }

        footer {
            background: #fff;
            border-top: 1px solid #e3e3e3;
            color: #555;
            padding: 20px 0;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body>

    {{-- 🔹 Navbar --}}
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('guest.home') }}">
                <img src="{{ asset('dashboard/assets/img/kiddo.png') }}" alt="Logo">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarGuest" aria-controls="navbarGuest" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class='bx bx-menu fs-2 text-white'></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarGuest">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center text-center text-lg-start">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('guest.home') ? 'active' : '' }}"
                            href="{{ route('guest.home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('guest.games.preview') ? 'active' : '' }}"
                            href="{{ route('guest.games.preview') }}">Games</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('guest.lessons.sample') ? 'active' : '' }}"
                            href="{{ route('guest.lessons.sample') }}">Lessons</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('guest.about') ? 'active' : '' }}"
                            href="{{ route('guest.about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('guest.contact') ? 'active' : '' }}"
                            href="{{ route('guest.contact') }}">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a href="{{ route('login') }}" class="btn btn-login">Login</a>
                    </li>
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
