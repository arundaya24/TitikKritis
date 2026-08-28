@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h2><i class="fas fa-chart-bar me-2"></i> Statistik Kritik</h2>
                        <p class="text-muted">Statistik berdasarkan data kritik yang tersedia.</p>
                    </div>

                    {{-- Filter Toggle --}}
                    <div class="btn-group" role="group">
                        <a href="{{ route('statistic.index', ['filter' => 'saya']) }}"
                            class="btn btn-{{ $filter == 'saya' ? 'primary' : 'outline-primary' }}">
                            <i class="fas fa-user me-1"></i> Kritik Saya
                        </a>
                        <a href="{{ route('statistic.index', ['filter' => 'semua']) }}"
                            class="btn btn-{{ $filter == 'semua' ? 'primary' : 'outline-primary' }}">
                            <i class="fas fa-users me-1"></i> Semua Kritik
                        </a>
                    </div>
                </div>
                @if ($filter == 'semua')
                    <div class="alert alert-info mt-2">
                        <i class="fas fa-info-circle me-1"></i>
                        Menampilkan statistik dari <strong>semua user</strong> ({{ $totalUsersWithCritiques }} user pernah
                        mengirim kritik)
                    </div>
                @else
                    <div class="alert alert-success mt-2">
                        <i class="fas fa-info-circle me-1"></i>
                        Menampilkan statistik dari <strong>kritik Anda</strong> saja
                    </div>
                @endif
            </div>
        </div>

        {{-- Stat Cards --}}
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

        {{-- Charts Row --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-chart-pie me-2"></i> Status Kritik
                    </div>
                    <div class="card-body">
                        @if (count($statusCounts) > 0)
                            <div
                                style="max-height: 280px; max-width: 100%; display: flex; justify-content: center; align-items: center;">
                                <div style="width: 280px; height: 280px;">
                                    <canvas id="statusChart"></canvas>
                                </div>
                            </div>
                        @else
                            <p class="text-muted text-center py-3">Belum ada data kritik.</p>
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
                        @if (count($levelStats) > 0)
                            <div style="max-height: 280px; max-width: 100%;">
                                <canvas id="levelChart"></canvas>
                            </div>
                        @else
                            <p class="text-muted text-center py-3">Belum ada data kritik.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Kategori Chart --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-tags me-2"></i> Kategori Kritik Terbanyak
                    </div>
                    <div class="card-body">
                        @if ($categoryStats->count() > 0)
                            <div style="max-height: 250px; max-width: 100%;">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        @else
                            <p class="text-muted text-center py-3">Belum ada data kritik.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Trend Chart --}}
        @if ($monthlyStats->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-calendar-alt me-2"></i> Trend Kritik Per Bulan
                        </div>
                        <div class="card-body">
                            <div style="max-height: 250px; max-width: 100%;">
                                <canvas id="trendChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Warna untuk chart
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
                colors.blue, colors.green, colors.yellow, colors.red,
                colors.cyan, colors.purple, colors.orange, colors.pink, colors.teal
            ];

            // ===== 1. STATUS CHART (Pie) =====
            @if (count($statusCounts) > 0)
                const statusCtx = document.getElementById('statusChart').getContext('2d');
                const statusLabels = {!! json_encode(array_keys($statusCounts)) !!};
                const statusData = {!! json_encode(array_values($statusCounts)) !!};
                const statusColors = statusLabels.map((label, i) => {
                    const map = {
                        'dikirim': '#ffc107',
                        'ditinjau': '#17a2b8',
                        'diproses': '#0d6efd',
                        'selesai': '#28a745',
                        'ditolak': '#dc3545'
                    };
                    return map[label] || colorPalette[i % colorPalette.length];
                });

                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
                        datasets: [{
                            data: statusData,
                            backgroundColor: statusColors,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 10,
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    font: {
                                        size: 11
                                    }
                                }
                            }
                        }
                    }
                });
            @endif

            // ===== 2. LEVEL CHART (Bar) =====
            @if (count($levelStats) > 0)
                const levelCtx = document.getElementById('levelChart').getContext('2d');
                const levelLabels = {!! json_encode(array_keys($levelStats)) !!};
                const levelData = {!! json_encode(array_values($levelStats)) !!};

                new Chart(levelCtx, {
                    type: 'bar',
                    data: {
                        labels: levelLabels.map(l => l.charAt(0).toUpperCase() + l.slice(1)),
                        datasets: [{
                            label: 'Jumlah Kritik',
                            data: levelData,
                            backgroundColor: ['#0d6efd', '#17a2b8', '#6f42c1'],
                            borderRadius: 6,
                            borderSkipped: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
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
            @endif

            // ===== 3. CATEGORY CHART (Horizontal Bar) =====
            @if ($categoryStats->count() > 0)
                const categoryCtx = document.getElementById('categoryChart').getContext('2d');
                const categoryLabels = {!! json_encode($categoryStats->pluck('name')->toArray()) !!};
                const categoryData = {!! json_encode($categoryStats->pluck('total')->toArray()) !!};

                new Chart(categoryCtx, {
                    type: 'bar',
                    data: {
                        labels: categoryLabels,
                        datasets: [{
                            label: 'Jumlah Kritik',
                            data: categoryData,
                            backgroundColor: categoryData.map((_, i) => colorPalette[i %
                                colorPalette
                                .length]),
                            borderRadius: 6,
                            borderSkipped: false
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: true,
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
            @endif

            // ===== 4. TREND CHART (Line) =====
            @if ($monthlyStats->count() > 0)
                const trendCtx = document.getElementById('trendChart').getContext('2d');
                const trendLabels = {!! json_encode(
                    $monthlyStats->map(function ($item) {
                            return \DateTime::createFromFormat('!m', $item->month)->format('F') . ' ' . $item->year;
                        })->toArray(),
                ) !!};
                const trendData = {!! json_encode($monthlyStats->pluck('total')->toArray()) !!};

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
                        maintainAspectRatio: true,
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
            @endif
        });
    </script>

    {{-- Dark mode fix untuk chart --}}
    <style>
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
