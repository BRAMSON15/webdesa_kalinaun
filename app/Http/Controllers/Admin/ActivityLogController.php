<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    private $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index(Request $request)
    {
        $logs = $this->activityLogService->getFilteredLogs($request->all());
        return view('admin.activity-logs.index', compact('logs'));
    }

    public function show($id)
    {
        $log = $this->activityLogService->getDetail($id);
        return view('admin.activity-logs.show', compact('log'));
    }

    public function statistics()
    {
        $stats = $this->activityLogService->getStatistics();
        return response()->json($stats);
    }
}
