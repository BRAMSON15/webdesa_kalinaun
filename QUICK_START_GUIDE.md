# 🚀 Quick Start Guide - Sistem Website Desa

## Instalasi Cepat

### 1. Clone & Setup
```bash
# Masuk ke direktori project
cd webdesa2

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 2. Setup Database
```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder untuk data demo
php artisan db:seed --class=ClassDiagramSeeder

# Buat symbolic link untuk storage
php artisan storage:link
```

### 3. Jalankan Aplikasi
```bash
# Clear semua cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Jalankan development server
php artisan serve
```

### 4. Akses Aplikasi
Buka browser dan akses: **http://localhost:8000/class-diagram/login**

---

## 🔐 Akun Demo

### Masyarakat
```
Email: ahmad.wijaya@gmail.com
Password: password123
```

### Sekdes (Sekretaris Desa)
```
Username: sekdes_desa
Password: sekdes123
```

### Admin
```
Username: admin_desa
Password: admin123
```

---

## 📋 Fitur Utama Per Role

### 👥 Masyarakat
- ✅ Buat pengajuan surat online
- ✅ Cek status pengajuan real-time
- ✅ Lihat riwayat pengajuan
- ✅ Update profil

### 📝 Sekdes
- ✅ Validasi pengajuan (setujui/tolak)
- ✅ Lihat laporan arsip
- ✅ Export laporan dengan filter
- ✅ Monitoring semua pengajuan

### 🛡️ Admin
- ✅ Verifikasi berkas pengajuan
- ✅ Kelola arsip dokumen desa
- ✅ Upload dokumen (Perdes, SK Kades, dll)
- ✅ Download & hapus dokumen

---

## 🔄 Alur Pengajuan Surat

```
Masyarakat → Buat Pengajuan
    ↓
Admin → Verifikasi Berkas
    ↓
Sekdes → Validasi Akhir (Setujui/Tolak)
    ↓
Masyarakat → Lihat Status & Catatan
```

---

## 📁 Struktur URL

### Authentication
- Login: `/class-diagram/login`
- Register: `/class-diagram/register`
- Logout: `/class-diagram/logout` (POST)

### Masyarakat
- Dashboard: `/class-diagram/masyarakat/dashboard`
- Form Pengajuan: `/class-diagram/masyarakat/form-pengajuan`
- Riwayat: `/class-diagram/masyarakat/riwayat-pengajuan`
- Detail Status: `/class-diagram/masyarakat/cek-status/{id}`
- Profil: `/class-diagram/masyarakat/profil`

### Sekdes
- Dashboard: `/class-diagram/sekdes/dashboard`
- Daftar Pengajuan: `/class-diagram/sekdes/daftar-pengajuan`
- Detail: `/class-diagram/sekdes/detail-pengajuan/{id}`
- Laporan Arsip: `/class-diagram/sekdes/laporan-arsip`
- Export: `/class-diagram/sekdes/export-laporan`
- Profil: `/class-diagram/sekdes/profil`

### Admin
- Dashboard: `/class-diagram/admin/dashboard`
- Daftar Pengajuan: `/class-diagram/admin/daftar-pengajuan`
- Detail: `/class-diagram/admin/detail-pengajuan/{id}`
- Arsip Dokumen: `/class-diagram/admin/arsip-dokumen`
- Tambah Dokumen: `/class-diagram/admin/form-arsip-dokumen`
- Profil: `/class-diagram/admin/profil`

---

## 🛠️ Troubleshooting

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
```

### Error: "Permission denied"
```bash
# Windows (PowerShell as Admin)
icacls storage /grant Users:F /T
icacls bootstrap/cache /grant Users:F /T

# Linux/Mac
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Database Error
```bash
# Reset database
php artisan migrate:fresh --seed
```

---

## 📊 Status Pengajuan

| Status | Keterangan | Badge Color |
|--------|-----------|-------------|
| **proses** | Sedang diproses | 🟡 Warning |
| **selesai** | Disetujui & selesai | 🟢 Success |
| **ditolak** | Ditolak | 🔴 Danger |

---

## 🎨 Teknologi

- **Backend**: Laravel 11
- **Database**: SQLite
- **Frontend**: Bootstrap 5 + Font Awesome 6
- **Charts**: Chart.js

---

## 📝 Testing Flow

### 1. Test sebagai Masyarakat
1. Login dengan akun masyarakat
2. Buat pengajuan surat baru
3. Lihat di riwayat pengajuan
4. Cek detail status

### 2. Test sebagai Admin
1. Login dengan akun admin
2. Lihat pengajuan baru di dashboard
3. Buka detail pengajuan
4. Verifikasi berkas (terverifikasi)
5. Test upload dokumen arsip

### 3. Test sebagai Sekdes
1. Login dengan akun sekdes
2. Lihat pengajuan yang sudah diverifikasi
3. Buka detail pengajuan
4. Validasi akhir (setujui dengan catatan)
5. Lihat laporan arsip

### 4. Verifikasi sebagai Masyarakat
1. Login kembali sebagai masyarakat
2. Cek status pengajuan
3. Lihat catatan dari sekdes

---

## 🔒 Keamanan

✅ CSRF Protection  
✅ Password Hashing (bcrypt)  
✅ Multi-Guard Authentication  
✅ Input Validation  
✅ File Upload Validation  

---

## 📞 Support

Jika ada pertanyaan atau masalah:
1. Cek file `DOKUMENTASI_SISTEM_CLASS_DIAGRAM.md` untuk dokumentasi lengkap
2. Lihat log error di `storage/logs/laravel.log`
3. Jalankan `php artisan route:list` untuk melihat semua routes

---

**Happy Coding! 🎉**
