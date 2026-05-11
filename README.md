# Sistem Informasi Desa

Sistem Informasi Desa adalah platform digital untuk pelayanan administrasi desa yang memungkinkan masyarakat mengajukan berbagai jenis surat keterangan secara online.

## Fitur Utama

### 🏛️ **Admin**
- **Kelola Profil Desa**: Mengelola informasi profil desa
- **Kelola Status Pengajuan Surat**: Melihat dan mengelola status pengajuan surat
- **Kelola Informasi Desa**: Mengelola berita dan informasi desa
- **Kelola Data Pengguna**: Mengelola data pengguna sistem
- **Kelola Jenis Surat**: Mengelola jenis-jenis surat yang tersedia
- **Mencetak Surat**: Mencetak surat yang sudah disetujui
- **Kelola Arsip Dokumen**: Mengelola arsip dokumen desa

### 👨‍💼 **Kepala Desa (Kades)**
- **Profil Sekdes**: Mengelola profil kepala desa
- **Validasi Pengajuan Surat**: Memvalidasi pengajuan surat dari masyarakat (menerima/menolak)
- **Monitoring Pengaduan Masyarakat**: Memonitor pengaduan dari masyarakat
- **Lihat Laporan Arsip**: Melihat laporan arsip surat

### 👥 **Masyarakat**
- **Pengajuan Surat**: Mengajukan berbagai jenis surat keterangan
- **Riwayat Pengajuan**: Melihat status dan riwayat pengajuan
- **Download Surat**: Mengunduh surat yang sudah disetujui
- **Informasi Desa**: Membaca berita dan informasi dari desa
- **Profil Desa**: Melihat profil dan informasi desa

## Jenis Surat yang Tersedia

1. **Surat Keterangan Domisili**
   - Persyaratan: KTP, KK, Surat Pengantar RT/RW

2. **Surat Keterangan Usaha**
   - Persyaratan: KTP, KK, Foto Tempat Usaha

3. **Surat Keterangan Tidak Mampu**
   - Persyaratan: KTP, KK, Surat Pengantar RT/RW

4. **Surat Pengantar Nikah**
   - Persyaratan: KTP, KK, Akta Kelahiran, Surat Keterangan Belum Menikah

## Alur Sistem

### Diagram Use Case Kades
```
Kades → Login → Profil Sekdes
     → Validasi Pengajuan Surat → (Menerima/Menolak)
     → Monitoring Pengaduan Masyarakat
     → Lihat Laporan Arsip
     → Logout
```

### Diagram Use Case Admin
```
Admin → Login → Kelola Profil Desa
      → Kelola Status Pengajuan Surat dan Pengaduan
      → Kelola Informasi Desa
      → Kelola Data Pengguna
      → Kelola Jenis Surat
      → Mencetak Surat
      → Kelola Arsip Dokumen Desa
      → Logout
```

### Activity Diagram Validasi Pengajuan Surat
1. Kades login ke sistem
2. Sistem validasi login
3. Kades pilih menu "Validasi Pengajuan"
4. Sistem tampilkan data pengajuan
5. Kades periksa berkas
6. Kades putuskan: Disetujui/Ditolak
7. Sistem update status dan kirim notifikasi email

### Activity Diagram Pengajuan Surat
1. Masyarakat login ke sistem
2. Sistem validasi data login
3. Masyarakat pilih menu "Buat Pengajuan Surat"
4. Masyarakat pilih jenis surat
5. Masyarakat isi formulir
6. Masyarakat upload dokumen
7. Sistem cek kelengkapan data
8. Jika lengkap: Simpan ke database, status = diproses
9. Jika tidak lengkap: Tampilkan pesan kesalahan
10. Sistem tampilkan notifikasi berhasil

## Teknologi yang Digunakan

- **Backend**: Laravel 13 (PHP 8.3+)
- **Frontend**: Bootstrap 5, Font Awesome
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Built-in Auth
- **File Storage**: Laravel Storage

## Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd webdesa2
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   # Sesuaikan konfigurasi database di .env
   php artisan migrate --seed
   ```

5. **Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Run Development Server**
   ```bash
   php artisan serve
   ```

## Akun Default

Setelah menjalankan seeder, tersedia akun default:

- **Admin**: admin@desa.com / password
- **Kades**: kades@desa.com / password  
- **Masyarakat**: budi@gmail.com / password

## Struktur Database

### Users
- id, name, email, password, role, nik, alamat, no_hp, tanggal_lahir, jenis_kelamin, is_active

### Jenis Surats
- id, nama_surat, deskripsi, persyaratan (JSON), is_active

### Pengajuan Surats
- id, user_id, jenis_surat_id, nomor_surat, keperluan, data_formulir (JSON), dokumen_pendukung (JSON), status, catatan_kades, tanggal_disetujui, tanggal_ditolak, diproses_oleh

### Profil Desas
- id, nama_desa, nama_kepala_desa, alamat_desa, kode_pos, telepon, email, visi, misi, sejarah, struktur_organisasi (JSON), logo

### Informasi Desas
- id, judul, konten, gambar, kategori, is_published, tanggal_publish, created_by

### Arsip Dokumens
- id, nama_dokumen, nomor_dokumen, deskripsi, file_path, file_type, file_size, kategori, tanggal_dokumen, uploaded_by

## Role-Based Access Control

Sistem menggunakan middleware role untuk mengontrol akses:
- **Admin**: Akses penuh ke semua fitur administrasi
- **Kades**: Akses ke validasi pengajuan dan monitoring
- **Masyarakat**: Akses ke pengajuan surat dan informasi

## Kontribusi

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

## Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

## Kontak

- Email: info@desamajujaya.go.id
- Telepon: 021-1234567
- Alamat: Jl. Raya Desa No. 1, Kecamatan Maju, Kabupaten Sejahtera