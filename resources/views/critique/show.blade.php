@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-12">

                {{-- ALERT --}}
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

                <div class="card">

                    {{-- HEADER --}}
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

                        <h3>{{ $critique->title }}</h3>

                        <hr>

                        {{-- INFORMASI --}}
                        <div class="row mb-3">

                            <div class="col-md-6">

                                <p>
                                    <strong>
                                        <i class="fas fa-user"></i>
                                        Pengirim:
                                    </strong>

                                    {{ $critique->is_anonymous ? 'Anonim' : $critique->user->name }}
                                </p>

                                <p>
                                    <strong>
                                        <i class="fas fa-tag"></i>
                                        Kategori:
                                    </strong>

                                    {{ $critique->category->name }}
                                </p>

                                <p>
                                    <strong>
                                        <i class="fas fa-layer-group"></i>
                                        Tingkat:
                                    </strong>

                                    <span class="text-capitalize">
                                        {{ $critique->government_level }}
                                    </span>
                                </p>

                            </div>

                            <div class="col-md-6">

                                <p>
                                    <strong>
                                        <i class="fas fa-map-marker-alt"></i>
                                        Wilayah:
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
                                        <i class="fas fa-calendar"></i>
                                        Tanggal:
                                    </strong>

                                    {{ $critique->submitted_at->format('d F Y H:i') }}
                                </p>

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
                                    Bukti Laporan
                                </h5>

                                @if (str_ends_with(strtolower($critique->image), '.pdf'))
                                    <a href="{{ asset('storage/' . $critique->image) }}" target="_blank"
                                        class="btn btn-outline-secondary">

                                        <i class="fas fa-file-pdf me-2"></i>
                                        Buka Dokumen

                                    </a>
                                @else
                                    <img src="{{ asset('storage/' . $critique->image) }}" alt="Bukti Laporan"
                                        class="img-fluid rounded" style="max-height: 400px;">
                                @endif

                            </div>
                        @endif

                        {{-- UPDATE DARI ADMIN --}}
                        @if ($critique->updates && $critique->updates->count())
                            <div class="mb-4">

                                <h5>
                                    <i class="fas fa-sync-alt me-2"></i>
                                    Perubahan dari Admin
                                </h5>

                                @foreach ($critique->updates->sortByDesc('created_at') as $update)
                                    <div class="border rounded p-3 mb-3">

                                        <div class="d-flex justify-content-between align-items-center">

                                            <strong>
                                                {{ $update->user->name ?? 'Admin' }}
                                            </strong>

                                            <small class="text-muted">
                                                {{ $update->created_at->format('d F Y H:i') }}
                                            </small>

                                        </div>

                                        <div class="my-3">

                                            <span class="badge badge-status badge-{{ $update->old_status }}">
                                                {{ ucfirst($update->old_status) }}
                                            </span>

                                            <i class="fas fa-arrow-right mx-2"></i>

                                            <span class="badge badge-status badge-{{ $update->new_status }}">
                                                {{ ucfirst($update->new_status) }}
                                            </span>

                                        </div>

                                        {{-- BUKTI ADMIN --}}
                                        @if ($update->files && $update->files->count())
                                            <strong class="d-block mb-2">
                                                <i class="fas fa-paperclip me-1"></i>
                                                Bukti dari Admin
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
                                                            @elseif($extension === 'pdf')
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
                                        @else
                                            <small class="text-muted">
                                                Tidak ada bukti yang dilampirkan.
                                            </small>
                                        @endif

                                    </div>
                                @endforeach

                            </div>
                        @endif

                        {{-- TANGGAPAN ADMIN --}}
                        @if ($critique->response)
                            <div class="mb-4">

                                <h5>
                                    <i class="fas fa-reply text-success me-2"></i>
                                    Tanggapan Admin
                                </h5>

                                <div class="p-3 bg-success bg-opacity-10 rounded">

                                    <p class="mb-1">
                                        <strong>
                                            {{ $critique->response->admin->name }}
                                        </strong>
                                    </p>

                                    <p class="mb-1">
                                        {{ $critique->response->content }}
                                    </p>

                                    <small class="text-muted">
                                        {{ $critique->response->created_at->format('d F Y H:i') }}
                                    </small>

                                </div>

                            </div>
                        @endif

                        @if ($critique->status === 'selesai' || $critique->status === 'ditolak')
                            <div class="alert alert-secondary">
                                <i class="bi bi-lock"></i>
                                Laporan ini sudah ditutup. Anda tidak dapat membalas lagi.
                            </div>
                        @elseif($critique->user_can_reply)
                            <div class="card mt-4">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        Balas Laporan
                                    </h5>

                                    <p class="text-muted">
                                        Admin telah mengubah status laporan Anda.
                                        Anda dapat memberikan balasan jika diperlukan.
                                    </p>

                                    <form action="{{ route('critique.message', $critique->id) }}" method="POST">
                                        @csrf

                                        <div class="mb-3">
                                            <textarea name="message" class="form-control" rows="4" placeholder="Tulis balasan Anda..." required
                                                maxlength="5000"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send"></i>
                                            Kirim Balasan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info mt-4">
                                <i class="bi bi-info-circle"></i>
                                Anda belum dapat membalas laporan ini.
                                Balasan akan tersedia kembali setelah admin mengubah status laporan.
                            </div>
                        @endif

                        {{-- RIWAYAT STATUS --}}
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
                                                            <span
                                                                class="badge badge-status badge-{{ $history->old_status }}">
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

                        {{-- AKSI USER --}}
                        <div class="d-flex justify-content-between mt-4">

                            <a href="{{ route('critique.history') }}" class="btn btn-secondary">

                                <i class="fas fa-arrow-left me-1"></i>
                                Kembali

                            </a>

                            <div>

                                @if ($critique->status === 'dikirim')
                                    <a href="{{ route('critique.edit', $critique->id) }}" class="btn btn-warning">

                                        <i class="fas fa-edit"></i>
                                        Edit

                                    </a>

                                    <form action="{{ route('critique.destroy', $critique->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kritik ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">

                                            <i class="fas fa-trash"></i>
                                            Hapus

                                        </button>

                                    </form>
                                @endif

                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
