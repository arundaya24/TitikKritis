@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-users-cog me-2"></i> Kelola Admin</span>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Admin
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
            <strong>Info:</strong>
            <span class="badge bg-danger">Super Admin</span> memiliki akses penuh.
            <span class="badge bg-primary">Admin</span> memiliki akses terbatas.
            Minimal harus ada 1 admin/super admin yang aktif.
        </div>

        @if($admins->count() > 0)
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
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($admins as $index => $admin)
                            <tr>
                                <td>{{ $admins->firstItem() + $index }}</td>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->username }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    @if($admin->role === 'super_admin')
                                        <span class="badge bg-danger">Super Admin</span>
                                    @else
                                        <span class="badge bg-primary">Admin</span>
                                    @endif
                                </td>
                                <td>{{ $admin->province->name ?? '-' }}</td>
                                <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">
                                        @if($admin->id !== auth()->id())
                                            {{-- Promote ke Super Admin (hanya super admin) --}}
                                            @if(auth()->user()->canCreateSuperAdmin() && $admin->role !== 'super_admin')
                                                <form action="{{ route('admin.users.promote', $admin->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Jadikan {{ $admin->name }} sebagai Super Admin?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Jadikan Super Admin">
                                                        <i class="fas fa-crown"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Turunkan ke User --}}
                                            @if(auth()->user()->canManageAdmins() || $admin->role !== 'super_admin')
                                                <form action="{{ route('admin.users.demote', $admin->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Turunkan {{ $admin->name }} menjadi user biasa?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-warning btn-sm" title="Turunkan menjadi user">
                                                        <i class="fas fa-user-minus"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Hapus --}}
                                            @if(auth()->user()->canManageAdmins() || $admin->role !== 'super_admin')
                                                <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('Hapus {{ $admin->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Anda</span>
                                            @if($admin->role === 'super_admin')
                                                <span class="badge bg-danger">Super Admin</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                {{ $admins->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                <h5>Belum Ada Admin</h5>
                <p class="text-muted">Tambahkan admin baru untuk mengelola sistem.</p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Admin
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
