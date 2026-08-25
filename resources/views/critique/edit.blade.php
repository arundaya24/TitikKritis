@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-edit me-2"></i> Edit Kritik
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('critique.update', $critique->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="government_level" class="form-label">Tingkat Pemerintahan <span class="text-danger">*</span></label>
                                <select class="form-select" id="government_level" name="government_level" required>
                                    <option value="kecamatan" {{ $critique->government_level == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                    <option value="kabupaten" {{ $critique->government_level == 'kabupaten' ? 'selected' : '' }}>Kabupaten/Kota</option>
                                    <option value="provinsi" {{ $critique->government_level == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Bidang/Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $critique->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="province_id" class="form-label">Provinsi <span class="text-danger">*</span></label>
                                <select class="form-select" id="province_id" name="province_id" required>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ $critique->province_id == $province->id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="regency_id" class="form-label">Kabupaten/Kota</label>
                                <select class="form-select" id="regency_id" name="regency_id">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                    @foreach($regencies as $regency)
                                        <option value="{{ $regency->id }}" {{ $critique->regency_id == $regency->id ? 'selected' : '' }}>
                                            {{ $regency->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="district_id" class="form-label">Kecamatan</label>
                                <select class="form-select" id="district_id" name="district_id">
                                    <option value="">Pilih Kecamatan</option>
                                    @foreach($districts as $district)
                                        <option value="{{ $district->id }}" {{ $critique->district_id == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Kritik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $critique->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Isi Kritik <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="content" name="content" rows="6" required>{{ $critique->content }}</textarea>
                            <small class="text-muted">Kritik harus disampaikan secara bertanggung jawab dan tidak mengandung kata kasar.</small>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Foto Bukti</label>
                            @if($critique->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $critique->image) }}" alt="Foto Bukti" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Format: jpg, png, jpeg, gif. Maks: 2MB</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_anonymous" name="is_anonymous"
                                       {{ $critique->is_anonymous ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_anonymous">
                                    <i class="fas fa-user-secret"></i> Kirim secara anonim
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('critique.show', $critique->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Kritik
                            </button>
                        </div>
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
            $.get('/get-regencies-critique?province_id=' + provinceId, function(data) {
                $('#regency_id').empty().append('<option value="">Pilih Kabupaten/Kota</option>');
                $.each(data, function(key, value) {
                    $('#regency_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                });
                $('#district_id').empty().append('<option value="">Pilih Kecamatan</option>');
            });
        }
    });

    $('#regency_id').change(function() {
        var regencyId = $(this).val();
        if (regencyId) {
            $.get('/get-districts-critique?regency_id=' + regencyId, function(data) {
                $('#district_id').empty().append('<option value="">Pilih Kecamatan</option>');
                $.each(data, function(key, value) {
                    $('#district_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                });
            });
        }
    });
});
</script>
@endpush
@endsection
