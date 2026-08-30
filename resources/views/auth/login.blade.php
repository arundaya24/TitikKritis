<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Titik Kritis - Login</title>
    <link rel="stylesheet" href="{{ asset('css/dark-mode-user.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 15px;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border: none;
            overflow: hidden;
        }

        .card-header {
            background: white;
            border: none;
            padding: 30px 30px 10px;
            text-align: center;
        }

        .card-header .logo {
            font-size: 2.5rem;
            color: #0d6efd;
        }

        .card-header h3 {
            font-weight: 700;
            color: #1a1a2e;
            margin-top: 10px;
        }

        .card-body {
            padding: 20px 30px 30px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .btn-login {
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            background: #0d6efd;
            border: none;
            color: white;
            width: 100%;
        }

        .btn-login:hover {
            background: #0b5ed7;
        }

        .btn-register {
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            border: 2px solid #0d6efd;
            color: #0d6efd;
            background: transparent;
            width: 100%;
        }

        .btn-register:hover {
            background: #0d6efd;
            color: white;
        }

        .btn-group-action {
            display: flex;
            gap: 10px;
        }

        .btn-group-action .btn {
            flex: 1;
        }

        .alert {
            border-radius: 12px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="card">
            <div class="card-header">
                <div class="logo"><i class="fas fa-exclamation-triangle"></i></div>
                <h3>Titik Kritis</h3>
                <p class="text-muted">Platform Kritik Pemerintah</p>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label fw-semibold">Username</label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Masukkan password" required>
                    </div>

                    <div class="btn-group-action mb-3">
                        <a href="{{ route('register') }}" class="btn btn-register">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </a>
                        <button type="submit" class="btn btn-login">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </button>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="text-muted">
                            <i class="fas fa-key"></i> Lupa Password?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
