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
</style>
@endpush

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-archive me-2"></i> Arsip Kritik</h2>
                    <p class="text-muted">Kritik yang sudah Anda arsipkan.</p>
                </div>
                <a href="{{ route('critique.history') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Kembali ke History
                </a>
            </div>
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
                                    <td>{{ $loop->iteration }}</td>
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
                    {{ $archivedCritiques->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-archive fa-3x text-muted mb-3"></i>
                <h5>Arsip Kosong</h5>
                <p class="text-muted">Belum ada kritik yang diarsipkan.</p>
                <a href="{{ route('critique.history') }}" class="btn btn-primary">
                    <i class="fas fa-list"></i> Kembali ke History
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
