<?php

namespace App\Services;

use App\Models\Notification;

class NotificationManagementService
{
    /**
     * Get unread notifications count
     */
    public function getUnreadCount($userId)
    {
        return Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();
    }

    /**
     * Get unread notifications
     */
    public function getUnread($userId, $limit = 10)
    {
        return Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get all notifications with pagination
     */
    public function getAllNotifications($userId, $perPage = 20)
    {
        return Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId, $userId)
    {
        $notification = Notification::findOrFail($notificationId);

        if ($notification->user_id !== $userId) {
            throw new \Exception('Unauthorized');
        }

        $notification->markAsRead();
        return $notification;
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead($userId)
    {
        Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return true;
    }

    /**
     * Delete notification
     */
    public function deleteNotification($notificationId, $userId)
    {
        $notification = Notification::findOrFail($notificationId);

        if ($notification->user_id !== $userId) {
            throw new \Exception('Unauthorized');
        }

        $notification->delete();
        return true;
    }

    /**
     * Delete all notifications
     */
    public function deleteAllNotifications($userId)
    {
        Notification::where('user_id', $userId)->delete();
        return true;
    }
}
