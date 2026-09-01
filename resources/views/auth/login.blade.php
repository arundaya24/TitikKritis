@extends('layouts.app')
@section('hide_footer', true)
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <i class="fas fa-exclamation-triangle fa-3x text-primary"></i>
                    <h2 class="mt-2">Titik Kritis</h2>
                    <p class="text-muted">Platform Kritik Pemerintah</p>
                </div>
                <div class="card">
                    <div class="card-header text-center">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username"
                                    value="{{ old('username') }}" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <a href="{{ route('register') }}" class="btn btn-link text-decoration-none">
                                    <i class="fas fa-user-plus"></i> Belum punya akun?
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('password.request') }}" class="text-muted text-decoration-none">
                                    <i class="fas fa-key"></i> Lupa Password?
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
