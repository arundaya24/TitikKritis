@extends('layouts.admin')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Kelola Admin</h2>
            <p class="text-muted mb-0">Kelola akun Admin dan Super Admin</p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            Tambah Admin
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Admin</h6>
                    <h3 class="fw-bold">{{ $totalAdmins }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Super Admin</h6>
                    <h3 class="fw-bold">{{ $totalSuperAdmins }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Administrator</h6>
                    <h3 class="fw-bold">{{ $totalAdmins + $totalSuperAdmins }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Bergabung</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($admins as $admin)
                            <tr>
                                <td>
                                    <div class="fw-semibold">
                                        {{ $admin->name }}
                                    </div>
                                </td>

                                <td>
                                    {{ '@' . $admin->username }}
                                </td>

                                <td>
                                    {{ $admin->email }}
                                </td>

                                <td>
                                    @if($admin->hasRole('superadmin'))
                                        <span class="badge bg-danger">
                                            Super Admin
                                        </span>
                                    @else
                                        <span class="badge bg-primary">
                                            Admin
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $admin->created_at->format('d M Y') }}
                                </td>

                                <td>
                                    <div class="d-flex gap-2">

                                        @if(auth()->user()->hasRole('superadmin') && !$admin->hasRole('superadmin'))
                                            <form action="{{ route('admin.users.promote', $admin->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <button type="submit" class="btn btn-sm btn-warning">
                                                    Jadikan Super Admin
                                                </button>
                                            </form>
                                        @endif

                                        @if(auth()->user()->hasRole('superadmin') || !$admin->hasRole('superadmin'))
                                            @if($admin->id !== auth()->id())
                                                <form action="{{ route('admin.users.demote', $admin->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <button type="submit" class="btn btn-sm btn-secondary">
                                                        Turunkan
                                                    </button>
                                                </form>
                                            @endif
                                        @endif

                                        @if(auth()->user()->hasRole('superadmin') || !$admin->hasRole('superadmin'))
                                            @if($admin->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $admin->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    Belum ada admin.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $admins->links() }}
            </div>

        </div>
    </div>

</div>
@endsection
