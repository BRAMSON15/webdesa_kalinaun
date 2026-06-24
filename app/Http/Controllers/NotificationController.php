<?php

namespace App\Http\Controllers;

use App\Services\NotificationManagementService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationManagementService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Get unread notifications count
     */
    public function getUnreadCount()
    {
        $count = $this->notificationService->getUnreadCount(auth()->id());
        return response()->json(['count' => $count]);
    }

    /**
     * Get unread notifications
     */
    public function getUnread()
    {
        $notifications = $this->notificationService->getUnread(auth()->id());
        return response()->json($notifications);
    }

    /**
     * Get all notifications
     */
    public function index()
    {
        $notifications = $this->notificationService->getAllNotifications(auth()->id());
        return view('Masyarakat.notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId)
    {
        try {
            $this->notificationService->markAsRead($notificationId, auth()->id());
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 403);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $this->notificationService->markAllAsRead(auth()->id());
        return response()->json(['success' => true]);
    }

    /**
     * Delete notification
     */
    public function destroy($notificationId)
    {
        try {
            $this->notificationService->deleteNotification($notificationId, auth()->id());
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 403);
        }
    }

    /**
     * Delete all notifications
     */
    public function deleteAll()
    {
        $this->notificationService->deleteAllNotifications(auth()->id());
        return response()->json(['success' => true]);
    }
}
