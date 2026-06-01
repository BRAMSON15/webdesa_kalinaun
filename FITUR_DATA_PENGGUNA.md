# 📋 FITUR KELOLA DATA PENGGUNA (Admin)

## 📌 Deskripsi Fitur

Fitur Kelola Data Pengguna memungkinkan Admin untuk mengelola semua pengguna sistem (Masyarakat dan Kepala Desa) dengan fitur lengkap termasuk:
- Melihat daftar semua pengguna
- Melihat detail pengguna
- Mengedit data pengguna
- Reset password pengguna
- Menghapus pengguna

---

## 🎯 Use Case

### Use Case 21: Kelola Data Pengguna (Admin)

**Requirements:** Admin memilih menu "Data Pengguna".  
**Goal:** Admin dapat mengelola semua data pengguna sistem.  
**Pre-Conditions:** Admin telah login ke sistem.  
**Post-Conditions:** Data pengguna berhasil dikelola.  
**Failed And Conditions:** Terjadi kesalahan saat menyimpan atau menghapus data.  
**Primary Actors:** Admin  
**Status:** ✅ IMPLEMENTED

**Main Flow Or Basic Path:**
1. Admin login ke sistem.
2. Admin memilih menu "Data Pengguna".
3. Sistem menampilkan tabel daftar pengguna dengan informasi:
   - No
   - Nama
   - Email
   - Role (Admin, Kepala Desa, Masyarakat)
   - Status (Aktif)
   - Terdaftar (Tanggal)
   - Aksi (Lihat Detail, Edit, Reset Password, Hapus)
4. Admin dapat:
   - Mencari pengguna dengan search box
   - Melihat detail pengguna
   - Mengedit data pengguna (kecuali admin)
   - Reset password pengguna
   - Menghapus pengguna

**Implementation Notes:**
- Route: `/admin/data-pengguna`
- Controller: `AdminController@dataPengguna`, `AdminController@updatePengguna`, `AdminController@deletePengguna`, `AdminController@resetPasswordPengguna`
- View: `resources/views/admin/data-pengguna.blade.php`
- Database: `users` table

---

## 🔧 Implementasi Teknis

### Database Schema

Menggunakan tabel `users` yang sudah ada dengan fields:
```sql
- id (Primary Key)
- name (string)
- email (unique)
- password (hashed)
- no_hp (nullable)
- nik (nullable)
- alamat (nullable)
- tempat_lahir (nullable)
- tanggal_lahir (nullable)
- jenis_kelamin (nullable, L/P)
- pekerjaan (nullable)
- role (masyarakat, kades, admin)
- created_at
- updated_at
```

### Model

**File:** `app/Models/User.php`

```php
class User extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'no_hp',
        'nik',
        'alamat',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'pekerjaan',
        'role',
    ];

    protected $hidden = ['password', 'remember_token'];
}
```

### Controller Methods

**File:** `app/Http/Controllers/Admin/AdminController.php`

#### 1. dataPengguna()
Menampilkan daftar semua pengguna.

```php
public function dataPengguna()
{
    $users = User::latest()->get();
    return view('admin.data-pengguna', compact('users'));
}
```

#### 2. updatePengguna(Request $request, $id)
Mengupdate data pengguna.

```php
public function updatePengguna(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'no_hp' => 'nullable|string|max:20',
        'nik' => 'nullable|string|max:20',
        'alamat' => 'nullable|string',
        'tempat_lahir' => 'nullable|string|max:100',
        'tanggal_lahir' => 'nullable|date',
        'jenis_kelamin' => 'nullable|in:L,P',
        'pekerjaan' => 'nullable|string|max:100',
        'role' => 'nullable|in:masyarakat,kades',
    ]);

    $user = User::findOrFail($id);
    
    // Proteksi: Tidak boleh mengubah data admin
    if ($user->role === 'admin') {
        return response()->json(['success' => false, 'message' => 'Tidak dapat mengubah data admin'], 403);
    }

    $user->update($request->all());

    return response()->json([
        'success' => true,
        'message' => 'Data pengguna berhasil diperbarui',
        'user' => $user
    ]);
}
```

#### 3. deletePengguna($id)
Menghapus pengguna dari sistem.

```php
public function deletePengguna($id)
{
    $user = User::findOrFail($id);
    
    // Proteksi: Tidak boleh menghapus admin
    if ($user->role === 'admin') {
        return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus data admin'], 403);
    }

    // Proteksi: Tidak boleh menghapus jika ada pengajuan aktif
    $activePengajuan = PengajuanSurat::where('user_id', $id)
        ->whereIn('status', ['proses', 'diproses'])
        ->count();

    if ($activePengajuan > 0) {
        return response()->json([
            'success' => false, 
            'message' => 'Tidak dapat menghapus pengguna yang memiliki pengajuan aktif'
        ], 422);
    }

    $user->delete();

    return response()->json([
        'success' => true,
        'message' => 'Data pengguna berhasil dihapus'
    ]);
}
```

#### 4. resetPasswordPengguna($id)
Mereset password pengguna dengan password sementara.

```php
public function resetPasswordPengguna($id)
{
    $user = User::findOrFail($id);
    
    // Proteksi: Tidak boleh reset password admin
    if ($user->role === 'admin') {
        return response()->json(['success' => false, 'message' => 'Tidak dapat reset password admin'], 403);
    }

    // Generate password sementara
    $tempPassword = 'Desa' . date('Ymd') . rand(1000, 9999);
    $user->update(['password' => bcrypt($tempPassword)]);

    return response()->json([
        'success' => true,
        'message' => 'Password berhasil direset',
        'temp_password' => $tempPassword,
        'note' => 'Berikan password sementara ini kepada pengguna. Pengguna dapat mengubahnya setelah login.'
    ]);
}
```

### Routes

**File:** `routes/web.php`

```php
Route::middleware(['auth:admin', 'role:admin'])->prefix('admin')->group(function () {
    // Data Pengguna
    Route::get('/data-pengguna', [AdminController::class, 'dataPengguna'])->name('data-pengguna');
    Route::put('/data-pengguna/{id}', [AdminController::class, 'updatePengguna'])->name('data-pengguna.update');
    Route::delete('/data-pengguna/{id}', [AdminController::class, 'deletePengguna'])->name('data-pengguna.delete');
    Route::post('/data-pengguna/{id}/reset-password', [AdminController::class, 'resetPasswordPengguna'])->name('data-pengguna.reset-password');
});
```

### View

**File:** `resources/views/admin/data-pengguna.blade.php`

Fitur yang tersedia di view:
1. **Search Box** - Mencari pengguna berdasarkan nama, email, atau NIK
2. **Tabel Pengguna** - Menampilkan daftar pengguna dengan informasi lengkap
3. **Modal Detail** - Menampilkan detail lengkap pengguna
4. **Modal Edit** - Form untuk mengedit data pengguna
5. **Tombol Aksi:**
   - 👁️ Lihat Detail - Membuka modal detail pengguna
   - ✏️ Edit - Membuka modal edit pengguna (hanya untuk non-admin)
   - 🔑 Reset Password - Mereset password pengguna (hanya untuk non-admin)
   - 🗑️ Hapus - Menghapus pengguna (hanya untuk non-admin)

---

## 📊 Fitur Detail

### 1. Lihat Daftar Pengguna

**Tampilan:**
- Tabel dengan kolom: No, Nama, Email, Role, Status, Terdaftar, Aksi
- Search box untuk mencari pengguna
- Badge untuk menampilkan role (Admin, Kepala Desa, Masyarakat)
- Status selalu "Aktif" (untuk implementasi future: bisa ditambah status aktif/nonaktif)

**Fitur:**
- Sorting otomatis berdasarkan tanggal terbaru
- Responsive design untuk mobile
- Hover effect pada baris tabel

### 2. Lihat Detail Pengguna

**Modal Detail Pengguna:**
- Avatar dengan inisial nama
- Informasi lengkap:
  - Nama Lengkap
  - Email (clickable link)
  - No. HP (clickable link)
  - NIK
  - Alamat
  - Tanggal Lahir
  - Jenis Kelamin
  - Role
  - Terdaftar (tanggal)
  - Terakhir Update (tanggal)

**Fitur:**
- Tampilan profesional dengan layout 2 kolom
- Email dan No. HP bisa diklik untuk kontak langsung
- Tanggal otomatis diformat ke format Indonesia

### 3. Edit Data Pengguna

**Form Edit:**
- Nama Lengkap (required)
- Email (required, unique)
- No. HP (optional)
- NIK (optional)
- Alamat (textarea)
- Tanggal Lahir (date picker)
- Jenis Kelamin (dropdown: Laki-laki, Perempuan)
- Role (dropdown: Masyarakat, Kepala Desa) - hanya untuk non-admin

**Validasi:**
- Nama: required, max 255 karakter
- Email: required, email format, unique (kecuali user yang sedang diedit)
- No. HP: max 20 karakter
- NIK: max 20 karakter
- Tanggal Lahir: format date
- Jenis Kelamin: L atau P
- Role: masyarakat atau kades

**Fitur:**
- Loading indicator saat menyimpan
- Error handling dengan pesan yang jelas
- Auto-reload halaman setelah sukses

### 4. Reset Password

**Fitur:**
- Generate password sementara otomatis dengan format: `Desa` + `YYYYMMDD` + `4 digit random`
- Contoh: `Desa202605261234`
- Password ditampilkan dalam alert untuk diberikan ke pengguna
- Pengguna dapat mengubah password setelah login

**Proteksi:**
- Tidak bisa reset password admin
- Konfirmasi sebelum reset

### 5. Hapus Pengguna

**Fitur:**
- Soft delete atau hard delete (sesuai kebutuhan)
- Proteksi: Tidak bisa menghapus jika ada pengajuan aktif
- Proteksi: Tidak bisa menghapus admin
- Konfirmasi sebelum hapus

**Validasi:**
- Cek apakah pengguna memiliki pengajuan dengan status 'proses' atau 'diproses'
- Jika ada, tampilkan pesan error

---

## 🔒 Keamanan

### Authorization
- Hanya admin yang bisa mengakses fitur ini
- Middleware: `auth:admin`, `role:admin`

### Proteksi Data
1. **Tidak bisa mengubah admin** - Hanya admin bisa mengubah data admin
2. **Tidak bisa menghapus admin** - Admin tidak bisa dihapus
3. **Tidak bisa reset password admin** - Password admin tidak bisa direset
4. **Tidak bisa menghapus pengguna dengan pengajuan aktif** - Cegah data inconsistency

### Validasi Input
- Email unique validation
- Format validation untuk semua field
- CSRF token protection untuk semua request

### Audit Trail
- Semua perubahan tercatat di `updated_at`
- Bisa ditambahkan activity logging untuk tracking lebih detail

---

## 🧪 Testing Checklist

### Unit Tests
- [ ] Test dataPengguna() menampilkan semua pengguna
- [ ] Test updatePengguna() dengan data valid
- [ ] Test updatePengguna() dengan email duplicate
- [ ] Test updatePengguna() tidak bisa mengubah admin
- [ ] Test deletePengguna() dengan pengguna non-admin
- [ ] Test deletePengguna() tidak bisa menghapus admin
- [ ] Test deletePengguna() tidak bisa menghapus jika ada pengajuan aktif
- [ ] Test resetPasswordPengguna() generate password sementara
- [ ] Test resetPasswordPengguna() tidak bisa reset admin

### Integration Tests
- [ ] Test flow: Lihat daftar → Lihat detail → Edit → Simpan
- [ ] Test flow: Lihat daftar → Reset password → Verifikasi password baru
- [ ] Test flow: Lihat daftar → Hapus → Verifikasi terhapus
- [ ] Test search functionality
- [ ] Test modal open/close

### UI/UX Tests
- [ ] Test responsive design di mobile
- [ ] Test search box real-time filtering
- [ ] Test modal display dan form validation
- [ ] Test button loading state
- [ ] Test alert messages

### Security Tests
- [ ] Test CSRF token validation
- [ ] Test authorization (non-admin tidak bisa akses)
- [ ] Test tidak bisa modify admin user
- [ ] Test tidak bisa delete admin user
- [ ] Test tidak bisa reset admin password

---

## 📝 Catatan Implementasi

### Fitur yang Sudah Diimplementasikan
✅ Lihat daftar pengguna
✅ Lihat detail pengguna
✅ Edit data pengguna
✅ Reset password pengguna
✅ Hapus pengguna
✅ Search pengguna
✅ Validasi input
✅ Error handling
✅ Authorization checks

### Fitur yang Bisa Ditambahkan di Future
- [ ] Export pengguna ke Excel/PDF
- [ ] Bulk edit pengguna
- [ ] Bulk delete pengguna
- [ ] Status aktif/nonaktif pengguna
- [ ] Activity logging
- [ ] Advanced filtering (by role, by date range, etc.)
- [ ] Pagination untuk pengguna banyak
- [ ] Import pengguna dari Excel
- [ ] Email notification saat password direset
- [ ] Two-factor authentication

---

## 🚀 Cara Menggunakan

### Untuk Admin

1. **Akses Fitur:**
   - Login sebagai admin
   - Klik menu "Data Pengguna" di sidebar

2. **Mencari Pengguna:**
   - Ketik nama, email, atau NIK di search box
   - Hasil akan filter otomatis

3. **Lihat Detail Pengguna:**
   - Klik tombol 👁️ (Lihat Detail)
   - Modal akan menampilkan informasi lengkap

4. **Edit Data Pengguna:**
   - Klik tombol ✏️ (Edit)
   - Ubah data yang diperlukan
   - Klik "Simpan Perubahan"

5. **Reset Password:**
   - Klik tombol 🔑 (Reset Password)
   - Konfirmasi reset
   - Copy password sementara dan berikan ke pengguna

6. **Hapus Pengguna:**
   - Klik tombol 🗑️ (Hapus)
   - Konfirmasi penghapusan
   - Pengguna akan dihapus dari sistem

---

## 📞 Support

Jika ada pertanyaan atau masalah, silakan hubungi tim development.

---

**Last Updated:** 1 Juni 2026  
**Status:** ✅ IMPLEMENTED  
**Version:** 1.0
