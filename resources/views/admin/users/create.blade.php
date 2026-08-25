@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="fas fa-user-plus me-2"></i> Tambah Admin Baru
        </div>
        <div class="card-body">
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

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="username" name="username"
                            value="{{ old('username') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ old('phone') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span
                                class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="province_id" class="form-label">Provinsi <span class="text-danger">*</span></label>
                        <select class="form-select" id="province_id" name="province_id" required>
                            <option value="">Pilih Provinsi</option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province->id }}"
                                    {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="regency_id" class="form-label">Kabupaten/Kota <span class="text-danger">*</span></label>
                        <select class="form-select" id="regency_id" name="regency_id" required>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="district_id" class="form-label">Kecamatan <span class="text-danger">*</span></label>
                        <select class="form-select" id="district_id" name="district_id" required>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Admin
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                console.log('jQuery loaded!');

                $('#province_id').on('change', function() {
                    var provinceId = $(this).val();
                    console.log('Province selected:', provinceId);

                    if (provinceId) {
                        $.ajax({
                            url: '{{ url('/get-regencies') }}',
                            type: 'GET',
                            data: {
                                province_id: provinceId
                            },
                            dataType: 'json',
                            success: function(data) {
                                console.log('Regencies data:', data);
                                var $regencySelect = $('#regency_id');
                                $regencySelect.empty().append(
                                    '<option value="">Pilih Kabupaten/Kota</option>');
                                $.each(data, function(key, value) {
                                    $regencySelect.append('<option value="' + value.id +
                                        '">' + value.name + '</option>');
                                });
                                $('#district_id').empty().append(
                                    '<option value="">Pilih Kecamatan</option>');
                            },
                            error: function(xhr) {
                                console.log('Error AJAX:', xhr);
                                alert('Gagal mengambil data kabupaten/kota! Cek console F12');
                            }
                        });
                    } else {
                        $('#regency_id').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
                        $('#district_id').empty().append('<option value="">Pilih Kecamatan</option>');
                    }
                });

                $('#regency_id').on('change', function() {
                    var regencyId = $(this).val();
                    console.log('Regency selected:', regencyId);

                    if (regencyId) {
                        $.ajax({
                            url: '{{ url('/get-districts') }}',
                            type: 'GET',
                            data: {
                                regency_id: regencyId
                            },
                            dataType: 'json',
                            success: function(data) {
                                console.log('Districts data:', data);
                                var $districtSelect = $('#district_id');
                                $districtSelect.empty().append(
                                    '<option value="">Pilih Kecamatan</option>');
                                $.each(data, function(key, value) {
                                    $districtSelect.append('<option value="' + value.id +
                                        '">' + value.name + '</option>');
                                });
                            },
                            error: function(xhr) {
                                console.log('Error AJAX:', xhr);
                                alert('Gagal mengambil data kecamatan! Cek console F12');
                            }
                        });
                    } else {
                        $('#district_id').empty().append('<option value="">Pilih Kecamatan</option>');
                    }
                });
            });
        </script>
    @endpush
@endsection
