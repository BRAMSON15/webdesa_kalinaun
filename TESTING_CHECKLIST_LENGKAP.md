# 🧪 TESTING CHECKLIST LENGKAP - SISTEM DESA DIGITAL

**Status:** Ready for Testing  
**Tanggal:** 26 Mei 2026  
**Version:** 2.1

---

## 📋 TESTING OVERVIEW

Dokumen ini berisi checklist lengkap untuk testing semua fitur sistem Desa Digital. Testing dibagi menjadi beberapa kategori:

1. **Unit Testing** - Testing individual components
2. **Integration Testing** - Testing component interactions
3. **Functional Testing** - Testing user workflows
4. **Security Testing** - Testing security features
5. **Performance Testing** - Testing system performance
6. **UI/UX Testing** - Testing user interface

---

## 🔐 AUTHENTICATION & AUTHORIZATION TESTING

### Login Masyarakat
- [ ] Akses halaman login `/login`
- [ ] Form login tersedia dengan field: Email/NIK, Password
- [ ] Submit dengan email kosong → Error message
- [ ] Submit dengan password kosong → Error message
- [ ] Submit dengan email tidak terdaftar → Error message
- [ ] Submit dengan password salah → Error message
- [ ] Submit dengan data benar → Redirect ke dashboard
- [ ] Session tersimpan dengan benar
- [ ] Logout berfungsi dengan benar

### Register Masyarakat
- [ ] Akses halaman register `/register`
- [ ] Form register tersedia dengan field: NIK, Email, Password, Confirm Password
- [ ] Validasi NIK: Harus 16 digit
- [ ] Validasi Email: Format email valid
- [ ] Validasi Password: Min 8 karakter
- [ ] Validasi Confirm Password: Harus sama dengan password
- [ ] Submit dengan NIK sudah terdaftar → Error message
- [ ] Submit dengan email sudah terdaftar → Error message
- [ ] Submit dengan data valid → Redirect ke login
- [ ] Data tersimpan di database dengan role "masyarakat"

### Login Admin
- [ ] Akses halaman login `/login`
- [ ] Pilih role "Admin" dari toggle
- [ ] Form login tersedia dengan field: Username, Password
- [ ] Submit dengan username kosong → Error message
- [ ] Submit dengan password kosong → Error message
- [ ] Submit dengan username tidak terdaftar → Error message
- [ ] Submit dengan password salah → Error message
- [ ] Submit dengan data benar → Redirect ke admin dashboard
- [ ] Session tersimpan dengan benar

### Forgot Password
- [ ] Akses halaman forgot password `/forgot-password`
- [ ] Form tersedia dengan field: Email
- [ ] Submit dengan email tidak terdaftar → Error message
- [ ] Submit dengan email terdaftar → Email reset token dikirim
- [ ] Klik link di email → Akses halaman reset password
- [ ] Form reset password tersedia dengan field: Password, Confirm Password
- [ ] Submit dengan password baru → Password berhasil direset
- [ ] Login dengan password baru → Berhasil

### Role-Based Access Control
- [ ] Masyarakat tidak bisa akses `/admin/*`
- [ ] Admin tidak bisa akses `/masyarakat/*` (kecuali public routes)
- [ ] Sekdes tidak bisa akses `/admin/*`
- [ ] Middleware role berfungsi dengan benar
- [ ] Unauthorized access → 403 Forbidden

---

## 📝 PENGADUAN MASYARAKAT TESTING

### Masyarakat - Create Pengaduan

#### Form Validation
- [ ] Akses form create `/masyarakat/pengaduan/create`
- [ ] Form tersedia dengan field: Judul, Deskripsi, Kategori
- [ ] Kategori dropdown berisi: Layanan, Infrastruktur, Kesehatan, Pendidikan, Lainnya
- [ ] Submit dengan judul kosong → Error message
- [ ] Submit dengan deskripsi kosong → Error message
- [ ] Submit dengan deskripsi < 10 karakter → Error message
- [ ] Submit dengan kategori kosong → Error message
- [ ] Submit dengan data valid → Pengaduan tersimpan

#### Data Storage
- [ ] Data tersimpan di tabel `pengaduans`
- [ ] user_id otomatis set ke user yang login
- [ ] status otomatis set ke "baru"
- [ ] tanggal_pengaduan otomatis set ke now()
- [ ] catatan_admin kosong (nullable)
- [ ] admin_id kosong (nullable)

#### User Experience
- [ ] Redirect ke index dengan pesan sukses
- [ ] Pesan sukses: "Pengaduan berhasil dikirim. Terima kasih atas masukan Anda."
- [ ] Pengaduan muncul di list dengan status "Baru"

### Masyarakat - List Pengaduan

#### Display
- [ ] Akses halaman list `/masyarakat/pengaduan`
- [ ] Tampilkan hanya pengaduan milik user yang login
- [ ] Tampilkan kolom: Judul, Kategori, Status, Tanggal
- [ ] Status badge dengan warna berbeda (Baru=Blue, Diproses=Yellow, Selesai=Green, Ditolak=Red)
- [ ] Pagination berfungsi (10 per halaman)
- [ ] Tombol detail, edit, delete tersedia

#### Filter & Search
- [ ] Filter by status berfungsi
- [ ] Filter "Semua" menampilkan semua pengaduan
- [ ] Filter "Baru" menampilkan hanya status baru
- [ ] Filter "Diproses" menampilkan hanya status diproses
- [ ] Filter "Selesai" menampilkan hanya status selesai
- [ ] Filter "Ditolak" menampilkan hanya status ditolak

#### Sorting
- [ ] Pengaduan diurutkan dari terbaru ke terlama
- [ ] Tanggal pengaduan ditampilkan dengan format yang jelas

### Masyarakat - Show Pengaduan

#### Display
- [ ] Akses detail pengaduan `/masyarakat/pengaduan/{id}`
- [ ] Tampilkan semua data pengaduan
- [ ] Tampilkan: Judul, Deskripsi, Kategori, Status, Tanggal Pengaduan
- [ ] Tampilkan catatan admin (jika ada)
- [ ] Tampilkan tanggal selesai (jika ada)
- [ ] Tampilkan timeline status

#### Authorization
- [ ] User hanya bisa melihat pengaduan milik mereka
- [ ] Akses pengaduan user lain → 403 Forbidden

#### Actions
- [ ] Tombol "Edit" tersedia (jika status = Baru)
- [ ] Tombol "Hapus" tersedia (jika status = Baru)
- [ ] Tombol "Edit" tidak tersedia (jika status ≠ Baru)
- [ ] Tombol "Hapus" tidak tersedia (jika status ≠ Baru)
- [ ] Tombol "Kembali" tersedia

### Masyarakat - Edit Pengaduan

#### Form
- [ ] Akses form edit `/masyarakat/pengaduan/{id}/edit`
- [ ] Form pre-filled dengan data lama
- [ ] Field: Judul, Deskripsi, Kategori
- [ ] Edit hanya untuk status "Baru"
- [ ] Akses edit untuk status ≠ Baru → 403 Forbidden

#### Validation
- [ ] Submit dengan judul kosong → Error message
- [ ] Submit dengan deskripsi kosong → Error message
- [ ] Submit dengan deskripsi < 10 karakter → Error message
- [ ] Submit dengan kategori kosong → Error message
- [ ] Submit dengan data valid → Pengaduan diupdate

#### Data Update
- [ ] Data diupdate di database
- [ ] user_id tidak berubah
- [ ] status tidak berubah
- [ ] tanggal_pengaduan tidak berubah
- [ ] Redirect ke show dengan pesan sukses

### Masyarakat - Delete Pengaduan

#### Authorization
- [ ] Delete hanya untuk status "Baru"
- [ ] Akses delete untuk status ≠ Baru → 403 Forbidden

#### Confirmation
- [ ] Konfirmasi sebelum delete
- [ ] Pesan konfirmasi: "Apakah Anda yakin ingin menghapus pengaduan ini?"

#### Data Deletion
- [ ] Data terhapus dari database
- [ ] Redirect ke index dengan pesan sukses
- [ ] Pesan sukses: "Pengaduan berhasil dihapus"

### Admin - List Pengaduan

#### Display
- [ ] Akses halaman list `/admin/pengaduan`
- [ ] Tampilkan semua pengaduan dari semua user
- [ ] Tampilkan kolom: Nama Pengadu, Judul, Kategori, Status, Tanggal
- [ ] Status badge dengan warna berbeda
- [ ] Pagination berfungsi (15 per halaman)
- [ ] Tombol detail, edit, delete tersedia

#### Filter & Search
- [ ] Filter by status berfungsi
- [ ] Filter by kategori berfungsi
- [ ] Search by judul berfungsi
- [ ] Search by deskripsi berfungsi
- [ ] Kombinasi filter & search berfungsi

#### Sorting
- [ ] Pengaduan diurutkan dari terbaru ke terlama

### Admin - Show Pengaduan

#### Display
- [ ] Akses detail pengaduan `/admin/pengaduan/{id}`
- [ ] Tampilkan data pengadu: Nama, Email, NIK, Alamat, No HP
- [ ] Tampilkan data pengaduan: Judul, Deskripsi, Kategori, Status, Tanggal
- [ ] Tampilkan catatan admin (jika ada)
- [ ] Tampilkan nama admin yang menangani (jika ada)
- [ ] Tampilkan tanggal selesai (jika ada)

#### Actions
- [ ] Tombol "Edit" tersedia
- [ ] Tombol "Hapus" tersedia
- [ ] Tombol "Kembali" tersedia

### Admin - Edit Pengaduan

#### Form
- [ ] Akses form edit `/admin/pengaduan/{id}/edit`
- [ ] Form tersedia dengan field: Status, Catatan Admin
- [ ] Status dropdown berisi: Baru, Diproses, Selesai, Ditolak

#### Validation
- [ ] Submit dengan status kosong → Error message
- [ ] Submit dengan data valid → Pengaduan diupdate

#### Data Update
- [ ] Status diupdate di database
- [ ] Catatan admin diupdate di database
- [ ] admin_id otomatis set ke admin yang login
- [ ] Jika status = Selesai/Ditolak → tanggal_selesai = now()
- [ ] Redirect ke show dengan pesan sukses

### Admin - Delete Pengaduan

#### Data Deletion
- [ ] Data terhapus dari database
- [ ] Redirect ke index dengan pesan sukses

### Dashboard - Statistik Pengaduan

#### Statistics Display
- [ ] Tampilkan total pengaduan
- [ ] Tampilkan pengaduan status "Baru"
- [ ] Tampilkan pengaduan status "Diproses"
- [ ] Tampilkan pengaduan status "Selesai"
- [ ] Tampilkan pengaduan status "Ditolak"

#### Chart
- [ ] Chart pengaduan per kategori ditampilkan
- [ ] Chart responsive dan readable

---

## 💰 BANTUAN SOSIAL (BANSOS) TESTING

### Masyarakat - List Program Bansos

#### Display
- [ ] Akses halaman list `/masyarakat/bansos`
- [ ] Tampilkan hanya program dengan status "aktif"
- [ ] Tampilkan hanya program dengan kuota tersisa (kuota > kuota_terpakai)
- [ ] Tampilkan kolom: Nama, Deskripsi, Jenis, Kuota Tersisa, Tanggal Mulai-Selesai
- [ ] Progress bar kuota ditampilkan dengan benar
- [ ] Pagination berfungsi (10 per halaman)
- [ ] Tombol detail tersedia

#### Filter
- [ ] Filter by jenis bansos berfungsi
- [ ] Filter "Semua" menampilkan semua program aktif
- [ ] Filter "Tunai" menampilkan hanya program tunai
- [ ] Filter "Pangan" menampilkan hanya program pangan
- [ ] Filter "Pendidikan" menampilkan hanya program pendidikan

#### Sorting
- [ ] Program diurutkan dari tanggal mulai terbaru

### Masyarakat - Show Program Bansos

#### Display
- [ ] Akses detail program `/masyarakat/bansos/{id}`
- [ ] Tampilkan detail lengkap program
- [ ] Tampilkan: Nama, Deskripsi, Jenis, Kuota, Kuota Tersisa, Nominal, Tanggal Mulai-Selesai
- [ ] Tampilkan syarat & ketentuan
- [ ] Progress bar kuota ditampilkan dengan benar

#### Actions
- [ ] Tombol "Daftar" tersedia (jika belum mendaftar & kuota ada)
- [ ] Tombol "Daftar" tidak tersedia (jika sudah mendaftar)
- [ ] Tombol "Daftar" tidak tersedia (jika kuota habis)
- [ ] Tombol "Lihat Pendaftaran Saya" tersedia (jika sudah mendaftar)
- [ ] Tombol "Kembali" tersedia

### Masyarakat - Apply Program Bansos

#### Validation
- [ ] Validasi: Kuota tersedia
- [ ] Validasi: Belum mendaftar untuk program ini
- [ ] Jika kuota habis → Error message: "Kuota program bansos sudah habis"
- [ ] Jika sudah mendaftar → Error message: "Anda sudah mendaftar untuk program ini"

#### Data Storage
- [ ] Data tersimpan di tabel `penerima_bansos`
- [ ] bansos_id set ke program yang didaftar
- [ ] user_id set ke user yang login
- [ ] nik, nama_penerima, alamat, no_hp auto-fill dari user profile
- [ ] status set ke "menunggu"
- [ ] nominal_diterima kosong (nullable)
- [ ] tanggal_penerimaan kosong (nullable)

#### Unique Constraint
- [ ] Unique constraint (bansos_id, user_id) berfungsi
- [ ] Tidak bisa mendaftar 2x untuk program yang sama

#### User Experience
- [ ] Redirect ke detail program dengan pesan sukses
- [ ] Pesan sukses: "Pendaftaran berhasil. Silakan tunggu verifikasi dari admin."

### Masyarakat - List Pendaftaran Saya

#### Display
- [ ] Akses halaman list `/masyarakat/bansos-applications`
- [ ] Tampilkan hanya pendaftaran milik user yang login
- [ ] Tampilkan kolom: Program, Status, Tanggal Daftar
- [ ] Status badge dengan warna berbeda (Menunggu=Yellow, Disetujui=Green, Ditolak=Red)
- [ ] Pagination berfungsi (10 per halaman)
- [ ] Tombol detail tersedia

#### Filter
- [ ] Filter by status berfungsi
- [ ] Filter "Semua" menampilkan semua pendaftaran
- [ ] Filter "Menunggu" menampilkan hanya status menunggu
- [ ] Filter "Disetujui" menampilkan hanya status disetujui
- [ ] Filter "Ditolak" menampilkan hanya status ditolak

#### Sorting
- [ ] Pendaftaran diurutkan dari terbaru ke terlama

### Masyarakat - Show Detail Pendaftaran

#### Display
- [ ] Akses detail pendaftaran `/masyarakat/bansos-applications/{id}`
- [ ] Tampilkan detail program
- [ ] Tampilkan status pendaftaran
- [ ] Tampilkan data penerima: NIK, Nama, Alamat, No HP
- [ ] Tampilkan catatan admin (jika ada)
- [ ] Tampilkan nominal diterima (jika disetujui)
- [ ] Tampilkan tanggal penerimaan (jika disetujui)

#### Authorization
- [ ] User hanya bisa melihat pendaftaran milik mereka
- [ ] Akses pendaftaran user lain → 403 Forbidden

#### Actions
- [ ] Tombol "Batalkan" tersedia (jika status = Menunggu)
- [ ] Tombol "Batalkan" tidak tersedia (jika status ≠ Menunggu)
- [ ] Tombol "Kembali" tersedia

### Masyarakat - Cancel Application

#### Authorization
- [ ] Cancel hanya untuk status "Menunggu"
- [ ] Akses cancel untuk status ≠ Menunggu → 403 Forbidden

#### Confirmation
- [ ] Konfirmasi sebelum cancel
- [ ] Pesan konfirmasi: "Apakah Anda yakin ingin membatalkan pendaftaran ini?"

#### Data Deletion
- [ ] Data terhapus dari database
- [ ] Redirect ke list dengan pesan sukses
- [ ] Pesan sukses: "Pendaftaran berhasil dibatalkan"

### Admin - List Program Bansos

#### Display
- [ ] Akses halaman list `/admin/bansos`
- [ ] Tampilkan semua program
- [ ] Tampilkan kolom: Nama, Jenis, Kuota, Kuota Terpakai, Status, Tanggal Mulai-Selesai
- [ ] Status badge dengan warna berbeda
- [ ] Pagination berfungsi (15 per halaman)
- [ ] Tombol: Create, Edit, Show, Delete tersedia

#### Filter & Search
- [ ] Filter by status berfungsi
- [ ] Search by nama berfungsi
- [ ] Kombinasi filter & search berfungsi

#### Sorting
- [ ] Program diurutkan dari tanggal mulai terbaru

### Admin - Create Program Bansos

#### Form
- [ ] Akses form create `/admin/bansos/create`
- [ ] Form tersedia dengan field: Nama, Deskripsi, Syarat, Kuota, Tanggal Mulai, Tanggal Selesai, Status, Nominal, Jenis, Catatan

#### Validation
- [ ] Submit dengan nama kosong → Error message
- [ ] Submit dengan deskripsi kosong → Error message
- [ ] Submit dengan kuota kosong → Error message
- [ ] Submit dengan kuota < 1 → Error message
- [ ] Submit dengan tanggal mulai kosong → Error message
- [ ] Submit dengan tanggal selesai kosong → Error message
- [ ] Submit dengan tanggal selesai ≤ tanggal mulai → Error message
- [ ] Submit dengan status kosong → Error message
- [ ] Submit dengan jenis kosong → Error message
- [ ] Submit dengan data valid → Program tersimpan

#### Data Storage
- [ ] Data tersimpan di tabel `bansos`
- [ ] kuota_terpakai otomatis set ke 0
- [ ] Redirect ke show dengan pesan sukses

### Admin - Edit Program Bansos

#### Form
- [ ] Akses form edit `/admin/bansos/{id}/edit`
- [ ] Form pre-filled dengan data lama
- [ ] Field: Nama, Deskripsi, Syarat, Kuota, Tanggal Mulai, Tanggal Selesai, Status, Nominal, Jenis, Catatan

#### Validation
- [ ] Validasi sama seperti create
- [ ] Submit dengan data valid → Program diupdate

#### Data Update
- [ ] Data diupdate di database
- [ ] kuota_terpakai tidak berubah
- [ ] Redirect ke show dengan pesan sukses

### Admin - Show Program Bansos

#### Display
- [ ] Akses detail program `/admin/bansos/{id}`
- [ ] Tampilkan detail lengkap program
- [ ] Tampilkan statistik penerima:
  - [ ] Total Penerima
  - [ ] Disetujui
  - [ ] Ditolak
  - [ ] Menunggu

#### Actions
- [ ] Tombol "Edit" tersedia
- [ ] Tombol "Delete" tersedia
- [ ] Tombol "Kelola Penerima" tersedia
- [ ] Tombol "Kembali" tersedia

### Admin - Manage Penerima

#### Display
- [ ] Akses halaman kelola penerima `/admin/bansos/{id}/penerima`
- [ ] Tampilkan tabel penerima
- [ ] Tampilkan kolom: Nama, NIK, Alamat, No HP, Status, Tanggal Daftar
- [ ] Status badge dengan warna berbeda
- [ ] Pagination berfungsi (15 per halaman)
- [ ] Tombol: Setujui, Tolak tersedia

#### Filter
- [ ] Filter by status berfungsi
- [ ] Filter "Semua" menampilkan semua penerima
- [ ] Filter "Menunggu" menampilkan hanya status menunggu
- [ ] Filter "Disetujui" menampilkan hanya status disetujui
- [ ] Filter "Ditolak" menampilkan hanya status ditolak

### Admin - Approve Penerima

#### Validation
- [ ] Validasi: Kuota tersedia
- [ ] Jika kuota habis → Error message: "Kuota program bansos sudah habis"

#### Data Update
- [ ] Status diupdate ke "disetujui"
- [ ] tanggal_penerimaan set ke now()
- [ ] nominal_diterima set ke nominal program
- [ ] kuota_terpakai increment +1
- [ ] Redirect dengan pesan sukses

#### Database Check
- [ ] Data diupdate di database
- [ ] kuota_terpakai bertambah 1

### Admin - Reject Penerima

#### Form
- [ ] Form tersedia dengan field: Alasan Penolakan
- [ ] Validasi: Alasan Penolakan required

#### Data Update
- [ ] Status diupdate ke "ditolak"
- [ ] alasan_penolakan diupdate
- [ ] kuota_terpakai tidak berubah
- [ ] Redirect dengan pesan sukses

### Admin - Delete Program

#### Data Deletion
- [ ] Data terhapus dari database
- [ ] Redirect ke index dengan pesan sukses

### Dashboard - Statistik Bansos

#### Statistics Display
- [ ] Tampilkan total program
- [ ] Tampilkan program aktif
- [ ] Tampilkan total penerima
- [ ] Tampilkan penerima disetujui

---

## 🔒 SECURITY TESTING

### Authentication Security
- [ ] Password tidak ditampilkan di form
- [ ] Password di-hash di database
- [ ] Session timeout berfungsi
- [ ] CSRF token ada di semua form
- [ ] SQL Injection tidak mungkin (menggunakan ORM)

### Authorization Security
- [ ] User tidak bisa akses data user lain
- [ ] Admin tidak bisa akses data admin lain
- [ ] Middleware role berfungsi dengan benar
- [ ] Unauthorized access → 403 Forbidden

### Data Validation
- [ ] Input validation di client-side
- [ ] Input validation di server-side
- [ ] XSS prevention (HTML escaping)
- [ ] File upload validation (jika ada)

---

## ⚡ PERFORMANCE TESTING

### Page Load Time
- [ ] Dashboard load time < 2 detik
- [ ] List page load time < 2 detik
- [ ] Detail page load time < 1 detik
- [ ] Create/Edit page load time < 1 detik

### Database Query
- [ ] Tidak ada N+1 query problem
- [ ] Eager loading digunakan untuk relationships
- [ ] Pagination berfungsi dengan benar
- [ ] Index ada di kolom yang sering di-query

### Memory Usage
- [ ] Memory usage < 50MB
- [ ] Tidak ada memory leak

---

## 🎨 UI/UX TESTING

### Responsive Design
- [ ] Layout responsive di desktop (1920px)
- [ ] Layout responsive di tablet (768px)
- [ ] Layout responsive di mobile (375px)
- [ ] Tidak ada horizontal scroll

### Navigation
- [ ] Menu navigasi mudah diakses
- [ ] Breadcrumb tersedia (jika perlu)
- [ ] Back button berfungsi dengan benar
- [ ] Link tidak broken

### Form UX
- [ ] Form label jelas
- [ ] Form placeholder helpful
- [ ] Error message jelas dan helpful
- [ ] Success message jelas
- [ ] Form validation feedback real-time (jika ada)

### Accessibility
- [ ] Color contrast sufficient
- [ ] Font size readable
- [ ] Button size sufficient (min 44px)
- [ ] Form input accessible
- [ ] Keyboard navigation berfungsi

---

## 📊 INTEGRATION TESTING

### Database Integration
- [ ] Create operation berfungsi
- [ ] Read operation berfungsi
- [ ] Update operation berfungsi
- [ ] Delete operation berfungsi
- [ ] Relationships berfungsi dengan benar

### API Integration (jika ada)
- [ ] API endpoint berfungsi
- [ ] API response format correct
- [ ] API error handling berfungsi

### Email Integration (jika ada)
- [ ] Email dikirim dengan benar
- [ ] Email content correct
- [ ] Email attachment berfungsi (jika ada)

---

## 🐛 BUG TRACKING

### Known Issues
- [ ] (Isi dengan bug yang ditemukan)

### Fixed Issues
- [ ] (Isi dengan bug yang sudah diperbaiki)

---

## ✅ TESTING SUMMARY

### Test Results
- Total Test Cases: ___
- Passed: ___
- Failed: ___
- Skipped: ___
- Pass Rate: ___%

### Critical Issues
- [ ] (Isi dengan critical issues)

### High Priority Issues
- [ ] (Isi dengan high priority issues)

### Medium Priority Issues
- [ ] (Isi dengan medium priority issues)

### Low Priority Issues
- [ ] (Isi dengan low priority issues)

---

## 📝 TESTING NOTES

(Isi dengan catatan testing)

---

**Testing Checklist Lengkap Selesai ✅**

