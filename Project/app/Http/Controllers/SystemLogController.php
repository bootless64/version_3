<?php

namespace App\Http\Controllers;

use App\Models\SystemLog;
use Illuminate\Http\Request;
use App\Services\LoggingService;

class SystemLogController extends Controller
{
    protected $logger;

    public function __construct(LoggingService $logger)
    {
        $this->logger = $logger;
    }

    public function index(Request $request)
    {
        $query = SystemLog::with('user');

        if ($request->filled('date_from')) {
            $query->whereDate('event_time', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('event_time', '<=', $request->date_to);
        }

        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->filled('category')) {
            $query->where('event_category', $request->category);
        }

        if ($request->filled('result')) {
            $query->where('event_result', $request->result == 'true');
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('ip')) {
            $query->where('user_ip', 'like', '%' . $request->ip . '%');
        }

        $logs = $query->orderBy('event_time', 'desc')->paginate(50);

        $categories = SystemLog::select('event_category')
            ->distinct()
            ->pluck('event_category');

        $eventTypes = SystemLog::select('event_type')
            ->distinct()
            ->pluck('event_type');

        return view('dashboard.manage-logs', compact('logs', 'categories', 'eventTypes'));
    }

    public function show($id)
    {
        $log = SystemLog::with('user')->findOrFail($id);
        return view('dashboard.log-detail', compact('log'));
    }

    public function destroy($id)
    {
        $log = SystemLog::findOrFail($id);
        $log->delete();

        $this->logger->logDataDelete('system_log', $id, ['log_id' => $id]);

        return back()->with('success', 'لاگ با موفقیت حذف شد.');
    }

    public function clearOld(Request $request)
    {
        $days = $request->input('days', 30);
        $count = SystemLog::where('event_time', '<', now()->subDays($days))->delete();

        $this->logger->logConfigurationChanged('logs_retention', $days . ' days', $days . ' days (cleared)');

        return back()->with('success', $count . ' رکورد لاگ قدیمی حذف شد.');
    }
}