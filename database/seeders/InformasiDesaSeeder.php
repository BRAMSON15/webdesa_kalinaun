<?php

namespace Database\Seeders;

use App\Models\InformasiDesa;
use App\Models\User;
use Illuminate\Database\Seeder;

class InformasiDesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $adminId = $admin ? $admin->id : 1;

        $sampleData = [
            [
                'judul' => 'Pembangunan Jalan Rabat Beton Desa Kalinaun Dimulai',
                'konten' => 'Pemerintah Desa Kalinaun secara resmi memulai pembangunan jalan rabat beton di Dusun II sepanjang 500 meter. Proyek ini bersumber dari alokasi Dana Desa (DD) tahun anggaran 2026 yang bertujuan untuk mempermudah jalur transportasi hasil bumi dan pertanian para warga. Kepala Desa menyampaikan bahwa pengerjaan jalan ini melibatkan warga setempat (padat karya tunai) guna membantu perekonomian warga selama masa pembangunan.',
                'gambar' => null,
                'kategori' => 'kegiatan',
                'is_published' => true,
                'tanggal_publish' => now()->subDays(2),
                'created_by' => $adminId,
            ],
            [
                'judul' => 'Jadwal Pemeriksaan Kesehatan Gratis & Posyandu Balita',
                'konten' => 'Diberitahukan kepada seluruh warga Desa Kalinaun, khususnya para ibu yang memiliki balita serta warga lanjut usia (lansia), bahwa kegiatan Posyandu rutin bulanan dan pemeriksaan kesehatan gratis akan diselenggarakan pada hari Jumat, 29 Mei 2026 bertempat di Balai Pertemuan Desa Kalinaun mulai pukul 08.00 WITA s.d selesai. Harap membawa buku KIA/KMS masing-masing.',
                'kategori' => 'pengumuman',
                'is_published' => true,
                'tanggal_publish' => now()->subDays(4),
                'created_by' => $adminId,
            ],
            [
                'judul' => 'Pemerataan Penyaluran Bantuan Langsung Tunai (BLT) Tahap II',
                'konten' => 'Pemerintah Desa Kalinaun bersiap menyalurkan Bantuan Langsung Tunai (BLT) Dana Desa untuk Tahap II kepada 45 Keluarga Penerima Manfaat (KPM) yang telah memenuhi kriteria dan terverifikasi dalam musyawarah desa khusus. Penyaluran direncanakan berlangsung tertib di aula kantor desa dengan menerapkan pembagian jadwal per dusun untuk menghindari kerumunan.',
                'kategori' => 'pengumuman',
                'is_published' => true,
                'tanggal_publish' => now()->subDays(6),
                'created_by' => $adminId,
            ]
        ];

        foreach ($sampleData as $data) {
            InformasiDesa::create($data);
        }
    }
}
