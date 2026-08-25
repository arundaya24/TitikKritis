@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-home me-2"></i> Selamat Datang di Titik Kritis
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <h3>Apa itu Titik Kritis?</h3>
                            <p class="lead">
                                Titik Kritis adalah platform digital yang memungkinkan masyarakat untuk menyampaikan
                                kritik, saran, dan laporan secara konstruktif kepada pemerintah daerah.
                            </p>

                            <h4 class="mt-4"><i class="fas fa-bullseye text-primary"></i> Tujuan</h4>
                            <p>
                                Memberikan ruang bagi masyarakat untuk berpartisipasi aktif dalam pembangunan dan
                                pengawasan kinerja pemerintah daerah melalui kritik yang membangun.
                            </p>

                            <h4 class="mt-4"><i class="fas fa-hand-holding-heart text-primary"></i> Fungsi Kritik Masyarakat</h4>
                            <ul>
                                <li>Meningkatkan transparansi dan akuntabilitas pemerintah</li>
                                <li>Mendorong perbaikan pelayanan publik</li>
                                <li>Menjadi saluran aspirasi masyarakat</li>
                                <li>Membangun komunikasi dua arah antara masyarakat dan pemerintah</li>
                            </ul>

                            <h4 class="mt-4"><i class="fas fa-arrow-right text-primary"></i> Cara Menggunakan Platform</h4>
                            <ol>
                                <li>Buat akun dengan mengisi data diri yang valid</li>
                                <li>Login ke platform menggunakan username dan password</li>
                                <li>Pilih menu <strong>Kritik</strong> untuk menyampaikan kritik</li>
                                <li>Isi form kritik dengan lengkap dan bertanggung jawab</li>
                                <li>Pantau status kritik Anda di menu <strong>History Kritik</strong></li>
                            </ol>

                            <h4 class="mt-4"><i class="fas fa-search text-primary"></i> Proses Peninjauan Kritik</h4>
                            <p>
                                Setiap kritik akan melalui proses peninjauan oleh admin:
                            </p>
                            <ul>
                                <li><span class="badge bg-warning text-dark">Dikirim</span> - Kritik berhasil dikirim</li>
                                <li><span class="badge bg-info">Ditinjau</span> - Admin sedang meninjau kritik</li>
                                <li><span class="badge bg-primary">Diproses</span> - Kritik sedang diproses</li>
                                <li><span class="badge bg-success">Selesai</span> - Kritik telah selesai ditangani</li>
                                <li><span class="badge bg-danger">Ditolak</span> - Kritik ditolak karena alasan tertentu</li>
                            </ul>

                            <h4 class="mt-4"><i class="fas fa-exclamation-triangle text-warning"></i> Kritik yang Bertanggung Jawab</h4>
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle"></i>
                                Setiap kritik harus disampaikan dengan data yang benar dan tidak mengandung
                                kata-kata kasar, fitnah, atau hal yang tidak sesuai dengan aturan yang berlaku.
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                    <h5>Mulai Bersuara</h5>
                                    <p>Kritik Anda adalah langkah awal untuk perubahan</p>
                                    <a href="{{ route('critique.create') }}" class="btn btn-light">
                                        <i class="fas fa-pen"></i> Kirim Kritik Sekarang
                                    </a>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-body">
                                    <h5><i class="fas fa-chart-bar"></i> Statistik Singkat</h5>
                                    <hr>
                                    <p><strong>Total Kritik Anda:</strong> {{ Auth::user()->critiques->count() }}</p>
                                    <p><strong>Kritik Diproses:</strong> {{ Auth::user()->critiques->whereIn('status', ['ditinjau', 'diproses'])->count() }}</p>
                                    <p><strong>Kritik Selesai:</strong> {{ Auth::user()->critiques->where('status', 'selesai')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
