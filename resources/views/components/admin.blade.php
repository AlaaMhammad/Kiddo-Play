<!doctype html>

<html class="layout-navbar-fixed layout-menu-fixed layout-compact" data-skin="default"
    data-assets-path="{{ asset('dashboard/assets') . '/' }}" data-base-url="{{ url('/') }}"
    data-template="vertical-menu-template" data-bs-theme="light"
    @if (Session::get('locale') == 'ar') dir="rtl" lang="ar" @endif>

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') {{ env('APP_NAME') }}</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('dashboard/assets/img/kiddo.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/fonts/iconify-icons.css') }}" />

    <!-- Core CSS -->
    <!-- build:css assets/vendor/css/theme.css  -->

    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/pickr/pickr-themes.css') }}" />

    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->

    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- endbuild -->

    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <!-- Core CSS -->

    @if (Session::get('locale') == 'ar')
        <link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/core-rtl.css') }}" />
    @endif

    @yield('css')

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('dashboard/assets/vendor/js/helpers.js') }}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    @if (Session::get('locale') == 'en')
        <script>
            // يجب أن يشير هذا المسار إلى المجلد الذي وضعت فيه ملفات "img/customizer"
            const assetsPath = "{{ asset('dashboard/assets/') }}/";
        </script>
        <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
        <script src="{{ asset('dashboard/assets/vendor/js/template-customizer.js') }}"></script>
    @endif

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->

    <script src="{{ asset('dashboard/assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.sidebar')

            <div class="menu-mobile-toggler d-xl-none rounded-1">
                <a href="javascript:void(0);"
                    class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
                    <i class="bx bx-menu icon-base"></i>
                    <i class="bx bx-chevron-right icon-base"></i>
                </a>
            </div>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
                    id="layout-navbar" style="z-index: 10 !important">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="icon-base bx bx-menu icon-md"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
                        <!-- Search -->
                        {{-- <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <a class="nav-item nav-link search-toggler px-0" href="javascript:void(0);">
                                    <span class="d-inline-block text-body-secondary fw-normal" id="autocomplete"></span>
                                </a>
                            </div>
                        </div> --}}

                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                            <!-- Language -->
                            <li class="nav-item dropdown-language dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="icon-base bx bx-globe icon-md"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('en') }}" data-language="en"
                                            data-text-direction="ltr">
                                            <span>@lang('menu.english')</span>
                                        </a>
                                        {{-- <form action="{{ route('change.language') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="lang" value="en">
                                            <button type="submit"
                                                class="dropdown-item {{ Session::get('locale') == 'en' ? 'active' : '' }}">
                                                <span class="align-middle">@lang('menu.english')</span>
                                            </button>
                                        </form> --}}

                                    </li>
                                    {{-- <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-language="fr"
                                            data-text-direction="ltr">
                                            <span>French</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item" href="{{ route('ar') }}" data-language="ar"
                                            data-text-direction="rtl">
                                            <span>@lang('menu.arabic')</span>
                                        </a>
                                        {{-- <form action="{{ route('change.language') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="lang" value="ar">
                                            <button type="submit"
                                                class="dropdown-item {{ Session::get('locale') == 'ar' ? 'active' : '' }}">
                                                <span class="align-middle">@lang('menu.arabic')</span>
                                            </button>
                                        </form> --}}
                                    </li>
                                    {{-- <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-language="de"
                                            data-text-direction="ltr">
                                            <span>German</span>
                                        </a>
                                    </li> --}}
                                </ul>
                            </li>
                            <!--/ Language -->

                            <!-- Style Switcher -->
                            <li class="nav-item dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" id="nav-theme" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <i class="icon-base bx bx-sun icon-md theme-icon-active"></i>
                                    <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                                    <li>
                                        <button type="button" class="dropdown-item align-items-center active"
                                            data-bs-theme-value="light" aria-pressed="false">
                                            <span><i class="icon-base bx bx-sun icon-md me-3"
                                                    data-icon="sun"></i>Light</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item align-items-center"
                                            data-bs-theme-value="dark" aria-pressed="true">
                                            <span><i class="icon-base bx bx-moon icon-md me-3"
                                                    data-icon="moon"></i>Dark</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="dropdown-item align-items-center"
                                            data-bs-theme-value="system" aria-pressed="false">
                                            <span><i class="icon-base bx bx-desktop icon-md me-3"
                                                    data-icon="desktop"></i>System</span>
                                        </button>
                                    </li>
                                </ul>
                            </li>
                            <!-- / Style Switcher-->

                            <!-- Quick links  -->
                            <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <i class="icon-base bx bx-grid-alt icon-md"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-0">
                                    <div class="dropdown-menu-header border-bottom">
                                        <div class="dropdown-header d-flex align-items-center py-3">
                                            <h6 class="mb-0 me-auto">Shortcuts</h6>
                                            <a href="javascript:void(0)" class="dropdown-shortcuts-add py-2"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Add shortcuts"><i
                                                    class="icon-base bx bx-plus-circle text-heading"></i></a>
                                        </div>
                                    </div>
                                    <div class="dropdown-shortcuts-list scrollable-container">
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base bx bx-calendar icon-26px text-heading"></i>
                                                </span>
                                                <a href="app-calendar.html" class="stretched-link">Calendar</a>
                                                <small>Appointments</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base bx bx-food-menu icon-26px text-heading"></i>
                                                </span>
                                                <a href="app-invoice-list.html" class="stretched-link">Invoice App</a>
                                                <small>Manage Accounts</small>
                                            </div>
                                        </div>
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base bx bx-user icon-26px text-heading"></i>
                                                </span>
                                                <a href="app-user-list.html" class="stretched-link">User App</a>
                                                <small>Manage Users</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base bx bx-check-shield icon-26px text-heading"></i>
                                                </span>
                                                <a href="app-access-roles.html" class="stretched-link">Role
                                                    Management</a>
                                                <small>Permission</small>
                                            </div>
                                        </div>
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i
                                                        class="icon-base bx bx-pie-chart-alt-2 icon-26px text-heading"></i>
                                                </span>
                                                <a href="index.html" class="stretched-link">Dashboard</a>
                                                <small>User Dashboard</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base bx bx-cog icon-26px text-heading"></i>
                                                </span>
                                                <a href="pages-account-settings-account.html"
                                                    class="stretched-link">Setting</a>
                                                <small>Account Settings</small>
                                            </div>
                                        </div>
                                        <div class="row row-bordered overflow-visible g-0">
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base bx bx-help-circle icon-26px text-heading"></i>
                                                </span>
                                                <a href="pages-faq.html" class="stretched-link">FAQs</a>
                                                <small>FAQs & Articles</small>
                                            </div>
                                            <div class="dropdown-shortcuts-item col">
                                                <span class="dropdown-shortcuts-icon rounded-circle mb-3">
                                                    <i class="icon-base bx bx-window-open icon-26px text-heading"></i>
                                                </span>
                                                <a href="modal-examples.html" class="stretched-link">Modals</a>
                                                <small>Useful Popups</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- Quick links -->

                            <!-- Notification -->
                            {{-- <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <span class="position-relative">
                                        <i class="icon-base bx bx-bell icon-md"></i>
                                        <span
                                            class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-0">
                                    <li class="dropdown-menu-header border-bottom">
                                        <div class="dropdown-header d-flex align-items-center py-3">
                                            <h6 class="mb-0 me-auto">Notification</h6>
                                            <div class="d-flex align-items-center h6 mb-0">
                                                <span class="badge bg-label-primary me-2">8 New</span>
                                                <a href="javascript:void(0)" class="dropdown-notifications-all p-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Mark all as read"><i
                                                        class="icon-base bx bx-envelope-open text-heading"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-notifications-list scrollable-container">
                                        <ul class="list-group list-group-flush">
                                            <li
                                                class="list-group-item list-group-item-action dropdown-notifications-item">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar">
                                                            <img src="{{ asset('dashboard/assets/img/avatars/1.png') }}"
                                                                alt class="rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="small mb-0">Congratulation Lettie 🎉</h6>
                                                        <small class="mb-1 d-block text-body">Won the monthly best
                                                            seller gold badge</small>
                                                        <small class="text-body-secondary">1h ago</small>
                                                    </div>
                                                    <div class="flex-shrink-0 dropdown-notifications-actions">
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-read"><span
                                                                class="badge badge-dot"></span></a>
                                                        <a href="javascript:void(0)"
                                                            class="dropdown-notifications-archive"><span
                                                                class="icon-base bx bx-x"></span></a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="border-top">
                                        <div class="d-grid p-4">
                                            <a class="btn btn-primary btn-sm d-flex" href="javascript:void(0);">
                                                <small class="align-middle">View all notifications</small>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li> --}}
                            <!--/ Notification -->
                            <!-- Notification -->
                            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                    <span class="position-relative">
                                        <i class="icon-base bx bx-bell icon-md"></i>
                                        <span
                                            class="badge rounded-pill bg-danger badge-dot badge-notifications border"></span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end p-0">
                                    <li class="dropdown-menu-header border-bottom">
                                        <div class="dropdown-header d-flex align-items-center py-3">
                                            <h6 class="mb-0 me-auto">Notification</h6>
                                            <div class="d-flex align-items-center h6 mb-0">
                                                @php
                                                    $unreadCount = app(
                                                        App\Http\Controllers\Admin\Notifications\NotificationController::class,
                                                    )
                                                        ->dropdownNotifications()
                                                        ->where('is_read', false)
                                                        ->count();
                                                @endphp

                                                <span class="badge bg-label-primary me-2">{{ $unreadCount }}
                                                    New</span>
                                                <a href="{{ route('admin.notifications.read') }}"
                                                    class="dropdown-notifications-all p-2" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Mark all as read">
                                                    <i class="icon-base bx bx-envelope-open text-heading"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-notifications-list scrollable-container">
                                        @php
                                            $dropdownNotifications = app(
                                                App\Http\Controllers\Admin\Notifications\NotificationController::class,
                                            )->dropdownNotifications();
                                        @endphp
                                        <ul class="list-group list-group-flush">
                                            @forelse($dropdownNotifications as $notification)
                                                <li
                                                    class="list-group-item list-group-item-action dropdown-notifications-item {{ $notification->is_read ? '' : 'unread' }}">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar">
                                                                <img src="{{ asset('dashboard/assets/img/avatars/1.png') }}"
                                                                    alt class="rounded-circle" />
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="small mb-0">
                                                                {{ $notification->title ?? 'New Notification' }}</h6>
                                                            <small class="mb-1 d-block text-body">
                                                                {{ $notification->body }}
                                                            </small>
                                                            <small class="text-body-secondary">
                                                                {{ $notification->sent_at ? $notification->sent_at->diffForHumans() : $notification->created_at->diffForHumans() }}
                                                            </small>
                                                        </div>
                                                        <div class="flex-shrink-0 dropdown-notifications-actions">
                                                            @if (!$notification->is_read)
                                                                <a href="{{ route('admin.notifications.read') }}"
                                                                    class="dropdown-notifications-read">
                                                                    <span class="badge badge-dot bg-primary"></span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                            @empty
                                                <li class="list-group-item text-center text-muted">
                                                    No notifications yet.
                                                </li>
                                            @endforelse
                                        </ul>
                                    </li>
                                    <li class="border-top">
                                        <div class="d-grid p-4">
                                            <a class="btn btn-primary btn-sm d-flex"
                                                href="{{ route('admin.notifications.index') }}">
                                                <small class="align-middle">View all notifications</small>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!--/ Notification -->
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('dashboard/assets/img/avatars/1.png') }}" alt
                                            class="rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="{{ asset('dashboard/assets/img/avatars/1.png') }}"
                                                            alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                                    <small
                                                        class="text-body-secondary">{{ auth()->user()->role->name }}</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.account.profile') }}">
                                            <i class="icon-base bx bx-user icon-md me-3"></i><span>My Profile</span>
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <a class="dropdown-item" href="pages-account-settings-account.html">
                                            <i class="icon-base bx bx-cog icon-md me-3"></i><span>Settings</span>
                                        </a>
                                    </li> --}}
                                    {{-- <li>
                                        <a class="dropdown-item" href="pages-account-settings-billing.html">
                                            <span class="d-flex align-items-center align-middle">
                                                <i
                                                    class="flex-shrink-0 icon-base bx bx-credit-card icon-md me-3"></i><span
                                                    class="flex-grow-1 align-middle">Billing Plan</span>
                                                <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="pages-pricing.html">
                                            <i class="icon-base bx bx-dollar icon-md me-3"></i><span>Pricing</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="pages-faq.html">
                                            <i class="icon-base bx bx-help-circle icon-md me-3"></i><span>FAQ</span>
                                        </a>
                                    </li> --}}
                                    <li>
                                        <div class="dropdown-divider my-1"></div>
                                    </li>
                                    <li>
                                        <a onclick="event.preventDefault(); document.querySelector('#logout-form').submit() "
                                            class="dropdown-item" href="{{ route('logout') }}">
                                            <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log Out</span>

                                        </a>
                                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        {{ $slot }}
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());
                                    </script>
                                    , made with ❤️ by
                                    <a href="https://github.com/AlaaMhammad" target="_blank"
                                        class="footer-link">ِAlaa
                                        Mhammad</a>
                                </div>
                                {{-- <div class="d-none d-lg-inline-block">
                                    <a href="https://themeselection.com/license/" class="footer-link me-4"
                                        target="_blank">License</a>
                                    <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More
                                        Themes</a>

                                    <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                                        target="_blank" class="footer-link me-4">Documentation</a>

                                    <a href="https://themeselection.com/support/" target="_blank"
                                        class="footer-link d-none d-sm-inline-block">Support</a>
                                </div> --}}
                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/theme.js  -->

    <script src="{{ asset('dashboard/assets/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="{{ asset('dashboard/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('dashboard/assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>

    <script src="{{ asset('dashboard/assets/vendor/libs/pickr/pickr.js') }}"></script>

    <script src="{{ asset('dashboard/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('dashboard/assets/vendor/libs/hammer/hammer.js') }}"></script>

    {{--
    <script src="{{ asset('dashboard/assets/vendor/libs/i18n/i18n.js') }}"></script> --}}

    <script src="{{ asset('dashboard/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('dashboard/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->

    <script src="{{ asset('dashboard/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('dashboard/assets/js/dashboards-analytics.js') }}"></script>


    @yield('js')
</body>

</html>
