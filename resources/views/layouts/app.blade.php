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

        /* Biar semua nav-item sejajar */
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

        /* Avatar Navbar */
        .navbar-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #0d6efd;
        }

        /* ===== FOOTER STICKY DI BAWAH ===== */
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main.py-4 {
            flex: 1;
        }

        .footer {
            margin-top: auto;
            background-color: #212529;
            color: #ced4da;
            padding: 40px 0 20px;
            border-top: 3px solid #0d6efd;
            width: 100%;
        }

        .hover-text-primary:hover {
            color: #0d6efd !important;
            transition: color 0.3s ease;
        }

        /* Dark mode footer */
        body.dark-mode .footer {
            background-color: #0d1b2a !important;
            border-top-color: #4fc3f7 !important;
        }

        body.dark-mode .footer .text-secondary {
            color: #b0b0b0 !important;
        }

        body.dark-mode .footer .text-white {
            color: #e0e0e0 !important;
        }

        /* Dark mode avatar border */
        body.dark-mode .navbar-avatar {
            border-color: #4fc3f7 !important;
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
                <a class="navbar-brand" href="{{ route('home') }}">
                    <i class="fas fa-exclamation-triangle"></i> Titik Kritis
                </a>

                @if (auth()->user()->isAdmin())
                    <span class="badge bg-danger me-2">Admin</span>
                @else
                    <span class="badge bg-info me-2">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ auth()->user()->district->name ?? 'Wilayah' }}
                    </span>
                @endif

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
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

                        {{-- Google Translate --}}
                        <li class="nav-item d-flex align-items-center">
                            <div id="google_translate_element" class="me-2"></div>
                        </li>

                        {{-- Dark Mode Toggle --}}
                        <li class="nav-item d-flex align-items-center">
                            <button class="theme-toggle-user" id="userThemeToggle" title="Ganti Mode">
                                <i class="fas fa-moon" id="userThemeIcon"></i>
                            </button>
                        </li>

                        {{-- Profile Dropdown dengan Avatar --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="navbar-avatar me-1">
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
                    <div class="col-lg-4 col-md-6 mb-4">
                        <h5 class="text-white fw-bold">
                            <i class="fas fa-exclamation-triangle text-primary me-2"></i>Titik Kritis
                        </h5>
                        <p class="text-secondary" style="font-size: 0.95rem;">
                            Platform kritik dan aspirasi masyarakat untuk
                            <span class="text-white">pemerintah daerah</span> yang lebih
                            transparan, akuntabel, dan responsif terhadap kebutuhan rakyat.
                        </p>
                        <div class="mt-3">
                            <a href="#" class="text-secondary me-3"><i class="fab fa-facebook fa-lg"></i></a>
                            <a href="#" class="text-secondary me-3"><i class="fab fa-twitter fa-lg"></i></a>
                            <a href="#" class="text-secondary me-3"><i class="fab fa-instagram fa-lg"></i></a>
                            <a href="#" class="text-secondary me-3"><i class="fab fa-youtube fa-lg"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-6 mb-4">
                        <h6 class="text-white fw-bold">Tautan Cepat</h6>
                        <ul class="list-unstyled" style="font-size: 0.9rem;">
                            <li class="mb-2"><a href="{{ route('home') }}"
                                    class="text-secondary text-decoration-none hover-text-primary">Beranda</a></li>
                            <li class="mb-2"><a href="{{ route('critique.create') }}"
                                    class="text-secondary text-decoration-none hover-text-primary">Kirim Kritik</a>
                            </li>
                            <li class="mb-2"><a href="{{ route('critique.history') }}"
                                    class="text-secondary text-decoration-none hover-text-primary">History Kritik</a>
                            </li>
                            <li class="mb-2"><a href="{{ route('statistic.index') }}"
                                    class="text-secondary text-decoration-none hover-text-primary">Statistik</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <h6 class="text-white fw-bold">Tentang</h6>
                        <ul class="list-unstyled" style="font-size: 0.9rem;">
                            <li class="mb-2"><a href="#"
                                    class="text-secondary text-decoration-none hover-text-primary">Tentang Kami</a>
                            </li>
                            <li class="mb-2"><a href="#"
                                    class="text-secondary text-decoration-none hover-text-primary">Cara Penggunaan</a>
                            </li>
                            <li class="mb-2"><a href="#"
                                    class="text-secondary text-decoration-none hover-text-primary">FAQ</a></li>
                            <li class="mb-2"><a href="#"
                                    class="text-secondary text-decoration-none hover-text-primary">Kebijakan
                                    Privasi</a></li>
                            <li class="mb-2"><a href="#"
                                    class="text-secondary text-decoration-none hover-text-primary">Syarat &
                                    Ketentuan</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 mb-4">
                        <h6 class="text-white fw-bold">Kontak</h6>
                        <ul class="list-unstyled" style="font-size: 0.9rem;">
                            <li class="mb-2 text-secondary">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                Jakarta, Indonesia
                            </li>
                            <li class="mb-2 text-secondary">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                info@titikkritis.com
                            </li>
                            <li class="mb-2 text-secondary">
                                <i class="fas fa-phone text-primary me-2"></i>
                                (021) 1234-5678
                            </li>
                            <li class="mb-2 text-secondary">
                                <i class="fas fa-clock text-primary me-2"></i>
                                Senin - Jumat: 08.00 - 17.00
                            </li>
                        </ul>
                    </div>
                </div>

                <hr class="border-secondary opacity-50 my-3">

                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="text-secondary mb-0" style="font-size: 0.85rem;">
                            &copy; {{ date('Y') }} <span class="text-white fw-semibold">Titik Kritis</span>.
                            All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <p class="text-secondary mb-0" style="font-size: 0.85rem;">
                            <i class="fas fa-code text-primary me-1"></i>
                            Made with <i class="fas fa-heart text-danger"></i> for better government
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    @endif

    {{-- Google Translate --}}
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'af,sq,am,ar,hy,az,eu,be,bn,bs,bg,ca,ceb,ny,zh-CN,zh-TW,co,hr,cs,da,nl,en,eo,et,tl,fi,fr,fy,gl,ka,de,el,gu,ht,ha,haw,iw,hi,hmn,hu,is,ig,id,ga,it,ja,jw,kn,kk,km,ko,ku,ky,lo,la,lv,lt,lb,mk,mg,ms,ml,mt,mi,mr,mn,my,ne,no,ps,fa,pl,pt,pa,ro,ru,sm,gd,sr,st,sn,sd,si,sk,sl,so,es,su,sw,sv,tg,ta,te,th,tr,uk,ur,uz,vi,cy,xh,yi,yo,zu',
                layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL,
                autoDisplay: false,
                multilanguagePage: true
            }, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });

        // ============ DARK MODE ============
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

        // ============ GOOGLE TRANSLATE ============
        document.addEventListener('DOMContentLoaded', function() {
            var savedLang = localStorage.getItem('googleTranslateLang');

            if (savedLang) {
                var checkExist = setInterval(function() {
                    var select = document.querySelector('.goog-te-combo');
                    if (select) {
                        clearInterval(checkExist);
                        select.value = savedLang;
                        select.dispatchEvent(new Event('change'));
                    }
                }, 500);
            }

            var hideBanner = setInterval(function() {
                var banner = document.querySelector('.goog-te-banner-frame');
                if (banner) {
                    banner.style.display = 'none';
                    banner.style.visibility = 'hidden';
                    banner.style.height = '0';
                }
                if (document.body.style.top !== '0px') {
                    document.body.style.top = '0px';
                }
            }, 100);

            document.addEventListener('change', function(e) {
                if (e.target.classList.contains('goog-te-combo')) {
                    localStorage.setItem('googleTranslateLang', e.target.value);
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
