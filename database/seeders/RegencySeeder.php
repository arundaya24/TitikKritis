<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegencySeeder extends Seeder
{
    public function run(): void
    {
        $regencies = [
            // ============ ACEH (11) ============
            ['id' => 1101, 'province_id' => 11, 'name' => 'Simeulue'],
            ['id' => 1102, 'province_id' => 11, 'name' => 'Aceh Singkil'],
            ['id' => 1103, 'province_id' => 11, 'name' => 'Aceh Selatan'],
            ['id' => 1104, 'province_id' => 11, 'name' => 'Aceh Tenggara'],
            ['id' => 1105, 'province_id' => 11, 'name' => 'Aceh Timur'],
            ['id' => 1106, 'province_id' => 11, 'name' => 'Aceh Tengah'],
            ['id' => 1107, 'province_id' => 11, 'name' => 'Aceh Barat'],
            ['id' => 1108, 'province_id' => 11, 'name' => 'Aceh Besar'],
            ['id' => 1109, 'province_id' => 11, 'name' => 'Pidie'],
            ['id' => 1110, 'province_id' => 11, 'name' => 'Bireuen'],
            ['id' => 1111, 'province_id' => 11, 'name' => 'Aceh Utara'],
            ['id' => 1112, 'province_id' => 11, 'name' => 'Aceh Barat Daya'],
            ['id' => 1113, 'province_id' => 11, 'name' => 'Gayo Lues'],
            ['id' => 1114, 'province_id' => 11, 'name' => 'Aceh Tamiang'],
            ['id' => 1115, 'province_id' => 11, 'name' => 'Nagan Raya'],
            ['id' => 1116, 'province_id' => 11, 'name' => 'Aceh Jaya'],
            ['id' => 1117, 'province_id' => 11, 'name' => 'Bener Meriah'],
            ['id' => 1118, 'province_id' => 11, 'name' => 'Pidie Jaya'],
            ['id' => 1171, 'province_id' => 11, 'name' => 'Banda Aceh'],
            ['id' => 1172, 'province_id' => 11, 'name' => 'Sabang'],
            ['id' => 1173, 'province_id' => 11, 'name' => 'Langsa'],
            ['id' => 1174, 'province_id' => 11, 'name' => 'Lhokseumawe'],
            ['id' => 1175, 'province_id' => 11, 'name' => 'Subulussalam'],

            // ============ SUMATERA UTARA (12) ============
            ['id' => 1201, 'province_id' => 12, 'name' => 'Nias'],
            ['id' => 1202, 'province_id' => 12, 'name' => 'Mandailing Natal'],
            ['id' => 1203, 'province_id' => 12, 'name' => 'Tapanuli Selatan'],
            ['id' => 1204, 'province_id' => 12, 'name' => 'Tapanuli Tengah'],
            ['id' => 1205, 'province_id' => 12, 'name' => 'Tapanuli Utara'],
            ['id' => 1206, 'province_id' => 12, 'name' => 'Toba Samosir'],
            ['id' => 1207, 'province_id' => 12, 'name' => 'Labuhanbatu'],
            ['id' => 1208, 'province_id' => 12, 'name' => 'Asahan'],
            ['id' => 1209, 'province_id' => 12, 'name' => 'Simalungun'],
            ['id' => 1210, 'province_id' => 12, 'name' => 'Dairi'],
            ['id' => 1211, 'province_id' => 12, 'name' => 'Karo'],
            ['id' => 1212, 'province_id' => 12, 'name' => 'Deli Serdang'],
            ['id' => 1213, 'province_id' => 12, 'name' => 'Langkat'],
            ['id' => 1214, 'province_id' => 12, 'name' => 'Nias Selatan'],
            ['id' => 1215, 'province_id' => 12, 'name' => 'Humbang Hasundutan'],
            ['id' => 1216, 'province_id' => 12, 'name' => 'Pakpak Bharat'],
            ['id' => 1217, 'province_id' => 12, 'name' => 'Samosir'],
            ['id' => 1218, 'province_id' => 12, 'name' => 'Serdang Bedagai'],
            ['id' => 1219, 'province_id' => 12, 'name' => 'Batu Bara'],
            ['id' => 1220, 'province_id' => 12, 'name' => 'Padang Lawas Utara'],
            ['id' => 1221, 'province_id' => 12, 'name' => 'Padang Lawas'],
            ['id' => 1222, 'province_id' => 12, 'name' => 'Labuhanbatu Selatan'],
            ['id' => 1223, 'province_id' => 12, 'name' => 'Labuhanbatu Utara'],
            ['id' => 1224, 'province_id' => 12, 'name' => 'Nias Utara'],
            ['id' => 1225, 'province_id' => 12, 'name' => 'Nias Barat'],
            ['id' => 1271, 'province_id' => 12, 'name' => 'Medan'],
            ['id' => 1272, 'province_id' => 12, 'name' => 'Pematang Siantar'],
            ['id' => 1273, 'province_id' => 12, 'name' => 'Sibolga'],
            ['id' => 1274, 'province_id' => 12, 'name' => 'Tanjung Balai'],
            ['id' => 1275, 'province_id' => 12, 'name' => 'Binjai'],
            ['id' => 1276, 'province_id' => 12, 'name' => 'Tebing Tinggi'],
            ['id' => 1277, 'province_id' => 12, 'name' => 'Padang Sidempuan'],
            ['id' => 1278, 'province_id' => 12, 'name' => 'Gunungsitoli'],

            // ============ SUMATERA BARAT (13) ============
            ['id' => 1301, 'province_id' => 13, 'name' => 'Kepulauan Mentawai'],
            ['id' => 1302, 'province_id' => 13, 'name' => 'Pesisir Selatan'],
            ['id' => 1303, 'province_id' => 13, 'name' => 'Solok'],
            ['id' => 1304, 'province_id' => 13, 'name' => 'Sijunjung'],
            ['id' => 1305, 'province_id' => 13, 'name' => 'Tanah Datar'],
            ['id' => 1306, 'province_id' => 13, 'name' => 'Padang Pariaman'],
            ['id' => 1307, 'province_id' => 13, 'name' => 'Agam'],
            ['id' => 1308, 'province_id' => 13, 'name' => 'Lima Puluh Kota'],
            ['id' => 1309, 'province_id' => 13, 'name' => 'Pasaman'],
            ['id' => 1310, 'province_id' => 13, 'name' => 'Solok Selatan'],
            ['id' => 1311, 'province_id' => 13, 'name' => 'Dharmasraya'],
            ['id' => 1312, 'province_id' => 13, 'name' => 'Pasaman Barat'],
            ['id' => 1371, 'province_id' => 13, 'name' => 'Padang'],
            ['id' => 1372, 'province_id' => 13, 'name' => 'Solok'],
            ['id' => 1373, 'province_id' => 13, 'name' => 'Sawahlunto'],
            ['id' => 1374, 'province_id' => 13, 'name' => 'Padang Panjang'],
            ['id' => 1375, 'province_id' => 13, 'name' => 'Bukittinggi'],
            ['id' => 1376, 'province_id' => 13, 'name' => 'Payakumbuh'],
            ['id' => 1377, 'province_id' => 13, 'name' => 'Pariaman'],

            // ============ RIAU (14) ============
            ['id' => 1401, 'province_id' => 14, 'name' => 'Kuantan Singingi'],
            ['id' => 1402, 'province_id' => 14, 'name' => 'Indragiri Hulu'],
            ['id' => 1403, 'province_id' => 14, 'name' => 'Indragiri Hilir'],
            ['id' => 1404, 'province_id' => 14, 'name' => 'Pelalawan'],
            ['id' => 1405, 'province_id' => 14, 'name' => 'Siak'],
            ['id' => 1406, 'province_id' => 14, 'name' => 'Kampar'],
            ['id' => 1407, 'province_id' => 14, 'name' => 'Rokan Hulu'],
            ['id' => 1408, 'province_id' => 14, 'name' => 'Bengkalis'],
            ['id' => 1409, 'province_id' => 14, 'name' => 'Rokan Hilir'],
            ['id' => 1410, 'province_id' => 14, 'name' => 'Kepulauan Meranti'],
            ['id' => 1471, 'province_id' => 14, 'name' => 'Pekanbaru'],
            ['id' => 1472, 'province_id' => 14, 'name' => 'Dumai'],

            // ============ JAMBI (15) ============
            ['id' => 1501, 'province_id' => 15, 'name' => 'Kerinci'],
            ['id' => 1502, 'province_id' => 15, 'name' => 'Merangin'],
            ['id' => 1503, 'province_id' => 15, 'name' => 'Sarolangun'],
            ['id' => 1504, 'province_id' => 15, 'name' => 'Batanghari'],
            ['id' => 1505, 'province_id' => 15, 'name' => 'Muaro Jambi'],
            ['id' => 1506, 'province_id' => 15, 'name' => 'Tanjung Jabung Timur'],
            ['id' => 1507, 'province_id' => 15, 'name' => 'Tanjung Jabung Barat'],
            ['id' => 1508, 'province_id' => 15, 'name' => 'Tebo'],
            ['id' => 1509, 'province_id' => 15, 'name' => 'Bungo'],
            ['id' => 1571, 'province_id' => 15, 'name' => 'Jambi'],
            ['id' => 1572, 'province_id' => 15, 'name' => 'Sungai Penuh'],

            // ============ SUMATERA SELATAN (16) ============
            ['id' => 1601, 'province_id' => 16, 'name' => 'Ogan Komering Ulu'],
            ['id' => 1602, 'province_id' => 16, 'name' => 'Ogan Komering Ilir'],
            ['id' => 1603, 'province_id' => 16, 'name' => 'Muara Enim'],
            ['id' => 1604, 'province_id' => 16, 'name' => 'Lahat'],
            ['id' => 1605, 'province_id' => 16, 'name' => 'Musi Rawas'],
            ['id' => 1606, 'province_id' => 16, 'name' => 'Musi Banyuasin'],
            ['id' => 1607, 'province_id' => 16, 'name' => 'Banyuasin'],
            ['id' => 1608, 'province_id' => 16, 'name' => 'Ogan Komering Ulu Selatan'],
            ['id' => 1609, 'province_id' => 16, 'name' => 'Ogan Komering Ulu Timur'],
            ['id' => 1610, 'province_id' => 16, 'name' => 'Ogan Ilir'],
            ['id' => 1611, 'province_id' => 16, 'name' => 'Empat Lawang'],
            ['id' => 1612, 'province_id' => 16, 'name' => 'Penukal Abab Lematang Ilir'],
            ['id' => 1613, 'province_id' => 16, 'name' => 'Musi Rawas Utara'],
            ['id' => 1671, 'province_id' => 16, 'name' => 'Palembang'],
            ['id' => 1672, 'province_id' => 16, 'name' => 'Prabumulih'],
            ['id' => 1673, 'province_id' => 16, 'name' => 'Lubuk Linggau'],
            ['id' => 1674, 'province_id' => 16, 'name' => 'Pagar Alam'],

            // ============ BENGKULU (17) ============
            ['id' => 1701, 'province_id' => 17, 'name' => 'Bengkulu Selatan'],
            ['id' => 1702, 'province_id' => 17, 'name' => 'Rejang Lebong'],
            ['id' => 1703, 'province_id' => 17, 'name' => 'Bengkulu Utara'],
            ['id' => 1704, 'province_id' => 17, 'name' => 'Kaur'],
            ['id' => 1705, 'province_id' => 17, 'name' => 'Seluma'],
            ['id' => 1706, 'province_id' => 17, 'name' => 'Muko Muko'],
            ['id' => 1707, 'province_id' => 17, 'name' => 'Lebong'],
            ['id' => 1708, 'province_id' => 17, 'name' => 'Kepahiang'],
            ['id' => 1709, 'province_id' => 17, 'name' => 'Bengkulu Tengah'],
            ['id' => 1771, 'province_id' => 17, 'name' => 'Bengkulu'],

            // ============ LAMPUNG (18) ============
            ['id' => 1801, 'province_id' => 18, 'name' => 'Lampung Barat'],
            ['id' => 1802, 'province_id' => 18, 'name' => 'Tanggamus'],
            ['id' => 1803, 'province_id' => 18, 'name' => 'Lampung Selatan'],
            ['id' => 1804, 'province_id' => 18, 'name' => 'Lampung Timur'],
            ['id' => 1805, 'province_id' => 18, 'name' => 'Lampung Tengah'],
            ['id' => 1806, 'province_id' => 18, 'name' => 'Lampung Utara'],
            ['id' => 1807, 'province_id' => 18, 'name' => 'Way Kanan'],
            ['id' => 1808, 'province_id' => 18, 'name' => 'Tulang Bawang'],
            ['id' => 1809, 'province_id' => 18, 'name' => 'Pesawaran'],
            ['id' => 1810, 'province_id' => 18, 'name' => 'Pringsewu'],
            ['id' => 1811, 'province_id' => 18, 'name' => 'Mesuji'],
            ['id' => 1812, 'province_id' => 18, 'name' => 'Tulang Bawang Barat'],
            ['id' => 1813, 'province_id' => 18, 'name' => 'Pesisir Barat'],
            ['id' => 1871, 'province_id' => 18, 'name' => 'Bandar Lampung'],
            ['id' => 1872, 'province_id' => 18, 'name' => 'Metro'],

            // ============ KEPULAUAN BANGKA BELITUNG (19) ============
            ['id' => 1901, 'province_id' => 19, 'name' => 'Bangka'],
            ['id' => 1902, 'province_id' => 19, 'name' => 'Belitung'],
            ['id' => 1903, 'province_id' => 19, 'name' => 'Bangka Barat'],
            ['id' => 1904, 'province_id' => 19, 'name' => 'Bangka Tengah'],
            ['id' => 1905, 'province_id' => 19, 'name' => 'Bangka Selatan'],
            ['id' => 1906, 'province_id' => 19, 'name' => 'Belitung Timur'],
            ['id' => 1971, 'province_id' => 19, 'name' => 'Pangkal Pinang'],

            // ============ KEPULAUAN RIAU (21) ============
            ['id' => 2101, 'province_id' => 21, 'name' => 'Karimun'],
            ['id' => 2102, 'province_id' => 21, 'name' => 'Bintan'],
            ['id' => 2103, 'province_id' => 21, 'name' => 'Natuna'],
            ['id' => 2104, 'province_id' => 21, 'name' => 'Lingga'],
            ['id' => 2105, 'province_id' => 21, 'name' => 'Kepulauan Anambas'],
            ['id' => 2171, 'province_id' => 21, 'name' => 'Batam'],
            ['id' => 2172, 'province_id' => 21, 'name' => 'Tanjung Pinang'],

            // ============================================================
            // ============ DKI JAKARTA (31) ============
            // ============================================================
            ['id' => 3101, 'province_id' => 31, 'name' => 'Kepulauan Seribu'],
            ['id' => 3171, 'province_id' => 31, 'name' => 'Jakarta Selatan'],
            ['id' => 3172, 'province_id' => 31, 'name' => 'Jakarta Timur'],
            ['id' => 3173, 'province_id' => 31, 'name' => 'Jakarta Pusat'],
            ['id' => 3174, 'province_id' => 31, 'name' => 'Jakarta Barat'],
            ['id' => 3175, 'province_id' => 31, 'name' => 'Jakarta Utara'],

            // ============================================================
            // ============ JAWA BARAT (32) ============
            // ============================================================
            // Kabupaten
            ['id' => 3201, 'province_id' => 32, 'name' => 'Bogor'],
            ['id' => 3202, 'province_id' => 32, 'name' => 'Sukabumi'],
            ['id' => 3203, 'province_id' => 32, 'name' => 'Cianjur'],
            ['id' => 3204, 'province_id' => 32, 'name' => 'Bandung'],
            ['id' => 3205, 'province_id' => 32, 'name' => 'Garut'],
            ['id' => 3206, 'province_id' => 32, 'name' => 'Tasikmalaya'],
            ['id' => 3207, 'province_id' => 32, 'name' => 'Ciamis'],
            ['id' => 3208, 'province_id' => 32, 'name' => 'Kuningan'],
            ['id' => 3209, 'province_id' => 32, 'name' => 'Cirebon'],
            ['id' => 3210, 'province_id' => 32, 'name' => 'Majalengka'],
            ['id' => 3211, 'province_id' => 32, 'name' => 'Sumedang'],
            ['id' => 3212, 'province_id' => 32, 'name' => 'Indramayu'],
            ['id' => 3213, 'province_id' => 32, 'name' => 'Subang'],
            ['id' => 3214, 'province_id' => 32, 'name' => 'Purwakarta'],
            ['id' => 3215, 'province_id' => 32, 'name' => 'Karawang'],
            ['id' => 3216, 'province_id' => 32, 'name' => 'Bekasi'],
            ['id' => 3217, 'province_id' => 32, 'name' => 'Bandung Barat'],
            ['id' => 3218, 'province_id' => 32, 'name' => 'Pangandaran'],
            // Kota
            ['id' => 3271, 'province_id' => 32, 'name' => 'Bogor'],
            ['id' => 3272, 'province_id' => 32, 'name' => 'Sukabumi'],
            ['id' => 3273, 'province_id' => 32, 'name' => 'Bandung'],
            ['id' => 3274, 'province_id' => 32, 'name' => 'Cirebon'],
            ['id' => 3275, 'province_id' => 32, 'name' => 'Bekasi'],
            ['id' => 3276, 'province_id' => 32, 'name' => 'Depok'],
            ['id' => 3277, 'province_id' => 32, 'name' => 'Cimahi'],
            ['id' => 3278, 'province_id' => 32, 'name' => 'Tasikmalaya'],
            ['id' => 3279, 'province_id' => 32, 'name' => 'Banjar'],

            // ============================================================
            // ============ JAWA TENGAH (33) ============
            // ============================================================
            // Kabupaten
            ['id' => 3301, 'province_id' => 33, 'name' => 'Cilacap'],
            ['id' => 3302, 'province_id' => 33, 'name' => 'Banyumas'],
            ['id' => 3303, 'province_id' => 33, 'name' => 'Purbalingga'],
            ['id' => 3304, 'province_id' => 33, 'name' => 'Banjarnegara'],
            ['id' => 3305, 'province_id' => 33, 'name' => 'Kebumen'],
            ['id' => 3306, 'province_id' => 33, 'name' => 'Purworejo'],
            ['id' => 3307, 'province_id' => 33, 'name' => 'Wonosobo'],
            ['id' => 3308, 'province_id' => 33, 'name' => 'Magelang'],
            ['id' => 3309, 'province_id' => 33, 'name' => 'Boyolali'],
            ['id' => 3310, 'province_id' => 33, 'name' => 'Klaten'],
            ['id' => 3311, 'province_id' => 33, 'name' => 'Sukoharjo'],
            ['id' => 3312, 'province_id' => 33, 'name' => 'Wonogiri'],
            ['id' => 3313, 'province_id' => 33, 'name' => 'Karanganyar'],
            ['id' => 3314, 'province_id' => 33, 'name' => 'Sragen'],
            ['id' => 3315, 'province_id' => 33, 'name' => 'Grobogan'],
            ['id' => 3316, 'province_id' => 33, 'name' => 'Blora'],
            ['id' => 3317, 'province_id' => 33, 'name' => 'Rembang'],
            ['id' => 3318, 'province_id' => 33, 'name' => 'Pati'],
            ['id' => 3319, 'province_id' => 33, 'name' => 'Kudus'],
            ['id' => 3320, 'province_id' => 33, 'name' => 'Jepara'],
            ['id' => 3321, 'province_id' => 33, 'name' => 'Demak'],
            ['id' => 3322, 'province_id' => 33, 'name' => 'Semarang'],
            ['id' => 3323, 'province_id' => 33, 'name' => 'Temanggung'],
            ['id' => 3324, 'province_id' => 33, 'name' => 'Kendal'],
            ['id' => 3325, 'province_id' => 33, 'name' => 'Batang'],
            ['id' => 3326, 'province_id' => 33, 'name' => 'Pekalongan'],
            ['id' => 3327, 'province_id' => 33, 'name' => 'Pemalang'],
            ['id' => 3328, 'province_id' => 33, 'name' => 'Tegal'],
            ['id' => 3329, 'province_id' => 33, 'name' => 'Brebes'],
            // Kota
            ['id' => 3371, 'province_id' => 33, 'name' => 'Magelang'],
            ['id' => 3372, 'province_id' => 33, 'name' => 'Surakarta'],
            ['id' => 3373, 'province_id' => 33, 'name' => 'Salatiga'],
            ['id' => 3374, 'province_id' => 33, 'name' => 'Semarang'],
            ['id' => 3375, 'province_id' => 33, 'name' => 'Pekalongan'],
            ['id' => 3376, 'province_id' => 33, 'name' => 'Tegal'],

            // ============================================================
            // ============ DI YOGYAKARTA (34) ============
            // ============================================================
            ['id' => 3401, 'province_id' => 34, 'name' => 'Kulon Progo'],
            ['id' => 3402, 'province_id' => 34, 'name' => 'Bantul'],
            ['id' => 3403, 'province_id' => 34, 'name' => 'Gunung Kidul'],
            ['id' => 3404, 'province_id' => 34, 'name' => 'Sleman'],
            ['id' => 3471, 'province_id' => 34, 'name' => 'Yogyakarta'],

            // ============================================================
            // ============ JAWA TIMUR (35) ============
            // ============================================================
            // Kabupaten
            ['id' => 3501, 'province_id' => 35, 'name' => 'Pacitan'],
            ['id' => 3502, 'province_id' => 35, 'name' => 'Ponorogo'],
            ['id' => 3503, 'province_id' => 35, 'name' => 'Trenggalek'],
            ['id' => 3504, 'province_id' => 35, 'name' => 'Tulungagung'],
            ['id' => 3505, 'province_id' => 35, 'name' => 'Blitar'],
            ['id' => 3506, 'province_id' => 35, 'name' => 'Kediri'],
            ['id' => 3507, 'province_id' => 35, 'name' => 'Malang'],
            ['id' => 3508, 'province_id' => 35, 'name' => 'Lumajang'],
            ['id' => 3509, 'province_id' => 35, 'name' => 'Jember'],
            ['id' => 3510, 'province_id' => 35, 'name' => 'Banyuwangi'],
            ['id' => 3511, 'province_id' => 35, 'name' => 'Bondowoso'],
            ['id' => 3512, 'province_id' => 35, 'name' => 'Situbondo'],
            ['id' => 3513, 'province_id' => 35, 'name' => 'Probolinggo'],
            ['id' => 3514, 'province_id' => 35, 'name' => 'Pasuruan'],
            ['id' => 3515, 'province_id' => 35, 'name' => 'Sidoarjo'],
            ['id' => 3516, 'province_id' => 35, 'name' => 'Mojokerto'],
            ['id' => 3517, 'province_id' => 35, 'name' => 'Jombang'],
            ['id' => 3518, 'province_id' => 35, 'name' => 'Nganjuk'],
            ['id' => 3519, 'province_id' => 35, 'name' => 'Madiun'],
            ['id' => 3520, 'province_id' => 35, 'name' => 'Magetan'],
            ['id' => 3521, 'province_id' => 35, 'name' => 'Ngawi'],
            ['id' => 3522, 'province_id' => 35, 'name' => 'Bojonegoro'],
            ['id' => 3523, 'province_id' => 35, 'name' => 'Tuban'],
            ['id' => 3524, 'province_id' => 35, 'name' => 'Lamongan'],
            ['id' => 3525, 'province_id' => 35, 'name' => 'Gresik'],
            ['id' => 3526, 'province_id' => 35, 'name' => 'Bangkalan'],
            ['id' => 3527, 'province_id' => 35, 'name' => 'Sampang'],
            ['id' => 3528, 'province_id' => 35, 'name' => 'Pamekasan'],
            ['id' => 3529, 'province_id' => 35, 'name' => 'Sumenep'],
            // Kota
            ['id' => 3571, 'province_id' => 35, 'name' => 'Kediri'],
            ['id' => 3572, 'province_id' => 35, 'name' => 'Blitar'],
            ['id' => 3573, 'province_id' => 35, 'name' => 'Malang'],
            ['id' => 3574, 'province_id' => 35, 'name' => 'Probolinggo'],
            ['id' => 3575, 'province_id' => 35, 'name' => 'Pasuruan'],
            ['id' => 3576, 'province_id' => 35, 'name' => 'Mojokerto'],
            ['id' => 3577, 'province_id' => 35, 'name' => 'Madiun'],
            ['id' => 3578, 'province_id' => 35, 'name' => 'Surabaya'],
            ['id' => 3579, 'province_id' => 35, 'name' => 'Batu'],

            // ============================================================
            // ============ BANTEN (36) ============
            // ============================================================
            ['id' => 3601, 'province_id' => 36, 'name' => 'Pandeglang'],
            ['id' => 3602, 'province_id' => 36, 'name' => 'Lebak'],
            ['id' => 3603, 'province_id' => 36, 'name' => 'Tangerang'],
            ['id' => 3604, 'province_id' => 36, 'name' => 'Serang'],
            ['id' => 3671, 'province_id' => 36, 'name' => 'Tangerang'],
            ['id' => 3672, 'province_id' => 36, 'name' => 'Cilegon'],
            ['id' => 3673, 'province_id' => 36, 'name' => 'Serang'],
            ['id' => 3674, 'province_id' => 36, 'name' => 'Tangerang Selatan'],

            // ============================================================
            // ============ BALI (51) ============
            // ============================================================
            ['id' => 5101, 'province_id' => 51, 'name' => 'Jembrana'],
            ['id' => 5102, 'province_id' => 51, 'name' => 'Tabanan'],
            ['id' => 5103, 'province_id' => 51, 'name' => 'Badung'],
            ['id' => 5104, 'province_id' => 51, 'name' => 'Gianyar'],
            ['id' => 5105, 'province_id' => 51, 'name' => 'Klungkung'],
            ['id' => 5106, 'province_id' => 51, 'name' => 'Bangli'],
            ['id' => 5107, 'province_id' => 51, 'name' => 'Karangasem'],
            ['id' => 5108, 'province_id' => 51, 'name' => 'Buleleng'],
            ['id' => 5171, 'province_id' => 51, 'name' => 'Denpasar'],

            // ============================================================
            // ============ NUSA TENGGARA BARAT (52) ============
            // ============================================================
            ['id' => 5201, 'province_id' => 52, 'name' => 'Lombok Barat'],
            ['id' => 5202, 'province_id' => 52, 'name' => 'Lombok Tengah'],
            ['id' => 5203, 'province_id' => 52, 'name' => 'Lombok Timur'],
            ['id' => 5204, 'province_id' => 52, 'name' => 'Sumbawa'],
            ['id' => 5205, 'province_id' => 52, 'name' => 'Dompu'],
            ['id' => 5206, 'province_id' => 52, 'name' => 'Bima'],
            ['id' => 5207, 'province_id' => 52, 'name' => 'Sumbawa Barat'],
            ['id' => 5208, 'province_id' => 52, 'name' => 'Lombok Utara'],
            ['id' => 5271, 'province_id' => 52, 'name' => 'Mataram'],
            ['id' => 5272, 'province_id' => 52, 'name' => 'Bima'],

            // ============================================================
            // ============ NUSA TENGGARA TIMUR (53) ============
            // ============================================================
            ['id' => 5301, 'province_id' => 53, 'name' => 'Sumba Barat'],
            ['id' => 5302, 'province_id' => 53, 'name' => 'Sumba Timur'],
            ['id' => 5303, 'province_id' => 53, 'name' => 'Kupang'],
            ['id' => 5304, 'province_id' => 53, 'name' => 'Timor Tengah Selatan'],
            ['id' => 5305, 'province_id' => 53, 'name' => 'Timor Tengah Utara'],
            ['id' => 5306, 'province_id' => 53, 'name' => 'Belu'],
            ['id' => 5307, 'province_id' => 53, 'name' => 'Alor'],
            ['id' => 5308, 'province_id' => 53, 'name' => 'Lembata'],
            ['id' => 5309, 'province_id' => 53, 'name' => 'Flores Timur'],
            ['id' => 5310, 'province_id' => 53, 'name' => 'Sikka'],
            ['id' => 5311, 'province_id' => 53, 'name' => 'Ende'],
            ['id' => 5312, 'province_id' => 53, 'name' => 'Ngada'],
            ['id' => 5313, 'province_id' => 53, 'name' => 'Manggarai'],
            ['id' => 5314, 'province_id' => 53, 'name' => 'Rote Ndao'],
            ['id' => 5315, 'province_id' => 53, 'name' => 'Manggarai Barat'],
            ['id' => 5316, 'province_id' => 53, 'name' => 'Sumba Tengah'],
            ['id' => 5317, 'province_id' => 53, 'name' => 'Sumba Barat Daya'],
            ['id' => 5318, 'province_id' => 53, 'name' => 'Nagekeo'],
            ['id' => 5319, 'province_id' => 53, 'name' => 'Manggarai Timur'],
            ['id' => 5320, 'province_id' => 53, 'name' => 'Sabu Raijua'],
            ['id' => 5321, 'province_id' => 53, 'name' => 'Malaka'],
            ['id' => 5371, 'province_id' => 53, 'name' => 'Kupang'],

            // ============================================================
            // ============ KALIMANTAN BARAT (61) ============
            // ============================================================
            ['id' => 6101, 'province_id' => 61, 'name' => 'Sambas'],
            ['id' => 6102, 'province_id' => 61, 'name' => 'Bengkayang'],
            ['id' => 6103, 'province_id' => 61, 'name' => 'Landak'],
            ['id' => 6104, 'province_id' => 61, 'name' => 'Mempawah'],
            ['id' => 6105, 'province_id' => 61, 'name' => 'Sanggau'],
            ['id' => 6106, 'province_id' => 61, 'name' => 'Ketapang'],
            ['id' => 6107, 'province_id' => 61, 'name' => 'Sintang'],
            ['id' => 6108, 'province_id' => 61, 'name' => 'Kapuas Hulu'],
            ['id' => 6109, 'province_id' => 61, 'name' => 'Sekadau'],
            ['id' => 6110, 'province_id' => 61, 'name' => 'Melawi'],
            ['id' => 6111, 'province_id' => 61, 'name' => 'Kayong Utara'],
            ['id' => 6112, 'province_id' => 61, 'name' => 'Kubu Raya'],
            ['id' => 6171, 'province_id' => 61, 'name' => 'Pontianak'],
            ['id' => 6172, 'province_id' => 61, 'name' => 'Singkawang'],

            // ============================================================
            // ============ KALIMANTAN TENGAH (62) ============
            // ============================================================
            ['id' => 6201, 'province_id' => 62, 'name' => 'Kotawaringin Barat'],
            ['id' => 6202, 'province_id' => 62, 'name' => 'Kotawaringin Timur'],
            ['id' => 6203, 'province_id' => 62, 'name' => 'Kapuas'],
            ['id' => 6204, 'province_id' => 62, 'name' => 'Barito Selatan'],
            ['id' => 6205, 'province_id' => 62, 'name' => 'Barito Utara'],
            ['id' => 6206, 'province_id' => 62, 'name' => 'Sukamara'],
            ['id' => 6207, 'province_id' => 62, 'name' => 'Lamandau'],
            ['id' => 6208, 'province_id' => 62, 'name' => 'Seruyan'],
            ['id' => 6209, 'province_id' => 62, 'name' => 'Katingan'],
            ['id' => 6210, 'province_id' => 62, 'name' => 'Pulang Pisau'],
            ['id' => 6211, 'province_id' => 62, 'name' => 'Gunung Mas'],
            ['id' => 6212, 'province_id' => 62, 'name' => 'Barito Timur'],
            ['id' => 6213, 'province_id' => 62, 'name' => 'Murung Raya'],
            ['id' => 6271, 'province_id' => 62, 'name' => 'Palangka Raya'],

            // ============================================================
            // ============ KALIMANTAN SELATAN (63) ============
            // ============================================================
            ['id' => 6301, 'province_id' => 63, 'name' => 'Tanah Laut'],
            ['id' => 6302, 'province_id' => 63, 'name' => 'Kota Baru'],
            ['id' => 6303, 'province_id' => 63, 'name' => 'Banjar'],
            ['id' => 6304, 'province_id' => 63, 'name' => 'Barito Kuala'],
            ['id' => 6305, 'province_id' => 63, 'name' => 'Tapin'],
            ['id' => 6306, 'province_id' => 63, 'name' => 'Hulu Sungai Selatan'],
            ['id' => 6307, 'province_id' => 63, 'name' => 'Hulu Sungai Tengah'],
            ['id' => 6308, 'province_id' => 63, 'name' => 'Hulu Sungai Utara'],
            ['id' => 6309, 'province_id' => 63, 'name' => 'Tabalong'],
            ['id' => 6310, 'province_id' => 63, 'name' => 'Tanah Bumbu'],
            ['id' => 6311, 'province_id' => 63, 'name' => 'Balangan'],
            ['id' => 6371, 'province_id' => 63, 'name' => 'Banjarmasin'],
            ['id' => 6372, 'province_id' => 63, 'name' => 'Banjarbaru'],

            // ============================================================
            // ============ KALIMANTAN TIMUR (64) ============
            // ============================================================
            ['id' => 6401, 'province_id' => 64, 'name' => 'Paser'],
            ['id' => 6402, 'province_id' => 64, 'name' => 'Kutai Barat'],
            ['id' => 6403, 'province_id' => 64, 'name' => 'Kutai Kartanegara'],
            ['id' => 6404, 'province_id' => 64, 'name' => 'Kutai Timur'],
            ['id' => 6405, 'province_id' => 64, 'name' => 'Berau'],
            ['id' => 6407, 'province_id' => 64, 'name' => 'Penajam Paser Utara'],
            ['id' => 6408, 'province_id' => 64, 'name' => 'Mahakam Ulu'],
            ['id' => 6471, 'province_id' => 64, 'name' => 'Balikpapan'],
            ['id' => 6472, 'province_id' => 64, 'name' => 'Samarinda'],
            ['id' => 6473, 'province_id' => 64, 'name' => 'Bontang'],

            // ============================================================
            // ============ KALIMANTAN UTARA (65) ============
            // ============================================================
            ['id' => 6501, 'province_id' => 65, 'name' => 'Malinau'],
            ['id' => 6502, 'province_id' => 65, 'name' => 'Bulungan'],
            ['id' => 6503, 'province_id' => 65, 'name' => 'Tana Tidung'],
            ['id' => 6504, 'province_id' => 65, 'name' => 'Nunukan'],
            ['id' => 6571, 'province_id' => 65, 'name' => 'Tarakan'],

            // ============================================================
            // ============ SULAWESI UTARA (71) ============
            // ============================================================
            ['id' => 7101, 'province_id' => 71, 'name' => 'Bolaang Mongondow'],
            ['id' => 7102, 'province_id' => 71, 'name' => 'Minahasa'],
            ['id' => 7103, 'province_id' => 71, 'name' => 'Kepulauan Sangihe'],
            ['id' => 7104, 'province_id' => 71, 'name' => 'Kepulauan Talaud'],
            ['id' => 7105, 'province_id' => 71, 'name' => 'Minahasa Selatan'],
            ['id' => 7106, 'province_id' => 71, 'name' => 'Minahasa Utara'],
            ['id' => 7107, 'province_id' => 71, 'name' => 'Bolaang Mongondow Utara'],
            ['id' => 7108, 'province_id' => 71, 'name' => 'Siau Tagulandang Biaro'],
            ['id' => 7109, 'province_id' => 71, 'name' => 'Minahasa Tenggara'],
            ['id' => 7110, 'province_id' => 71, 'name' => 'Bolaang Mongondow Selatan'],
            ['id' => 7111, 'province_id' => 71, 'name' => 'Bolaang Mongondow Timur'],
            ['id' => 7171, 'province_id' => 71, 'name' => 'Manado'],
            ['id' => 7172, 'province_id' => 71, 'name' => 'Bitung'],
            ['id' => 7173, 'province_id' => 71, 'name' => 'Tomohon'],
            ['id' => 7174, 'province_id' => 71, 'name' => 'Kotamobagu'],

            // ============================================================
            // ============ SULAWESI TENGAH (72) ============
            // ============================================================
            ['id' => 7201, 'province_id' => 72, 'name' => 'Banggai Kepulauan'],
            ['id' => 7202, 'province_id' => 72, 'name' => 'Banggai'],
            ['id' => 7203, 'province_id' => 72, 'name' => 'Morowali'],
            ['id' => 7204, 'province_id' => 72, 'name' => 'Poso'],
            ['id' => 7205, 'province_id' => 72, 'name' => 'Donggala'],
            ['id' => 7206, 'province_id' => 72, 'name' => 'Toli Toli'],
            ['id' => 7207, 'province_id' => 72, 'name' => 'Buol'],
            ['id' => 7208, 'province_id' => 72, 'name' => 'Parigi Moutong'],
            ['id' => 7209, 'province_id' => 72, 'name' => 'Tojo Una Una'],
            ['id' => 7210, 'province_id' => 72, 'name' => 'Sigi'],
            ['id' => 7211, 'province_id' => 72, 'name' => 'Banggai Laut'],
            ['id' => 7212, 'province_id' => 72, 'name' => 'Morowali Utara'],
            ['id' => 7271, 'province_id' => 72, 'name' => 'Palu'],

            // ============================================================
            // ============ SULAWESI SELATAN (73) ============
            // ============================================================
            ['id' => 7301, 'province_id' => 73, 'name' => 'Kepulauan Selayar'],
            ['id' => 7302, 'province_id' => 73, 'name' => 'Bulukumba'],
            ['id' => 7303, 'province_id' => 73, 'name' => 'Bantaeng'],
            ['id' => 7304, 'province_id' => 73, 'name' => 'Jeneponto'],
            ['id' => 7305, 'province_id' => 73, 'name' => 'Takalar'],
            ['id' => 7306, 'province_id' => 73, 'name' => 'Gowa'],
            ['id' => 7307, 'province_id' => 73, 'name' => 'Sinjai'],
            ['id' => 7308, 'province_id' => 73, 'name' => 'Maros'],
            ['id' => 7309, 'province_id' => 73, 'name' => 'Pangkajene Kepulauan'],
            ['id' => 7310, 'province_id' => 73, 'name' => 'Barru'],
            ['id' => 7311, 'province_id' => 73, 'name' => 'Bone'],
            ['id' => 7312, 'province_id' => 73, 'name' => 'Soppeng'],
            ['id' => 7313, 'province_id' => 73, 'name' => 'Wajo'],
            ['id' => 7314, 'province_id' => 73, 'name' => 'Sidenreng Rappang'],
            ['id' => 7315, 'province_id' => 73, 'name' => 'Pinrang'],
            ['id' => 7316, 'province_id' => 73, 'name' => 'Enrekang'],
            ['id' => 7317, 'province_id' => 73, 'name' => 'Luwu'],
            ['id' => 7318, 'province_id' => 73, 'name' => 'Tana Toraja'],
            ['id' => 7322, 'province_id' => 73, 'name' => 'Luwu Utara'],
            ['id' => 7325, 'province_id' => 73, 'name' => 'Luwu Timur'],
            ['id' => 7326, 'province_id' => 73, 'name' => 'Toraja Utara'],
            ['id' => 7371, 'province_id' => 73, 'name' => 'Makassar'],
            ['id' => 7372, 'province_id' => 73, 'name' => 'Pare Pare'],
            ['id' => 7373, 'province_id' => 73, 'name' => 'Palopo'],

            // ============================================================
            // ============ SULAWESI TENGGARA (74) ============
            // ============================================================
            ['id' => 7401, 'province_id' => 74, 'name' => 'Kolaka'],
            ['id' => 7402, 'province_id' => 74, 'name' => 'Konawe'],
            ['id' => 7403, 'province_id' => 74, 'name' => 'Muna'],
            ['id' => 7404, 'province_id' => 74, 'name' => 'Buton'],
            ['id' => 7405, 'province_id' => 74, 'name' => 'Konawe Selatan'],
            ['id' => 7406, 'province_id' => 74, 'name' => 'Bombana'],
            ['id' => 7407, 'province_id' => 74, 'name' => 'Wakatobi'],
            ['id' => 7408, 'province_id' => 74, 'name' => 'Kolaka Utara'],
            ['id' => 7409, 'province_id' => 74, 'name' => 'Buton Utara'],
            ['id' => 7410, 'province_id' => 74, 'name' => 'Konawe Utara'],
            ['id' => 7411, 'province_id' => 74, 'name' => 'Kolaka Timur'],
            ['id' => 7412, 'province_id' => 74, 'name' => 'Konawe Kepulauan'],
            ['id' => 7413, 'province_id' => 74, 'name' => 'Muna Barat'],
            ['id' => 7414, 'province_id' => 74, 'name' => 'Buton Tengah'],
            ['id' => 7415, 'province_id' => 74, 'name' => 'Buton Selatan'],
            ['id' => 7471, 'province_id' => 74, 'name' => 'Kendari'],
            ['id' => 7472, 'province_id' => 74, 'name' => 'Baubau'],

            // ============================================================
            // ============ GORONTALO (75) ============
            // ============================================================
            ['id' => 7501, 'province_id' => 75, 'name' => 'Boalemo'],
            ['id' => 7502, 'province_id' => 75, 'name' => 'Gorontalo'],
            ['id' => 7503, 'province_id' => 75, 'name' => 'Pohuwato'],
            ['id' => 7504, 'province_id' => 75, 'name' => 'Bone Bolango'],
            ['id' => 7505, 'province_id' => 75, 'name' => 'Gorontalo Utara'],
            ['id' => 7571, 'province_id' => 75, 'name' => 'Gorontalo'],

            // ============================================================
            // ============ SULAWESI BARAT (76) ============
            // ============================================================
            ['id' => 7601, 'province_id' => 76, 'name' => 'Majene'],
            ['id' => 7602, 'province_id' => 76, 'name' => 'Polewali Mandar'],
            ['id' => 7603, 'province_id' => 76, 'name' => 'Mamasa'],
            ['id' => 7604, 'province_id' => 76, 'name' => 'Mamuju'],
            ['id' => 7605, 'province_id' => 76, 'name' => 'Mamuju Utara'],
            ['id' => 7606, 'province_id' => 76, 'name' => 'Pasangkayu'],

            // ============================================================
            // ============ MALUKU (81) ============
            // ============================================================
            ['id' => 8101, 'province_id' => 81, 'name' => 'Maluku Tenggara Barat'],
            ['id' => 8102, 'province_id' => 81, 'name' => 'Maluku Tenggara'],
            ['id' => 8103, 'province_id' => 81, 'name' => 'Maluku Tengah'],
            ['id' => 8104, 'province_id' => 81, 'name' => 'Buru'],
            ['id' => 8105, 'province_id' => 81, 'name' => 'Kepulauan Aru'],
            ['id' => 8106, 'province_id' => 81, 'name' => 'Seram Bagian Barat'],
            ['id' => 8107, 'province_id' => 81, 'name' => 'Seram Bagian Timur'],
            ['id' => 8108, 'province_id' => 81, 'name' => 'Maluku Barat Daya'],
            ['id' => 8109, 'province_id' => 81, 'name' => 'Buru Selatan'],
            ['id' => 8171, 'province_id' => 81, 'name' => 'Ambon'],
            ['id' => 8172, 'province_id' => 81, 'name' => 'Tual'],

            // ============================================================
            // ============ MALUKU UTARA (82) ============
            // ============================================================
            ['id' => 8201, 'province_id' => 82, 'name' => 'Halmahera Barat'],
            ['id' => 8202, 'province_id' => 82, 'name' => 'Halmahera Tengah'],
            ['id' => 8203, 'province_id' => 82, 'name' => 'Halmahera Utara'],
            ['id' => 8204, 'province_id' => 82, 'name' => 'Halmahera Selatan'],
            ['id' => 8205, 'province_id' => 82, 'name' => 'Kepulauan Sula'],
            ['id' => 8206, 'province_id' => 82, 'name' => 'Halmahera Timur'],
            ['id' => 8207, 'province_id' => 82, 'name' => 'Pulau Morotai'],
            ['id' => 8208, 'province_id' => 82, 'name' => 'Pulau Taliabu'],
            ['id' => 8271, 'province_id' => 82, 'name' => 'Ternate'],
            ['id' => 8272, 'province_id' => 82, 'name' => 'Tidore Kepulauan'],

            // ============================================================
            // ============ PAPUA BARAT (91) ============
            // ============================================================
            ['id' => 9101, 'province_id' => 91, 'name' => 'Fakfak'],
            ['id' => 9102, 'province_id' => 91, 'name' => 'Kaimana'],
            ['id' => 9103, 'province_id' => 91, 'name' => 'Teluk Wondama'],
            ['id' => 9104, 'province_id' => 91, 'name' => 'Teluk Bintuni'],
            ['id' => 9105, 'province_id' => 91, 'name' => 'Manokwari'],
            ['id' => 9106, 'province_id' => 91, 'name' => 'Sorong Selatan'],
            ['id' => 9107, 'province_id' => 91, 'name' => 'Sorong'],
            ['id' => 9108, 'province_id' => 91, 'name' => 'Raja Ampat'],
            ['id' => 9109, 'province_id' => 91, 'name' => 'Tambrauw'],
            ['id' => 9110, 'province_id' => 91, 'name' => 'Maybrat'],
            ['id' => 9111, 'province_id' => 91, 'name' => 'Manokwari Selatan'],
            ['id' => 9112, 'province_id' => 91, 'name' => 'Pegunungan Arfak'],
            ['id' => 9171, 'province_id' => 91, 'name' => 'Sorong'],

            // ============================================================
            // ============ PAPUA (92) ============
            // ============================================================
            ['id' => 9201, 'province_id' => 92, 'name' => 'Jayapura'],
            ['id' => 9202, 'province_id' => 92, 'name' => 'Jayawijaya'],
            ['id' => 9203, 'province_id' => 92, 'name' => 'Panjai'],
            ['id' => 9204, 'province_id' => 92, 'name' => 'Nabire'],
            ['id' => 9205, 'province_id' => 92, 'name' => 'Kepulauan Yapen'],
            ['id' => 9206, 'province_id' => 92, 'name' => 'Biak Numfor'],
            ['id' => 9207, 'province_id' => 92, 'name' => 'Paniai'],
            ['id' => 9208, 'province_id' => 92, 'name' => 'Puncak Jaya'],
            ['id' => 9209, 'province_id' => 92, 'name' => 'Mimika'],
            ['id' => 9210, 'province_id' => 92, 'name' => 'Sarmi'],
            ['id' => 9211, 'province_id' => 92, 'name' => 'Keerom'],
            ['id' => 9212, 'province_id' => 92, 'name' => 'Pegunungan Bintang'],
            ['id' => 9213, 'province_id' => 92, 'name' => 'Yahukimo'],
            ['id' => 9214, 'province_id' => 92, 'name' => 'Tolikara'],
            ['id' => 9215, 'province_id' => 92, 'name' => 'Waropen'],
            ['id' => 9216, 'province_id' => 92, 'name' => 'Boven Digoel'],
            ['id' => 9217, 'province_id' => 92, 'name' => 'Mappi'],
            ['id' => 9218, 'province_id' => 92, 'name' => 'Asmat'],
            ['id' => 9219, 'province_id' => 92, 'name' => 'Supiori'],
            ['id' => 9220, 'province_id' => 92, 'name' => 'Mamberamo Raya'],
            ['id' => 9221, 'province_id' => 92, 'name' => 'Mamberamo Tengah'],
            ['id' => 9222, 'province_id' => 92, 'name' => 'Yalimo'],
            ['id' => 9223, 'province_id' => 92, 'name' => 'Lanny Jaya'],
            ['id' => 9224, 'province_id' => 92, 'name' => 'Nduga'],
            ['id' => 9225, 'province_id' => 92, 'name' => 'Puncak'],
            ['id' => 9226, 'province_id' => 92, 'name' => 'Dogiyai'],
            ['id' => 9227, 'province_id' => 92, 'name' => 'Intan Jaya'],
            ['id' => 9228, 'province_id' => 92, 'name' => 'Deiyai'],
            ['id' => 9271, 'province_id' => 92, 'name' => 'Jayapura'],

            // ============================================================
            // ============ PAPUA SELATAN (93) ============
            // ============================================================
            ['id' => 9301, 'province_id' => 93, 'name' => 'Merauke'],
            ['id' => 9302, 'province_id' => 93, 'name' => 'Boven Digoel'],
            ['id' => 9303, 'province_id' => 93, 'name' => 'Mappi'],
            ['id' => 9304, 'province_id' => 93, 'name' => 'Asmat'],

            // ============================================================
            // ============ PAPUA TENGAH (94) ============
            // ============================================================
            ['id' => 9401, 'province_id' => 94, 'name' => 'Nabire'],
            ['id' => 9402, 'province_id' => 94, 'name' => 'Paniai'],
            ['id' => 9403, 'province_id' => 94, 'name' => 'Mimika'],
            ['id' => 9404, 'province_id' => 94, 'name' => 'Dogiyai'],
            ['id' => 9405, 'province_id' => 94, 'name' => 'Intan Jaya'],
            ['id' => 9406, 'province_id' => 94, 'name' => 'Deiyai'],

            // ============================================================
            // ============ PAPUA PEGUNUNGAN (95) ============
            // ============================================================
            ['id' => 9501, 'province_id' => 95, 'name' => 'Jayawijaya'],
            ['id' => 9502, 'province_id' => 95, 'name' => 'Pegunungan Bintang'],
            ['id' => 9503, 'province_id' => 95, 'name' => 'Yahukimo'],
            ['id' => 9504, 'province_id' => 95, 'name' => 'Tolikara'],
            ['id' => 9505, 'province_id' => 95, 'name' => 'Yalimo'],
            ['id' => 9506, 'province_id' => 95, 'name' => 'Lanny Jaya'],
            ['id' => 9507, 'province_id' => 95, 'name' => 'Nduga'],
            ['id' => 9508, 'province_id' => 95, 'name' => 'Puncak'],
            ['id' => 9509, 'province_id' => 95, 'name' => 'Puncak Jaya'],
            ['id' => 9510, 'province_id' => 95, 'name' => 'Mamberamo Tengah'],
        ];

        DB::table('regencies')->insert($regencies);
    }
}
