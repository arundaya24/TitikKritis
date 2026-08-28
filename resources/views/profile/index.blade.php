@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2><i class="fas fa-user-circle me-2"></i> Profile</h2>
                <p class="text-muted">Kelola data pribadi Anda.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
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
                        <div class="profile-image mx-auto"
                            style="width: 80px; height: 80px; font-size: 2.5rem; background-color: #0d6efd; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h5 class="mt-3">{{ $user->name }}</h5>
                        <p class="text-muted">{{ $user->username }}</p>
                        <p><span class="badge bg-info">{{ ucfirst($user->role) }}</span></p>
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
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-edit me-2"></i> Edit Profile
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')
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
                                        <option value="">Pilih Kabupaten/Kota</option>
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
                                        <option value="">Pilih Kecamatan</option>
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
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
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
        </script>
    @endpush
@endsection
