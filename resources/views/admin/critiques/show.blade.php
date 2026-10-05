@extends('layouts.admin')

@section('content')

    <style>
        .badge-status { -webkit-print-color-adjust: exact; print-color-adjust: exact; }

        .print-only { display: none; }

        @media print {
            /* Sembunyikan semua elemen layout (sidebar, navbar, dll), tampilkan hanya area cetak */
            body * { visibility: hidden !important; }
            #print-area, #print-area * { visibility: visible !important; }
            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print, .no-print * { display: none !important; }
            .print-only { display: block !important; }
            .card { border: none !important; box-shadow: none !important; }
            .bg-light { background-color: #f8f9fa !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            img { max-width: 100% !important; page-break-inside: avoid; }
            .border.rounded { page-break-inside: avoid; }
        }
    </style>

    <div class="row">
        <div class="col-12">

            <div class="no-print">
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
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- ===================== AREA CETAK ===================== --}}
            <div id="print-area">

                <div class="print-only text-center mb-3">
                    <h4 class="mb-0">Laporan Kritik #{{ $critique->id }}</h4>
                    <small>Dicetak pada {{ now()->format('d F Y H:i') }}</small>
                    <hr>
                </div>

                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-file-alt me-2"></i>
                            Detail Kritik
                        </span>

                        <span class="badge badge-status badge-{{ $critique->status }}">
                            {{ ucfirst($critique->status) }}
                        </span>
                    </div>

                    <div class="card-body">

                        <div class="row mb-3">

                            <div class="col-md-6">

                                <h3>{{ $critique->title }}</h3>

                                <p>
                                    <strong><i class="fas fa-user"></i> Pengirim:</strong>
                                    {{ $critique->is_anonymous ? 'Anonim' : $critique->user->name }}
                                </p>

                                <p>
                                    <strong><i class="fas fa-user-tag"></i> Username:</strong>
                                    {{ $critique->is_anonymous ? 'anonim' : $critique->user->username }}
                                </p>

                                <p>
                                    <strong><i class="fas fa-envelope"></i> Email:</strong>
                                    {{ $critique->is_anonymous ? 'Tidak tersedia' : $critique->user->email }}
                                </p>

                                <p>
                                    <strong><i class="fas fa-phone"></i> Telepon:</strong>
                                    {{ $critique->is_anonymous ? 'Tidak tersedia' : $critique->user->phone ?? '-' }}
                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>
                                    <strong><i class="fas fa-tag"></i> Kategori:</strong>
                                    {{ $critique->category->name }}
                                </p>

                                <p>
                                    <strong><i class="fas fa-layer-group"></i> Tingkat:</strong>
                                    <span class="text-capitalize">{{ $critique->government_level }}</span>
                                </p>

                                <p>
                                    <strong><i class="fas fa-map-marker-alt"></i> Wilayah:</strong>
                                    {{ $critique->province->name }}
                                    @if ($critique->regency)
                                        , {{ $critique->regency->name }}
                                    @endif
                                    @if ($critique->district)
                                        , {{ $critique->district->name }}
                                    @endif
                                </p>

                                <p>
                                    <strong><i class="fas fa-calendar"></i> Tanggal:</strong>
                                    {{ $critique->submitted_at->format('d F Y H:i') }}
                                </p>

                                @if ($critique->is_anonymous)
                                    <p>
                                        <strong><i class="fas fa-user-secret"></i> Status:</strong>
                                        <span class="badge bg-secondary">Anonim</span>
                                    </p>
                                @endif

                            </div>

                        </div>

                        <hr>

                        <div class="mb-4">
                            <h5>
                                <i class="fas fa-align-left me-2"></i>
                                Isi Kritik
                            </h5>

                            <div class="p-3 bg-light rounded">
                                {!! nl2br(e($critique->content)) !!}
                            </div>
                        </div>

                        @if ($critique->image)
                            <div class="mb-4">
                                <h5>
                                    <i class="fas fa-paperclip me-2"></i>
                                    Bukti dari Pengguna
                                </h5>

                                @if (str_ends_with(strtolower($critique->image), '.pdf'))
                                    <a href="{{ asset('storage/' . $critique->image) }}"
                                       target="_blank"
                                       class="btn btn-outline-secondary">
                                        <i class="fas fa-file-pdf me-2"></i>
                                        Buka Dokumen PDF
                                    </a>
                                @else
                                    <img src="{{ asset('storage/' . $critique->image) }}"
                                         alt="Foto Bukti"
                                         class="img-fluid rounded"
                                         style="max-height: 400px;">
                                @endif
                            </div>
                        @endif

                        <div class="mb-4">

                            <h5 class="mb-3">
                                <i class="fas fa-comments me-2"></i>
                                Balasan Dari Pengguna
                            </h5>

                            @if ($critique->messages && $critique->messages->count())

                                @foreach ($critique->messages->sortBy('created_at') as $message)

                                    <div class="border rounded p-3 mb-3">

                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <strong>
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ $message->user?->name ?? 'Pengguna' }}
                                                </strong>

                                                @if ($message->user_id === $critique->user_id)
                                                    <span class="badge bg-primary ms-2">Pengguna</span>
                                                @endif
                                            </div>

                                            <small class="text-muted">
                                                {{ $message->created_at->format('d F Y H:i') }}
                                            </small>
                                        </div>

                                        <div class="p-3 bg-light rounded">
                                            {!! nl2br(e($message->message)) !!}
                                        </div>

                                    </div>

                                @endforeach

                            @else

                                <div class="alert alert-light border">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Belum ada balasan dari pengguna.
                                </div>

                            @endif

                        </div>

                        @if ($critique->response)
                            <div class="mb-4">
                                <h5>
                                    <i class="fas fa-reply me-2"></i>
                                    Tanggapan Terakhir Admin
                                </h5>

                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($critique->response->content)) !!}
                                </div>

                                <small class="text-muted">
                                    {{ $critique->response->created_at->format('d F Y H:i') }}
                                </small>
                            </div>
                        @endif

                        @if ($critique->updates && $critique->updates->count())

                            <div class="mb-4">

                                <h5>
                                    <i class="fas fa-history me-2"></i>
                                    Riwayat Perubahan Status
                                </h5>

                                @foreach ($critique->updates->sortByDesc('created_at') as $update)

                                    <div class="border rounded p-3 mb-3">

                                        <div class="d-flex justify-content-between align-items-center">
                                            <strong>{{ $update->user->name ?? 'Admin' }}</strong>

                                            <small class="text-muted">
                                                {{ $update->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </div>

                                        <div class="my-2">
                                            <span class="badge badge-status badge-{{ $update->old_status }}">
                                                {{ ucfirst($update->old_status) }}
                                            </span>

                                            <i class="fas fa-arrow-right mx-2"></i>

                                            <span class="badge badge-status badge-{{ $update->new_status }}">
                                                {{ ucfirst($update->new_status) }}
                                            </span>
                                        </div>

                                        @if ($update->files && $update->files->count())

                                            <div class="mt-3">

                                                <strong class="d-block mb-2">
                                                    <i class="fas fa-paperclip me-1"></i>
                                                    Bukti Perubahan
                                                </strong>

                                                <div class="row g-2">

                                                    @foreach ($update->files as $file)

                                                        @php
                                                            $extension = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));
                                                            $fileUrl = asset('storage/' . $file->file_path);
                                                        @endphp

                                                        <div class="col-md-4">

                                                            <div class="border rounded p-2 h-100">

                                                                @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                                                                    <img src="{{ $fileUrl }}"
                                                                         alt="{{ $file->original_name }}"
                                                                         class="img-fluid rounded mb-2"
                                                                         style="height: 150px; width: 100%; object-fit: cover;">
                                                                @elseif ($extension === 'pdf')
                                                                    <div class="text-center py-4">
                                                                        <i class="fas fa-file-pdf text-danger" style="font-size: 48px;"></i>
                                                                    </div>
                                                                @elseif (in_array($extension, ['doc', 'docx']))
                                                                    <div class="text-center py-4">
                                                                        <i class="fas fa-file-word text-primary" style="font-size: 48px;"></i>
                                                                    </div>
                                                                @else
                                                                    <div class="text-center py-4">
                                                                        <i class="fas fa-file text-secondary" style="font-size: 48px;"></i>
                                                                    </div>
                                                                @endif

                                                                <div class="small text-truncate mb-2"
                                                                     title="{{ $file->original_name }}">
                                                                    {{ $file->original_name }}
                                                                </div>

                                                                <a href="{{ $fileUrl }}"
                                                                   target="_blank"
                                                                   class="btn btn-sm btn-outline-primary w-100 no-print">
                                                                    <i class="fas fa-external-link-alt me-1"></i>
                                                                    Lihat Bukti
                                                                </a>

                                                            </div>

                                                        </div>

                                                    @endforeach

                                                </div>

                                            </div>

                                        @else

                                            <div class="text-muted small mt-2">
                                                Tidak ada bukti pada perubahan ini.
                                            </div>

                                        @endif

                                    </div>

                                @endforeach

                            </div>

                        @endif

                        @if ($critique->histories->count() > 0)

                            <div class="mb-4">

                                <h5>
                                    <i class="fas fa-history me-2"></i>
                                    Riwayat Status
                                </h5>

                                <div class="table-responsive">

                                    <table class="table table-sm">

                                        <thead>
                                            <tr>
                                                <th>Status Sebelum</th>
                                                <th>Status Baru</th>
                                                <th>Diubah Oleh</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @foreach ($critique->histories as $history)
                                                <tr>
                                                    <td>
                                                        @if ($history->old_status)
                                                            <span class="badge badge-status badge-{{ $history->old_status }}">
                                                                {{ ucfirst($history->old_status) }}
                                                            </span>
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <span class="badge badge-status badge-{{ $history->new_status }}">
                                                            {{ ucfirst($history->new_status) }}
                                                        </span>
                                                    </td>

                                                    <td>{{ $history->changer->name ?? '-' }}</td>

                                                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>
            {{-- =================== END AREA CETAK =================== --}}

            {{-- ===================== TINDAK LANJUT (SATU KOTAK) ===================== --}}
            @php
                $nextStatuses = [
                    'dikirim'  => ['ditinjau' => 'Ditinjau', 'ditolak' => 'Ditolak'],
                    'ditinjau' => ['diproses' => 'Diproses', 'ditolak' => 'Ditolak'],
                    'diproses' => ['selesai'  => 'Selesai'],
                ][$critique->status] ?? [];
            @endphp

            <div class="card mt-4 no-print">

                <div class="card-header">
                    <i class="fas fa-edit me-2"></i>
                    Tindak Lanjut Laporan
                </div>

                <div class="card-body">

                    <form
                        id="followUpForm"
                        method="POST"
                        action="{{ route('admin.critiques.respond', $critique->id) }}"
                        enctype="multipart/form-data"
                    >

                        @csrf

                        <div class="row g-3">

                            <div class="col-md-4">

                                <label class="form-label">Ubah Status (opsional)</label>

                                <select name="status" id="statusSelect" class="form-select"
                                        @if (empty($nextStatuses)) disabled @endif>
                                    @if (empty($nextStatuses))
                                        <option value="">
                                            Status akhir ({{ ucfirst($critique->status) }}) - tidak dapat diubah
                                        </option>
                                    @else
                                        <option value="">-- Tidak mengubah status --</option>
                                        @foreach ($nextStatuses as $value => $label)
                                            <option value="{{ $value }}" @selected(old('status') === $value)>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>

                                <small class="text-muted d-block mt-1">
                                    Mengubah status wajib disertai bukti dan tanggapan.
                                </small>

                                <div class="mt-3">

                                    <label class="form-label">
                                        Bukti Perubahan
                                        <span class="text-danger d-none" id="filesRequiredMark">*</span>
                                    </label>

                                    <input
                                        type="file"
                                        name="files[]"
                                        id="filesInput"
                                        class="form-control"
                                        multiple
                                        accept="image/*,.pdf,.doc,.docx"
                                    >

                                    <small class="text-muted d-block mt-1">
                                        Opsional. Jika mengunggah bukti, tanggapan wajib diisi.
                                    </small>

                                </div>

                            </div>

                            <div class="col-md-8">

                                <label class="form-label">
                                    Tanggapan Admin
                                    <span class="text-danger d-none" id="contentRequiredMark">*</span>
                                </label>

                                <textarea
                                    name="content"
                                    id="contentInput"
                                    class="form-control"
                                    rows="7"
                                    placeholder="Tulis tanggapan kepada pengguna..."
                                >{{ old('content') }}</textarea>

                                <small class="text-muted">
                                    Tanggapan boleh dikirim sendiri tanpa bukti.
                                </small>

                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            <i class="fas fa-paper-plane me-2"></i>
                            Simpan &amp; Kirim
                        </button>

                    </form>

                </div>

            </div>

            <div class="mt-4 d-flex gap-2 no-print">

                <a href="{{ route('admin.critiques.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali
                </a>

                <button type="button" class="btn btn-outline-success" onclick="window.print()">
    <i class="fas fa-print me-2"></i>
    Cetak Laporan
</button>

            </div>

        </div>
    </div>

    <script>
        (function () {
            const form    = document.getElementById('followUpForm');
            const status  = document.getElementById('statusSelect');
            const files   = document.getElementById('filesInput');
            const content = document.getElementById('contentInput');
            const filesMark   = document.getElementById('filesRequiredMark');
            const contentMark = document.getElementById('contentRequiredMark');

            function sync() {
                const hasStatus = status.value !== '';
                const hasFiles  = files.files.length > 0;

                // ubah status -> wajib bukti; bukti -> wajib tanggapan
                files.required   = hasStatus;
                content.required = hasFiles || hasStatus;

                filesMark.classList.toggle('d-none', !hasStatus);
                contentMark.classList.toggle('d-none', !(hasFiles || hasStatus));
            }

            status.addEventListener('change', sync);
            files.addEventListener('change', sync);
            sync();

            form.addEventListener('submit', function (e) {
                if (status.value === '' && files.files.length === 0 && content.value.trim() === '') {
                    e.preventDefault();
                    alert('Isi tanggapan atau pilih perubahan status terlebih dahulu.');
                }
            });
        })();
    </script>

@endsection
