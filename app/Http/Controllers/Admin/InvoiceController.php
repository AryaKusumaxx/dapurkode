<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InvoiceController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of invoices.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Invoice::class);
        
        $status = $request->get('status', 'all');
        
        $query = Invoice::with(['order.user']);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $invoices = $query->latest()->paginate(10);
        
        return view('admin.invoices.index', compact('invoices', 'status'));
    }
    
    /**
     * Show invoice details.
     */
    public function show(Invoice $invoice): View
    {
        $this->authorize('view', $invoice);
        
        $invoice->load(['order.user', 'order.items.product', 'payments']);
        
        return view('admin.invoices.show', compact('invoice'));
    }
}
