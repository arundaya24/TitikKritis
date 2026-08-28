<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Titik Kritis - {{ $title ?? 'Platform Kritik Masyarakat' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dark-mode-user.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        .navbar-brand {
            font-weight: bold;
            color: #0d6efd !important;
        }

        .navbar-brand i {
            font-size: 1.5rem;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        .card-header {
            background-color: #0d6efd;
            color: white;
            border-radius: 15px 15px 0 0 !important;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        .footer {
            background-color: #212529;
            color: white;
            padding: 20px 0;
            margin-top: 50px;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #0d6efd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            transition: background-color 0.3s, color 0.3s;
        }

        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
        }

        .badge-dikirim {
            background-color: #ffc107;
            color: #000;
        }

        .badge-ditinjau {
            background-color: #17a2b8;
            color: #fff;
        }

        .badge-diproses {
            background-color: #007bff;
            color: #fff;
        }

        .badge-selesai {
            background-color: #28a745;
            color: #fff;
        }

        .badge-ditolak {
            background-color: #dc3545;
            color: #fff;
        }

        .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
            color: #0d6efd;
        }

        .stat-card .label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .stat-card .icon {
            font-size: 2rem;
            color: #0d6efd;
            opacity: 0.3;
        }

        .theme-toggle-user {
            cursor: pointer;
            font-size: 1.2rem;
            padding: 5px 10px;
            border-radius: 20px;
            transition: all 0.3s;
            background: transparent;
            border: none;
            color: #0d6efd;
        }

        .theme-toggle-user:hover {
            background: rgba(13, 110, 253, 0.1);
        }

        body.dark-mode .theme-toggle-user {
            color: #ffd54f;
        }

        body.dark-mode .theme-toggle-user:hover {
            background: rgba(255, 213, 79, 0.1);
        }

        /* ===== PERBAIKAN: Biar semua nav-item sejajar ===== */
        .navbar-nav .nav-item {
            display: flex;
            align-items: center;
        }

        .navbar-nav .nav-link {
            padding-top: 8px;
            padding-bottom: 8px;
            line-height: 1.5;
        }

        .navbar-nav .dropdown .nav-link {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .navbar-nav .nav-item .theme-toggle-user {
            padding-top: 8px;
            padding-bottom: 8px;
            display: flex;
            align-items: center;
        }

        @media (max-width: 991.98px) {
            .navbar-nav {
                margin-top: 10px;
            }
            .navbar-nav .nav-item {
                margin-top: 5px;
                margin-bottom: 5px;
            }
            .theme-toggle-user {
                margin-left: 0;
                padding-left: 0;
            }
        }
    </style>
</head>

<body>
    @auth
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                {{-- Brand --}}
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-exclamation-triangle"></i> Titik Kritis
                </a>

                {{-- Badge --}}
                @if (auth()->user()->isAdmin())
                    <span class="badge bg-danger me-2">Admin</span>
                @else
                    <span class="badge bg-info me-2">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ auth()->user()->district->name ?? 'Wilayah' }}
                    </span>
                @endif

                {{-- Toggler --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                {{-- Navbar Items --}}
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        {{-- Menu User --}}
                        @if (!auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                                    href="{{ route('home') }}">
                                    <i class="fas fa-home"></i> Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('statistic.index') ? 'active' : '' }}"
                                    href="{{ route('statistic.index') }}">
                                    <i class="fas fa-chart-bar"></i> Statistik
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('critique.create') ? 'active' : '' }}"
                                    href="{{ route('critique.create') }}">
                                    <i class="fas fa-pen"></i> Kritik
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('critique.history') ? 'active' : '' }}"
                                    href="{{ route('critique.history') }}">
                                    <i class="fas fa-history"></i> History Kritik
                                </a>
                            </li>
                        @else
                            {{-- Menu Admin --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                    href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-chart-line"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.critiques.*') ? 'active' : '' }}"
                                    href="{{ route('admin.critiques.index') }}">
                                    <i class="fas fa-list"></i> Kritik
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                                    href="{{ route('admin.users.index') }}">
                                    <i class="fas fa-users-cog"></i> Admin
                                </a>
                            </li>
                        @endif

                        {{-- Dark Mode Toggle --}}
                        <li class="nav-item d-flex align-items-center">
                            <button class="theme-toggle-user" id="userThemeToggle" title="Ganti Mode">
                                <i class="fas fa-moon" id="userThemeIcon"></i>
                            </button>
                        </li>

                        {{-- Profile Dropdown --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="profile-image me-1">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">
                                        <i class="fas fa-user-circle"></i> Profile
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endauth

    <main class="py-4">
        @yield('content')
    </main>

    @if (!auth()->user()?->isAdmin())
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h5><i class="fas fa-exclamation-triangle"></i> Titik Kritis</h5>
                        <p>Platform kritik masyarakat untuk pemerintah daerah.</p>
                    </div>
                    <div class="col-md-4">
                        <h5>Tentang</h5>
                        <ul class="list-unstyled">
                            <li><a href="#">Tentang Kami</a></li>
                            <li><a href="#">Kebijakan Privasi</a></li>
                            <li><a href="#">Syarat & Ketentuan</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5>Kontak</h5>
                        <p><i class="fas fa-envelope"></i> info@titikkritis.com</p>
                        <p><i class="fas fa-phone"></i> (021) 1234-5678</p>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <p>&copy; {{ date('Y') }} Titik Kritis. All rights reserved.</p>
                </div>
            </div>
        </footer>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });

        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('userThemeToggle');
            const icon = document.getElementById('userThemeIcon');

            if (localStorage.getItem('theme') === 'dark') {
                document.body.classList.add('dark-mode');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }

            if (toggle) {
                toggle.addEventListener('click', function() {
                    document.body.classList.toggle('dark-mode');

                    if (document.body.classList.contains('dark-mode')) {
                        localStorage.setItem('theme', 'dark');
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                    } else {
                        localStorage.setItem('theme', 'light');
                        icon.classList.remove('fa-sun');
                        icon.classList.add('fa-moon');
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
