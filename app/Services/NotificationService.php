<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use App\Mail\BansosApprovedMail;
use App\Mail\BansosRejectedMail;
use App\Mail\LetterCompletedMail;
use App\Mail\LetterRejectedMail;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Send notification to user
     */
    public static function send(User $user, string $type, string $title, string $message, array $data = [])
    {
        return Notification::create([
            'user_id' => $user->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'sent_at' => now(),
        ]);
    }

    /**
     * Send notification to multiple users
     */
    public static function sendToMany(array $users, string $type, string $title, string $message, array $data = [])
    {
        $notifications = [];
        foreach ($users as $user) {
            $notifications[] = [
                'user_id' => $user->id,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'data' => json_encode($data),
                'sent_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return Notification::insert($notifications);
    }

    /**
     * Send notification for new complaint
     */
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

    /**
     * Send notification for complaint status change
     */
    public static function notifyComplaintStatusChange($pengaduan, $oldStatus)
    {
        $statusLabels = [
            'baru' => 'Baru',
            'diproses' => 'Diproses',
            'selesai' => 'Selesai',
            'ditolak' => 'Ditolak',
        ];

        return self::send(
            $pengaduan->user,
            'pengaduan',
            'Status Pengaduan Berubah',
            'Status pengaduan Anda telah berubah dari ' . $statusLabels[$oldStatus] . ' menjadi ' . $statusLabels[$pengaduan->status] . '.',
            ['pengaduan_id' => $pengaduan->id, 'status' => $pengaduan->status]
        );
    }

    /**
     * Send notification for new bansos application
     */
    public static function notifyNewBansosApplication($penerima)
    {
        return self::send(
            $penerima->user,
            'bansos',
            'Pendaftaran Bansos Berhasil',
            'Pendaftaran Anda untuk program "' . $penerima->bansos->nama_bansos . '" telah berhasil diterima. Silakan tunggu verifikasi dari admin.',
            ['penerima_id' => $penerima->id, 'bansos_id' => $penerima->bansos_id]
        );
    }

    /**
     * Send notification for bansos application status change
     */
    public static function notifyBansosStatusChange($penerima, $oldStatus)
    {
        $statusLabels = [
            'menunggu' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
        ];

        $message = 'Status pendaftaran Anda untuk program "' . $penerima->bansos->nama_bansos . '" telah berubah menjadi ' . $statusLabels[$penerima->status] . '.';
        
        if ($penerima->status === 'disetujui') {
            $message .= ' Nominal yang akan Anda terima adalah Rp ' . number_format($penerima->nominal_diterima, 0, ',', '.');
            // Send email
            try {
                Mail::to($penerima->user->email)->send(new BansosApprovedMail($penerima));
            } catch (\Exception $e) {
                \Log::error('Email error: ' . $e->getMessage());
            }
        } elseif ($penerima->status === 'ditolak' && $penerima->alasan_penolakan) {
            $message .= ' Alasan: ' . $penerima->alasan_penolakan;
            // Send email
            try {
                Mail::to($penerima->user->email)->send(new BansosRejectedMail($penerima));
            } catch (\Exception $e) {
                \Log::error('Email error: ' . $e->getMessage());
            }
        }

        return self::send(
            $penerima->user,
            'bansos',
            'Status Pendaftaran Bansos Berubah',
            $message,
            ['penerima_id' => $penerima->id, 'status' => $penerima->status]
        );
    }

    /**
     * Get unread notifications count for user
     */
    public static function getUnreadCount(User $user)
    {
        return Notification::where('user_id', $user->id)->unread()->count();
    }

    /**
     * Get unread notifications for user
     */
    public static function getUnread(User $user, $limit = 10)
    {
        return Notification::where('user_id', $user->id)
            ->unread()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get all notifications for user
     */
    public static function getAll(User $user, $limit = 20)
    {
        return Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Mark notification as read
     */
    public static function markAsRead(Notification $notification)
    {
        $notification->markAsRead();
    }

    /**
     * Mark all notifications as read for user
     */
    public static function markAllAsRead(User $user)
    {
        Notification::where('user_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    /**
     * Delete old notifications (older than 30 days)
     */
    public static function deleteOldNotifications($days = 30)
    {
        Notification::where('created_at', '<', now()->subDays($days))->delete();
    }

    /**
     * Generate WhatsApp message link for bansos approval
     */
    public static function getWhatsAppLinkBansosApproved($penerima)
    {
        $user = $penerima->user;
        $bansos = $penerima->bansos;
        
        if (empty($user->no_hp)) {
            return null;
        }

        $message = "*SELAMAT! BANSOS DISETUJUI* ✅\n\n";
        $message .= "Yth. Bapak/Ibu *{$user->name}*\n\n";
        $message .= "Kami informasikan bahwa pendaftaran Anda untuk program bantuan sosial telah *DISETUJUI*:\n\n";
        $message .= "📋 *Program:* {$bansos->nama_bansos}\n";
        $message .= "💰 *Nominal:* Rp " . number_format($penerima->nominal_diterima, 0, ',', '.') . "\n";
        
        if ($penerima->tanggal_penerimaan) {
            $message .= "📅 *Tanggal Persetujuan:* " . $penerima->tanggal_penerimaan->format('d/m/Y') . "\n\n";
        } else {
            $message .= "📅 *Tanggal Persetujuan:* " . now()->format('d/m/Y') . "\n\n";
        }
        
        $message .= "Silakan hubungi kantor desa untuk informasi lebih lanjut mengenai proses pencairan bantuan.\n\n";
        $message .= "_Selamat dan semoga bermanfaat._\n";
        $message .= "Sistem Informasi Desa";

        return self::generateWhatsAppLink($user->no_hp, $message);
    }

    /**
     * Generate WhatsApp message link for bansos rejection
     */
    public static function getWhatsAppLinkBansosRejected($penerima)
    {
        $user = $penerima->user;
        $bansos = $penerima->bansos;
        
        if (empty($user->no_hp)) {
            return null;
        }

        $message = "*PEMBERITAHUAN STATUS BANSOS* ❌\n\n";
        $message .= "Yth. Bapak/Ibu *{$user->name}*\n\n";
        $message .= "Kami informasikan bahwa pendaftaran Anda untuk program bantuan sosial tidak dapat disetujui:\n\n";
        $message .= "📋 *Program:* {$bansos->nama_bansos}\n";
        $message .= "❌ *Status:* Ditolak\n";
        
        if (!empty($penerima->alasan_penolakan)) {
            $message .= "📝 *Alasan:* {$penerima->alasan_penolakan}\n";
        }
        
        $message .= "\nAnda dapat mendaftar kembali pada program bantuan sosial lainnya yang sesuai dengan kriteria.\n\n";
        $message .= "Untuk informasi lebih lanjut, silakan hubungi kantor desa.\n\n";
        $message .= "_Terima kasih atas pengertiannya._\n";
        $message .= "Sistem Informasi Desa";

        return self::generateWhatsAppLink($user->no_hp, $message);
    }

    /**
     * Generate WhatsApp message link for letter completion
     */
    public static function getWhatsAppLinkLetterCompleted($pengajuan)
    {
        $user = $pengajuan->user;
        $jenisSurat = $pengajuan->jenisSurat;
        
        if (empty($user->no_hp)) {
            return null;
        }

        $message = "*SURAT SUDAH SELESAI* ✅\n\n";
        $message .= "Yth. Bapak/Ibu *{$user->name}*\n\n";
        $message .= "Kami informasikan bahwa pengajuan surat Anda telah selesai diproses:\n\n";
        $message .= "📄 *Jenis Surat:* {$jenisSurat->nama_surat}\n";
        $message .= "📅 *Tanggal Pengajuan:* " . $pengajuan->created_at->format('d/m/Y') . "\n";
        $message .= "✅ *Status:* Selesai\n";
        $message .= "📥 *Nomor Surat:* {$pengajuan->nomor_surat}\n\n";
        
        if (!empty($pengajuan->catatan_kades)) {
            $message .= "📝 *Catatan:* {$pengajuan->catatan_kades}\n\n";
        }
        
        $message .= "Surat dapat diambil di kantor desa atau diunduh melalui sistem.\n\n";
        $message .= "_Terima kasih._\n";
        $message .= "Sistem Informasi Desa";

        return self::generateWhatsAppLink($user->no_hp, $message);
    }

    /**
     * Generate WhatsApp message link for letter rejection
     */
    public static function getWhatsAppLinkLetterRejected($pengajuan)
    {
        $user = $pengajuan->user;
        $jenisSurat = $pengajuan->jenisSurat;
        
        if (empty($user->no_hp)) {
            return null;
        }

        $message = "*PEMBERITAHUAN PENGAJUAN SURAT* ❌\n\n";
        $message .= "Yth. Bapak/Ibu *{$user->name}*\n\n";
        $message .= "Kami informasikan bahwa pengajuan surat Anda tidak dapat diproses:\n\n";
        $message .= "📄 *Jenis Surat:* {$jenisSurat->nama_surat}\n";
        $message .= "📅 *Tanggal Pengajuan:* " . $pengajuan->created_at->format('d/m/Y') . "\n";
        $message .= "❌ *Status:* Ditolak\n";
        
        if (!empty($pengajuan->catatan_kades)) {
            $message .= "📝 *Alasan:* {$pengajuan->catatan_kades}\n";
        }
        
        $message .= "\nUntuk informasi lebih lanjut, silakan hubungi kantor desa.\n\n";
        $message .= "_Terima kasih atas pengertiannya._\n";
        $message .= "Sistem Informasi Desa";

        return self::generateWhatsAppLink($user->no_hp, $message);
    }

    /**
     * Generate wa.me link with message
     */
    protected static function generateWhatsAppLink($phoneNumber, $message)
    {
        // Format phone number (remove leading 0, add 62 for Indonesia)
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        } elseif (substr($phoneNumber, 0, 2) !== '62') {
            $phoneNumber = '62' . $phoneNumber;
        }

        // URL encode the message
        $encodedMessage = urlencode($message);

        return "https://wa.me/{$phoneNumber}?text={$encodedMessage}";
    }

    /**
     * Send email notification for letter completion
     */
    public static function sendLetterCompletedEmail($pengajuan)
    {
        try {
            Mail::to($pengajuan->user->email)->send(new LetterCompletedMail($pengajuan));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send email notification for letter rejection
     */
    public static function sendLetterRejectedEmail($pengajuan)
    {
        try {
            Mail::to($pengajuan->user->email)->send(new LetterRejectedMail($pengajuan));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send email notification for bansos approval
     */
    public static function sendBansosApprovedEmail($penerima)
    {
        try {
            Mail::to($penerima->user->email)->send(new BansosApprovedMail($penerima));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send email notification for bansos rejection
     */
    public static function sendBansosRejectedEmail($penerima)
    {
        try {
            Mail::to($penerima->user->email)->send(new BansosRejectedMail($penerima));
            return true;
        } catch (\Exception $e) {
            \Log::error('Email error: ' . $e->getMessage());
            return false;
        }
    }
}

