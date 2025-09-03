<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of pending payments.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Payment::class);
        
        $status = $request->get('status', 'pending');
        
        $payments = Payment::with(['invoice.order.user'])
            ->where('status', $status)
            ->latest()
            ->paginate(10);
            
        return view('admin.payments.index', compact('payments', 'status'));
    }
    
    /**
     * Show payment details.
     */
    public function show(Payment $payment): View
    {
        $this->authorize('view', $payment);
        
        $payment->load(['invoice.order.user', 'invoice.order.items.product']);
        
        return view('admin.payments.show', compact('payment'));
    }
    
    /**
     * Verify a payment (for admin only).
     */
    public function verify(Payment $payment)
    {
        $this->authorize('verify', $payment);
        
        // Delegate to PaymentController verify method
        return app(\App\Http\Controllers\PaymentController::class)->verify($payment);
    }
    
    /**
     * Reject a payment (for admin only).
     */
    public function reject(Request $request, Payment $payment)
    {
        $this->authorize('verify', $payment);
        
        // Delegate to PaymentController reject method
        return app(\App\Http\Controllers\PaymentController::class)->reject($request, $payment);
    }
}
