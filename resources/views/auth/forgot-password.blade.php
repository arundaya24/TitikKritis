@extends('layouts.app')
@section('hide_footer', true)
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="text-center mb-4">
                    <i class="fas fa-exclamation-triangle fa-3x text-primary"></i>
                    <h2 class="mt-2">Titik Kritis</h2>
                    <p class="text-muted">Lupa Password</p>
                </div>
                <div class="card">
                    <div class="card-header text-center">
                        <i class="fas fa-key me-2"></i> Reset Password
                    </div>
                    <div class="card-body">
                        <p class="text-muted text-center">Masukkan email Anda untuk menerima link reset password</p>

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show">
                                {{ session('status') }}
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

                        {{-- PERBAIKAN: Action harus mengarah ke route password.email --}}
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}" required autofocus>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('login') }}" class="btn btn-link text-decoration-none">
                                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Kirim Link Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
