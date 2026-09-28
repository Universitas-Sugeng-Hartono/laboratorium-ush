<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of audit logs with filters and summary statistics.
     */
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->filter($request);

        // Calculate summary cards
        $totalLogs   = AuditLog::count();
        $todayLogs   = AuditLog::whereDate('created_at', today())->count();
        $updateLogs  = AuditLog::whereIn('action', ['UPDATE', 'STATUS_CHANGE'])->count();
        $deleteLogs  = AuditLog::where('action', 'DELETE')->count();

        // Get filter dropdown options
        $modules = AuditLog::select('module')->distinct()->whereNotNull('module')->orderBy('module')->pluck('module');
        $actions = AuditLog::select('action')->distinct()->whereNotNull('action')->orderBy('action')->pluck('action');
        $users   = User::select('id', 'name', 'role')->orderBy('name')->get();

        $perPage = in_array((int)$request->get('per_page'), [10, 25, 50, 100]) ? (int)$request->get('per_page') : 25;
        $logs = $query->latest('created_at')->paginate($perPage)->withQueryString();

        return view('audit.index', compact(
            'logs',
            'totalLogs',
            'todayLogs',
            'updateLogs',
            'deleteLogs',
            'modules',
            'actions',
            'users'
        ));
    }

    /**
     * Return JSON details for modal diff view.
     */
    public function show($id)
    {
        $log = AuditLog::with('user')->findOrFail($id);

        return response()->json([
            'id'           => $log->id,
            'user_name'    => $log->user_name ?? ($log->user->name ?? 'Sistem / Tamu'),
            'user_role'    => $log->user_role ?? ($log->user->role ?? '-'),
            'action'       => $log->action,
            'module'       => $log->module,
            'record_id'    => $log->record_id,
            'record_label' => $log->record_label,
            'description'  => $log->description,
            'old_values'   => $log->old_values,
            'new_values'   => $log->new_values,
            'ip_address'   => $log->ip_address,
            'user_agent'   => $log->user_agent,
            'created_at'   => $log->created_at ? $log->created_at->format('d M Y, H:i:s') : '-',
        ]);
    }
}
