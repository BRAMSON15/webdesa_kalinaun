# ✅ Testing Checklist - Sistem Website Desa

## 🎯 Panduan Testing

Gunakan checklist ini untuk memastikan semua fitur berjalan dengan baik.

---

## 🔐 Authentication Testing

### Login
- [ ] Login sebagai Masyarakat berhasil
- [ ] Login sebagai Sekdes berhasil
- [ ] Login sebagai Admin berhasil
- [ ] Login dengan kredensial salah ditolak
- [ ] Redirect ke dashboard sesuai role

### Register (Masyarakat)
- [ ] Form register tampil dengan benar
- [ ] Validasi NIK (16 digit)
- [ ] Validasi email format
- [ ] Validasi password minimal 8 karakter
- [ ] Password confirmation harus sama
- [ ] Register berhasil dan redirect ke login

### Logout
- [ ] Logout dari Masyarakat berhasil
- [ ] Logout dari Sekdes berhasil
- [ ] Logout dari Admin berhasil
- [ ] Redirect ke halaman login setelah logout

---

## 👥 Testing Masyarakat

### Akun Test
```
Email: ahmad.wijaya@gmail.com
Password: password123
```

### Dashboard
- [ ] Dashboard tampil dengan benar
- [ ] Statistik pengajuan tampil (total, proses, selesai, ditolak)
- [ ] Daftar 5 pengajuan terbaru tampil
- [ ] Link navigasi berfungsi
- [ ] Sidebar dapat di-collapse

### Buat Pengajuan Surat
- [ ] Form pengajuan tampil
- [ ] Dropdown jenis surat tampil 6 pilihan
- [ ] Validasi jenis surat required
- [ ] Validasi keterangan required
- [ ] Submit berhasil
- [ ] Redirect ke riwayat pengajuan
- [ ] Success message tampil
- [ ] Data tersimpan di database dengan status "proses"

### Riwayat Pengajuan
- [ ] Tabel pengajuan tampil
- [ ] Pagination berfungsi (jika > 10 data)
- [ ] Status badge tampil dengan warna yang benar
  - [ ] Proses = Warning (kuning)
  - [ ] Selesai = Success (hijau)
  - [ ] Ditolak = Danger (merah)
- [ ] Tombol "Detail" berfungsi
- [ ] Tanggal format Indonesia

### Detail Status
- [ ] Informasi pengajuan lengkap tampil
- [ ] Timeline proses tampil dengan benar
- [ ] Status terkini tampil
- [ ] Catatan dari Sekdes tampil (jika ada)
- [ ] Alert sesuai status:
  - [ ] Proses = Warning
  - [ ] Selesai = Success
  - [ ] Ditolak = Danger
- [ ] Tombol kembali berfungsi

### Profil
- [ ] Data profil tampil
- [ ] NIK tidak dapat diubah (disabled)
- [ ] Alamat tidak dapat diubah (disabled)
- [ ] Form edit nama berfungsi
- [ ] Form edit email berfungsi
- [ ] Form edit no HP berfungsi
- [ ] Validasi email unique
- [ ] Update berhasil
- [ ] Success message tampil
- [ ] Data terupdate di database

---

## 📝 Testing Sekdes

### Akun Test
```
Username: sekdes_desa
Password: sekdes123
```

### Dashboard
- [ ] Dashboard tampil dengan benar
- [ ] Statistik keseluruhan tampil
- [ ] Daftar 5 pengajuan menunggu tampil
- [ ] Link navigasi berfungsi

### Daftar Pengajuan
- [ ] Tabel pengajuan status "proses" tampil
- [ ] Pagination berfungsi
- [ ] Data pemohon tampil
- [ ] Tombol "Detail" berfungsi
- [ ] Sorting berdasarkan tanggal (ascending)

### Detail Pengajuan
- [ ] Informasi pengajuan lengkap
- [ ] Data pemohon lengkap
- [ ] Form validasi akhir tampil
- [ ] Radio button setujui/tolak berfungsi
- [ ] Textarea catatan berfungsi
- [ ] Validasi status required
- [ ] Submit validasi berhasil
- [ ] Redirect ke daftar pengajuan
- [ ] Success message tampil
- [ ] Status berubah di database

### Laporan Arsip
- [ ] Tabel laporan tampil
- [ ] Filter bulan berfungsi
- [ ] Filter tahun berfungsi
- [ ] Filter status berfungsi
- [ ] Chart statistik tampil
- [ ] Tombol export berfungsi
- [ ] Data sesuai filter

### Export Laporan
- [ ] View export tampil
- [ ] Data sesuai filter
- [ ] Format siap print
- [ ] Print preview berfungsi
- [ ] Tombol kembali berfungsi

### Profil
- [ ] Data profil tampil
- [ ] Form edit username berfungsi
- [ ] Form edit password berfungsi
- [ ] Validasi username unique
- [ ] Validasi password minimal 8 karakter
- [ ] Password confirmation harus sama
- [ ] Update berhasil
- [ ] Success message tampil

---

## 🛡️ Testing Admin

### Akun Test
```
Username: admin_desa
Password: admin123
```

### Dashboard
- [ ] Dashboard tampil dengan benar
- [ ] 4 Statistics cards tampil:
  - [ ] Total Pengajuan
  - [ ] Sedang Diproses
  - [ ] Selesai
  - [ ] Total Arsip
- [ ] Daftar 5 pengajuan terbaru tampil
- [ ] Link "Lihat Semua Pengajuan" berfungsi

### Daftar Pengajuan
- [ ] Tabel semua pengajuan tampil
- [ ] Pagination berfungsi (15 per page)
- [ ] Filter modal berfungsi
- [ ] Filter status berfungsi
- [ ] Filter jenis surat berfungsi
- [ ] Reset filter berfungsi
- [ ] Tombol "Detail" berfungsi

### Detail Pengajuan
- [ ] Informasi pengajuan lengkap
- [ ] Data pemohon lengkap (NIK, nama, email, HP, alamat)
- [ ] Form verifikasi berkas tampil (jika status proses)
- [ ] Radio button terverifikasi/ditolak berfungsi
- [ ] Submit verifikasi berhasil
- [ ] Success message tampil
- [ ] Data terupdate di database
- [ ] Tombol kembali berfungsi

### Arsip Dokumen
- [ ] Tabel arsip dokumen tampil
- [ ] Badge kategori tampil dengan warna:
  - [ ] Perdes = Primary (biru)
  - [ ] SK Kades = Success (hijau)
  - [ ] Aset = Warning (kuning)
  - [ ] Lainnya = Secondary (abu)
- [ ] Tombol "Tambah Dokumen" berfungsi
- [ ] Tombol "Download" berfungsi
- [ ] Tombol "Hapus" berfungsi
- [ ] Confirmation dialog hapus tampil
- [ ] Hapus berhasil
- [ ] File terhapus dari storage

### Tambah Arsip Dokumen
- [ ] Form tambah dokumen tampil
- [ ] Input judul dokumen berfungsi
- [ ] Dropdown kategori tampil 4 pilihan
- [ ] File input berfungsi
- [ ] Validasi judul required
- [ ] Validasi kategori required
- [ ] Validasi file required
- [ ] Validasi file format (PDF, DOC, DOCX)
- [ ] Validasi file size max 10MB
- [ ] Upload berhasil
- [ ] File tersimpan di storage
- [ ] Redirect ke arsip dokumen
- [ ] Success message tampil

### Download Dokumen
- [ ] Klik download memulai download
- [ ] File terdownload dengan nama yang benar
- [ ] File dapat dibuka
- [ ] Error jika file tidak ditemukan

### Profil
- [ ] Data profil tampil
- [ ] Role badge "Administrator" tampil
- [ ] Form edit username berfungsi
- [ ] Form edit password berfungsi
- [ ] Validasi username unique
- [ ] Validasi password minimal 8 karakter
- [ ] Password confirmation harus sama
- [ ] Update berhasil
- [ ] Success message tampil

---

## 🔄 Integration Testing

### Alur Lengkap Pengajuan Surat

#### Step 1: Masyarakat Buat Pengajuan
- [ ] Login sebagai Masyarakat
- [ ] Buat pengajuan surat baru
- [ ] Jenis: "Surat Keterangan Domisili"
- [ ] Keterangan: "Untuk keperluan pembuatan KTP"
- [ ] Submit berhasil
- [ ] Status = "proses"
- [ ] Catat ID pengajuan: _______

#### Step 2: Admin Verifikasi Berkas
- [ ] Logout dari Masyarakat
- [ ] Login sebagai Admin
- [ ] Buka daftar pengajuan
- [ ] Cari pengajuan dengan ID di atas
- [ ] Buka detail pengajuan
- [ ] Pilih "Terverifikasi"
- [ ] Submit berhasil
- [ ] Success message tampil

#### Step 3: Sekdes Validasi Akhir
- [ ] Logout dari Admin
- [ ] Login sebagai Sekdes
- [ ] Buka daftar pengajuan
- [ ] Cari pengajuan dengan ID di atas
- [ ] Buka detail pengajuan
- [ ] Pilih "Setujui"
- [ ] Isi catatan: "Surat sudah selesai, silakan ambil di kantor desa"
- [ ] Submit berhasil
- [ ] Status berubah = "selesai"
- [ ] Success message tampil

#### Step 4: Masyarakat Cek Status
- [ ] Logout dari Sekdes
- [ ] Login sebagai Masyarakat
- [ ] Buka riwayat pengajuan
- [ ] Status pengajuan = "Selesai" (badge hijau)
- [ ] Buka detail status
- [ ] Catatan dari Sekdes tampil
- [ ] Alert success tampil
- [ ] Timeline menunjukkan "Selesai"

### Alur Pengajuan Ditolak

#### Step 1: Masyarakat Buat Pengajuan
- [ ] Login sebagai Masyarakat
- [ ] Buat pengajuan surat baru
- [ ] Jenis: "Surat Keterangan Usaha"
- [ ] Submit berhasil
- [ ] Catat ID pengajuan: _______

#### Step 2: Admin Verifikasi Berkas
- [ ] Login sebagai Admin
- [ ] Verifikasi berkas = "Terverifikasi"

#### Step 3: Sekdes Tolak Pengajuan
- [ ] Login sebagai Sekdes
- [ ] Buka detail pengajuan
- [ ] Pilih "Tolak"
- [ ] Isi catatan: "Berkas tidak lengkap, harap melengkapi KTP"
- [ ] Submit berhasil
- [ ] Status berubah = "ditolak"

#### Step 4: Masyarakat Cek Status
- [ ] Login sebagai Masyarakat
- [ ] Status = "Ditolak" (badge merah)
- [ ] Catatan penolakan tampil
- [ ] Alert danger tampil

---

## 📊 Data Validation Testing

### Form Validation
- [ ] Required fields tidak boleh kosong
- [ ] Email harus format valid
- [ ] NIK harus 16 digit
- [ ] Password minimal 8 karakter
- [ ] Password confirmation harus sama
- [ ] File upload hanya PDF, DOC, DOCX
- [ ] File size max 10MB
- [ ] Error message tampil dengan jelas

### Database Validation
- [ ] Email unique di tbl_masyarakat
- [ ] Username unique di tbl_sekdes
- [ ] Username unique di tbl_admin
- [ ] Foreign key constraints berfungsi
- [ ] Timestamps (created_at, updated_at) terupdate

---

## 🔒 Security Testing

### Authentication
- [ ] Tidak bisa akses dashboard tanpa login
- [ ] Tidak bisa akses route lain tanpa login
- [ ] Logout menghapus session
- [ ] Password di-hash di database (tidak plain text)

### Authorization
- [ ] Masyarakat tidak bisa akses route Sekdes
- [ ] Masyarakat tidak bisa akses route Admin
- [ ] Sekdes tidak bisa akses route Masyarakat
- [ ] Sekdes tidak bisa akses route Admin
- [ ] Admin tidak bisa akses route Masyarakat
- [ ] Admin tidak bisa akses route Sekdes

### CSRF Protection
- [ ] Form tanpa @csrf ditolak
- [ ] Token CSRF valid
- [ ] Token CSRF berubah setiap session

### File Upload Security
- [ ] File selain PDF/DOC/DOCX ditolak
- [ ] File > 10MB ditolak
- [ ] File tersimpan di storage/app/public
- [ ] File tidak bisa diakses langsung tanpa route

---

## 🎨 UI/UX Testing

### Responsive Design
- [ ] Desktop (1920x1080) tampil baik
- [ ] Laptop (1366x768) tampil baik
- [ ] Tablet (768x1024) tampil baik
- [ ] Mobile (375x667) tampil baik
- [ ] Sidebar collapse di mobile

### Navigation
- [ ] Sidebar menu berfungsi
- [ ] Active menu highlighted
- [ ] Breadcrumb tampil (jika ada)
- [ ] Back button berfungsi
- [ ] Logout button berfungsi

### Feedback
- [ ] Success message tampil hijau
- [ ] Error message tampil merah
- [ ] Warning message tampil kuning
- [ ] Info message tampil biru
- [ ] Loading state tampil (jika ada)

### Accessibility
- [ ] Form labels jelas
- [ ] Required fields ditandai (*)
- [ ] Error messages deskriptif
- [ ] Button text jelas
- [ ] Icon dengan tooltip (jika perlu)

---

## 🐛 Bug Testing

### Common Issues
- [ ] Tidak ada error 404
- [ ] Tidak ada error 500
- [ ] Tidak ada error di console browser
- [ ] Tidak ada error di laravel.log
- [ ] Tidak ada SQL error

### Edge Cases
- [ ] Pagination dengan 0 data
- [ ] Pagination dengan 1 data
- [ ] Filter tanpa hasil
- [ ] Upload file 0 byte
- [ ] Upload file > 10MB
- [ ] Input special characters
- [ ] Input SQL injection attempt
- [ ] Input XSS attempt

---

## 📈 Performance Testing

### Load Time
- [ ] Dashboard load < 2 detik
- [ ] List page load < 2 detik
- [ ] Detail page load < 1 detik
- [ ] Form submit < 1 detik
- [ ] File upload < 5 detik (untuk 10MB)

### Database Queries
- [ ] Tidak ada N+1 query problem
- [ ] Eager loading berfungsi
- [ ] Pagination efisien

---

## ✅ Final Checklist

### Pre-Production
- [ ] Semua test di atas passed
- [ ] Tidak ada error di log
- [ ] Database seeder berfungsi
- [ ] Storage link dibuat
- [ ] .env configured
- [ ] Cache cleared

### Production Ready
- [ ] Debug mode OFF di production
- [ ] Database backup ready
- [ ] Error logging configured
- [ ] File upload folder writable
- [ ] SSL certificate installed (jika production)

---

## 📝 Test Results

### Test Date: _______________
### Tester: _______________

### Summary
- Total Tests: _______
- Passed: _______
- Failed: _______
- Skipped: _______

### Failed Tests (jika ada)
1. _______________________________
2. _______________________________
3. _______________________________

### Notes
_______________________________
_______________________________
_______________________________

---

## 🎉 Conclusion

Jika semua checklist di atas ✅, maka sistem **SIAP PRODUCTION**!

---

**Last Updated**: 8 Mei 2026
