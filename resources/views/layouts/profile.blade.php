<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Titik Kritis - {{ $title ?? 'Profile' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dark-mode-user.css') }}">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        main.py-4 {
            flex: 1;
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
        .badge-dikirim { background-color: #ffc107; color: #000; }
        .badge-ditinjau { background-color: #17a2b8; color: #fff; }
        .badge-diproses { background-color: #007bff; color: #fff; }
        .badge-selesai { background-color: #28a745; color: #fff; }
        .badge-ditolak { background-color: #dc3545; color: #fff; }

        html, body {
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

        /* Dark mode */
        body.dark-mode {
            background-color: #1a1a2e !important;
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
        body.dark-mode .btn-outline-primary {
            border-color: #1a3a5c !important;
            color: #b0b0b0 !important;
        }
        body.dark-mode .btn-outline-primary:hover {
            background-color: #1a3a5c !important;
            color: #e0e0e0 !important;
        }
    </style>
</head>
<body>
    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>
