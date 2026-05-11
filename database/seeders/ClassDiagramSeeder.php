<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TblMasyarakat;
use App\Models\TblSekdes;
use App\Models\TblAdmin;
use App\Models\TblPengajuanSurat;
use App\Models\TblArsipDokumenDesa;
use Illuminate\Support\Facades\Hash;

class ClassDiagramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed tbl_admin
        TblAdmin::create([
            'username' => 'admin_desa',
            'password' => Hash::make('admin123')
        ]);

        // Seed tbl_sekdes
        TblSekdes::create([
            'username' => 'sekdes_desa',
            'password' => Hash::make('sekdes123')
        ]);

        // Seed tbl_masyarakat
        $masyarakat1 = TblMasyarakat::create([
            'nik' => '3201234567890001',
            'nama' => 'Ahmad Wijaya',
            'email' => 'ahmad.wijaya@gmail.com',
            'no_hp' => '081234567890',
            'password' => Hash::make('password123')
        ]);

        $masyarakat2 = TblMasyarakat::create([
            'nik' => '3201234567890002',
            'nama' => 'Siti Nurhaliza',
            'email' => 'siti.nurhaliza@gmail.com',
            'no_hp' => '081234567891',
            'password' => Hash::make('password123')
        ]);

        $masyarakat3 = TblMasyarakat::create([
            'nik' => '3201234567890003',
            'nama' => 'Budi Santoso',
            'email' => 'budi.santoso@gmail.com',
            'no_hp' => '081234567892',
            'password' => Hash::make('password123')
        ]);

        // Seed tbl_pengajuan_surat
        TblPengajuanSurat::create([
            'id_masyarakat' => $masyarakat1->id_masyarakat,
            'keterangan' => 'Surat keterangan domisili untuk keperluan pembuatan KTP baru',
            'tgl_pengajuan' => now()->subDays(5),
            'jenis_surat' => 'Surat Keterangan Domisili',
            'status' => 'proses'
        ]);

        TblPengajuanSurat::create([
            'id_masyarakat' => $masyarakat2->id_masyarakat,
            'keterangan' => 'Surat keterangan usaha untuk keperluan pengajuan kredit UMKM',
            'tgl_pengajuan' => now()->subDays(3),
            'jenis_surat' => 'Surat Keterangan Usaha',
            'status' => 'selesai'
        ]);

        TblPengajuanSurat::create([
            'id_masyarakat' => $masyarakat3->id_masyarakat,
            'keterangan' => 'Surat keterangan tidak mampu untuk keperluan beasiswa anak',
            'tgl_pengajuan' => now()->subDays(1),
            'jenis_surat' => 'Surat Keterangan Tidak Mampu',
            'status' => 'proses'
        ]);

        TblPengajuanSurat::create([
            'id_masyarakat' => $masyarakat1->id_masyarakat,
            'keterangan' => 'Surat pengantar nikah untuk keperluan pernikahan bulan depan',
            'tgl_pengajuan' => now()->subDays(7),
            'jenis_surat' => 'Surat Pengantar Nikah',
            'status' => 'ditolak'
        ]);

        // Seed tbl_arsip_dokumen_desa
        $admin = TblAdmin::first();
        
        TblArsipDokumenDesa::create([
            'judul_dokumen' => 'Peraturan Desa No. 1 Tahun 2024 tentang APBDes',
            'kategori' => 'Perdes',
            'file_path' => 'arsip-dokumen-desa/perdes_01_2024.pdf',
            'id_admin' => $admin->id_admin,
            'tgl_upload' => now()->subDays(30)
        ]);

        TblArsipDokumenDesa::create([
            'judul_dokumen' => 'SK Kepala Desa No. 15 tentang Pembentukan Tim Pelaksana Program',
            'kategori' => 'SK Kades',
            'file_path' => 'arsip-dokumen-desa/sk_kades_15_2024.pdf',
            'id_admin' => $admin->id_admin,
            'tgl_upload' => now()->subDays(15)
        ]);

        TblArsipDokumenDesa::create([
            'judul_dokumen' => 'Inventaris Aset Desa Tahun 2024',
            'kategori' => 'Aset',
            'file_path' => 'arsip-dokumen-desa/inventaris_aset_2024.pdf',
            'id_admin' => $admin->id_admin,
            'tgl_upload' => now()->subDays(10)
        ]);
    }
}
