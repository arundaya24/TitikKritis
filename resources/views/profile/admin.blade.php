@extends('layouts.profile')

@section('content')
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2><i class="fas fa-user-shield me-2"></i> Profile Admin</h2>
                        <p class="text-muted">Kelola data pribadi Anda sebagai administrator.</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>

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

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        {{-- Avatar dengan tombol hapus --}}
                        <div class="position-relative d-inline-block">
                            <img src="{{ $user->avatar_url }}" alt="Avatar"
                                style="width: 130px; height: 130px; border-radius: 50%; object-fit: cover; border: 4px solid #0d6efd;">
                            @if ($user->avatar)
                                <div class="mt-2">
                                    <form action="{{ route('profile.delete.avatar') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Yakin ingin menghapus foto profile?')">
                                            <i class="fas fa-trash"></i> Hapus Foto
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <h5 class="mt-3 fw-bold">{{ $user->name }}</h5>
                        <p class="text-muted">@ {{ $user->username }}</p>
                        <p>
                            @if ($user->role === 'super_admin')
                                <span class="badge bg-danger">Super Admin</span>
                            @else
                                <span class="badge bg-primary">Admin</span>
                            @endif
                        </p>
                        <hr>
                        <p class="text-muted small">
                            <i class="fas fa-envelope me-1"></i> {{ $user->email }}
                        </p>
                        @if ($user->phone)
                            <p class="text-muted small">
                                <i class="fas fa-phone me-1"></i> {{ $user->phone }}
                            </p>
                        @endif
                        <p class="text-muted small">
                            <i class="fas fa-calendar-alt me-1"></i> Bergabung: {{ $user->created_at->format('d F Y') }}
                        </p>
                        <hr>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                {{-- Form Edit Profile --}}
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-edit me-2"></i> Edit Profile
                        @if ($user->role === 'super_admin')
                            <span class="badge bg-danger ms-2">Super Admin</span>
                        @else
                            <span class="badge bg-primary ms-2">Admin</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="avatar" class="form-label fw-semibold">Foto Profile</label>
                                <div class="d-flex align-items-center gap-3 flex-wrap">
                                    <img src="{{ $user->avatar_url }}" alt="Avatar"
                                        style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #0d6efd;">
                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control" id="avatar" name="avatar"
                                            accept="image/*">
                                        <small class="text-muted">Format: jpg, png, jpeg, gif. Maks: 2MB</small>
                                        @if ($user->avatar)
                                            <span class="badge bg-success mt-1">Foto terpasang</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $user->name }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">Username <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="{{ $user->username }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $user->email }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        value="{{ $user->phone }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="province_id" class="form-label">Provinsi <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="province_id" name="province_id" required>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}"
                                                {{ $user->province_id == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="regency_id" class="form-label">Kabupaten/Kota <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="regency_id" name="regency_id" required>
                                        @foreach ($regencies as $regency)
                                            <option value="{{ $regency->id }}"
                                                {{ $user->regency_id == $regency->id ? 'selected' : '' }}>
                                                {{ $regency->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="district_id" class="form-label">Kecamatan <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="district_id" name="district_id" required>
                                        @foreach ($districts as $district)
                                            <option value="{{ $district->id }}"
                                                {{ $user->district_id == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control" id="address" name="address" rows="2">{{ $user->address }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Profile
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Change Password --}}
                <div class="card mt-3">
                    <div class="card-header">
                        <i class="fas fa-key me-2"></i> Ubah Password
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.password') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="current_password"
                                    name="current_password" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password Baru <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key"></i> Ubah Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#province_id').change(function() {
                    var provinceId = $(this).val();
                    if (provinceId) {
                        $.get('/get-regencies?province_id=' + provinceId, function(data) {
                            $('#regency_id').empty().append(
                                '<option value="">Pilih Kabupaten/Kota</option>');
                            $.each(data, function(key, value) {
                                $('#regency_id').append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                            $('#district_id').empty().append(
                                '<option value="">Pilih Kecamatan</option>');
                        });
                    }
                });

                $('#regency_id').change(function() {
                    var regencyId = $(this).val();
                    if (regencyId) {
                        $.get('/get-districts?regency_id=' + regencyId, function(data) {
                            $('#district_id').empty().append(
                                '<option value="">Pilih Kecamatan</option>');
                            $.each(data, function(key, value) {
                                $('#district_id').append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                        });
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                // Update border avatar saat dark mode
                const avatarImg = document.querySelector('img[alt="Avatar"]');
                if (avatarImg) {
                    if (document.body.classList.contains('dark-mode')) {
                        avatarImg.style.borderColor = '#4fc3f7';
                    } else {
                        avatarImg.style.borderColor = '#0d6efd';
                    }
                }
            });
        </script>
    @endpush
@endsection
