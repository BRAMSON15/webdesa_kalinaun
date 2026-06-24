# Cara Kerja Sistem Notifikasi WhatsApp - Webdesa2

## 📋 Daftar Isi
1. [Gambaran Umum](#gambaran-umum)
2. [Arsitektur Sistem](#arsitektur-sistem)
3. [Flow Notifikasi Bansos](#flow-notifikasi-bansos)
4. [Flow Notifikasi Surat Pengajuan](#flow-notifikasi-surat-pengajuan)
5. [Implementasi Teknis](#implementasi-teknis)
6. [Integrasi dengan WhatsApp API](#integrasi-dengan-whatsapp-api)
7. [Testing & Troubleshooting](#testing--troubleshooting)

---

## Gambaran Umum

Sistem notifikasi WhatsApp di Webdesa2 dirancang untuk memberitahu masyarakat tentang:
- **Persetujuan/Penolakan Bansos** (Bantuan Sosial)
- **Persetujuan/Penolakan Surat Pengajuan**

Sistem ini menggunakan teknologi:
- **WhatsApp Web API** (`wa.me` link)
- **Database Notifications** untuk tracking
- **Email** sebagai backup

---

## Arsitektur Sistem

### Komponen Utama

```
┌─────────────────────────────────────────────────────────┐
│                   Admin/Kades Portal                    │
│     (Approve/Reject Bansos atau Pengajuan Surat)       │
└────────────────────┬────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────┐
│              Controller (Admin/Kades)                   │
│    - BansosController                                  │
│    - PengajuanSuratController                          │
└────────────────────┬────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────┐
│         NotificationService (Orchestrator)              │
│                                                         │
│  - Trigger Events                                      │
│  - Generate Message                                    │
│  - Create DB Records                                   │
└────────────────────┬────────────────────────────────────┘
                     │
        ┌────────────┼────────────┐
        ▼            ▼            ▼
    ┌────────┐  ┌────────┐  ┌──────────┐
    │Database│  │  Email │  │ WhatsApp │
    │  (DB)  │  │        │  │  Link    │
    └────────┘  └────────┘  └──────────┘
```

### Data Flow Diagram

```
┌─────────────┐
│   Masyarakat│
│ Daftar Bans │
└──────┬──────┘
       │
       ▼
┌──────────────────┐
│ PenerimaBansos   │
│ status: menunggu │
└──────┬───────────┘
       │
       ▼
┌────────────────────────────────┐
│ Admin Approve/Reject           │
│ (Update status)                │
└──────┬─────────────────────────┘
       │
       ▼
┌────────────────────────────────┐
│ Event: StatusChanged            │
│ (Trigger Notification)          │
└──────┬─────────────────────────┘
       │
       ▼
┌────────────────────────────────┐
│ NotificationService:            │
│ - Create DB record             │
│ - Generate WhatsApp Link       │
│ - Send Email                   │
└──────┬─────────────────────────┘
       │
       ├─► DB Notification (for app)
       ├─► Email Notification
       └─► WhatsApp Link (generate on demand)
```

---

## Flow Notifikasi Bansos

### 1. Saat Masyarakat Mendaftar Bansos

**File: `app/Services/NotificationService.php`**

```php
public static function notifyNewBansosApplication($penerima)
{
    return self::send(
        $penerima->user,
        'bansos',                           // type
        'Pendaftaran Bansos Berhasil',      // title
        'Pendaftaran Anda untuk program "' . $penerima->bansos->nama_bansos . '" 
        telah berhasil diterima...',        // message
        ['penerima_id' => $penerima->id, 'bansos_id' => $penerima->bansos_id]
    );
}
```

**Proses:**
1. Masyarakat submit formulir pendaftaran bansos
2. Record disimpan di `penerima_bansos` table dengan `status: 'menunggu'`
3. Notifikasi disimpan di database `notifications` table
4. Masyarakat melihat notifikasi di aplikasi web

---

### 2. Saat Admin Approve Bansos

**File: `app/Http/Controllers/Admin/BansosController.php`**

```php
public function approve($id)
{
    $penerima = PenerimaBansos::findOrFail($id);
    $oldStatus = $penerima->status;
    
    // Update status
    $penerima->update([
        'status' => 'disetujui',
        'tanggal_penerimaan' => now()
    ]);
    
    // Create notification
    NotificationService::notifyBansosStatusChange($penerima, $oldStatus);
    
    // Send email
    NotificationService::sendBansosApprovedEmail($penerima);
}
```

**Proses:**
1. Admin/Kades login ke portal admin
2. Buka halaman daftar pengajuan bansos
3. Klik tombol "Approve"
4. System:
   - Update `penerima_bansos.status = 'disetujui'`
   - Create record di `notifications` table
   - Send email ke user
   - Generate WhatsApp link (tersedia on-demand)

---

### 3. Saat Admin Reject Bansos

**Proses sama seperti approve, namun:**
- Update `penerima_bansos.status = 'ditolak'`
- Include `alasan_penolakan` di message

---

### 4. WhatsApp Link Generation untuk Bansos Approval

**File: `app/Services/NotificationService.php`**

```php
public static function getWhatsAppLinkBansosApproved($penerima)
{
    $user = $penerima->user;
    $bansos = $penerima->bansos;
    
    if (empty($user->no_hp)) {
        return null;  // Tidak ada nomor HP
    }

    $message = "*SELAMAT! BANSOS DISETUJUI* ✅\n\n";
    $message .= "Yth. Bapak/Ibu *{$user->name}*\n\n";
    $message .= "Kami informasikan bahwa pendaftaran Anda untuk program bantuan sosial telah *DISETUJUI*:\n\n";
    $message .= "📋 *Program:* {$bansos->nama_bansos}\n";
    $message .= "💰 *Nominal:* Rp " . number_format($penerima->nominal_diterima, 0, ',', '.') . "\n";
    $message .= "📅 *Tanggal Persetujuan:* " . now()->format('d/m/Y') . "\n\n";
    $message .= "Silakan hubungi kantor desa untuk informasi lebih lanjut...\n\n";
    $message .= "_Selamat dan semoga bermanfaat._\n";
    $message .= "Sistem Informasi Desa";

    return self::generateWhatsAppLink($user->no_hp, $message);
}
```

**Output WhatsApp Link:**
```
https://wa.me/62812xxxxxxxx?text=*SELAMAT!%20BANSOS%20DISETUJUI*%20%E2%9C%85%0A%0A...
```

Ketika user klik link ini:
- WhatsApp membuka dengan nomor penerima yang sudah tersedia
- Message sudah pre-filled
- User tinggal klik "Send"

---

## Flow Notifikasi Surat Pengajuan

### 1. Saat Masyarakat Mengajukan Surat

**File: `app/Services/NotificationService.php`**

```php
public static function notifyNewComplaint($pengaduan)
{
    return self::send(
        $pengaduan->user,
        'pengaduan',
        'Pengaduan Baru Dibuat',
        'Pengaduan Anda dengan judul "' . $pengaduan->judul . '" telah berhasil dibuat.',
        ['pengaduan_id' => $pengaduan->id]
    );
}
```

---

### 2. Saat Kades Selesaikan Surat

**File: `app/Http/Controllers/Kades/KadesController.php`**

```php
public function completeLetter($id)
{
    $pengajuan = PengajuanSurat::findOrFail($id);
    $oldStatus = $pengajuan->status;
    
    // Update status
    $pengajuan->update([
        'status' => 'selesai',
        'nomor_surat' => generateLetterNumber(),
        'tanggal_selesai' => now()
    ]);
    
    // Create notification
    NotificationService::notifyLetterStatusChange($pengajuan, $oldStatus);
    
    // Send email
    NotificationService::sendLetterCompletedEmail($pengajuan);
}
```

---

### 3. WhatsApp Link Generation untuk Surat Selesai

```php
public static function getWhatsAppLinkLetterCompleted($pengajuan)
{
    $user = $pengajuan->user;
    $jenisSurat = $pengajuan->jenisSurat;
    
    $message = "*SURAT SUDAH SELESAI* ✅\n\n";
    $message .= "Yth. Bapak/Ibu *{$user->name}*\n\n";
    $message .= "Kami informasikan bahwa pengajuan surat Anda telah selesai diproses:\n\n";
    $message .= "📄 *Jenis Surat:* {$jenisSurat->nama_surat}\n";
    $message .= "📅 *Tanggal Pengajuan:* " . $pengajuan->created_at->format('d/m/Y') . "\n";
    $message .= "✅ *Status:* Selesai\n";
    $message .= "📥 *Nomor Surat:* {$pengajuan->nomor_surat}\n\n";
    $message .= "Surat dapat diambil di kantor desa atau diunduh melalui sistem.\n\n";
    $message .= "_Terima kasih._\n";
    $message .= "Sistem Informasi Desa";

    return self::generateWhatsAppLink($user->no_hp, $message);
}
```

---

## Implementasi Teknis

### Database Schema

#### `users` table
```
- id (Primary Key)
- name
- email
- no_hp (nomor HP untuk WhatsApp) ← PENTING!
- role (admin, kades, masyarakat)
- ...
```

#### `notifications` table
```
- id
- user_id (Foreign Key ke users)
- type (bansos, pengaduan, surat)
- title
- message
- data (JSON)
- read_at (nullable - untuk tracking pembacaan)
- sent_at
- created_at
- updated_at
```

#### `penerima_bansos` table
```
- id
- user_id
- bansos_id
- status (menunggu, disetujui, ditolak)
- nominal_diterima
- tanggal_penerimaan
- alasan_penolakan (nullable)
- ...
```

#### `pengajuan_surat` table
```
- id
- user_id
- jenis_surat_id
- status (diajukan, diproses, selesai, ditolak)
- nomor_surat (nullable)
- catatan_kades (nullable)
- ...
```

---

### Integrasi dengan WhatsApp API

#### Metode 1: WhatsApp Web Link (Current Implementation) ✅

**Keuntungan:**
- Tidak perlu API key atau registrasi khusus
- Langsung menggunakan WhatsApp yang sudah terinstall
- Gratis
- Support on semua device

**Cara Kerja:**
```
URL: https://wa.me/{phone}?text={message}

Contoh:
https://wa.me/628123456789?text=Halo%20Pak%2C%20pengajuan%20Anda%20disetujui
```

**Implementasi:**
```php
// Format nomor HP
$phoneNumber = preg_replace('/[^0-9]/', '', $no_hp);  // 08123456789
if (substr($phoneNumber, 0, 1) === '0') {
    $phoneNumber = '62' . substr($phoneNumber, 1);   // 628123456789
}

// Encode message
$encodedMessage = urlencode($message);

// Generate link
$whatsappLink = "https://wa.me/{$phoneNumber}?text={$encodedMessage}";
```

**Di Aplikasi:**
- Simpan link di database atau generate on-the-fly
- Tampilkan tombol "Kirim via WhatsApp" di halaman notifikasi
- User klik → WhatsApp membuka dengan draft message

---

#### Metode 2: WhatsApp Business API (Optional - Future Implementation)

Jika ingin automatic messaging tanpa user click:

**Setup Required:**
1. Registrasi di Meta (Facebook) Business Account
2. Create WhatsApp Business Account
3. Generate API Token
4. Verify Business Phone Number

**Keuntungan:**
- Fully automated
- Template messages
- Analytics
- Better for mass messaging

**Implementasi:**
```php
use GuzzleHttp\Client;

public static function sendViaWhatsAppAPI($phoneNumber, $message)
{
    $client = new Client();
    
    $response = $client->post('https://graph.instagram.com/v18.0/YOUR_PHONE_ID/messages', [
        'headers' => [
            'Authorization' => 'Bearer ' . env('WHATSAPP_API_TOKEN'),
            'Content-Type' => 'application/json',
        ],
        'json' => [
            'messaging_product' => 'whatsapp',
            'to' => $phoneNumber,
            'type' => 'text',
            'text' => [
                'preview_url' => true,
                'body' => $message,
            ],
        ],
    ]);
    
    return $response->getStatusCode() === 200;
}
```

---

## Integrasi dengan WhatsApp API

### Phase 1: Current Implementation (WhatsApp Web Links) ✅

**Setup:**
- No additional setup required
- Already implemented in codebase

**Usage:**
```php
// Di Controller atau Service
$whatsappLink = NotificationService::getWhatsAppLinkBansosApproved($penerima);

// Di View (Blade)
<a href="{{ $whatsappLink }}" target="_blank" class="btn btn-success">
    <i class="fab fa-whatsapp"></i> Kirim via WhatsApp
</a>
```

---

### Phase 2: WhatsApp API Integration (Optional)

**Setup Steps:**

1. **Create Meta Business Account**
   - Go to facebook.com/business
   - Setup business account

2. **Setup WhatsApp Business**
   - Go to developers.facebook.com
   - Create WhatsApp Business Account
   - Get Phone Number ID & API Token

3. **Add .env Configuration**
```env
WHATSAPP_ENABLED=true
WHATSAPP_API_TOKEN=your_token_here
WHATSAPP_PHONE_ID=your_phone_id_here
WHATSAPP_BUSINESS_ACCOUNT_ID=your_account_id_here
```

4. **Install Package**
```bash
composer require guzzlehttp/guzzle
```

5. **Create WhatsApp Service**
```php
// app/Services/WhatsAppService.php
namespace App\Services;

use GuzzleHttp\Client;

class WhatsAppService
{
    protected $client;
    protected $apiToken;
    protected $phoneId;
    
    public function __construct()
    {
        $this->client = new Client();
        $this->apiToken = env('WHATSAPP_API_TOKEN');
        $this->phoneId = env('WHATSAPP_PHONE_ID');
    }
    
    public function send($phoneNumber, $message)
    {
        try {
            $response = $this->client->post(
                "https://graph.instagram.com/v18.0/{$this->phoneId}/messages",
                [
                    'headers' => [
                        'Authorization' => "Bearer {$this->apiToken}",
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'messaging_product' => 'whatsapp',
                        'to' => $this->formatPhoneNumber($phoneNumber),
                        'type' => 'text',
                        'text' => ['body' => $message],
                    ],
                ]
            );
            
            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            \Log::error('WhatsApp API Error: ' . $e->getMessage());
            return false;
        }
    }
    
    protected function formatPhoneNumber($phoneNumber)
    {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }
        return $phoneNumber;
    }
}
```

---

## Testing & Troubleshooting

### Common Issues & Solutions

#### 1. WhatsApp Link Tidak Bekerja

**Masalah:** Ketika user klik link, WhatsApp tidak membuka

**Solusi:**
- Pastikan WhatsApp sudah terinstall di device
- Cek format nomor HP (harus format 62XXX, bukan 0XXX)
- Test link: `https://wa.me/628123456789`

```php
// Debug: Cek nomor HP
$user = auth()->user();
echo $user->no_hp;  // Harus format: 628123456789

// Jika masalah, format ulang
$formatted = NotificationService::formatPhoneNumber($user->no_hp);
```

---

#### 2. Message Terpotong atau Error

**Masalah:** WhatsApp menampilkan encoding error pada message

**Solusi:**
- Pastikan menggunakan `urlencode()` untuk message
- Hindari special characters
- Test di: https://www.urlencoder.org/

```php
$message = "Halo Pak, status disetujui";
$encoded = urlencode($message);  // Correct
// Wrong: $encoded = $message;
```

---

#### 3. Nomor HP Tidak Tersimpan

**Masalah:** `$user->no_hp` kosong

**Solusi:**
- Pastikan field `no_hp` di migration & model sudah ada
- Cek field `no_hp` di form registrasi/profile
- Update database jika field belum ada

```bash
# Create migration jika belum ada
php artisan make:migration add_no_hp_to_users_table

# Di migration file:
Schema::table('users', function (Blueprint $table) {
    $table->string('no_hp')->nullable()->after('email');
});

php artisan migrate
```

---

#### 4. Notifikasi Tidak Muncul

**Masalah:** Masyarakat tidak melihat notifikasi di aplikasi

**Solusi:**
- Cek database `notifications` table apakah data tersimpan
- Cek view apakah sudah fetch dari NotificationService
- Cek JavaScript untuk real-time update (jika ada)

```php
// Debug: Check notifications
$notifications = auth()->user()->notifications;
dd($notifications);

// Atau check dengan SQL
SELECT * FROM notifications WHERE user_id = 1 ORDER BY created_at DESC;
```

---

### Testing Checklist

**Manual Testing:**

- [ ] Masyarakat bisa registrasi dan isi nomor HP
- [ ] Admin bisa approve bansos
- [ ] Notifikasi muncul di database (check `notifications` table)
- [ ] Notifikasi muncul di aplikasi web
- [ ] WhatsApp link bisa di-generate
- [ ] WhatsApp link buka aplikasi WhatsApp
- [ ] Message format benar dan tidak terpotong
- [ ] Email notifikasi terkirim
- [ ] Surat pengajuan sama prosesnya seperti bansos

---

### Debugging Commands

```bash
# Check notifications for specific user
php artisan tinker
>>> $user = \App\Models\User::find(1);
>>> $user->notifications;

# Generate WhatsApp link untuk testing
>>> $penerima = \App\Models\PenerimaBansos::find(1);
>>> $link = \App\Services\NotificationService::getWhatsAppLinkBansosApproved($penerima);
>>> echo $link;

# Check unread notifications
>>> $unread = \App\Services\NotificationService::getUnreadCount($user);
>>> echo $unread;

# Mark all as read
>>> \App\Services\NotificationService::markAllAsRead($user);
```

---

## Summary

### Ringkasan Cara Kerja

1. **Masyarakat Daftar** → DB record dibuat + Notifikasi di app
2. **Admin Approve/Reject** → DB diupdate + Notifikasi dibuat + Email dikirim
3. **User Lihat Notifikasi** → Di halaman notifikasi aplikasi web
4. **User Klik "Kirim WhatsApp"** → Link wa.me dibuka
5. **User Kirim Message** → Message sudah di-format dengan info penting

### Key Features

✅ **Dual Channel:** Database Notifications + Email  
✅ **WhatsApp Integration:** Web links (current) + API ready (future)  
✅ **Tracking:** Bisa lihat berapa banyak notifikasi dibaca  
✅ **Flexible:** Mudah ditambah event notifikasi baru  
✅ **Scalable:** Support mass notifications dengan `sendToMany()`  

### Next Steps (Optional)

1. Add WhatsApp Business API untuk automatic messaging
2. Add SMS sebagai fallback jika WhatsApp tidak available
3. Add notification preferences (user bisa pilih channel mana yang diinginkan)
4. Add notification analytics dashboard
5. Add scheduled notifications untuk reminder

---

**Last Updated:** June 24, 2026  
**Status:** ✅ Production Ready
