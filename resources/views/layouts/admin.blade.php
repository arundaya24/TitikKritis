<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Titik Kritis - Admin {{ $title ?? '' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }

        .card {
            --bs-card-border-radius: 8px;
            --bs-card-inner-border-radius: 8px;
            /* biar header/body ikut, tanpa ini jadi 6.375px aneh */
            border-radius: 8px !important;
            overflow: hidden;
            /* penting: biar isi (table, header) ikut kepotong ngikutin lengkungan */
        }

        .card-header,
        .card-body,
        .card-footer {
            border-radius: inherit;
            /* ikut parent, gak perlu itung manual */
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s;
        }

        .admin-sidebar .brand {
            padding: 0 20px 20px;
            border-bottom: 1px solid #34495e;
            margin-bottom: 20px;
        }

        .admin-sidebar .brand h4 {
            color: #ecf0f1;
        }

        .admin-sidebar .brand i {
            color: #3498db;
        }

        .admin-sidebar .brand small {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        .admin-sidebar .nav-link {
            color: #bdc3c7;
            padding: 12px 20px;
            border-radius: 0;
            transition: all 0.2s;
        }

        .admin-sidebar .nav-link:hover {
            color: white;
            background-color: #34495e;
        }

        .admin-sidebar .nav-link.active {
            color: white;
            background-color: #3498db;
        }

        .admin-sidebar .nav-link i {
            width: 25px;
        }

        .admin-sidebar .sidebar-bottom {
            margin-top: auto;
            padding: 20px;
            border-top: 1px solid #34495e;
        }

        .admin-sidebar .sidebar-bottom .theme-toggle {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #445566;
            background: transparent;
            color: #bdc3c7;
            transition: all 0.3s;
            cursor: pointer;
        }

        .admin-sidebar .sidebar-bottom .theme-toggle:hover {
            background: #34495e;
            color: white;
        }

        .admin-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
            background-color: #f4f6f9;
            transition: background-color 0.3s, color 0.3s;
            min-height: 100vh;
        }

        .admin-header {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s, color 0.3s;
        }

        .admin-header .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-header .user-info .profile-image {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .admin-header .user-info .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #3498db;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        .card-header {
            background-color: white;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        .card-body {
            background-color: white;
            transition: background-color 0.3s, color 0.3s;
        }

        .table {
            transition: background-color 0.3s, color 0.3s;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, background-color 0.3s, color 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-card .number {
            font-size: 2rem;
            font-weight: bold;
        }

        .stat-card .label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .stat-card .icon {
            font-size: 2rem;
            opacity: 0.3;
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

        /* ============ DARK MODE - ADMIN ============ */
        body.dark-mode .admin-content {
            background-color: #1a1a2e !important;
        }

        body.dark-mode .admin-header {
            background-color: #16213e !important;
            border-bottom: 1px solid #0f3460 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .card {
            background-color: #16213e !important;
            border: 1px solid #0f3460 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .card-header {
            background-color: #0f3460 !important;
            border-bottom: 1px solid #1a1a4e !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .card-body {
            background-color: #16213e !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .table {
            background-color: #16213e !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .table thead th {
            background-color: #0f3460 !important;
            color: #e0e0e0 !important;
            border-bottom: 2px solid #1a3a5c !important;
        }

        body.dark-mode .table tbody td {
            background-color: #16213e !important;
            color: #e0e0e0 !important;
            border-bottom: 1px solid #1a3a5c !important;
        }

        body.dark-mode .table-hover tbody tr:hover td {
            background-color: #1a1a4e !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .table-striped tbody tr:nth-of-type(odd) td {
            background-color: #1a1a3e !important;
        }

        body.dark-mode .table-striped tbody tr:nth-of-type(even) td {
            background-color: #16213e !important;
        }

        body.dark-mode .list-group-item {
            background-color: #16213e !important;
            color: #e0e0e0 !important;
            border-color: #1a3a5c !important;
        }

        body.dark-mode .list-group-item:hover {
            background-color: #1a1a4e !important;
        }

        body.dark-mode .list-group-item .badge {
            background-color: #0f3460 !important;
            color: #4fc3f7 !important;
        }

        body.dark-mode .list-group-item .badge.bg-primary {
            background-color: #0f3460 !important;
            color: #4fc3f7 !important;
        }

        body.dark-mode .list-group-item .badge.bg-warning {
            background-color: #3a2a1a !important;
            color: #ffa726 !important;
        }

        body.dark-mode .list-group-item .badge.bg-success {
            background-color: #1a3a2a !important;
            color: #8bc34a !important;
        }

        body.dark-mode .list-group-item .badge.bg-danger {
            background-color: #3a1a1a !important;
            color: #ef5350 !important;
        }

        body.dark-mode .list-group-item .badge.bg-info {
            background-color: #1a3a5c !important;
            color: #4fc3f7 !important;
        }

        body.dark-mode .list-group-item .badge.bg-secondary {
            background-color: #2a2a3a !important;
            color: #888 !important;
        }

        body.dark-mode .stat-card {
            background-color: #16213e !important;
            border: 1px solid #0f3460 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .stat-card .label {
            color: #888 !important;
        }

        body.dark-mode .stat-card .number {
            color: #4fc3f7 !important;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #0d1b2a !important;
            border-color: #1a3a5c !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            background-color: #0d1b2a !important;
            border-color: #4fc3f7 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .form-label {
            color: #b0b0b0 !important;
        }

        body.dark-mode .text-muted {
            color: #888888 !important;
        }

        body.dark-mode .alert-success {
            background-color: #1a3a2a !important;
            border-color: #2a5a3a !important;
            color: #8bc34a !important;
        }

        body.dark-mode .alert-danger {
            background-color: #3a1a1a !important;
            border-color: #5a2a2a !important;
            color: #ef5350 !important;
        }

        body.dark-mode .alert-warning {
            background-color: #3a2a1a !important;
            border-color: #5a3a2a !important;
            color: #ffa726 !important;
        }

        body.dark-mode .alert-info {
            background-color: #1a2a3a !important;
            border-color: #2a3a5a !important;
            color: #4fc3f7 !important;
        }

        body.dark-mode .page-link {
            background-color: #16213e !important;
            border-color: #0f3460 !important;
            color: #b0b0b0 !important;
        }

        body.dark-mode .page-link:hover {
            background-color: #0f3460 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .page-item.active .page-link {
            background-color: #4fc3f7 !important;
            border-color: #4fc3f7 !important;
            color: #0d1b2a !important;
        }

        body.dark-mode .page-item.disabled .page-link {
            background-color: #0d1b2a !important;
            border-color: #1a3a5c !important;
            color: #555 !important;
        }

        body.dark-mode .badge.bg-secondary {
            background-color: #444 !important;
        }

        body.dark-mode .badge.bg-info {
            background-color: #1a3a5c !important;
            color: #4fc3f7 !important;
        }

        body.dark-mode .badge.bg-primary {
            background-color: #1a3a5c !important;
            color: #4fc3f7 !important;
        }

        body.dark-mode .badge.bg-success {
            background-color: #1a3a2a !important;
            color: #8bc34a !important;
        }

        body.dark-mode .badge.bg-danger {
            background-color: #3a1a1a !important;
            color: #ef5350 !important;
        }

        body.dark-mode .badge.bg-warning {
            background-color: #3a2a1a !important;
            color: #ffa726 !important;
        }

        body.dark-mode .modal-content {
            background-color: #16213e !important;
            border-color: #0f3460 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .modal-header {
            border-bottom-color: #0f3460 !important;
        }

        body.dark-mode .modal-footer {
            border-top-color: #0f3460 !important;
        }

        body.dark-mode .btn-close {
            filter: invert(1);
        }

        body.dark-mode .dropdown-menu {
            background-color: #16213e !important;
            border-color: #0f3460 !important;
        }

        body.dark-mode .dropdown-item {
            color: #b0b0b0 !important;
        }

        body.dark-mode .dropdown-item:hover {
            background-color: #0f3460 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .dropdown-divider {
            border-color: #0f3460 !important;
        }

        body.dark-mode .admin-sidebar {
            background-color: #0d1b2a !important;
        }

        body.dark-mode .admin-sidebar .brand {
            border-bottom-color: #1a3a5c !important;
        }

        body.dark-mode .admin-sidebar .brand h4 {
            color: #e0e0e0 !important;
        }

        body.dark-mode .admin-sidebar .brand small {
            color: rgba(255, 255, 255, 0.5) !important;
        }

        body.dark-mode .admin-sidebar .nav-link {
            color: #888 !important;
        }

        body.dark-mode .admin-sidebar .nav-link:hover {
            background-color: #1a3a5c !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .admin-sidebar .nav-link.active {
            background-color: #4fc3f7 !important;
            color: #0d1b2a !important;
        }

        body.dark-mode .admin-sidebar .sidebar-bottom {
            border-top-color: #1a3a5c !important;
        }

        body.dark-mode .admin-sidebar .sidebar-bottom .theme-toggle {
            border-color: #1a3a5c !important;
            color: #888 !important;
        }

        body.dark-mode .admin-sidebar .sidebar-bottom .theme-toggle:hover {
            background: #1a3a5c !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .input-group-text {
            background-color: #0d1b2a !important;
            border-color: #1a3a5c !important;
            color: #888 !important;
        }

        @media (max-width: 768px) {
            .admin-sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .admin-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>
    <div class="admin-wrapper">
        <div class="admin-sidebar">
            <div class="brand text-center">
                <i class="fas fa-exclamation-triangle fa-2x"></i>
                <h4 class="text-white fw-bold">Titik Kritis</h4>
                <small class="text-white-50">Admin Panel</small>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.critiques.*') ? 'active' : '' }}"
                    href="{{ route('admin.critiques.index') }}">
                    <i class="fas fa-list"></i> Kritik
                </a>
                <a class="nav-link {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.users.create') ? 'active' : '' }}"
                    href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users-cog"></i> Kelola Admin
                </a>
                <a class="nav-link {{ request()->routeIs('admin.users.manage') || request()->routeIs('admin.users.detail') ? 'active' : '' }}"
                    href="{{ route('admin.users.manage') }}">
                    <i class="fas fa-users"></i> Manajemen User
                </a>
                {{-- TOMBOL PROFILE DI SIDEBAR --}}
                <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                    href="{{ route('profile.index') }}">
                    <i class="fas fa-user-edit"></i> Edit Profile
                </a>
            </nav>
            <div class="sidebar-bottom">
                <button class="theme-toggle" id="adminThemeToggle">
                    <i class="fas fa-moon" id="adminThemeIcon"></i> Mode Gelap
                </button>
            </div>
        </div>

        <div class="admin-content">
            <div class="admin-header">
                <h5 class="mb-0"><i class="fas fa-dashboard"></i> {{ $title ?? 'Dashboard' }}</h5>
                <div class="user-info">
                    @include('partials.notification-bell')
                    {{-- NAMA BISA DIKLIK KE PROFILE --}}
                    <a href="{{ route('profile.index') }}" class="text-decoration-none fw-semibold"
                        style="font-size: 0.95rem; color: inherit;">
                        {{ auth()->user()->name }}
                    </a>
                    {{-- AVATAR BISA DIKLIK KE PROFILE --}}
                    <a href="{{ route('profile.index') }}">
                        <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="admin-avatar">
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });

        // Dark Mode Toggle for Admin
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('adminThemeToggle');
            const icon = document.getElementById('adminThemeIcon');

            if (localStorage.getItem('theme') === 'dark') {
                document.body.classList.add('dark-mode');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                toggle.innerHTML = '<i class="fas fa-sun"></i> Mode Terang';
            }

            toggle.addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');

                if (document.body.classList.contains('dark-mode')) {
                    localStorage.setItem('theme', 'dark');
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                    toggle.innerHTML = '<i class="fas fa-sun"></i> Mode Terang';
                } else {
                    localStorage.setItem('theme', 'light');
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                    toggle.innerHTML = '<i class="fas fa-moon"></i> Mode Gelap';
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
