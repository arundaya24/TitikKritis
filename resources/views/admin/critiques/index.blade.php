@extends('layouts.admin')

@section('content')
<div class="card" style="border-radius: 0px;">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-list me-2"></i> Daftar Kritik</span>
        <span class="badge bg-primary">{{ $critiques->total() }} Total</span>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.critiques.index') }}" class="mb-3">
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
                            <th>Tanggal</th>
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
            <div class="d-flex justify-content-center">
                {{ $critiques->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <h5>Belum Ada Kritik</h5>
                <p class="text-muted">Tidak ada kritik yang masuk.</p>
            </div>
        @endif
    </div>
</div>
@endsection
