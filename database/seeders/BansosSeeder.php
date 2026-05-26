<?php

namespace Database\Seeders;

use App\Models\Bansos;
use App\Models\PenerimaBansos;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BansosSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masyarakat = User::where('role', 'masyarakat')->first();

        // Create Bansos Programs
        $bansos1 = Bansos::create([
            'nama_bansos' => 'Bantuan Langsung Tunai (BLT)',
            'deskripsi' => 'Program bantuan langsung tunai untuk keluarga kurang mampu',
            'syarat_ketentuan' => 'Terdaftar sebagai keluarga kurang mampu, Memiliki KTP dan KK, Tidak menerima bantuan serupa dari program lain',
            'kuota' => 50,
            'kuota_terpakai' => 2,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonths(3),
            'status' => 'aktif',
            'nominal' => 500000,
            'jenis_bansos' => 'Tunai',
            'catatan' => 'Program prioritas untuk keluarga dengan penghasilan di bawah UMR',
        ]);

        $bansos2 = Bansos::create([
            'nama_bansos' => 'Bantuan Pangan Non Tunai (BPNT)',
            'deskripsi' => 'Program bantuan pangan untuk keluarga kurang mampu',
            'syarat_ketentuan' => 'Terdaftar sebagai keluarga kurang mampu, Memiliki KTP dan KK',
            'kuota' => 100,
            'kuota_terpakai' => 1,
            'tanggal_mulai' => now(),
            'tanggal_selesai' => now()->addMonths(6),
            'status' => 'aktif',
            'nominal' => 300000,
            'jenis_bansos' => 'Pangan',
            'catatan' => 'Bantuan diberikan dalam bentuk kartu elektronik',
        ]);

        $bansos3 = Bansos::create([
            'nama_bansos' => 'Beasiswa Pendidikan',
            'deskripsi' => 'Program beasiswa untuk siswa berprestasi dari keluarga kurang mampu',
            'syarat_ketentuan' => 'Siswa aktif di sekolah, Nilai rata-rata minimal 7.0, Dari keluarga kurang mampu',
            'kuota' => 30,
            'kuota_terpakai' => 0,
            'tanggal_mulai' => now()->addMonths(1),
            'tanggal_selesai' => now()->addMonths(12),
            'status' => 'nonaktif',
            'nominal' => 1000000,
            'jenis_bansos' => 'Pendidikan',
            'catatan' => 'Akan dimulai pada awal tahun ajaran baru',
        ]);

        // Create sample recipients
        if ($masyarakat) {
            PenerimaBansos::create([
                'bansos_id' => $bansos1->id,
                'user_id' => $masyarakat->id,
                'nik' => $masyarakat->nik,
                'nama_penerima' => $masyarakat->name,
                'alamat' => $masyarakat->alamat,
                'no_hp' => $masyarakat->no_hp,
                'status' => 'disetujui',
                'nominal_diterima' => 500000,
                'tanggal_penerimaan' => now()->subDays(5),
            ]);

            PenerimaBansos::create([
                'bansos_id' => $bansos2->id,
                'user_id' => $masyarakat->id,
                'nik' => $masyarakat->nik,
                'nama_penerima' => $masyarakat->name,
                'alamat' => $masyarakat->alamat,
                'no_hp' => $masyarakat->no_hp,
                'status' => 'menunggu',
            ]);
        }
    }
}
