@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-archive me-2"></i> Arsip Kritik</span>
        <a href="{{ route('admin.critiques.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Kritik
        </a>
    </div>
    <div class="card-body">
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

        <div class="alert alert-info">
            <i class="fas fa-info-circle me-1"></i>
            Halaman ini menampilkan semua kritik yang sudah diarsipkan. Kritik arsip bisa <strong>dikembalikan</strong> atau <strong>dihapus permanen</strong>.
        </div>

        <form method="GET" action="{{ route('admin.critiques.archive.list') }}" class="mb-3">
            <div class="row g-2">
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="category">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari judul/konten..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filter
                    </button>
                </div>
            </div>
        </form>

        @if($critiques->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Pengirim</th>
                            <th>Kategori</th>
                            <th>Tingkat</th>
                            <th>Status</th>
                            <th>Tanggal Arsip</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($critiques as $index => $critique)
                            <tr>
                                <td>{{ $critiques->firstItem() + $index }}</td>
                                <td>{{ Str::limit($critique->title, 30) }}</td>
                                <td>{{ $critique->is_anonymous ? 'Anonim' : $critique->user->name }}</td>
                                <td>{{ $critique->category->name }}</td>
                                <td><span class="text-capitalize">{{ $critique->government_level }}</span></td>
                                <td>
                                    <span class="badge badge-status badge-{{ $critique->status }}">
                                        {{ ucfirst($critique->status) }}
                                    </span>
                                </td>
                                <td>{{ $critique->updated_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('admin.critiques.show', $critique->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <form action="{{ route('admin.critiques.unarchive', $critique->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="fas fa-undo"></i> Kembalikan
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.critiques.delete.archived', $critique->id) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Hapus kritik dari arsip permanen?')">
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
                {{ $critiques->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-archive fa-3x text-muted mb-3"></i>
                <h5>Arsip Kosong</h5>
                <p class="text-muted">Belum ada kritik yang diarsipkan.</p>
                <a href="{{ route('admin.critiques.index') }}" class="btn btn-primary">
                    <i class="fas fa-list"></i> Kembali ke Daftar Kritik
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
