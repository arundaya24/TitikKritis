@extends('layouts.app')

@section('content')
    <style>
        @media (min-width: 992px) {
            #critiqueRow {
                position: relative;
                /* acuan posisi absolute #feedCol */
            }

            /* Default: form FULL WIDTH (feed masih tersembunyi) */
            #formCol {
                flex: 0 0 100%;
                max-width: 100%;
                transition: flex-basis .45s cubic-bezier(.4, 0, .2, 1),
                    max-width .45s cubic-bezier(.4, 0, .2, 1);
            }

            /* Saat feed dibuka, form menyempit jadi setara col-lg-7 */
            #formCol.form-shrunk {
                flex: 0 0 58.333333%;
                max-width: 58.333333%;
            }

            /* #feedCol di luar alur flex (absolute), supaya TIDAK PERNAH
                                       mempengaruhi tinggi #critiqueRow -> footer tidak ikut naik/turun */
            #feedCol {
                position: absolute;
                top: 0;
                right: 15px;
                width: 0;
                opacity: 0;
                overflow: hidden;
                pointer-events: none;
                transition: width .45s cubic-bezier(.4, 0, .2, 1),
                    opacity .3s ease;
            }

            #feedCol.feed-open {
                width: 41.666667%;
                opacity: 1;
                pointer-events: auto;
            }

            #feedCol .feed-inner {
                width: 100%;
                /* dioverride presisi via JS */
            }
        }

        @media (max-width: 991.98px) {

            #formCol,
            #feedCol {
                flex-basis: 100%;
                max-width: 100%;
            }

            #feedCol {
                display: grid;
                grid-template-rows: 0fr;
                margin-top: 0;
                transition: grid-template-rows .4s cubic-bezier(.4, 0, .2, 1),
                    opacity .3s ease,
                    margin-top .4s ease;
                opacity: 0;
            }

            #feedCol .feed-inner {
                min-height: 0;
                overflow: hidden;
            }

            #feedCol.feed-open {
                grid-template-rows: 1fr;
                opacity: 1;
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
        <div class="row" id="critiqueRow">
            <div class="col-lg-7" id="formCol">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-pen me-2"></i> Kirim Kritik
                    </div>
                    <div class="card-body">
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

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Laporan hari ini:
                            <strong>{{ $todayReports }}/{{ $maxDailyReports }}</strong>

                            @if ($todayReports < $maxDailyReports)
                                <br>
                                Sisa laporan hari ini:
                                <strong>{{ $maxDailyReports - $todayReports }}</strong>
                            @else
                                <br>
                                <strong>Batas laporan hari ini sudah tercapai.</strong>
                                <br>
                                Kuota akan direset pada pukul 00:00 WIB.
                            @endif
                        </div>

                        <form method="POST" action="{{ route('critique.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="government_level" class="form-label">Tingkat Pemerintahan <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="government_level" name="government_level" required>
                                        <option value="">Pilih Tingkat</option>
                                        <option value="kecamatan"
                                            {{ old('government_level') == 'kecamatan' ? 'selected' : '' }}>Kecamatan
                                        </option>
                                        <option value="kabupaten"
                                            {{ old('government_level') == 'kabupaten' ? 'selected' : '' }}>Kabupaten/Kota
                                        </option>
                                        <option value="provinsi"
                                            {{ old('government_level') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="category_id" class="form-label">Bidang/Kategori <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="province_id" class="form-label">Provinsi <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="province_id" name="province_id" required>
                                        <option value="">Pilih Provinsi</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}"
                                                {{ old('province_id') == $province->id || $user->province_id == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="regency_id" class="form-label">Kabupaten/Kota</label>
                                    <select class="form-select" id="regency_id" name="regency_id">
                                        <option value="">Pilih Kabupaten/Kota</option>
                                        @if (old('regency_id'))
                                            @php
                                                $regencies = App\Models\Regency::where(
                                                    'province_id',
                                                    old('province_id'),
                                                )->get();
                                            @endphp
                                            @foreach ($regencies as $regency)
                                                <option value="{{ $regency->id }}"
                                                    {{ old('regency_id') == $regency->id ? 'selected' : '' }}>
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
                                        @if (old('district_id'))
                                            @php
                                                $districts = App\Models\District::where(
                                                    'regency_id',
                                                    old('regency_id'),
                                                )->get();
                                            @endphp
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}"
                                                    {{ old('district_id') == $district->id ? 'selected' : '' }}>
                                                    {{ $district->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Kritik <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Isi Kritik <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="content" name="content" rows="6" required>{{ old('content') }}</textarea>
                                <small class="text-muted">Kritik harus disampaikan secara bertanggung jawab dan tidak
                                    mengandung kata kasar.</small>
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Foto/Dokumen Bukti</label>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*,.pdf,application/pdf">
                                <small class="text-muted">Format: jpg, png, jpeg, gif, pdf. Maks: 10MB</small>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is_anonymous"
                                        name="is_anonymous" {{ old('is_anonymous') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_anonymous">
                                        <i class="fas fa-user-secret"></i> Kirim secara anonim
                                    </label>
                                </div>
                                <small class="text-muted">Identitas Anda tetap diketahui oleh admin untuk keperluan
                                    verifikasi.</small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary"
                                    {{ !$canSend || $todayReports >= $maxDailyReports ? 'disabled' : '' }}>
                                    <i class="fas fa-paper-plane"></i> Kirim Kritik
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5" id="feedCol">
                <div class="feed-inner">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-stream me-2"></i> Semua Kritik Warga
                        </div>
                        <div class="card-body" style="max-height: 740px; overflow-y: auto;">
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
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const submitButton = document.querySelector('button[type="submit"]');

                let remainingTotalSeconds = {{ $remainingMinutes * 60 + $remainingSeconds }};

                if (remainingTotalSeconds <= 0) {
                    return;
                }

                submitButton.disabled = true;

                const countdown = setInterval(function() {
                    remainingTotalSeconds--;

                    if (remainingTotalSeconds <= 0) {
                        clearInterval(countdown);

                        @if ($todayReports < $maxDailyReports)
                            submitButton.disabled = false;
                        @endif

                        return;
                    }
                }, 1000);
            });
            $(document).ready(function() {
                $('#province_id').change(function() {
                    var provinceId = $(this).val();
                    if (provinceId) {
                        $.get('/get-regencies-critique?province_id=' + provinceId, function(data) {
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
                        $.get('/get-districts-critique?regency_id=' + regencyId, function(data) {
                            $('#district_id').empty().append(
                                '<option value="">Pilih Kecamatan</option>');
                            $.each(data, function(key, value) {
                                $('#district_id').append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                        });
                    }
                });

                // Pin lebar konten kartu feed (px) supaya teks di dalamnya
                // tidak reflow selama #feedCol melebar/menyempit.
                function pinFeedInnerWidth() {
                    if ($(window).width() < 992) {
                        $('#feedCol .feed-inner').css('width', '');
                        return;
                    }
                    var rowWidth = $('#critiqueRow').width();
                    var expandedWidth = (rowWidth * (5 / 12)) - 15; // setara col-lg-5 dikurangi padding
                    $('#feedCol .feed-inner').css('width', expandedWidth + 'px');
                }

                pinFeedInnerWidth();
                $(window).on('resize', pinFeedInnerWidth);

                $('#toggleFeedBtn').click(function() {
                    var $feed = $('#feedCol');
                    var $form = $('#formCol');
                    var $btn = $(this);
                    var opening = !$feed.hasClass('feed-open');

                    pinFeedInnerWidth();

                    $feed.toggleClass('feed-open', opening);
                    $form.toggleClass('form-shrunk', opening);

                    $btn.html(opening ?
                        '<i class="fas fa-eye-slash"></i> Sembunyikan Kritik Warga' :
                        '<i class="fas fa-eye"></i> Tampilkan Kritik Warga');
                });
            });
        </script>
    @endpush
@endsection
