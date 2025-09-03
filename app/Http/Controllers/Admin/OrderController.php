<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of orders.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Order::class);
        
        $status = $request->get('status');
        $query = Order::with(['user', 'items.product']);
        
        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }
        
        $orders = $query->latest()->paginate(10);
        
        return view('admin.orders.index', compact('orders'));
    }
    
    /**
     * Display the specified order.
     */
    public function show(Order $order): View
    {
        $this->authorize('view', $order);
        
        $order->load(['user', 'items.product', 'items.variant', 'items.warranty', 'invoice.payments']);
        
        return view('admin.orders.show', compact('order'));
    }
    
    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', [
                Order::STATUS_PENDING,
                Order::STATUS_PAID,
                Order::STATUS_COMPLETED,
                Order::STATUS_CANCELLED,
            ]),
        ]);
        
        $order->update([
            'status' => $validated['status'],
        ]);
        
        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
