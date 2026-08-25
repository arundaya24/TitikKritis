@extends('layouts.admin')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="number">{{ $totalCritiques }}</div>
                    <div class="label">Total Kritik</div>
                </div>
                <div class="icon"><i class="fas fa-file-alt"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="number text-warning">{{ $pendingCritiques }}</div>
                    <div class="label">Menunggu</div>
                </div>
                <div class="icon text-warning"><i class="fas fa-clock"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="number text-primary">{{ $processingCritiques + $reviewingCritiques }}</div>
                    <div class="label">Diproses</div>
                </div>
                <div class="icon text-primary"><i class="fas fa-spinner"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="number text-success">{{ $completedCritiques }}</div>
                    <div class="label">Selesai</div>
                </div>
                <div class="icon text-success"><i class="fas fa-check-circle"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="number text-danger">{{ $rejectedCritiques }}</div>
                    <div class="label">Ditolak</div>
                </div>
                <div class="icon text-danger"><i class="fas fa-times-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="number text-info">{{ $totalUsers }}</div>
                    <div class="label">Total Pengguna</div>
                </div>
                <div class="icon text-info"><i class="fas fa-users"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="number text-secondary">{{ $totalAdmins }}</div>
                    <div class="label">Total Admin</div>
                </div>
                <div class="icon text-secondary"><i class="fas fa-user-shield"></i></div>
            </div>
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
                <i class="fas fa-tags me-2"></i> Kategori Kritik Terbanyak
            </div>
            <div class="card-body">
                @if($categoryStats->count() > 0)
                    <ul class="list-group">
                        @foreach($categoryStats as $stat)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $stat->name }}
                                <span class="badge bg-primary rounded-pill">{{ $stat->total }}</span>
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
                <i class="fas fa-clock me-2"></i> Kritik Terbaru
            </div>
            <div class="card-body">
                @if($recentCritiques->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Pengirim</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentCritiques as $critique)
                                    <tr>
                                        <td>{{ Str::limit($critique->title, 30) }}</td>
                                        <td>{{ $critique->is_anonymous ? 'Anonim' : $critique->user->name }}</td>
                                        <td>{{ $critique->category->name }}</td>
                                        <td>
                                            <span class="badge badge-status badge-{{ $critique->status }}">
                                                {{ ucfirst($critique->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $critique->submitted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.critiques.show', $critique->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Belum ada kritik.</p>
                @endif
            </div>
        </div>
    </div>
</div>

@if($monthlyCritiques->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-calendar-alt me-2"></i> Trend Kritik 6 Bulan Terakhir
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
                            @foreach($monthlyCritiques as $stat)
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
@endsection
