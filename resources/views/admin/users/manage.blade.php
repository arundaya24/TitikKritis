@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-users me-2"></i> Manajemen User</span>
            <span class="badge bg-primary">{{ $totalUsers }} Total User</span>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Statistik --}}
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-light">
                        <div class="card-body text-center bg-primary" style="border-radius: 10px;">
                            <h5 class="card-title">Total User</h5>
                            <h2>{{ $totalUsers }}</h2>
                            <small>Semua user terdaftar</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-light">
                        <div class="card-body text-center bg-success" style="border-radius: 10px;">
                            <h5 class="card-title">User Aktif</h5>
                            <h2>{{ $activeUsers }}</h2>
                            <small>Pernah kirim kritik</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-light">
                        <div class="card-body text-center bg-info" style="border-radius: 10px;">
                            <h5 class="card-title">Total Admin</h5>
                            <h2>{{ $totalAdmins }}</h2>
                            <small>Role administrator</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-light">
                        <div class="card-body text-center bg-warning" style="border-radius: 10px;">
                            <h5 class="card-title">Total Kritik</h5>
                            <h2>{{ $totalCritiques }}</h2>
                            <small>Semua kritik terkirim</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tabel User --}}
            @if ($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Wilayah</th>
                                <th>Jumlah Kritik</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>{{ $user->province->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $user->critiques_count ?? 0 }}</span>
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.users.detail', $user->id) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($user->id !== auth()->id())
                                                <a href="{{ route('admin.users.toggle', $user->id) }}"
                                                    class="btn btn-success btn-sm"
                                                    onclick="return confirm('Jadikan user ini sebagai Admin?')">
                                                    <i class="fas fa-user-shield"></i>
                                                </a>
                                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini beserta semua kritiknya?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-secondary">Anda</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                    <h5>Belum Ada User</h5>
                    <p class="text-muted">Belum ada user yang terdaftar.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
