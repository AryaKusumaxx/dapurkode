<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use App\Models\WarrantyExtension;
use App\Services\OrderStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display user dashboard.
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        
        // Get recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->with(['items.product'])
            ->latest()
            ->limit(5)
            ->get();
            
        // Get active warranties
        $activeWarranties = $user->warranties()
            ->where('end_date', '>=', now())
            ->where('is_active', true)
            ->with(['orderItem.product'])
            ->limit(5)
            ->get();
            
        // Counts for dashboard stats
        $orderCount = Order::where('user_id', $user->id)->count();
        $completedOrderCount = Order::where('user_id', $user->id)->where('status', 'completed')->count();
        $pendingOrderCount = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $warrantyCount = $user->warranties()->where('end_date', '>=', now())->where('is_active', true)->count();
            
        // Get unpaid invoices
        $unpaidInvoices = Invoice::whereHas('order', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', Invoice::STATUS_UNPAID)
            ->where('due_date', '>=', now())
            ->with(['order'])
            ->get();
            
        return view('user.dashboard', compact(
            'recentOrders',
            'activeWarranties',
            'unpaidInvoices',
            'orderCount',
            'completedOrderCount',
            'pendingOrderCount',
            'warrantyCount'
        ));
    }
    
    /**
     * Display user orders.
     */
    public function orders(Request $request): View
    {
        $query = Order::where('user_id', Auth::id())->with(['items.product', 'invoice']);
        
        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by date period if provided
        if ($request->has('period') && $request->period) {
            $days = match ($request->period) {
                '7days' => 7,
                '30days' => 30,
                '90days' => 90,
                default => null,
            };
            
            if ($days) {
                $query->where('created_at', '>=', now()->subDays($days));
            }
        }
        
        $orders = $query->latest()->paginate(10);
            
        return view('user.orders', compact('orders'));
    }
    
    /**
     * Display user invoices.
     */
    public function invoices(Request $request): View
    {
        $query = Invoice::whereHas('order', function($query) {
                $query->where('user_id', Auth::id());
            })
            ->with(['order', 'payments']);
            
        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
            
        $invoices = $query->latest()->paginate(10);
            
        return view('user.invoices', compact('invoices'));
    }
    
    /**
     * Display user warranties.
     */
    public function warranties(): View
    {
        $user = Auth::user();
        $warranties = $user->warranties()
            ->with('orderItem.product')
            ->latest()
            ->paginate(10);
            
        return view('user.warranties', compact('warranties'));
    }
    
    /**
     * Display user profile.
     */
    public function profile(): View
    {
        $user = Auth::user();
        
        return view('user.profile', compact('user'));
    }
    
    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:1024', // Max 1MB
        ]);
        
        // Upload avatar if provided
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }
        
        $user->update($validated);
        
        return redirect()->route('user.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
    
    /**
     * Show the change password form.
     */
    public function showChangePasswordForm(): View
    {
        return view('user.change-password');
    }
    
    /**
     * Change user password.
     */
    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        
        $user = Auth::user();
        
        // Verify current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini salah.']);
        }
        
        // Update password
        $user->password = Hash::make($validated['new_password']);
        $user->save();
        
        return redirect()->route('user.profile')
            ->with('success', 'Password berhasil diubah.');
    }
}
