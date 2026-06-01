<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogService
{
    /**
     * Get filtered activity logs
     */
    public function getFilteredLogs($filters = [])
    {
        $query = ActivityLog::with('user');

        if (!empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (!empty($filters['model_type'])) {
            $query->where('model_type', $filters['model_type']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (!empty($filters['from_date'])) {
            $query->where('created_at', '>=', $filters['from_date'] . ' 00:00:00');
        }

        if (!empty($filters['to_date'])) {
            $query->where('created_at', '<=', $filters['to_date'] . ' 23:59:59');
        }

        return $query->orderBy('created_at', 'desc')->paginate(50);
    }

    /**
     * Get activity statistics
     */
    public function getStatistics()
    {
        return [
            'total_logs' => ActivityLog::count(),
            'today_logs' => ActivityLog::whereDate('created_at', today())->count(),
            'this_week_logs' => ActivityLog::where('created_at', '>=', now()->subDays(7))->count(),
            'by_action' => ActivityLog::selectRaw('action, COUNT(*) as count')
                ->groupBy('action')
                ->get(),
            'by_model' => ActivityLog::selectRaw('model_type, COUNT(*) as count')
                ->groupBy('model_type')
                ->get(),
        ];
    }

    /**
     * Get activity log detail
     */
    public function getDetail($id)
    {
        return ActivityLog::with('user')->findOrFail($id);
    }

    /**
     * Log activity
     */
    public function log($action, $modelType, $modelId, $description = null, $oldValues = null, $newValues = null)
    {
        return ActivityLog::log($action, $modelType, $modelId, $description, $oldValues, $newValues);
    }
}
