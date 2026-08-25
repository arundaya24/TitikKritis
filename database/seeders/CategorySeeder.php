<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pendidikan',
                'description' => 'Kritik terkait fasilitas pendidikan, kualitas guru, kurikulum, dan pelayanan pendidikan'
            ],
            [
                'name' => 'Kesehatan',
                'description' => 'Kritik terkait fasilitas kesehatan, pelayanan rumah sakit, puskesmas, dan tenaga medis'
            ],
            [
                'name' => 'Infrastruktur',
                'description' => 'Kritik terkait jalan, jembatan, drainase, penerangan jalan, dan pembangunan fisik lainnya'
            ],
            [
                'name' => 'Transportasi',
                'description' => 'Kritik terkait angkutan umum, terminal, stasiun, pelabuhan, dan bandara'
            ],
            [
                'name' => 'Lingkungan Hidup',
                'description' => 'Kritik terkait pengelolaan sampah, polusi, reboisasi, dan pelestarian lingkungan'
            ],
            [
                'name' => 'Pelayanan Publik',
                'description' => 'Kritik terkait pelayanan administrasi kependudukan, perizinan, dan birokrasi pemerintahan'
            ],
            [
                'name' => 'Ekonomi dan UMKM',
                'description' => 'Kritik terkait kebijakan ekonomi, pembinaan UMKM, dan kesejahteraan masyarakat'
            ],
            [
                'name' => 'Keamanan dan Ketertiban',
                'description' => 'Kritik terkait keamanan lingkungan, penegakan hukum, dan ketertiban umum'
            ],
            [
                'name' => 'Sosial dan Kesejahteraan',
                'description' => 'Kritik terkait bantuan sosial, pemberdayaan masyarakat, dan perlindungan sosial'
            ],
            [
                'name' => 'Pariwisata dan Budaya',
                'description' => 'Kritik terkait pengembangan wisata, pelestarian budaya, dan fasilitas pariwisata'
            ],
            [
                'name' => 'Pertanian dan Pangan',
                'description' => 'Kritik terkait ketahanan pangan, pertanian, perkebunan, dan peternakan'
            ],
            [
                'name' => 'Ketenagakerjaan',
                'description' => 'Kritik terkait lapangan pekerjaan, pelatihan tenaga kerja, dan perlindungan pekerja'
            ],
            [
                'name' => 'Komunikasi dan Informatika',
                'description' => 'Kritik terkait jaringan internet, pelayanan komunikasi, dan digitalisasi pemerintahan'
            ],
            [
                'name' => 'Perumahan dan Pemukiman',
                'description' => 'Kritik terkait perumahan kumuh, rusunawa, dan pengembangan permukiman'
            ],
            [
                'name' => 'Kependudukan dan KB',
                'description' => 'Kritik terkait pengendalian penduduk, program KB, dan data kependudukan'
            ],
            [
                'name' => 'Perdagangan dan Investasi',
                'description' => 'Kritik terkait iklim investasi, pasar tradisional, dan perdagangan daerah'
            ],
            [
                'name' => 'Olahraga dan Pemuda',
                'description' => 'Kritik terkait fasilitas olahraga, pembinaan pemuda, dan event olahraga'
            ],
            [
                'name' => 'Pemberdayaan Perempuan',
                'description' => 'Kritik terkait perlindungan perempuan, kesetaraan gender, dan pemberdayaan'
            ],
            [
                'name' => 'Perizinan dan Investasi',
                'description' => 'Kritik terkait kemudahan perizinan, birokrasi investasi, dan pelayanan terpadu'
            ],
            [
                'name' => 'Lainnya',
                'description' => 'Kritik untuk bidang-bidang lainnya yang tidak tercantum'
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
