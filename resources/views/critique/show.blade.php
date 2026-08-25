@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
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

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>
                        <i class="fas fa-file-alt me-2"></i> Detail Kritik
                    </span>
                    <span class="badge badge-status badge-{{ $critique->status }}">
                        {{ ucfirst($critique->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <h3>{{ $critique->title }}</h3>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user"></i> Pengirim:</strong>
                                {{ $critique->is_anonymous ? 'Anonim' : $critique->user->name }}
                            </p>
                            <p><strong><i class="fas fa-tag"></i> Kategori:</strong> {{ $critique->category->name }}</p>
                            <p><strong><i class="fas fa-layer-group"></i> Tingkat:</strong>
                                <span class="text-capitalize">{{ $critique->government_level }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-map-marker-alt"></i> Wilayah:</strong>
                                {{ $critique->province->name }}
                                @if($critique->regency)
                                    , {{ $critique->regency->name }}
                                @endif
                                @if($critique->district)
                                    , {{ $critique->district->name }}
                                @endif
                            </p>
                            <p><strong><i class="fas fa-calendar"></i> Tanggal:</strong>
                                {{ $critique->submitted_at->format('d F Y H:i') }}
                            </p>
                            @if($critique->is_anonymous)
                                <p><strong><i class="fas fa-user-secret"></i> Status:</strong>
                                    <span class="badge bg-secondary">Anonim</span>
                                </p>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <h5>Isi Kritik</h5>
                        <div class="p-3 bg-light rounded">
                            {{ nl2br($critique->content) }}
                        </div>
                    </div>

                    @if($critique->image)
                        <div class="mb-3">
                            <h5>Foto Bukti</h5>
                            <img src="{{ asset('storage/' . $critique->image) }}" alt="Foto Bukti" class="img-fluid rounded" style="max-height: 400px;">
                        </div>
                    @endif

                    @if($critique->admin_note)
                        <div class="mb-3">
                            <h5><i class="fas fa-sticky-note text-warning"></i> Catatan Admin</h5>
                            <div class="p-3 bg-warning bg-opacity-10 rounded">
                                {{ $critique->admin_note }}
                            </div>
                        </div>
                    @endif

                    @if($critique->response)
                        <div class="mb-3">
                            <h5><i class="fas fa-reply text-success"></i> Tanggapan Admin</h5>
                            <div class="p-3 bg-success bg-opacity-10 rounded">
                                <p><strong>Admin:</strong> {{ $critique->response->admin->name }}</p>
                                <p>{{ $critique->response->content }}</p>
                                <small class="text-muted">{{ $critique->response->created_at->format('d F Y H:i') }}</small>
                            </div>
                        </div>
                    @endif

                    @if($critique->histories->count() > 0)
                        <div class="mb-3">
                            <h5><i class="fas fa-history"></i> Riwayat Status</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Status Sebelum</th>
                                            <th>Status Baru</th>
                                            <th>Diubah Oleh</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($critique->histories as $history)
                                            <tr>
                                                <td>
                                                    @if($history->old_status)
                                                        <span class="badge badge-status badge-{{ $history->old_status }}">
                                                            {{ ucfirst($history->old_status) }}
                                                        </span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge badge-status badge-{{ $history->new_status }}">
                                                        {{ ucfirst($history->new_status) }}
                                                    </span>
                                                </td>
                                                <td>{{ $history->changer->name }}</td>
                                                <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('critique.history') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <div>
                            @if($critique->status === 'dikirim')
                                <a href="{{ route('critique.edit', $critique->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('critique.destroy', $critique->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kritik ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
