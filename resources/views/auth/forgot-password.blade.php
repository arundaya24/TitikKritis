<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Titik Kritis - Lupa Password</title>
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
        .container-form {
            width: 100%;
            max-width: 420px;
            padding: 15px;
        }
        .card {
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
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
        .btn-send {
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            background: #0d6efd;
            border: none;
            color: white;
            width: 100%;
        }
        .btn-send:hover {
            background: #0b5ed7;
        }
        .btn-back {
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            border: 2px solid #6c757d;
            color: #6c757d;
            background: transparent;
            width: 100%;
        }
        .btn-back:hover {
            background: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-form">
        <div class="card">
            <div class="card-header">
                <div class="logo"><i class="fas fa-exclamation-triangle"></i></div>
                <h3>Lupa Password</h3>
                <p class="text-muted">Masukkan email Anda untuk reset password</p>
            </div>
            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p class="mb-0">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- PERBAIKAN: Action harus mengarah ke route password.email --}}
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required autofocus>
                    </div>

                    <button type="submit" class="btn btn-send mb-2">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Link Reset
                    </button>

                    <a href="{{ route('login') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
                    </a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
