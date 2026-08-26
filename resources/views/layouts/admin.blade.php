<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Titik Kritis - Admin {{ $title ?? '' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        .admin-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }
        .admin-header {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-header .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
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
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
        }
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
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
        .badge-dikirim { background-color: #ffc107; color: #000; }
        .badge-ditinjau { background-color: #17a2b8; color: #fff; }
        .badge-diproses { background-color: #007bff; color: #fff; }
        .badge-selesai { background-color: #28a745; color: #fff; }
        .badge-ditolak { background-color: #dc3545; color: #fff; }
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
                <h4>Titik Kritis</h4>
                <small class="text-muted">Admin Panel</small>
            </div>
            <nav class="nav flex-column">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.critiques.*') ? 'active' : '' }}" href="{{ route('admin.critiques.index') }}">
                    <i class="fas fa-list"></i> Kritik
                </a>
                <a class="nav-link {{ request()->routeIs('admin.users.index') || request()->routeIs('admin.users.create') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users-cog"></i> Kelola Admin
                </a>
                <a class="nav-link {{ request()->routeIs('admin.users.manage') || request()->routeIs('admin.users.detail') ? 'active' : '' }}" href="{{ route('admin.users.manage') }}">
                    <i class="fas fa-users"></i> Manajemen User
                </a>
            </nav>
        </div>

        <div class="admin-content">
            <div class="admin-header">
                <h5 class="mb-0"><i class="fas fa-dashboard"></i> {{ $title ?? 'Dashboard' }}</h5>
                <div class="user-info">
                    <span>{{ auth()->user()->name }}</span>
                    <div class="profile-image">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
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
    </script>
    @stack('scripts')
</body>
</html>
