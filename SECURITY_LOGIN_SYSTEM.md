# Sistem Login Aman dengan Pemisahan Role

## Ringkasan Perubahan

Sistem login telah diperbarui dengan fitur keamanan yang lebih ketat dan pemisahan portal berdasarkan role pengguna.

## Fitur Keamanan

### 1. **Pemisahan Portal Login**
- **Portal Masyarakat**: `/masyarakat-login`
  - Hanya user dengan role `masyarakat` yang dapat login
  - Akses ke dashboard masyarakat
  - Dapat mendaftar akun baru
  
- **Portal Admin/Kades**: `/admin-login`
  - Hanya user dengan role `admin` atau `kades` yang dapat login
  - Akses ke dashboard admin atau kades
  - Tidak ada opsi pendaftaran

### 2. **Validasi Role Ketat**
Setiap login divalidasi dengan ketat:

```php
// Masyarakat hanya bisa login di portal masyarakat
if ($user->role !== 'masyarakat') {
    throw new Exception('Akses ditolak. Portal ini hanya untuk masyarakat.');
}

// Admin/Kades hanya bisa login di portal admin
if (!in_array($user->role, ['admin', 'kades'])) {
    throw new Exception('Akses ditolak. Hanya admin dan kades yang dapat login di portal ini.');
}
```

### 3. **Pencegahan Akses Silang**
- Masyarakat **TIDAK BISA** login di portal admin meskipun tahu email/password
- Admin/Kades **TIDAK BISA** login di portal masyarakat
- Setiap portal memiliki validasi role yang independen

## Routes

### Login Routes
```
GET  /masyarakat-login          → Tampilkan form login masyarakat
POST /masyarakat-login          → Proses login masyarakat
GET  /admin-login               → Tampilkan form login admin/kades
POST /admin-login               → Proses login admin/kades
GET  /login                     → Generic login (backward compatibility)
POST /login                     → Generic login submit
```

### Password Reset Routes
```
GET  /forgot-password           → Form lupa password
POST /forgot-password           → Kirim token reset
GET  /reset-password/{token}/{email} → Form reset password
POST /reset-password            → Update password
```

### Registration Routes
```
GET  /register                  → Form registrasi (masyarakat only)
POST /register                  → Proses registrasi
```

## Views

### Login Views
- `resources/views/auth/masyarakat-login.blade.php` - Portal login masyarakat
- `resources/views/auth/admin-login.blade.php` - Portal login admin/kades
- `resources/views/auth/login.blade.php` - Generic login (legacy)

### Features di Views
- Toggle password visibility
- Error message display
- Link ke portal lain
- Responsive design

## AuthService Methods

### Login Methods
```php
// Login dengan validasi role
login($email, $password, $role = null)

// Login khusus admin/kades
loginAdmin($email, $password)

// Login khusus masyarakat
loginMasyarakat($email, $password)

// Registrasi (masyarakat only)
register($data)

// Logout
logout()
```

### Password Reset Methods
```php
// Kirim token reset
sendResetToken($email)

// Validasi token
validateResetToken($token, $email)

// Update password
updatePassword($token, $email, $password)
```

## Alur Login

### Masyarakat Login
1. User klik "Login Masyarakat" di homepage
2. Masuk ke `/masyarakat-login`
3. Input email dan password
4. System validasi:
   - Email ada di database?
   - Password benar?
   - Role = 'masyarakat'?
5. Jika semua valid → redirect ke `/masyarakat/dashboard`
6. Jika role bukan masyarakat → error "Akses ditolak"

### Admin/Kades Login
1. User klik "Login Admin/Kades" di homepage
2. Masuk ke `/admin-login`
3. Input email dan password
4. System validasi:
   - Email ada di database?
   - Password benar?
   - Role = 'admin' atau 'kades'?
5. Jika semua valid → redirect ke `/admin/dashboard` atau `/kades/dashboard`
6. Jika role bukan admin/kades → error "Akses ditolak"

## Middleware Protection

Semua routes dilindungi dengan middleware:

```php
// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(...)

// Kades routes
Route::middleware(['auth', 'role:kades'])->prefix('kades')->group(...)

// Masyarakat routes
Route::middleware(['auth', 'role:masyarakat'])->prefix('masyarakat')->group(...)
```

## Error Handling

### Error Messages
- **Email tidak ditemukan**: "Email atau password salah"
- **Password salah**: "Email atau password salah"
- **Role tidak sesuai**: "Akses ditolak. Portal ini hanya untuk [role]"
- **Token expired**: "Token sudah kadaluarsa"
- **Token invalid**: "Token tidak valid"

## Security Best Practices

1. ✅ Password di-hash dengan bcrypt
2. ✅ Reset token random 32 karakter
3. ✅ Reset token expire dalam 24 jam
4. ✅ Validasi role di setiap login
5. ✅ Middleware protection di routes
6. ✅ CSRF protection di forms
7. ✅ Password visibility toggle
8. ✅ Separate login portals per role

## Testing Scenarios

### Scenario 1: Masyarakat Login Sukses
```
Email: masyarakat@example.com
Password: password123
Role: masyarakat
Result: ✅ Login berhasil → /masyarakat/dashboard
```

### Scenario 2: Masyarakat Coba Login di Admin Portal
```
Email: masyarakat@example.com
Password: password123
Portal: /admin-login
Result: ❌ Error "Akses ditolak. Hanya admin dan kades..."
```

### Scenario 3: Admin Login Sukses
```
Email: admin@example.com
Password: password123
Role: admin
Result: ✅ Login berhasil → /admin/dashboard
```

### Scenario 4: Admin Coba Login di Masyarakat Portal
```
Email: admin@example.com
Password: password123
Portal: /masyarakat-login
Result: ❌ Error "Akses ditolak. Portal ini hanya untuk masyarakat..."
```

## Migrasi dari Sistem Lama

Jika ada user yang sudah login dengan sistem lama:
1. Session akan tetap valid sampai logout
2. Setelah logout, harus login di portal yang sesuai
3. Tidak ada perubahan di database user

## Catatan Penting

- ⚠️ Jangan ubah role user di database tanpa notifikasi
- ⚠️ Reset password hanya bisa dilakukan di portal yang sesuai
- ⚠️ Admin tidak bisa membuat akun masyarakat baru (hanya via registrasi)
- ⚠️ Masyarakat tidak bisa membuat akun admin/kades

## File yang Diubah

1. `app/Services/AuthService.php` - Tambah login methods per role
2. `app/Http/Controllers/AuthController.php` - Tambah controller methods
3. `routes/web.php` - Tambah routes untuk login terpisah
4. `resources/views/auth/masyarakat-login.blade.php` - View baru
5. `resources/views/auth/admin-login.blade.php` - View baru
6. `resources/views/welcome.blade.php` - Update CTA buttons

## Verifikasi

Semua file sudah diverifikasi:
- ✅ Syntax check passed
- ✅ Cache cleared
- ✅ Config cleared
- ✅ Routes registered
- ✅ Views created
