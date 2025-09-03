<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DashboardController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display admin dashboard.
     */
    public function index(): View
    {
        // Check if user has admin or superadmin role
        if (!auth()->user()->hasRole(['admin', 'superadmin'])) {
            abort(403, 'Unauthorized action.');
        }
        
        // Summary statistics
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Invoice::where('status', Invoice::STATUS_PAID)->sum('amount'),
        ];
        
        // Recent orders
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->limit(5)
            ->get();
            
        // Pending payments
        $pendingPayments = Payment::where('status', Payment::STATUS_PENDING)
            ->with(['invoice.order.user'])
            ->latest()
            ->limit(5)
            ->get();
            
        // Monthly revenue chart data
        $monthlyRevenue = Invoice::where('status', Invoice::STATUS_PAID)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
            
        // Format chart data
        $chartData = [];
        $months = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec'
        ];
        
        foreach ($months as $monthNum => $monthName) {
            $revenue = 0;
            
            $entry = $monthlyRevenue->first(function ($item) use ($monthNum) {
                return $item->month == $monthNum;
            });
            
            if ($entry) {
                $revenue = $entry->total_amount;
            }
            
            $chartData[] = [
                'month' => $monthName,
                'revenue' => $revenue,
            ];
        }
        
        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'pendingPayments',
            'chartData'
        ));
    }
}
