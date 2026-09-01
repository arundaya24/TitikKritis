@extends('layouts.app')

@section('content')
<style>
    #formCol,
    #feedCol {
        transition: flex-basis .35s ease, max-width .35s ease, opacity .3s ease, padding .35s ease, margin .35s ease;
    }

    #feedCol.feed-collapsed {
        opacity: 0;
        pointer-events: none;
        overflow: hidden;
    }

    @media (min-width: 992px) {
        #feedCol.feed-collapsed {
            flex-basis: 0% !important;
            max-width: 0% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        #formCol.form-expanded {
            flex-basis: 100% !important;
            max-width: 100% !important;
        }
    }

    @media (max-width: 991.98px) {
        #formCol,
        #feedCol {
            flex-basis: 100%;
            max-width: 100%;
        }

        #feedCol.feed-collapsed {
            max-height: 0;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            margin-top: 0 !important;
        }

        #feedCol:not(.feed-collapsed) {
            max-height: 2000px;
            margin-top: 1rem;
        }
    }
</style>
<div class="container">
    <div class="d-flex justify-content-end mb-3">
        <button type="button" id="toggleFeedBtn" class="btn btn-outline-primary">
            <i class="fas fa-eye"></i> Tampilkan Kritik Warga
        </button>
    </div>
    <div class="row">
        <div class="col-lg-7 form-expanded" id="formCol">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-pen me-2"></i> Kirim Kritik
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

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

                    <form method="POST" action="{{ route('critique.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="government_level" class="form-label">Tingkat Pemerintahan <span class="text-danger">*</span></label>
                                <select class="form-select" id="government_level" name="government_level" required>
                                    <option value="">Pilih Tingkat</option>
                                    <option value="kecamatan" {{ old('government_level') == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                    <option value="kabupaten" {{ old('government_level') == 'kabupaten' ? 'selected' : '' }}>Kabupaten/Kota</option>
                                    <option value="provinsi" {{ old('government_level') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Bidang/Kategori <span class="text-danger">*</span></label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}"
                                            {{ (old('province_id') == $province->id || $user->province_id == $province->id) ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="regency_id" class="form-label">Kabupaten/Kota</label>
                                <select class="form-select" id="regency_id" name="regency_id">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                    @if(old('regency_id'))
                                        @php
                                            $regencies = App\Models\Regency::where('province_id', old('province_id'))->get();
                                        @endphp
                                        @foreach($regencies as $regency)
                                            <option value="{{ $regency->id }}" {{ old('regency_id') == $regency->id ? 'selected' : '' }}>
                                                {{ $regency->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="district_id" class="form-label">Kecamatan</label>
                                <select class="form-select" id="district_id" name="district_id">
                                    <option value="">Pilih Kecamatan</option>
                                    @if(old('district_id'))
                                        @php
                                            $districts = App\Models\District::where('regency_id', old('regency_id'))->get();
                                        @endphp
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Kritik <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Isi Kritik <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="content" name="content" rows="6" required>{{ old('content') }}</textarea>
                            <small class="text-muted">Kritik harus disampaikan secara bertanggung jawab dan tidak mengandung kata kasar.</small>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Foto/Dokumen Bukti</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*,.pdf,application/pdf">
                            <small class="text-muted">Format: jpg, png, jpeg, gif, pdf. Maks: 10MB</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_anonymous" name="is_anonymous"
                                    {{ old('is_anonymous') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_anonymous">
                                    <i class="fas fa-user-secret"></i> Kirim secara anonim
                                </label>
                            </div>
                            <small class="text-muted">Identitas Anda tetap diketahui oleh admin untuk keperluan verifikasi.</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Kirim Kritik
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5 feed-collapsed" id="feedCol">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-stream me-2"></i> Semua Kritik Warga
                </div>
                <div class="card-body" style="max-height: 720px; overflow-y: auto;">
                    @forelse($recentCritiques as $recent)
                        <div class="border-bottom pb-2 mb-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <h6 class="mb-1">{{ $recent->title }}</h6>
                                <span class="badge badge-status badge-{{ $recent->status }} ms-2">
                                    {{ ucfirst($recent->status) }}
                                </span>
                            </div>
                            <p class="mb-1 small">
                                {!! nl2br(e($recent->content)) !!}
                            </p>
                            <div class="small text-muted">
                                <i class="fas fa-user"></i> {{ $recent->submitter_name }}
                                &middot;
                                <i class="fas fa-tag"></i> {{ $recent->category->name }}
                                &middot;
                                {{ $recent->submitted_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">Belum ada kritik dari warga lain.</p>
                    @endforelse
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

        $('#toggleFeedBtn').click(function() {
            $('#feedCol').toggleClass('feed-collapsed');
            $('#formCol').toggleClass('form-expanded');

            if ($('#feedCol').hasClass('feed-collapsed')) {
                $(this).html('<i class="fas fa-eye"></i> Tampilkan Kritik Warga');
            } else {
                $(this).html('<i class="fas fa-eye-slash"></i> Sembunyikan Kritik Warga');
            }
        });
    });
</script>
@endpush
@endsection
