# Dokumentasi Sistem Website Desa (Class Diagram Implementation)

## Overview
Sistem ini adalah implementasi lengkap dari class diagram untuk website desa dengan 3 role utama: **Masyarakat**, **Sekdes (Sekretaris Desa)**, dan **Admin**.

## Struktur Database

### Tabel Utama
1. **tbl_masyarakat** - Data masyarakat yang dapat mengajukan surat
2. **tbl_sekdes** - Data sekretaris desa yang melakukan validasi akhir
3. **tbl_admin** - Data admin yang melakukan verifikasi berkas
4. **tbl_pengajuan_surat** - Data pengajuan surat dari masyarakat
5. **tbl_arsip_dokumen_desa** - Arsip dokumen desa yang dikelola admin

## Akun Demo

### Masyarakat
- **Email**: ahmad.wijaya@gmail.com
- **Password**: password123
- **NIK**: 1234567890123456

### Sekdes
- **Username**: sekdes_desa
- **Password**: sekdes123

### Admin
- **Username**: admin_desa
- **Password**: admin123

## Fitur Per Role

### 1. Masyarakat
**URL Base**: `/class-diagram/masyarakat/`

#### Menu & Fitur:
1. **Dashboard** (`/dashboard`)
   - Statistik pengajuan (total, proses, selesai, ditolak)
   - Daftar 5 pengajuan terbaru
   - Quick access ke fitur utama

2. **Buat Pengajuan Surat** (`/form-pengajuan`)
   - Form pengajuan surat baru
   - Pilihan jenis surat:
     * Surat Keterangan Domisili
     * Surat Keterangan Usaha
     * Surat Keterangan Tidak Mampu
     * Surat Pengantar Nikah
     * Surat Keterangan Kelahiran
     * Surat Keterangan Kematian
   - Input keterangan/keperluan

3. **Riwayat Pengajuan** (`/riwayat-pengajuan`)
   - Tabel semua pengajuan dengan pagination
   - Filter berdasarkan status
   - Akses ke detail setiap pengajuan

4. **Detail Status** (`/cek-status/{id}`)
   - Informasi lengkap pengajuan
   - Timeline proses pengajuan
   - Status terkini (proses/selesai/ditolak)
   - Catatan dari Sekdes (jika ada)

5. **Profil Saya** (`/profil`)
   - Edit nama, email, no HP
   - NIK dan alamat tidak dapat diubah
   - Informasi akun

#### Methods dari Class Diagram:
- `register()` - Registrasi akun baru
- `login()` - Login ke sistem
- `buatPengajuan()` - Membuat pengajuan surat baru
- `cekStatus()` - Mengecek status pengajuan

---

### 2. Sekdes (Sekretaris Desa)
**URL Base**: `/class-diagram/sekdes/`

#### Menu & Fitur:
1. **Dashboard Sekdes** (`/dashboard`)
   - Statistik pengajuan keseluruhan
   - Daftar 5 pengajuan yang menunggu validasi
   - Overview sistem

2. **Profil Sekdes** (`/profil`)
   - Edit username
   - Ubah password
   - Informasi akun

3. **Validasi Pengajuan** (`/daftar-pengajuan`)
   - Daftar pengajuan dengan status "proses"
   - Filter dan pencarian
   - Pagination
   - Akses ke detail untuk validasi

4. **Detail Pengajuan** (`/detail-pengajuan/{id}`)
   - Informasi lengkap pengajuan
   - Data pemohon
   - Form validasi akhir:
     * Setujui (status: selesai)
     * Tolak (status: ditolak)
     * Input catatan

5. **Lihat Laporan Arsip** (`/laporan-arsip`)
   - Tabel semua pengajuan yang sudah selesai/ditolak
   - Filter berdasarkan:
     * Bulan
     * Tahun
     * Status
   - Chart statistik pengajuan
   - Export laporan

6. **Export Laporan** (`/export-laporan`)
   - View untuk print/PDF
   - Filter custom
   - Format siap cetak

#### Methods dari Class Diagram:
- `validasiAkhir()` - Melakukan validasi akhir (setujui/tolak)
- `lihatLaporanArsip()` - Melihat laporan arsip pengajuan

---

### 3. Admin
**URL Base**: `/class-diagram/admin/`

#### Menu & Fitur:
1. **Dashboard Admin** (`/dashboard`)
   - Statistik lengkap:
     * Total pengajuan
     * Pengajuan diproses
     * Pengajuan selesai
     * Total arsip dokumen
   - Daftar 5 pengajuan terbaru

2. **Daftar Pengajuan** (`/daftar-pengajuan`)
   - Semua pengajuan surat
   - Filter berdasarkan status dan jenis surat
   - Pagination
   - Akses ke detail

3. **Detail Pengajuan** (`/detail-pengajuan/{id}`)
   - Informasi lengkap pengajuan
   - Data pemohon lengkap
   - Form verifikasi berkas:
     * Terverifikasi (berkas lengkap)
     * Ditolak (berkas tidak lengkap)

4. **Arsip Dokumen Desa** (`/arsip-dokumen`)
   - Daftar semua dokumen arsip
   - Kategori:
     * Perdes (Peraturan Desa)
     * SK Kades (Surat Keputusan Kepala Desa)
     * Aset
     * Lainnya
   - Download dokumen
   - Hapus dokumen

5. **Tambah Arsip Dokumen** (`/form-arsip-dokumen`)
   - Form upload dokumen baru
   - Input judul dokumen
   - Pilih kategori
   - Upload file (PDF, DOC, DOCX, max 10MB)

6. **Profil Admin** (`/profil`)
   - Edit username
   - Ubah password
   - Informasi akun

#### Methods dari Class Diagram:
- `verifikasiBerkas()` - Verifikasi kelengkapan berkas pengajuan
- `kelolaArsipDesa()` - Mengelola (tambah/hapus) arsip dokumen desa
- `getDaftarArsipDesa()` - Mendapatkan daftar arsip dokumen

---

## Alur Proses Pengajuan Surat

```
1. Masyarakat membuat pengajuan surat
   ↓
2. Admin memverifikasi berkas (terverifikasi/ditolak)
   ↓
3. Sekdes melakukan validasi akhir (setujui/tolak)
   ↓
4. Status pengajuan berubah menjadi "selesai" atau "ditolak"
   ↓
5. Masyarakat dapat melihat status dan catatan
```

## Status Pengajuan
- **proses**: Sedang dalam proses verifikasi
- **selesai**: Pengajuan disetujui dan selesai
- **ditolak**: Pengajuan ditolak

## File Structure

### Controllers
```
app/Http/Controllers/ClassDiagram/
├── MasyarakatController.php
├── SekdesController.php
└── AdminController.php

app/Http/Controllers/
└── ClassDiagramAuthController.php
```

### Models
```
app/Models/
├── TblMasyarakat.php
├── TblSekdes.php
├── TblAdmin.php
├── TblPengajuanSurat.php
└── TblArsipDokumenDesa.php
```

### Views
```
resources/views/class-diagram/
├── auth/
│   └── login.blade.php
├── masyarakat/
│   ├── dashboard.blade.php
│   ├── form-pengajuan.blade.php
│   ├── riwayat-pengajuan.blade.php
│   ├── detail-status.blade.php
│   └── profil.blade.php
├── sekdes/
│   ├── dashboard.blade.php
│   ├── profil.blade.php
│   ├── daftar-pengajuan.blade.php
│   ├── detail-pengajuan.blade.php
│   ├── laporan-arsip.blade.php
│   └── export-laporan.blade.php
└── admin/
    ├── dashboard.blade.php
    ├── daftar-pengajuan.blade.php
    ├── detail-pengajuan.blade.php
    ├── arsip-dokumen.blade.php
    ├── form-arsip-dokumen.blade.php
    └── profil.blade.php
```

### Migrations
```
database/migrations/
├── 2026_04_24_121617_create_tbl_masyarakat_table.php
├── 2026_04_24_121625_create_tbl_sekdes_table.php
├── 2026_04_24_121631_create_tbl_admin_table.php
├── 2026_04_24_121640_create_tbl_pengajuan_surat_table.php
└── 2026_04_24_121647_create_tbl_arsip_dokumen_desa_table.php
```

## Authentication Guards

Sistem menggunakan multiple authentication guards:

```php
// config/auth.php
'guards' => [
    'masyarakat' => [
        'driver' => 'session',
        'provider' => 'masyarakat',
    ],
    'sekdes' => [
        'driver' => 'session',
        'provider' => 'sekdes',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admin',
    ],
],
```

## Cara Menjalankan

1. **Setup Database**
   ```bash
   php artisan migrate
   php artisan db:seed --class=ClassDiagramSeeder
   ```

2. **Clear Cache**
   ```bash
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

3. **Jalankan Server**
   ```bash
   php artisan serve
   ```

4. **Akses Aplikasi**
   - Login: `http://localhost:8000/class-diagram/login`
   - Register: `http://localhost:8000/class-diagram/register`

## Teknologi yang Digunakan

- **Framework**: Laravel 11
- **Database**: SQLite
- **Frontend**: 
  - Bootstrap 5.3.0
  - Font Awesome 6.4.0
  - Chart.js (untuk visualisasi data)
- **Authentication**: Laravel Multi-Guard Authentication

## Catatan Penting

1. **File Upload**: Pastikan folder `storage/app/public/arsip-dokumen-desa` memiliki permission yang tepat
2. **Symbolic Link**: Jalankan `php artisan storage:link` untuk membuat symbolic link ke storage
3. **Environment**: Pastikan `.env` sudah dikonfigurasi dengan benar
4. **Database**: Sistem menggunakan SQLite, file database ada di `database/database.sqlite`

## Fitur Keamanan

1. **CSRF Protection**: Semua form menggunakan `@csrf` token
2. **Password Hashing**: Password di-hash menggunakan bcrypt
3. **Authentication Middleware**: Setiap route dilindungi dengan middleware auth guard
4. **Input Validation**: Semua input divalidasi di controller
5. **File Upload Validation**: File upload dibatasi tipe dan ukuran

## Troubleshooting

### Error: "Class not found"
```bash
composer dump-autoload
```

### Error: "View not found"
```bash
php artisan view:clear
```

### Error: "Route not found"
```bash
php artisan route:clear
php artisan route:cache
```

### Error: "Permission denied" saat upload file
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## Pengembangan Selanjutnya

Fitur yang bisa ditambahkan:
1. Notifikasi email/SMS untuk status pengajuan
2. Export laporan ke PDF/Excel
3. Dashboard analytics yang lebih detail
4. Sistem approval bertingkat
5. Upload dokumen pendukung untuk pengajuan
6. Tracking real-time status pengajuan
7. Integrasi dengan sistem e-KTP
8. API untuk mobile app

---

**Dibuat**: Mei 2026  
**Versi**: 1.0.0  
**Status**: Production Ready ✅
