@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p class="text-muted">Selamat datang di Titik Kritis, platform kritik masyarakat untuk pemerintah daerah.</p>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-4">
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon"><i class="fas fa-file-alt"></i></div>
                <div class="number">{{ $totalCritiques }}</div>
                <div class="label">Total Kritik</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon"><i class="fas fa-clock text-warning"></i></div>
                <div class="number">{{ $pendingCritiques }}</div>
                <div class="label">Menunggu Tinjauan</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon"><i class="fas fa-spinner text-primary"></i></div>
                <div class="number">{{ $processedCritiques }}</div>
                <div class="label">Sedang Diproses</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon"><i class="fas fa-check-circle text-success"></i></div>
                <div class="number">{{ $completedCritiques }}</div>
                <div class="label">Selesai</div>
            </div>
        </div>
    </div>

    {{-- Aksi Cepat --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-bullhorn me-2"></i> Aksi Cepat
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('critique.create') }}" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-pen fa-2x d-block"></i>
                                Kirim Kritik
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('critique.history') }}" class="btn btn-info w-100 py-3 text-white">
                                <i class="fas fa-history fa-2x d-block"></i>
                                History Kritik
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('statistic.index') }}" class="btn btn-success w-100 py-3">
                                <i class="fas fa-chart-bar fa-2x d-block"></i>
                                Lihat Statistik
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
