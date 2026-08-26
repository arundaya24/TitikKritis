@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-user me-2"></i> Detail User</span>
                <a href="{{ route('admin.users.manage') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                {{-- Profile --}}
                <div class="row mb-4">
                    <div class="col-md-3 text-center">
                        <div style="width:100px;height:100px;border-radius:50%;background:#0d6efd;color:white;display:flex;align-items:center;justify-content:center;font-size:3rem;margin:0 auto;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h5 class="mt-3">{{ $user->name }}</h5>
                        <p class="text-muted">{{ $user->username }}</p>
                        <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-info' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-envelope"></i> Email:</strong> {{ $user->email }}</p>
                                <p><strong><i class="fas fa-phone"></i> Telepon:</strong> {{ $user->phone ?? '-' }}</p>
                                <p><strong><i class="fas fa-calendar"></i> Bergabung:</strong> {{ $user->created_at->format('d F Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong><i class="fas fa-map-marker-alt"></i> Provinsi:</strong> {{ $user->province->name ?? '-' }}</p>
                                <p><strong><i class="fas fa-map-pin"></i> Kabupaten/Kota:</strong> {{ $user->regency->name ?? '-' }}</p>
                                <p><strong><i class="fas fa-map"></i> Kecamatan:</strong> {{ $user->district->name ?? '-' }}</p>
                                <p><strong><i class="fas fa-home"></i> Alamat:</strong> {{ $user->address ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Statistik Kritik --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h5>Total Kritik</h5>
                                <h2>{{ $totalCritiques }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body text-center">
                                <h5>Menunggu</h5>
                                <h2>{{ $critiqueStatus['dikirim'] ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h5>Diproses</h5>
                                <h2>{{ ($critiqueStatus['ditinjau'] ?? 0) + ($critiqueStatus['diproses'] ?? 0) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h5>Selesai</h5>
                                <h2>{{ $critiqueStatus['selesai'] ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Daftar Kritik User --}}
                <h5><i class="fas fa-list me-2"></i> Daftar Kritik</h5>
                @if($user->critiques->count() > 0)
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
                                @foreach($user->critiques as $index => $critique)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ Str::limit($critique->title, 30) }}</td>
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
                    <p class="text-muted">User ini belum pernah mengirim kritik.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
