<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\JenisSurat;
use App\Models\ProfilDesa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@desa.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nik' => '1234567890123456',
            'alamat' => 'Kantor Desa',
            'no_hp' => '081234567890',
            'tanggal_lahir' => '1980-01-01',
            'jenis_kelamin' => 'L',
        ]);

        // Create Kades User
        User::create([
            'name' => 'Kepala Desa',
            'email' => 'kades@desa.com',
            'password' => Hash::make('password'),
            'role' => 'kades',
            'nik' => '1234567890123457',
            'alamat' => 'Rumah Dinas Kepala Desa',
            'no_hp' => '081234567891',
            'tanggal_lahir' => '1975-01-01',
            'jenis_kelamin' => 'L',
        ]);

        // Create Sample Masyarakat User
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'masyarakat',
            'nik' => '1234567890123458',
            'alamat' => 'Jl. Merdeka No. 123',
            'no_hp' => '081234567892',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
        ]);

        // Create Jenis Surat
        $jenisSurats = [
            [
                'nama_surat' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Surat keterangan tempat tinggal',
                'persyaratan' => ['KTP', 'KK', 'Surat Pengantar RT/RW'],
            ],
            [
                'nama_surat' => 'Surat Keterangan Usaha',
                'deskripsi' => 'Surat keterangan untuk keperluan usaha',
                'persyaratan' => ['KTP', 'KK', 'Foto Tempat Usaha'],
            ],
            [
                'nama_surat' => 'Surat Keterangan Tidak Mampu',
                'deskripsi' => 'Surat keterangan untuk keluarga tidak mampu',
                'persyaratan' => ['KTP', 'KK', 'Surat Pengantar RT/RW'],
            ],
            [
                'nama_surat' => 'Surat Pengantar Nikah',
                'deskripsi' => 'Surat pengantar untuk keperluan pernikahan',
                'persyaratan' => ['KTP', 'KK', 'Akta Kelahiran', 'Surat Keterangan Belum Menikah'],
            ],
        ];

        foreach ($jenisSurats as $jenis) {
            JenisSurat::create($jenis);
        }

        // Create Profil Desa
        ProfilDesa::create([
            'nama_desa' => 'Desa Maju Jaya',
            'nama_kepala_desa' => 'Bapak Slamet Riyadi',
            'alamat_desa' => 'Jl. Raya Desa No. 1, Kecamatan Maju, Kabupaten Sejahtera',
            'kode_pos' => '12345',
            'telepon' => '021-1234567',
            'email' => 'info@desamajujaya.go.id',
            'visi' => 'Mewujudkan Desa Maju Jaya yang sejahtera, mandiri, dan berkeadilan',
            'misi' => 'Meningkatkan pelayanan publik, Mengembangkan ekonomi desa, Melestarikan budaya lokal',
            'sejarah' => 'Desa Maju Jaya didirikan pada tahun 1945...',
        ]);
    }
}
