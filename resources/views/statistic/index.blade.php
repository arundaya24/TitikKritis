@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-chart-bar me-2"></i> Statistik Kritik</h2>
            <p class="text-muted">Statistik berdasarkan data kritik yang Anda kirimkan.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon"><i class="fas fa-file-alt"></i></div>
                <div class="number">{{ $totalCritiques }}</div>
                <div class="label">Total Kritik</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon"><i class="fas fa-check-circle text-success"></i></div>
                <div class="number">{{ $responseRate }}</div>
                <div class="label">Kritik Ditanggapi</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon"><i class="fas fa-clock text-warning"></i></div>
                <div class="number">{{ $avgResponseTime ? round($avgResponseTime, 1) : 0 }}</div>
                <div class="label">Rata-rata Waktu Tanggap (Jam)</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card text-center">
                <div class="icon"><i class="fas fa-layer-group text-info"></i></div>
                <div class="number">{{ count($statusCounts) }}</div>
                <div class="label">Status Aktif</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-2"></i> Status Kritik
                </div>
                <div class="card-body">
                    @if(count($statusCounts) > 0)
                        <ul class="list-group">
                            @foreach($statusCounts as $status => $count)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="badge badge-status badge-{{ $status }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                    <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Belum ada data kritik.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-layer-group me-2"></i> Tingkat Pemerintahan
                </div>
                <div class="card-body">
                    @if(count($levelStats) > 0)
                        <ul class="list-group">
                            @foreach($levelStats as $level => $count)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="text-capitalize">{{ $level }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ $count }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Belum ada data kritik.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-tags me-2"></i> Kategori Kritik Terbanyak
                </div>
                <div class="card-body">
                    @if($categoryStats->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kategori</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categoryStats as $index => $stat)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $stat->name }}</td>
                                            <td><span class="badge bg-primary">{{ $stat->total }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada data kritik.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($monthlyStats->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-calendar-alt me-2"></i> Trend Kritik Per Bulan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Jumlah Kritik</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($monthlyStats as $stat)
                                    <tr>
                                        <td>{{ DateTime::createFromFormat('!m', $stat->month)->format('F') }}</td>
                                        <td>{{ $stat->year }}</td>
                                        <td><span class="badge bg-primary">{{ $stat->total }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
