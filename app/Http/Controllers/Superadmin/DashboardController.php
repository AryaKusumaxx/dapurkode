<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Models\Warranty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    /**
     * Display the superadmin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get stats for dashboard
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalPayments = Payment::count();
        $activeWarranties = Warranty::where('expires_at', '>', now())->count();

        // Get recent audit logs
        $recentAuditLogs = AuditLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Get roles with user count
        $roles = Role::withCount('users')
            ->take(3)
            ->get();

        // Get latest backup info
        $latestBackup = null;
        $backupSize = null;
        
        // In a real app, you would have logic here to get backup information
        // For demonstration purposes, we'll use mock data
        $latestBackup = Carbon::now()->subDays(2);
        $backupSize = '15.4 MB';

        return view('superadmin.dashboard', compact(
            'totalUsers',
            'totalProducts',
            'totalPayments',
            'activeWarranties',
            'recentAuditLogs',
            'roles',
            'latestBackup',
            'backupSize'
        ));
    }
}
