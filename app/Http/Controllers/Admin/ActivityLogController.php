<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display activity logs
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by model type
        if ($request->filled('model_type')) {
            $query->where('model_type', $request->model_type);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->where('created_at', '>=', $request->from_date . ' 00:00:00');
        }

        if ($request->filled('to_date')) {
            $query->where('created_at', '<=', $request->to_date . ' 23:59:59');
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(50);

        return view('admin.activity-logs.index', compact('logs'));
    }

    /**
     * Show activity log detail
     */
    public function show($id)
    {
        $log = ActivityLog::with('user')->findOrFail($id);
        return view('admin.activity-logs.show', compact('log'));
    }

    /**
     * Get activity statistics
     */
    public function statistics()
    {
        $stats = [
            'total_logs' => ActivityLog::count(),
            'today_logs' => ActivityLog::whereDate('created_at', today())->count(),
            'this_week_logs' => ActivityLog::where('created_at', '>=', now()->subDays(7))->count(),
            'by_action' => ActivityLog::selectRaw('action, COUNT(*) as count')
                ->groupBy('action')
                ->get(),
            'by_model' => ActivityLog::selectRaw('model_type, COUNT(*) as count')
                ->groupBy('model_type')
                ->get(),
            'by_user' => ActivityLog::selectRaw('user_id, COUNT(*) as count')
                ->with('user')
                ->groupBy('user_id')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get(),
        ];

        return response()->json($stats);
    }
}
