<?php

namespace Database\Seeders;

use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaduanSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masyarakat = User::where('role', 'masyarakat')->first();

        if ($masyarakat) {
            // Create sample complaints
            $pengaduans = [
                [
                    'user_id' => $masyarakat->id,
                    'judul' => 'Jalan Rusak di Depan Rumah',
                    'deskripsi' => 'Jalan di depan rumah saya sudah rusak parah dan berbahaya bagi pengendara. Mohon segera diperbaiki sebelum terjadi kecelakaan.',
                    'kategori' => 'infrastruktur',
                    'status' => 'baru',
                    'tanggal_pengaduan' => now(),
                ],
                [
                    'user_id' => $masyarakat->id,
                    'judul' => 'Lampu Jalan Mati',
                    'deskripsi' => 'Lampu jalan di jalan utama desa sudah mati selama 2 minggu. Ini membuat jalan menjadi gelap dan tidak aman di malam hari.',
                    'kategori' => 'infrastruktur',
                    'status' => 'diproses',
                    'catatan_admin' => 'Sudah dilaporkan ke bagian perbaikan infrastruktur',
                    'tanggal_pengaduan' => now()->subDays(5),
                ],
                [
                    'user_id' => $masyarakat->id,
                    'judul' => 'Pelayanan Kesehatan Kurang Responsif',
                    'deskripsi' => 'Petugas kesehatan di puskesmas kurang responsif terhadap keluhan pasien. Waktu tunggu sangat lama.',
                    'kategori' => 'kesehatan',
                    'status' => 'diproses',
                    'catatan_admin' => 'Akan dilakukan evaluasi terhadap pelayanan kesehatan',
                    'tanggal_pengaduan' => now()->subDays(3),
                ],
                [
                    'user_id' => $masyarakat->id,
                    'judul' => 'Sekolah Membutuhkan Perbaikan Atap',
                    'deskripsi' => 'Atap sekolah dasar sudah bocor dan membahayakan siswa saat hujan. Perlu segera diperbaiki.',
                    'kategori' => 'pendidikan',
                    'status' => 'selesai',
                    'catatan_admin' => 'Sudah dilakukan perbaikan atap sekolah',
                    'tanggal_pengaduan' => now()->subDays(10),
                    'tanggal_selesai' => now()->subDays(2),
                ],
                [
                    'user_id' => $masyarakat->id,
                    'judul' => 'Layanan Air Bersih Terganggu',
                    'deskripsi' => 'Air bersih di rumah saya tidak mengalir selama 3 hari. Mohon segera ditangani.',
                    'kategori' => 'layanan',
                    'status' => 'ditolak',
                    'catatan_admin' => 'Masalah sudah teratasi sendiri, tidak perlu intervensi',
                    'tanggal_pengaduan' => now()->subDays(7),
                    'tanggal_selesai' => now()->subDays(5),
                ],
            ];

            foreach ($pengaduans as $pengaduan) {
                Pengaduan::create($pengaduan);
            }
        }
    }
}
