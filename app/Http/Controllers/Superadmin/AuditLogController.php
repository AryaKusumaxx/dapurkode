<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AuditLogController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of audit logs.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAuditLogs');
        
        $query = AuditLog::with(['user']);
        
        // Filter by type
        if ($request->has('type')) {
            $query->where('log_type', $request->type);
        }
        
        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        // Filter by date range
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $auditLogs = $query->latest()->paginate(20);
        
        return view('superadmin.audit-logs.index', compact('auditLogs'));
    }
    
    /**
     * Display the specified audit log.
     */
    public function show(AuditLog $auditLog): View
    {
        $this->authorize('viewAuditLogs');
        
        $auditLog->load('user');
        
        return view('superadmin.audit-logs.show', compact('auditLog'));
    }
}
