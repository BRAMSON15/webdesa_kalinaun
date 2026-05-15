# Dokumentasi Fitur Lupa Password (Forgot Password)

## Deskripsi Fitur
Fitur lupa password memungkinkan user yang lupa password untuk mereset password mereka dengan cara:
1. Memasukkan email yang terdaftar
2. Sistem akan menghasilkan token reset password
3. User akan diarahkan ke halaman reset password dengan token
4. User memasukkan password baru dan konfirmasi password
5. Password berhasil direset

## Alur Sistem

### 1. Halaman Login
- User klik link "lupa sandi?" di halaman login
- Diarahkan ke halaman forgot password

### 2. Halaman Forgot Password (`/forgot-password`)
- User memasukkan email yang terdaftar
- Sistem validasi email ada di database
- Jika valid, sistem generate token random 32 karakter
- Token disimpan di database dengan waktu expired 24 jam
- User diarahkan ke halaman reset password dengan token dan email

### 3. Halaman Reset Password (`/reset-password/{token}/{email}`)
- Menampilkan token reset (read-only)
- User memasukkan password baru
- User memasukkan konfirmasi password
- Sistem validasi:
  - Token harus valid dan belum expired
  - Password minimal 8 karakter
  - Password dan konfirmasi harus sama
- Jika valid, password diupdate dan token dihapus
- User diarahkan ke login dengan pesan sukses

## Database Schema

### Kolom yang Ditambahkan ke Tabel `users`
```sql
ALTER TABLE users ADD COLUMN reset_token VARCHAR(255) NULL;
ALTER TABLE users ADD COLUMN reset_token_expires_at TIMESTAMP NULL;
```

### Migration File
File: `database/migrations/2026_05_15_141620_add_reset_token_to_users_table.php`

## File-File yang Dibuat/Diubah

### 1. Views
- **`resources/views/auth/forgot-password.blade.php`** (BARU)
  - Form untuk memasukkan email
  - Validasi error display
  - Link kembali ke login

- **`resources/views/auth/reset-password.blade.php`** (BARU)
  - Menampilkan token reset (read-only)
  - Form password baru dan konfirmasi
  - Toggle password visibility
  - Auto copy token ke clipboard

- **`resources/views/auth/login.blade.php`** (DIUBAH)
  - Link "lupa sandi?" diubah dari `#` ke `{{ route('forgot-password') }}`

### 2. Controllers
- **`app/Http/Controllers/AuthController.php`** (DIUBAH)
  - Method `showForgotPassword()` - menampilkan form forgot password
  - Method `sendResetToken()` - generate dan simpan token
  - Method `showResetPassword()` - menampilkan form reset password
  - Method `updatePassword()` - update password dan hapus token

### 3. Routes
- **`routes/web.php`** (DIUBAH)
  - `GET /forgot-password` → `showForgotPassword()`
  - `POST /forgot-password` → `sendResetToken()`
  - `GET /reset-password/{token}/{email}` → `showResetPassword()`
  - `POST /reset-password` → `updatePassword()`

### 4. Models
- **`app/Models/User.php`** (DIUBAH)
  - Tambah `reset_token` dan `reset_token_expires_at` ke Fillable

## Fitur Keamanan

1. **Token Expiration**: Token berlaku hanya 24 jam
2. **Token Validation**: Token harus valid dan belum expired
3. **Email Verification**: Email harus terdaftar di sistem
4. **Password Hashing**: Password di-hash sebelum disimpan
5. **Token Cleanup**: Token dihapus setelah password berhasil direset
6. **CSRF Protection**: Semua form dilindungi CSRF token

## Validasi

### Forgot Password Form
- Email harus valid format email
- Email harus terdaftar di database

### Reset Password Form
- Token harus valid
- Email harus valid
- Password minimal 8 karakter
- Password dan konfirmasi harus sama
- Token tidak boleh expired

## Error Handling

### Forgot Password
- Email tidak ditemukan → "Email tidak ditemukan dalam sistem."
- Email tidak valid → "Email harus berupa email yang valid."

### Reset Password
- Token tidak valid → "Token tidak valid."
- Token expired → "Token sudah kadaluarsa. Silakan minta token baru."
- Password tidak cocok → "Password confirmation does not match."
- Password terlalu pendek → "Password harus minimal 8 karakter."

## Testing

### Test Case 1: Forgot Password Sukses
1. Buka `/forgot-password`
2. Masukkan email yang terdaftar
3. Klik "Kirim Token Reset"
4. Verifikasi redirect ke halaman reset password
5. Verifikasi token ditampilkan

### Test Case 2: Reset Password Sukses
1. Dari halaman reset password
2. Masukkan password baru (minimal 8 karakter)
3. Masukkan konfirmasi password yang sama
4. Klik "Reset Sandi"
5. Verifikasi redirect ke login dengan pesan sukses
6. Login dengan password baru

### Test Case 3: Token Expired
1. Tunggu lebih dari 24 jam
2. Coba akses halaman reset password
3. Verifikasi error "Token sudah kadaluarsa"

### Test Case 4: Email Tidak Terdaftar
1. Buka `/forgot-password`
2. Masukkan email yang tidak terdaftar
3. Verifikasi error "Email tidak ditemukan dalam sistem."

## Catatan Penting

1. Token disimpan dalam plain text di database (bisa di-hash untuk keamanan lebih)
2. Tidak ada email notification (bisa ditambahkan dengan Mail/Notification)
3. Token hanya berlaku 24 jam
4. Setelah reset password, user harus login ulang
5. Fitur ini berlaku untuk semua role (admin, kades, masyarakat)

## Pengembangan Lebih Lanjut

Fitur yang bisa ditambahkan:
1. Email notification dengan link reset password
2. Hash token di database untuk keamanan lebih
3. Rate limiting untuk mencegah brute force
4. Audit log untuk tracking reset password
5. SMS notification sebagai alternatif email
6. Two-factor authentication
7. Security questions sebagai verifikasi tambahan
