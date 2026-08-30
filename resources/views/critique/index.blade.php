@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i> Kritik Saya</span>
            <span class="badge bg-primary">{{ $critiques->total() }} Total</span>
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

            <form method="GET" action="{{ route('critique.index') }}" class="mb-3">
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
                    <div class="col-md-2">
                        <select class="form-select" name="archived">
                            <option value="">Semua</option>
                            <option value="0" {{ request('archived') == '0' ? 'selected' : '' }}>Aktif</option>
                            <option value="1" {{ request('archived') == '1' ? 'selected' : '' }}>Arsip</option>
                        </select>
                    </div>
                    <div class="col-md-2">
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
                                <th>Kategori</th>
                                <th>Tingkat</th>
                                <th>Status</th>
                                <th>Arsip</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($critiques as $index => $critique)
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
                                    <td>
                                        @if($critique->is_archived)
                                            <span class="badge bg-secondary">📦 Arsip</span>
                                        @else
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
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

                                            @if($critique->status === 'ditolak' && !$critique->is_archived)
                                                <form action="{{ route('critique.force.delete', $critique->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Hapus kritik yang ditolak ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif

                                            @if($critique->status === 'selesai' && !$critique->is_archived)
                                                <form action="{{ route('critique.archive', $critique->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-secondary">
                                                        <i class="fas fa-archive"></i> Arsip
                                                    </button>
                                                </form>
                                            @endif

                                            @if($critique->is_archived)
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
                                            @endif
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
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>Belum Ada Kritik</h5>
                    <p class="text-muted">Anda belum pernah mengirim kritik.</p>
                    <a href="{{ route('critique.create') }}" class="btn btn-primary">
                        <i class="fas fa-pen"></i> Kirim Kritik Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
