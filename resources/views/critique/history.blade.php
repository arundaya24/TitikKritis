@extends('layouts.app')

@push('styles')
<style>
    /* ===== DARK MODE - CARD & TABLE ===== */
    body.dark-mode .card {
        background-color: #16213e !important;
        border: 1px solid #0f3460 !important;
        color: #e0e0e0 !important;
    }

    body.dark-mode .card-body {
        background-color: #16213e !important;
        color: #e0e0e0 !important;
    }

    body.dark-mode .table {
        background-color: #16213e !important;
        color: #e0e0e0 !important;
    }

    body.dark-mode .table thead th {
        background-color: #0f3460 !important;
        color: #e0e0e0 !important;
        border-bottom: 2px solid #1a3a5c !important;
    }

    body.dark-mode .table tbody td {
        background-color: #16213e !important;
        color: #e0e0e0 !important;
        border-bottom: 1px solid #1a3a5c !important;
    }

    body.dark-mode .table-hover tbody tr:hover td {
        background-color: #1a1a4e !important;
        color: #e0e0e0 !important;
    }

    body.dark-mode .table-striped tbody tr:nth-of-type(odd) td {
        background-color: #1a1a3e !important;
    }

    body.dark-mode .table-striped tbody tr:nth-of-type(even) td {
        background-color: #16213e !important;
    }

    /* ===== DARK MODE - TAB ===== */
    body.dark-mode .nav-tabs {
        background-color: #1a1a2e !important; /* ADDED: background bar tab */
        border-bottom-color: #1a3a5c !important;
    }

    body.dark-mode .nav-tabs .nav-link {
        color: #b0b0b0 !important;
        background-color: transparent !important; /* ADDED (explicit) */
        border-color: transparent !important;
    }

    body.dark-mode .nav-tabs .nav-link:hover {
        color: #e0e0e0 !important;
        background-color: #16213e !important; /* ADDED */
        border-color: #1a3a5c !important;
    }

    body.dark-mode .nav-tabs .nav-link.active {
        color: #4fc3f7 !important;
        background-color: #16213e !important;
        border-color: #1a3a5c !important;
        border-bottom-color: #16213e !important;
    }

    body.dark-mode .tab-content {
        background-color: transparent !important; /* ADDED */
    }

    /* ===== DARK MODE - BADGE ===== */
    body.dark-mode .badge.bg-secondary {
        background-color: #444 !important;
    }
    body.dark-mode .badge.bg-info {
        background-color: #1a3a5c !important;
        color: #4fc3f7 !important;
    }
    body.dark-mode .badge.bg-primary {
        background-color: #1a3a5c !important;
        color: #4fc3f7 !important;
    }
    body.dark-mode .badge.bg-success {
        background-color: #1a3a2a !important;
        color: #8bc34a !important;
    }
    body.dark-mode .badge.bg-danger {
        background-color: #3a1a1a !important;
        color: #ef5350 !important;
    }
    body.dark-mode .badge.bg-warning {
        background-color: #3a2a1a !important;
        color: #ffa726 !important;
    }

    /* ===== DARK MODE - PAGINATION ===== */
    body.dark-mode .page-link {
        background-color: #16213e !important;
        border-color: #0f3460 !important;
        color: #b0b0b0 !important;
    }

    body.dark-mode .page-link:hover {
        background-color: #0f3460 !important;
        color: #e0e0e0 !important;
    }

    body.dark-mode .page-item.active .page-link {
        background-color: #4fc3f7 !important;
        border-color: #4fc3f7 !important;
        color: #0d1b2a !important;
    }

    body.dark-mode .page-item.disabled .page-link {
        background-color: #0d1b2a !important;
        border-color: #1a3a5c !important;
        color: #555 !important;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-history me-2"></i> History Kritik</h2>
            <p class="text-muted">Daftar semua kritik yang telah Anda kirimkan.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter Tabs --}}
    <ul class="nav nav-tabs mb-3" id="critiqueTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">
                <i class="fas fa-inbox"></i> Aktif
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="archived-tab" data-bs-toggle="tab" data-bs-target="#archived" type="button" role="tab">
                <i class="fas fa-archive"></i> Arsip
            </button>
        </li>
    </ul>

    <div class="tab-content" id="critiqueTabContent">
        {{-- TAB AKTIF --}}
        <div class="tab-pane fade show active" id="active" role="tabpanel">
            @php
                $activeCritiques = $critiques->filter(function($c) { return !$c->is_archived; });
            @endphp

            @if($activeCritiques->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Tingkat</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activeCritiques as $index => $critique)
                                        <tr>
                                            <td>{{ $critiques->firstItem() + $index }}</td>
                                            <td>{{ Str::limit($critique->title, 30) }}</td>
                                            <td>{{ $critique->category->name }}</td>
                                            <td><span class="text-capitalize">{{ $critique->government_level }}</span></td>
                                            <td>
                                                <span class="badge badge-status badge-{{ $critique->status }}">
                                                    {{ ucfirst($critique->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $critique->submitted_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="d-flex gap-1 flex-wrap">
                                                    <a href="{{ route('critique.show', $critique->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    @if($critique->status === 'dikirim')
                                                        <a href="{{ route('critique.edit', $critique->id) }}" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('critique.destroy', $critique->id) }}" method="POST" class="d-inline"
                                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kritik ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($critique->status === 'ditolak')
                                                        <form action="{{ route('critique.force.delete', $critique->id) }}" method="POST" class="d-inline"
                                                              onsubmit="return confirm('Hapus kritik yang ditolak ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if($critique->status === 'selesai')
                                                        <form action="{{ route('critique.archive', $critique->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-sm btn-secondary">
                                                                <i class="fas fa-archive"></i> Arsip
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $critiques->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5>Tidak Ada Kritik Aktif</h5>
                        <p class="text-muted">Semua kritik sudah diarsipkan atau belum ada.</p>
                        <a href="{{ route('critique.create') }}" class="btn btn-primary">
                            <i class="fas fa-pen"></i> Kirim Kritik Pertama
                        </a>
                    </div>
                </div>
            @endif
        </div>

        {{-- TAB ARSIP --}}
        <div class="tab-pane fade" id="archived" role="tabpanel">
            @php
                $archivedCritiques = $critiques->filter(function($c) { return $c->is_archived; });
            @endphp

            @if($archivedCritiques->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kategori</th>
                                        <th>Tingkat</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($archivedCritiques as $index => $critique)
                                        <tr>
                                            <td>{{ $critiques->firstItem() + $index }}</td>
                                            <td>{{ Str::limit($critique->title, 30) }}</td>
                                            <td>{{ $critique->category->name }}</td>
                                            <td><span class="text-capitalize">{{ $critique->government_level }}</span></td>
                                            <td>
                                                <span class="badge badge-status badge-{{ $critique->status }}">
                                                    {{ ucfirst($critique->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $critique->submitted_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="d-flex gap-1 flex-wrap">
                                                    <a href="{{ route('critique.show', $critique->id) }}" class="btn btn-sm btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <form action="{{ route('critique.unarchive', $critique->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-undo"></i> Kembalikan
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('critique.delete.archived', $critique->id) }}" method="POST" class="d-inline"
                                                          onsubmit="return confirm('Hapus kritik dari arsip?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $critiques->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-archive fa-3x text-muted mb-3"></i>
                        <h5>Arsip Kosong</h5>
                        <p class="text-muted">Belum ada kritik yang diarsipkan.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
