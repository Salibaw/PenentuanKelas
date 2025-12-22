<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <title>Dashboard - SMPN 2 Sumenep</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css">
    <style>
        :root {
            --sidebar-bg: #ffffff;
            --main-bg: #f4f6fa;
            --accent-color: #206bc4;
        }

        body {
            background-color: var(--main-bg);
        }

        .navbar-vertical {
            background-color: var(--sidebar-bg);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, 0.07);
        }

        .card-status-top {
            height: 4px;
        }
    </style>
</head>

<body>
    <div class="page">
        <aside class="navbar navbar-vertical navbar-expand-lg navbar-light shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <h1 class="navbar-brand navbar-brand-autodark mt-2">
                    <a href="{{ url('/dashboard') }}" class="d-flex align-items-center text-decoration-none">
                        <img src="{{ asset('assets/img/logo2.png') }}"
                            alt="Logo SMPN 2 Sumenep"
                            style="height: 35px; width: auto;"
                            class="navbar-brand-image me-2">
                        <span class="h3 fw-bolder text-primary mb-0">SMPN 2 Sumenep</span>
                    </a>
                </h1>

                <div class="collapse navbar-collapse" id="sidebar-menu">
                    <ul class="navbar-nav pt-lg-3">

                        <li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/dashboard') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block text-azure">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <polyline points="5 12 3 12 12 3 21 12 19 12" />
                                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Dashboard</span>
                            </a>
                        </li>

                        <div class="hr-text hr-text-left mt-4 mb-2 text-muted" style="font-size: 10px; letter-spacing: 1px;">DATA MASTER</div>

                        <li class="nav-item {{ Request::is('alternatif*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/alternatif') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block text-blue">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="9" cy="7" r="4" />
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Data Siswa</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Request::is('walikelas*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/walikelas') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block text-purple">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                        <path d="M12 12l0 9" />
                                        <path d="M9 18l3 3l3 -3" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Wali Kelas</span>
                            </a>
                        </li>

                        <div class="hr-text hr-text-left mt-4 mb-2 text-muted" style="font-size: 10px; letter-spacing: 1px;">PROSES SPK</div>

                        <li class="nav-item {{ Request::is('kriteria*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/kriteria') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block text-orange">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                        <path d="M9 9l1 0" />
                                        <path d="M9 13l6 0" />
                                        <path d="M9 17l6 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Kriteria SMART</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Request::is('penilaian*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/penilaian') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block text-green">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 5h10l2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14l2 -2h2" />
                                        <polyline points="9 3 9 5 15 5 15 3" />
                                        <path d="M9 17l6 0" />
                                        <path d="M9 13l6 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Input Penilaian</span>
                            </a>
                        </li>

                        <li class="nav-item {{ Request::is('perangkingan*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ url('/perangkingan') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block text-red">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M12 7v5l3 3" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">Hasil Perangkingan</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </aside>

        <div class="page-wrapper">
            <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
                <div class="container-xl">
                    <div class="navbar-nav flex-row order-md-last">
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                                <span class="avatar avatar-sm" style="background-image: url(https://via.placeholder.com/150)"></span>
                                <div class="d-none d-xl-block ps-2">
                                    <div>Admin System</div>
                                    <div class="mt-1 small text-muted">Administrator</div>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                        <path d="M13.5 6.5l4 4" />
                                    </svg>
                                    Edit Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon text-danger" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                        <path d="M9 12h12l-3 -3" />
                                        <path d="M18 15l3 -3" />
                                    </svg>
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="collapse navbar-collapse" id="navbar-menu">
                        <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                            <h2 class="page-title text-dark">Selamat Datang, Admin</h2>
                        </div>
                    </div>
                </div>
            </header>

            <main class="page-content">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>

    @stack('myscript')
</body>

</html>