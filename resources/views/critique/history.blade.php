@extends('layouts.app')

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

    @if($critiques->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Kategori</th>
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
                                    <td>{{ $critique->category->name }}</td>
                                    <td>
                                        <span class="badge badge-status badge-{{ $critique->status }}">
                                            {{ ucfirst($critique->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $critique->submitted_at->format('d/m/Y H:i') }}</td>
                                    <td>
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
                <h5>Belum Ada Kritik</h5>
                <p class="text-muted">Anda belum mengirimkan kritik apapun.</p>
                <a href="{{ route('critique.create') }}" class="btn btn-primary">
                    <i class="fas fa-pen"></i> Kirim Kritik Pertama
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
