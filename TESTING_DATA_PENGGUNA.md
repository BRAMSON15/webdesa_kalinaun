# 🧪 TESTING CHECKLIST - FITUR DATA PENGGUNA

## 📋 Test Plan

### Test Environment
- **Browser:** Chrome, Firefox, Safari, Edge
- **Devices:** Desktop, Tablet, Mobile
- **Database:** SQLite (development)
- **Server:** Laravel Development Server

---

## ✅ UNIT TESTS

### Controller Tests

#### Test 1: dataPengguna() - Menampilkan Daftar Pengguna
```
Test Case: Verify dataPengguna returns all users
Expected: View 'admin.data-pengguna' dengan data users
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 2: updatePengguna() - Update Data Valid
```
Test Case: Update pengguna dengan data valid
Input: name, email, no_hp, nik, alamat, tanggal_lahir, jenis_kelamin, role
Expected: Response JSON success=true, user data updated
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 3: updatePengguna() - Email Duplicate
```
Test Case: Update pengguna dengan email yang sudah digunakan
Input: email yang sudah ada di user lain
Expected: Validation error, email unique
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 4: updatePengguna() - Tidak Bisa Update Admin
```
Test Case: Coba update data admin
Input: Admin user ID
Expected: Response JSON success=false, message "Tidak dapat mengubah data admin"
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 5: updatePengguna() - Validasi Field Required
```
Test Case: Update tanpa field required (name, email)
Input: name atau email kosong
Expected: Validation error
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 6: deletePengguna() - Delete User Non-Admin
```
Test Case: Hapus pengguna non-admin tanpa pengajuan aktif
Input: User ID (non-admin)
Expected: Response JSON success=true, user deleted
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 7: deletePengguna() - Tidak Bisa Delete Admin
```
Test Case: Coba hapus admin
Input: Admin user ID
Expected: Response JSON success=false, message "Tidak dapat menghapus data admin"
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 8: deletePengguna() - Tidak Bisa Delete dengan Pengajuan Aktif
```
Test Case: Coba hapus pengguna yang punya pengajuan status 'proses'
Input: User ID dengan pengajuan aktif
Expected: Response JSON success=false, message "Tidak dapat menghapus pengguna yang memiliki pengajuan aktif"
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 9: resetPasswordPengguna() - Generate Password Sementara
```
Test Case: Reset password pengguna
Input: User ID (non-admin)
Expected: Response JSON success=true, temp_password generated (format: Desa + YYYYMMDD + 4 digit)
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 10: resetPasswordPengguna() - Tidak Bisa Reset Admin
```
Test Case: Coba reset password admin
Input: Admin user ID
Expected: Response JSON success=false, message "Tidak dapat reset password admin"
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 11: resetPasswordPengguna() - Password Bisa Login
```
Test Case: Login dengan password sementara yang di-generate
Input: Email dan temp_password
Expected: Login berhasil
Status: [ ] Pass [ ] Fail
Notes: _______________
```

---

## ✅ INTEGRATION TESTS

### Flow Tests

#### Test 12: Flow - Lihat Daftar → Lihat Detail → Edit → Simpan
```
Test Case: Complete flow edit pengguna
Steps:
1. Login sebagai admin
2. Buka menu Data Pengguna
3. Klik tombol Lihat Detail pada pengguna
4. Verifikasi modal detail terbuka
5. Tutup modal
6. Klik tombol Edit pada pengguna
7. Ubah beberapa field (name, email, no_hp)
8. Klik Simpan Perubahan
9. Verifikasi alert success
10. Verifikasi halaman reload
11. Verifikasi data berubah di tabel

Expected: Semua step berhasil, data terupdate
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 13: Flow - Reset Password
```
Test Case: Complete flow reset password
Steps:
1. Login sebagai admin
2. Buka menu Data Pengguna
3. Klik tombol Reset Password pada pengguna
4. Konfirmasi reset
5. Copy password sementara dari alert
6. Logout
7. Login dengan email pengguna dan temp_password
8. Verifikasi login berhasil

Expected: Semua step berhasil, bisa login dengan temp_password
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 14: Flow - Hapus Pengguna
```
Test Case: Complete flow hapus pengguna
Steps:
1. Login sebagai admin
2. Buka menu Data Pengguna
3. Klik tombol Hapus pada pengguna (tanpa pengajuan aktif)
4. Konfirmasi hapus
5. Verifikasi alert success
6. Verifikasi halaman reload
7. Verifikasi pengguna tidak ada di tabel

Expected: Semua step berhasil, pengguna terhapus
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 15: Flow - Search Pengguna
```
Test Case: Search functionality
Steps:
1. Login sebagai admin
2. Buka menu Data Pengguna
3. Ketik nama pengguna di search box
4. Verifikasi tabel filter otomatis
5. Ketik email pengguna
6. Verifikasi tabel filter otomatis
7. Ketik NIK pengguna
8. Verifikasi tabel filter otomatis
9. Clear search box
10. Verifikasi semua pengguna kembali

Expected: Search berfungsi real-time
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 16: Flow - Modal Open/Close
```
Test Case: Modal functionality
Steps:
1. Login sebagai admin
2. Buka menu Data Pengguna
3. Klik tombol Lihat Detail
4. Verifikasi modal detail terbuka
5. Klik tombol close (X)
6. Verifikasi modal tertutup
7. Klik tombol Edit
8. Verifikasi modal edit terbuka
9. Klik tombol Batal
10. Verifikasi modal tertutup

Expected: Modal berfungsi dengan baik
Status: [ ] Pass [ ] Fail
Notes: _______________
```

---

## ✅ UI/UX TESTS

### Responsive Design

#### Test 17: Desktop View
```
Test Case: Tampilan desktop (1920x1080)
Verify:
- [ ] Tabel terlihat dengan baik
- [ ] Semua kolom terlihat
- [ ] Tombol aksi terlihat
- [ ] Search box terlihat
- [ ] Modal terlihat dengan baik
- [ ] Form input terlihat dengan baik

Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 18: Tablet View
```
Test Case: Tampilan tablet (768x1024)
Verify:
- [ ] Tabel responsive
- [ ] Tombol aksi terlihat
- [ ] Search box terlihat
- [ ] Modal terlihat dengan baik
- [ ] Form input terlihat dengan baik

Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 19: Mobile View
```
Test Case: Tampilan mobile (375x667)
Verify:
- [ ] Tabel responsive (horizontal scroll jika perlu)
- [ ] Tombol aksi terlihat
- [ ] Search box terlihat
- [ ] Modal terlihat dengan baik
- [ ] Form input terlihat dengan baik
- [ ] Tidak ada overflow

Status: [ ] Pass [ ] Fail
Notes: _______________
```

### Form Validation

#### Test 20: Form Edit - Validasi Name Required
```
Test Case: Submit form tanpa name
Input: name kosong
Expected: Error message "Nama Lengkap wajib diisi"
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 21: Form Edit - Validasi Email Required
```
Test Case: Submit form tanpa email
Input: email kosong
Expected: Error message "Email wajib diisi"
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 22: Form Edit - Validasi Email Format
```
Test Case: Submit form dengan email invalid
Input: email = "invalid-email"
Expected: Error message "Email harus format email yang valid"
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 23: Form Edit - Validasi Tanggal Lahir
```
Test Case: Submit form dengan tanggal invalid
Input: tanggal_lahir = "invalid-date"
Expected: Error message atau date picker tidak accept
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 24: Form Edit - Validasi Jenis Kelamin
```
Test Case: Submit form dengan jenis_kelamin invalid
Input: jenis_kelamin = "X"
Expected: Error message atau dropdown tidak accept
Status: [ ] Pass [ ] Fail
Notes: _______________
```

### Button States

#### Test 25: Loading State - Edit Button
```
Test Case: Klik Simpan Perubahan
Verify:
- [ ] Button text berubah menjadi "Menyimpan..."
- [ ] Button disabled
- [ ] Loading spinner terlihat
- [ ] Setelah selesai, button kembali normal

Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 26: Loading State - Reset Password Button
```
Test Case: Klik Reset Password
Verify:
- [ ] Button text berubah menjadi loading spinner
- [ ] Button disabled
- [ ] Setelah selesai, button kembali normal

Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 27: Loading State - Delete Button
```
Test Case: Klik Hapus
Verify:
- [ ] Button text berubah menjadi loading spinner
- [ ] Button disabled
- [ ] Setelah selesai, button kembali normal

Status: [ ] Pass [ ] Fail
Notes: _______________
```

### Alert Messages

#### Test 28: Success Alert - Edit
```
Test Case: Edit pengguna berhasil
Expected: Alert success dengan message "Data pengguna berhasil diperbarui"
Verify:
- [ ] Alert terlihat
- [ ] Icon check-circle terlihat
- [ ] Message jelas
- [ ] Close button berfungsi

Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 29: Success Alert - Reset Password
```
Test Case: Reset password berhasil
Expected: Alert success dengan message "Password berhasil direset"
Verify:
- [ ] Alert terlihat
- [ ] Password sementara ditampilkan
- [ ] Message jelas

Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 30: Success Alert - Delete
```
Test Case: Delete pengguna berhasil
Expected: Alert success dengan message "Data pengguna berhasil dihapus"
Verify:
- [ ] Alert terlihat
- [ ] Message jelas
- [ ] Halaman reload

Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 31: Error Alert - Email Duplicate
```
Test Case: Edit dengan email yang sudah ada
Expected: Alert error dengan message "Email sudah digunakan"
Verify:
- [ ] Alert terlihat
- [ ] Icon warning terlihat
- [ ] Message jelas

Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 32: Error Alert - Delete dengan Pengajuan Aktif
```
Test Case: Hapus pengguna dengan pengajuan aktif
Expected: Alert error dengan message "Tidak dapat menghapus pengguna yang memiliki pengajuan aktif"
Verify:
- [ ] Alert terlihat
- [ ] Message jelas

Status: [ ] Pass [ ] Fail
Notes: _______________
```

---

## ✅ SECURITY TESTS

### Authorization

#### Test 33: Non-Admin Tidak Bisa Akses
```
Test Case: Login sebagai masyarakat, akses /admin/data-pengguna
Expected: Redirect ke login atau error 403
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 34: Non-Login Tidak Bisa Akses
```
Test Case: Akses /admin/data-pengguna tanpa login
Expected: Redirect ke login page
Status: [ ] Pass [ ] Fail
Notes: _______________
```

### CSRF Protection

#### Test 35: CSRF Token Validation - Update
```
Test Case: Update pengguna tanpa CSRF token
Expected: Error 419 atau CSRF token mismatch
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 36: CSRF Token Validation - Delete
```
Test Case: Delete pengguna tanpa CSRF token
Expected: Error 419 atau CSRF token mismatch
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 37: CSRF Token Validation - Reset Password
```
Test Case: Reset password tanpa CSRF token
Expected: Error 419 atau CSRF token mismatch
Status: [ ] Pass [ ] Fail
Notes: _______________
```

### Data Protection

#### Test 38: Tidak Bisa Modify Admin User
```
Test Case: Coba update admin user via API
Input: Admin user ID dengan data baru
Expected: Response error 403, data tidak berubah
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 39: Tidak Bisa Delete Admin User
```
Test Case: Coba delete admin user via API
Input: Admin user ID
Expected: Response error 403, user tidak terhapus
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 40: Tidak Bisa Reset Admin Password
```
Test Case: Coba reset admin password via API
Input: Admin user ID
Expected: Response error 403, password tidak berubah
Status: [ ] Pass [ ] Fail
Notes: _______________
```

---

## ✅ DATA VALIDATION TESTS

### Input Validation

#### Test 41: Name - Max Length
```
Test Case: Input name lebih dari 255 karakter
Expected: Validation error atau truncate
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 42: Email - Valid Format
```
Test Case: Input email dengan format invalid
Examples: "test@", "@test.com", "test@.com"
Expected: Validation error
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 43: No HP - Max Length
```
Test Case: Input no_hp lebih dari 20 karakter
Expected: Validation error atau truncate
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 44: NIK - Max Length
```
Test Case: Input nik lebih dari 20 karakter
Expected: Validation error atau truncate
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 45: Jenis Kelamin - Valid Values
```
Test Case: Input jenis_kelamin dengan value invalid
Input: jenis_kelamin = "X"
Expected: Validation error
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 46: Role - Valid Values
```
Test Case: Input role dengan value invalid
Input: role = "superadmin"
Expected: Validation error
Status: [ ] Pass [ ] Fail
Notes: _______________
```

---

## ✅ PERFORMANCE TESTS

#### Test 47: Load Time - Data Pengguna Page
```
Test Case: Buka halaman data pengguna dengan 100+ pengguna
Expected: Page load < 3 detik
Actual: ___ detik
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 48: Search Performance
```
Test Case: Search dengan 100+ pengguna
Expected: Filter real-time < 500ms
Actual: ___ ms
Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 49: Modal Open Performance
```
Test Case: Buka modal detail dengan data lengkap
Expected: Modal open < 1 detik
Actual: ___ detik
Status: [ ] Pass [ ] Fail
Notes: _______________
```

---

## ✅ BROWSER COMPATIBILITY TESTS

#### Test 50: Chrome
```
Browser: Chrome (latest)
Verify:
- [ ] Halaman load dengan baik
- [ ] Semua fitur berfungsi
- [ ] Styling terlihat benar
- [ ] Modal berfungsi
- [ ] Form validation berfungsi

Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 51: Firefox
```
Browser: Firefox (latest)
Verify:
- [ ] Halaman load dengan baik
- [ ] Semua fitur berfungsi
- [ ] Styling terlihat benar
- [ ] Modal berfungsi
- [ ] Form validation berfungsi

Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 52: Safari
```
Browser: Safari (latest)
Verify:
- [ ] Halaman load dengan baik
- [ ] Semua fitur berfungsi
- [ ] Styling terlihat benar
- [ ] Modal berfungsi
- [ ] Form validation berfungsi

Status: [ ] Pass [ ] Fail
Notes: _______________
```

#### Test 53: Edge
```
Browser: Edge (latest)
Verify:
- [ ] Halaman load dengan baik
- [ ] Semua fitur berfungsi
- [ ] Styling terlihat benar
- [ ] Modal berfungsi
- [ ] Form validation berfungsi

Status: [ ] Pass [ ] Fail
Notes: _______________
```

---

## 📊 TEST SUMMARY

### Total Tests: 53

**Passed:** ___ / 53  
**Failed:** ___ / 53  
**Skipped:** ___ / 53  

**Pass Rate:** ___%

### Critical Issues Found:
1. _______________
2. _______________
3. _______________

### Minor Issues Found:
1. _______________
2. _______________
3. _______________

### Recommendations:
1. _______________
2. _______________
3. _______________

---

**Test Date:** _______________  
**Tested By:** _______________  
**Status:** [ ] Ready for Production [ ] Need Fixes [ ] Blocked

---

**Last Updated:** 1 Juni 2026  
**Version:** 1.0
