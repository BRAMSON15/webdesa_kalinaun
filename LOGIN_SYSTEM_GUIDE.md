# 📋 PANDUAN SISTEM LOGIN SIPAKAL

> **Sistem Login Baru - Pemisahan Portal Masyarakat & Admin/Kades**

---

## 🎯 RINGKAS CEPAT

Sistem login SIPAKAL sekarang memiliki **DUA PORTAL TERPISAH** dengan kredensial berbeda:

| Aspek | **Masyarakat** | **Admin/Kades** |
|------|---|---|
| **URL Login** | `/masyarakat-login` | `/admin-login` |
| **Username** | Nama Lengkap | Email |
| **Password** | NIK (16 digit) | Password |
| **Akses** | Hanya Masyarakat | Hanya Admin & Kades |
| **Format Akun** | NAMA + NIK | EMAIL + PASSWORD |

---

## 🔑 AKUN TEST (UNTUK TESTING)

### 1️⃣ Portal Masyarakat (`/masyarakat-login`)
```
Nama Lengkap: Budi Santoso
NIK:          1234567890123458
```
- Ini adalah akun dengan role `masyarakat`
- Setelah login, akan diarahkan ke `/masyarakat/dashboard`

### 2️⃣ Portal Admin (`/admin-login`)
```
Email:    admin@desa.com
Password: password
```
- Ini adalah akun dengan role `admin`
- Setelah login, akan diarahkan ke `/admin/dashboard`

### 3️⃣ Portal Admin - Kades (`/admin-login`)
```
Email:    kades@desa.com
Password: password
```
- Ini adalah akun dengan role `kades`
- Setelah login, akan diarahkan ke `/kades/dashboard`

---

## 🚀 CARA MENGGUNAKAN SISTEM LOGIN

### ✅ Login sebagai Masyarakat

**Step 1:** Buka halaman `/masyarakat-login`
- Atau klik tombol "Login" di halaman utama

**Step 2:** Isi form login
- **Nama Lengkap:** Masukkan nama lengkap (cth: "Budi Santoso")
- **NIK:** Masukkan 16 digit NIK (cth: "1234567890123458")

**Step 3:** Klik tombol "Masuk Sekarang"

**Step 4:** Jika berhasil, akan diarahkan ke dashboard masyarakat

**Catatan:**
- ❌ Tidak bisa login sebagai masyarakat menggunakan email
- ❌ Tidak bisa login sebagai admin dari portal masyarakat
- ✅ Hanya NIK yang valid yang bisa digunakan sebagai password

---

### ✅ Login sebagai Admin/Kades

**Step 1:** Buka halaman `/admin-login`
- Atau klik tombol "Login Admin/Kades" di halaman utama

**Step 2:** Isi form login
- **Email:** Masukkan email (cth: "admin@desa.com" atau "kades@desa.com")
- **Password:** Masukkan password yang benar

**Step 3:** Klik tombol "Masuk Sekarang"

**Step 4:** Jika berhasil, akan diarahkan ke dashboard admin atau kades

**Catatan:**
- ❌ Tidak bisa login sebagai admin menggunakan nama lengkap
- ❌ Tidak bisa login menggunakan NIK sebagai password
- ✅ Hanya email dan password yang valid yang bisa digunakan
- 🔒 Password berbeda dengan NIK masyarakat

---

## 🛡️ FITUR KEAMANAN

Sistem login memiliki beberapa fitur keamanan:

### 1. Rate Limiting (Pembatasan Percobaan)
- **Maksimal 5 percobaan login per 1 menit**
- Jika melebihi batas, akan di-block sementara
- Reset otomatis setelah waktu tunggu habis

### 2. Brute Force Protection (Proteksi Penyerangan Brutal)
- **Maksimal 5 percobaan gagal dalam 15 menit**
- Akun akan terkunci untuk 15 menit
- Pesan error: "Terlalu banyak percobaan login gagal. Silakan coba lagi dalam 15 menit."

### 3. Account Status Check (Cek Status Akun)
- Setiap login diverifikasi apakah akun **aktif (is_active = true)**
- Jika akun tidak aktif, login ditolak dengan pesan: "Akun Anda tidak aktif. Hubungi admin untuk informasi lebih lanjut."
- Admin bisa menonaktifkan akun pengguna

### 4. Login Audit Tracking (Pencatatan Login)
- Setiap percobaan login dicatat di tabel `login_attempts`
- Admin bisa melihat riwayat login di menu `/admin/login-history`
- Informasi yang dicatat:
  - Username/Email yang digunakan
  - Status (success/failed)
  - Alasan kegagalan (jika ada)
  - IP address
  - Timestamp

---

## 📊 TABEL YANG DIGUNAKAN

### Tabel `users`
Menyimpan data pengguna (Masyarakat, Admin, Kades):
```
- id
- name (Nama lengkap)
- email
- password (Hashed)
- role (masyarakat, admin, kades)
- nik (16 digit, khusus masyarakat)
- alamat
- no_hp
- tanggal_lahir
- jenis_kelamin
- is_active (untuk disable/enable akun)
- last_login_at (tracking login terakhir)
- last_login_ip (IP address terakhir)
- created_at
- updated_at
```

### Tabel `login_attempts`
Menyimpan riwayat percobaan login:
```
- id
- username (atau email)
- login_type (masyarakat, admin)
- status (success, failed)
- reason (Alasan kegagalan)
- ip_address
- user_agent
- created_at
```

---

## 🔐 ALUR AUTENTIKASI

### Alur Login Masyarakat

```
1. User membuka /masyarakat-login
2. User input Nama Lengkap & NIK
3. Sistem cek apakah blocked (brute force protection)
   ├─ Jika blocked → Error "Terlalu banyak percobaan"
   └─ Jika tidak → Lanjut ke step 4
4. Sistem query user dengan:
   - name = input nama
   - nik = input nik
   - role = 'masyarakat'
5. Hasil pencarian:
   ├─ Tidak ketemu → Error "Nama/NIK tidak sesuai" + catat attempt gagal
   └─ Ketemu → Cek status akun
6. Cek status akun (is_active):
   ├─ is_active = false → Error "Akun tidak aktif" + catat attempt gagal
   └─ is_active = true → Login berhasil
7. Login berhasil:
   - Catat dalam tabel login_attempts (success)
   - Update last_login_at & last_login_ip
   - Buat session
   - Redirect ke /masyarakat/dashboard
```

### Alur Login Admin/Kades

```
1. User membuka /admin-login
2. User input Email & Password
3. Sistem cek apakah blocked (brute force protection)
   ├─ Jika blocked → Error "Terlalu banyak percobaan"
   └─ Jika tidak → Lanjut ke step 4
4. Sistem query user dengan email = input email
5. Hasil:
   ├─ Tidak ketemu → Error "Email/Password salah" + catat attempt
   └─ Ketemu → Cek password
6. Cek password:
   ├─ Password tidak match → Error "Email/Password salah" + catat attempt
   └─ Password match → Cek role
7. Cek role (harus admin atau kades):
   ├─ Role bukan admin/kades → Error "Akses ditolak" + catat attempt
   └─ Role adalah admin/kades → Cek status akun
8. Cek status akun (is_active):
   ├─ is_active = false → Error "Akun tidak aktif" + catat attempt
   └─ is_active = true → Login berhasil
9. Login berhasil:
   - Catat dalam tabel login_attempts (success)
   - Update last_login_at & last_login_ip
   - Buat session
   - Redirect ke /admin/dashboard atau /kades/dashboard
```

---

## 🎛️ STRUKTUR ROUTES

### Public Routes
```
GET  /                          → Halaman utama (welcome)
GET  /masyarakat-login          → Form login masyarakat
POST /masyarakat-login          → Proses login masyarakat
GET  /admin-login               → Form login admin/kades
POST /admin-login               → Proses login admin/kades
GET  /register                  → Form registrasi (masyarakat)
POST /register                  → Proses registrasi (masyarakat)
GET  /forgot-password           → Form lupa password
POST /forgot-password           → Kirim token reset
GET  /reset-password/{token}    → Form reset password
POST /reset-password            → Update password
```

### Masyarakat Routes (Protected)
```
Prefix: /masyarakat
Middleware: auth, role:masyarakat, check.account
GET /dashboard
GET /pengajuan-surat
POST /pengajuan-surat
... (lihat routes/web.php untuk detail lengkap)
```

### Admin Routes (Protected)
```
Prefix: /admin
Middleware: auth, role:admin, check.account
GET /dashboard
GET /data-pengguna
GET /pengaduan
GET /bansos
... (lihat routes/web.php untuk detail lengkap)
```

### Kades Routes (Protected)
```
Prefix: /kades
Middleware: auth, role:kades, check.account
GET /dashboard
GET /validasi-pengajuan
GET /validasi-bansos
... (lihat routes/web.php untuk detail lengkap)
```

---

## 🔍 MIDDLEWARE YANG DIGUNAKAN

### 1. `auth`
- Memverifikasi bahwa user sudah login
- Jika belum login, redirect ke halaman login

### 2. `role:admin|kades|masyarakat`
- Memverifikasi bahwa user memiliki role yang tepat
- Jika tidak, tampilkan error 403 Unauthorized

### 3. `check.account` (CheckAccountStatus Middleware)
- Memverifikasi bahwa akun user masih aktif (is_active = true)
- Jika tidak aktif, logout user dan redirect ke login
- Diterapkan pada semua protected routes

### 4. `throttle:5,1`
- Rate limiting: maksimal 5 request per 1 menit
- Diterapkan pada semua login routes

---

## 📋 CHECKLIST TESTING LOGIN

### Test Login Masyarakat ✅
- [ ] Login dengan Nama + NIK yang benar
- [ ] Login dengan Nama yang salah
- [ ] Login dengan NIK yang salah
- [ ] Login dengan NIK kurang dari 16 digit
- [ ] Percobaan login lebih dari 5x dalam 15 menit (test brute force)
- [ ] Login ketika akun tidak aktif
- [ ] Login dengan role yang bukan masyarakat

### Test Login Admin/Kades ✅
- [ ] Login dengan Email + Password yang benar (Admin)
- [ ] Login dengan Email + Password yang benar (Kades)
- [ ] Login dengan Email yang salah
- [ ] Login dengan Password yang salah
- [ ] Percobaan login lebih dari 5x dalam 15 menit (test brute force)
- [ ] Login ketika akun tidak aktif
- [ ] Login dengan role yang bukan admin/kades
- [ ] Coba login masyarakat di portal admin
- [ ] Coba login admin di portal masyarakat

### Test Rate Limiting ✅
- [ ] Lebih dari 5 request dalam 1 menit → Error "Too Many Attempts"
- [ ] Tunggu 1 menit → Login normal kembali

### Test Login Audit ✅
- [ ] Lihat riwayat login di `/admin/login-history`
- [ ] Filter per user
- [ ] Verifikasi IP address tercatat
- [ ] Verifikasi timestamp tercatat

### Test Redirect After Login ✅
- [ ] Masyarakat login → redirect ke `/masyarakat/dashboard`
- [ ] Admin login → redirect ke `/admin/dashboard`
- [ ] Kades login → redirect ke `/kades/dashboard`

---

## 🐛 TROUBLESHOOTING

### Error: "Terlalu banyak percobaan login gagal"
**Penyebab:** Lebih dari 5 percobaan gagal dalam 15 menit
**Solusi:** 
1. Tunggu 15 menit
2. Atau admin manual delete entry di tabel `login_attempts`
3. Pastikan email/nama dan password/NIK benar

### Error: "Akun Anda tidak aktif"
**Penyebab:** Field `is_active` = false di database
**Solusi:**
1. Admin buka menu `/admin/data-pengguna`
2. Cari pengguna yang tidak aktif
3. Klik Edit dan ubah status menjadi Aktif
4. User bisa login kembali

### Error: "Akses ditolak. Hanya admin dan kades yang dapat login"
**Penyebab:** Mencoba login sebagai masyarakat di portal admin, atau role tidak sesuai
**Solusi:**
1. Pastikan login di portal yang benar:
   - Masyarakat → `/masyarakat-login`
   - Admin/Kades → `/admin-login`
2. Verifikasi role user di database

### Error: "Nama lengkap atau NIK tidak sesuai"
**Penyebab:** Data tidak cocok atau role bukan masyarakat
**Solusi:**
1. Verifikasi nama dan NIK benar
2. Cek di tabel `users` bahwa role = 'masyarakat'
3. NIK harus tepat 16 digit

### Error: "Too Many Attempts. Please try again in X seconds."
**Penyebab:** Lebih dari 5 request dalam 1 menit (rate limiting)
**Solusi:**
1. Tunggu X detik
2. Atau gunakan browser incognito mode (beda IP)

---

## 📊 ADMIN DASHBOARD - LOGIN HISTORY

Admin bisa memantau semua login attempts di menu `/admin/login-history`:

**Fitur:**
- ✅ Lihat semua percobaan login (success & failed)
- ✅ Filter per user
- ✅ Lihat detail attempt: waktu, IP, alasan gagal
- ✅ Export laporan login

---

## 🔄 FLOW CHART AUTHENTICATION

```
User membuka website
        ↓
Apakah sudah login?
├─ Ya → Redirect ke dashboard sesuai role
└─ Tidak → Lihat tombol login
        ↓
Pilih portal login:
├─ Masyarakat → /masyarakat-login
│   ├─ Input Nama + NIK
│   └─ Validasi & Login
└─ Admin/Kades → /admin-login
    ├─ Input Email + Password
    └─ Validasi & Login
        ↓
Validasi:
├─ Cek brute force protection
├─ Cek user exists
├─ Cek password/NIK
├─ Cek role
└─ Cek is_active
        ↓
Hasil:
├─ ✅ Login Berhasil → Create session → Redirect dashboard
└─ ❌ Login Gagal → Catat attempt → Tampilkan error
```

---

## 📞 KONTAK SUPPORT

Jika mengalami masalah dengan sistem login, hubungi:
- **Admin Sistem:** admin@desa.com
- **Email Support:** support@sipakal.go.id
- **Waktu Support:** Senin - Jumat, 09:00 - 17:00

---

**Dokumen ini dibuat:** 2 Juni 2026  
**Versi:** 1.0  
**Status:** Selesai & Terverifikasi  
**Terakhir diupdate:** 2 Juni 2026
