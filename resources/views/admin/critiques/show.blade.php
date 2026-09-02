@extends('layouts.admin')

@section('content')

    <div class="row">
        <div class="col-12">

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

                    {{-- INFORMASI LAPORAN --}}
                    <div class="row mb-3">

                        <div class="col-md-6">

                            <h3>{{ $critique->title }}</h3>

                            <p>
                                <strong>
                                    <i class="fas fa-user"></i> Pengirim:
                                </strong>
                                {{ $critique->is_anonymous ? 'Anonim' : $critique->user->name }}
                            </p>

                            <p>
                                <strong>
                                    <i class="fas fa-user-tag"></i> Username:
                                </strong>
                                {{ $critique->is_anonymous ? 'anonim' : $critique->user->username }}
                            </p>

                            <p>
                                <strong>
                                    <i class="fas fa-envelope"></i> Email:
                                </strong>
                                {{ $critique->is_anonymous ? 'Tidak tersedia' : $critique->user->email }}
                            </p>

                            <p>
                                <strong>
                                    <i class="fas fa-phone"></i> Telepon:
                                </strong>
                                {{ $critique->is_anonymous ? 'Tidak tersedia' : $critique->user->phone ?? '-' }}
                            </p>

                        </div>

                        <div class="col-md-6">

                            <p>
                                <strong>
                                    <i class="fas fa-tag"></i> Kategori:
                                </strong>
                                {{ $critique->category->name }}
                            </p>

                            <p>
                                <strong>
                                    <i class="fas fa-layer-group"></i> Tingkat:
                                </strong>

                                <span class="text-capitalize">
                                    {{ $critique->government_level }}
                                </span>
                            </p>

                            <p>
                                <strong>
                                    <i class="fas fa-map-marker-alt"></i> Wilayah:
                                </strong>

                                {{ $critique->province->name }}

                                @if ($critique->regency)
                                    , {{ $critique->regency->name }}
                                @endif

                                @if ($critique->district)
                                    , {{ $critique->district->name }}
                                @endif
                            </p>

                            <p>
                                <strong>
                                    <i class="fas fa-calendar"></i> Tanggal:
                                </strong>

                                {{ $critique->submitted_at->format('d F Y H:i') }}
                            </p>

                            @if ($critique->is_anonymous)
                                <p>
                                    <strong>
                                        <i class="fas fa-user-secret"></i> Status:
                                    </strong>

                                    <span class="badge bg-secondary">
                                        Anonim
                                    </span>
                                </p>
                            @endif

                        </div>

                    </div>

                    <hr>

                    {{-- ISI KRITIK --}}
                    <div class="mb-4">

                        <h5>
                            <i class="fas fa-align-left me-2"></i>
                            Isi Kritik
                        </h5>

                        <div class="p-3 bg-light rounded">
                            {!! nl2br(e($critique->content)) !!}
                        </div>

                    </div>

                    {{-- BUKTI USER --}}
                    @if ($critique->image)
                        <div class="mb-4">

                            <h5>
                                <i class="fas fa-paperclip me-2"></i>
                                Bukti dari Pengguna
                            </h5>

                            @if (str_ends_with(strtolower($critique->image), '.pdf'))
                                <a href="{{ asset('storage/' . $critique->image) }}" target="_blank"
                                    class="btn btn-outline-secondary">

                                    <i class="fas fa-file-pdf me-2"></i>
                                    Buka Dokumen PDF

                                </a>
                            @else
                                <img src="{{ asset('storage/' . $critique->image) }}" alt="Foto Bukti"
                                    class="img-fluid rounded" style="max-height: 400px;">
                            @endif

                        </div>
                    @endif

                    {{-- PESAN / BALASAN USER --}}
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
                                                <span class="badge bg-primary ms-2">
                                                    Pengguna
                                                </span>
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

                    {{-- RIWAYAT PERUBAHAN + BUKTI --}}
                    @if ($critique->updates && $critique->updates->count())
                        <div class="mb-4">

                            <h5>
                                <i class="fas fa-history me-2"></i>
                                Riwayat Perubahan Status
                            </h5>

                            @foreach ($critique->updates->sortByDesc('created_at') as $update)
                                <div class="border rounded p-3 mb-3">

                                    <div class="d-flex justify-content-between">

                                        <strong>
                                            {{ $update->user->name ?? 'Admin' }}
                                        </strong>

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
                                                        $extension = strtolower(
                                                            pathinfo($file->original_name, PATHINFO_EXTENSION),
                                                        );
                                                    @endphp

                                                    <div class="col-md-4">

                                                        <div class="border rounded p-2">

                                                            @if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                                                                <img src="{{ asset('storage/' . $file->file_path) }}"
                                                                    class="img-fluid rounded mb-2"
                                                                    style="height: 150px; width: 100%; object-fit: cover;">
                                                            @elseif ($extension === 'pdf')
                                                                <div class="text-center py-4">
                                                                    <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                                                </div>
                                                            @else
                                                                <div class="text-center py-4">
                                                                    <i class="fas fa-file fa-3x text-secondary"></i>
                                                                </div>
                                                            @endif

                                                            <a href="{{ asset('storage/' . $file->file_path) }}"
                                                                target="_blank"
                                                                class="btn btn-sm btn-outline-primary w-100">

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

                    {{-- RIWAYAT STATUS LAMA --}}
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

                                                <td>
                                                    {{ $history->changer->name ?? '-' }}
                                                </td>

                                                <td>
                                                    {{ $history->created_at->format('d/m/Y H:i') }}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        </div>
                    @endif

                    <hr>

                    <div class="row g-3">

                        {{-- UBAH STATUS --}}
                        <div class="col-md-6">

                            <div class="border rounded p-3 h-100">

                                <h5 class="mb-3">
                                    <i class="fas fa-edit me-2"></i>
                                    Ubah Status Laporan
                                </h5>

                                <form method="POST" action="{{ route('admin.critiques.status', $critique->id) }}"
                                    enctype="multipart/form-data">

                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Status Baru
                                        </label>

                                        <select name="status" class="form-select" required>

                                            @if ($critique->status === 'dikirim')
                                                <option value="ditinjau">
                                                    Ditinjau
                                                </option>

                                                <option value="ditolak">
                                                    Ditolak
                                                </option>
                                            @elseif ($critique->status === 'ditinjau')
                                                <option value="diproses">
                                                    Diproses
                                                </option>

                                                <option value="ditolak">
                                                    Ditolak
                                                </option>
                                            @elseif ($critique->status === 'diproses')
                                                <option value="selesai">
                                                    Selesai
                                                </option>
                                            @else
                                                <option value="{{ $critique->status }}" selected disabled>
                                                    {{ ucfirst($critique->status) }}
                                                </option>
                                            @endif

                                        </select>

                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label">
                                            Bukti Perubahan
                                        </label>

                                        <input type="file" name="files[]" class="form-control" multiple required
                                            accept="image/*,.pdf,.doc,.docx">

                                        <small class="text-muted">
                                            Wajib mengunggah minimal satu bukti saat mengubah status.
                                        </small>

                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">

                                        <i class="fas fa-save me-2"></i>
                                        Simpan Perubahan

                                    </button>

                                </form>

                            </div>

                        </div>

                        {{-- TANGGAPAN ADMIN --}}
                        <div class="col-md-6">

                            <div class="border rounded p-3 h-100">

                                <h5 class="mb-3">
                                    <i class="fas fa-reply me-2"></i>
                                    Tanggapan Admin
                                </h5>

                                <form method="POST" action="{{ route('admin.critiques.respond', $critique->id) }}">

                                    @csrf

                                    <div class="mb-3">

                                        <textarea name="content" class="form-control" rows="7" placeholder="Tulis tanggapan kepada pengguna..."
                                            required></textarea>

                                    </div>

                                    <button type="submit" class="btn btn-success w-100">

                                        <i class="fas fa-paper-plane me-2"></i>
                                        Kirim Tanggapan

                                    </button>

                                </form>

                                @if ($critique->response)
                                    <hr>

                                    <div class="bg-light rounded p-3">

                                        <strong>
                                            Tanggapan terakhir:
                                        </strong>

                                        <p class="mb-1 mt-2">
                                            {{ $critique->response->content }}
                                        </p>

                                        <small class="text-muted">
                                            {{ $critique->response->created_at->format('d F Y H:i') }}
                                        </small>

                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- KEMBALI --}}
            <div class="mt-4">

                <a href="{{ route('admin.critiques.index') }}" class="btn btn-secondary">

                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali

                </a>

            </div>

        </div>
    </div>

@endsection
