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
                    <div class="icon text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="number text-primary">
                            {{ $processingCritiques + $reviewingCritiques }}
                        </div>
                        <div class="label">Diproses</div>
                    </div>
                    <div class="icon text-primary">
                        <i class="fas fa-spinner"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="number text-success">
                            {{ $completedCritiques }}
                        </div>
                        <div class="label">Selesai</div>
                    </div>
                    <div class="icon text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="number text-danger">
                            {{ $rejectedCritiques }}
                        </div>
                        <div class="label">Ditolak</div>
                    </div>
                    <div class="icon text-danger">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="number text-info">
                            {{ $totalUsers }}
                        </div>
                        <div class="label">Total Pengguna</div>
                    </div>
                    <div class="icon text-info">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="number text-secondary">
                            {{ $totalAdmins }}
                        </div>
                        <div class="label">Total Admin</div>
                    </div>
                    <div class="icon text-secondary">
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="number text-secondary">
                            {{ $totalSuperAdmins }}
                        </div>
                        <div class="label">Total Super Admin</div>
                    </div>
                    <div class="icon text-secondary">
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 align-items-stretch">
        <div class="col-md-6 d-flex">
            <div class="card w-100">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-2"></i>
                    Status Kritik
                </div>

                <div class="card-body d-flex align-items-center justify-content-center">
                    @if (count($statusCounts) > 0)
                        <div class="status-chart-wrapper">
                            <canvas id="adminStatusChart"></canvas>
                        </div>
                    @else
                        <p class="text-muted text-center py-3">
                            Belum ada data kritik.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 d-flex">
            <div class="card w-100">
                <div class="card-header">
                    <i class="fas fa-tags me-2"></i>
                    Kategori Kritik Terbanyak
                </div>

                <div class="card-body d-flex align-items-center">
                    @if ($categoryStats->count() > 0)
                        <div class="category-chart-wrapper">
                            <canvas id="adminCategoryChart"></canvas>
                        </div>
                    @else
                        <p class="text-muted text-center py-3 w-100">
                            Belum ada data kritik.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-clock me-2"></i>
                    Kritik Terbaru
                </div>

                <div class="card-body">
                    @if ($recentCritiques->count() > 0)
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
                                    @foreach ($recentCritiques as $critique)
                                        <tr>
                                            <td>
                                                {{ Str::limit($critique->title, 30) }}
                                            </td>

                                            <td>
                                                {{ $critique->is_anonymous ? 'Anonim' : $critique->user->name }}
                                            </td>

                                            <td>
                                                {{ $critique->category->name }}
                                            </td>

                                            <td>
                                                <span class="badge badge-status badge-{{ $critique->status }}">
                                                    {{ ucfirst($critique->status) }}
                                                </span>
                                            </td>

                                            <td>
                                                {{ $critique->submitted_at->format('d/m/Y H:i') }}
                                            </td>

                                            <td>
                                                <a
                                                    href="{{ route('admin.critiques.show', $critique->id) }}"
                                                    class="btn btn-sm btn-info"
                                                >
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">
                            Belum ada kritik.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($monthlyCritiques->count() > 0)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Trend Kritik 6 Bulan Terakhir
                    </div>

                    <div class="card-body">
                        <div class="trend-chart-wrapper">
                            <canvas id="adminTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const colors = {
                blue: '#0d6efd',
                green: '#28a745',
                yellow: '#ffc107',
                red: '#dc3545',
                cyan: '#17a2b8',
                purple: '#6f42c1',
                orange: '#fd7e14',
                pink: '#e83e8c',
                teal: '#20c997'
            };

            const colorPalette = [
                colors.blue,
                colors.green,
                colors.yellow,
                colors.red,
                colors.cyan,
                colors.purple,
                colors.orange,
                colors.pink,
                colors.teal
            ];

            @if (count($statusCounts) > 0)
                const statusCanvas = document.getElementById('adminStatusChart');

                if (statusCanvas) {
                    const statusCtx = statusCanvas.getContext('2d');

                    const statusLabels = {!! json_encode(array_keys($statusCounts)) !!};
                    const statusData = {!! json_encode(array_values($statusCounts)) !!};

                    const statusColors = statusLabels.map((label) => {
                        const map = {
                            'dikirim': '#ffc107',
                            'ditinjau': '#17a2b8',
                            'diproses': '#0d6efd',
                            'selesai': '#28a745',
                            'ditolak': '#dc3545'
                        };

                        return map[label] || '#6c757d';
                    });

                    new Chart(statusCtx, {
                        type: 'doughnut',

                        data: {
                            labels: statusLabels.map(
                                label => label.charAt(0).toUpperCase() + label.slice(1)
                            ),

                            datasets: [{
                                data: statusData,
                                backgroundColor: statusColors,
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: false,

                            plugins: {
                                legend: {
                                    position: 'bottom',

                                    labels: {
                                        padding: 8,
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        boxWidth: 10,

                                        font: {
                                            size: 10
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            @endif

            @if ($categoryStats->count() > 0)
                const categoryCanvas = document.getElementById('adminCategoryChart');

                if (categoryCanvas) {
                    const categoryCtx = categoryCanvas.getContext('2d');

                    const categoryLabels = {!! json_encode(
                        $categoryStats->keys()->values()->toArray()
                    ) !!};

                    const categoryData = {!! json_encode(
                        $categoryStats->values()->toArray()
                    ) !!};

                    new Chart(categoryCtx, {
                        type: 'bar',

                        data: {
                            labels: categoryLabels,

                            datasets: [{
                                label: 'Jumlah Kritik',
                                data: categoryData,

                                backgroundColor: categoryData.map(
                                    (_, i) => colorPalette[i % colorPalette.length]
                                ),

                                borderRadius: 6,
                                borderSkipped: false
                            }]
                        },

                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,

                            plugins: {
                                legend: {
                                    display: false
                                }
                            },

                            scales: {
                                x: {
                                    beginAtZero: true,

                                    ticks: {
                                        stepSize: 1,

                                        font: {
                                            size: 10
                                        }
                                    }
                                },

                                y: {
                                    ticks: {
                                        font: {
                                            size: 10
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            @endif

            @if ($monthlyCritiques->count() > 0)
                const trendCanvas = document.getElementById('adminTrendChart');

                if (trendCanvas) {
                    const trendCtx = trendCanvas.getContext('2d');

                    const trendLabels = {!! json_encode(
                        $monthlyCritiques->map(function ($item) {
                            return \DateTime::createFromFormat('!m', $item->month)->format('F')
                                . ' ' . $item->year;
                        })->toArray()
                    ) !!};

                    const trendData = {!! json_encode(
                        $monthlyCritiques->pluck('total')->toArray()
                    ) !!};

                    new Chart(trendCtx, {
                        type: 'line',

                        data: {
                            labels: trendLabels,

                            datasets: [{
                                label: 'Jumlah Kritik',
                                data: trendData,
                                borderColor: '#0d6efd',
                                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#0d6efd',
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }]
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: false,

                            plugins: {
                                legend: {
                                    display: false
                                }
                            },

                            scales: {
                                y: {
                                    beginAtZero: true,

                                    ticks: {
                                        stepSize: 1,

                                        font: {
                                            size: 10
                                        }
                                    }
                                },

                                x: {
                                    ticks: {
                                        font: {
                                            size: 10
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            @endif
        });
    </script>

    <style>
        .row > .col-md-6 {
            display: flex;
        }

        .row > .col-md-6 > .card {
            width: 100%;
            height: 100%;
        }

        .status-chart-wrapper {
            width: 100%;
            height: 280px;
            position: relative;
        }

        .category-chart-wrapper {
            width: 100%;
            height: 280px;
            position: relative;
        }

        .trend-chart-wrapper {
            width: 100%;
            height: 250px;
            position: relative;
        }

        #adminStatusChart,
        #adminCategoryChart,
        #adminTrendChart {
            width: 100% !important;
            height: 100% !important;
        }

        body.dark-mode .stat-card {
            background-color: #16213e !important;
            border: 1px solid #0f3460 !important;
            color: #e0e0e0 !important;
        }

        body.dark-mode .stat-card .number {
            color: #4fc3f7 !important;
        }

        body.dark-mode .stat-card .label {
            color: #888 !important;
        }

        body.dark-mode .stat-card .icon {
            color: #4fc3f7 !important;
            opacity: 0.3;
        }
    </style>
@endsection
