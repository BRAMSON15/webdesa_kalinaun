<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;

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
        } elseif ($penerima->status === 'ditolak' && $penerima->alasan_penolakan) {
            $message .= ' Alasan: ' . $penerima->alasan_penolakan;
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
}
