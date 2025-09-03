<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\WarrantyExtension;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaymentController extends Controller
{
    use AuthorizesRequests;
    
    public function __construct()
    {
        // Constructor
    }
    
    /**
     * Display the payment form for an invoice.
     */
    public function show(Invoice $invoice): View
    {
        // Ensure current user owns the invoice
        if ($invoice->order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }
        
        // Load related data
        $invoice->load(['order.items.product', 'order.items.variant', 'order.items.warranty']);
        
        return view('payment.show', compact('invoice'));
    }
    
    /**
     * Store a new payment.
     */
    public function store(Request $request, Invoice $invoice)
    {
        // Ensure current user owns the invoice
        if ($invoice->order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke invoice ini.');
        }
        
        // Check if invoice amount is valid
        if ($invoice->amount <= 0) {
            return redirect()->back()
                ->with('error', 'Total pembayaran tidak valid. Silakan hubungi admin.');
        }
        
        // Log untuk debug
        \Log::info('Payment request received', [
            'method' => $request->payment_method,
            'bank' => $request->bank,
            'has_file' => $request->hasFile('proof_image'),
        ]);
        
        // Validate request dengan validasi yang lebih sederhana
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'bank' => 'required_if:payment_method,bank_transfer|string',
            'reference_number' => 'nullable|string|max:50',
            'proof_image' => 'required|file|max:2048', // Max 2MB, validasi lebih longgar
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Store proof image dengan penanganan kesalahan yang lebih baik
        $imagePath = null;
        if ($request->hasFile('proof_image')) {
            try {
                // Pastikan folder ada
                if (!file_exists(storage_path('app/public/payment_proofs'))) {
                    Storage::disk('public')->makeDirectory('payment_proofs');
                }
                
                // Simpan file dengan nama yang unik
                $file = $request->file('proof_image');
                $imageName = time() . '_' . $file->getClientOriginalName();
                $imagePath = $file->storeAs('payment_proofs', $imageName, 'public');
                
                \Log::info('File saved successfully', ['path' => $imagePath]);
            } catch (\Exception $fileEx) {
                \Log::error('File upload error: ' . $fileEx->getMessage());
                return redirect()->back()
                    ->with('error', 'Gagal upload file bukti pembayaran: ' . $fileEx->getMessage())
                    ->withInput();
            }
        } else {
            \Log::warning('No file uploaded in request');
        }
        
        DB::beginTransaction();
        
        try {
            // Tambah logging untuk debug
            \Log::info('Payment attempt data:', [
                'invoice_id' => $invoice->id,
                'user_id' => Auth::id(),
                'payment_method' => $validated['payment_method'],
                'bank' => $validated['bank'] ?? null,
                'reference_number' => $validated['reference_number'] ?? null,
                'proof_image' => $imagePath,
                'amount' => $invoice->amount
            ]);
            
            // Create payment
            Payment::create([
                'invoice_id' => $invoice->id,
                'user_id' => Auth::id(),
                'payment_method' => $validated['payment_method'],
                'bank' => $validated['bank'] ?? null,
                'reference_number' => $validated['reference_number'] ?? null,
                'proof_image' => $imagePath,
                'amount' => $invoice->amount,
                'payment_date' => now(),
                'status' => Payment::STATUS_PENDING,
                'notes' => $validated['notes'] ?? null,
            ]);
            
            // Update invoice status to pending confirmation
            $invoice->update([
                'status' => Invoice::STATUS_PENDING_CONFIRMATION,
            ]);
            
            DB::commit();
            
            return redirect()->route('user.invoices')
                ->with('success', 'Pembayaran berhasil diupload dan sedang menunggu verifikasi.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error untuk debugging
            \Log::error('Payment processing error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            // Delete uploaded image if exists
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Admin: Verify a payment.
     */
    public function verify(Payment $payment)
    {
        $this->authorize('verify', $payment);
        
        DB::beginTransaction();
        
        try {
            // Log untuk debugging
            \Log::info('Verifikasi pembayaran dimulai', [
                'payment_id' => $payment->id,
                'user_id' => Auth::id(),
                'payment_status' => $payment->status
            ]);
            
            // Update payment status
            $payment->update([
                'status' => Payment::STATUS_VERIFIED,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
            ]);
            
            // Update invoice status
            $invoice = $payment->invoice;
            \Log::info('Invoice ditemukan', [
                'invoice_id' => $invoice->id,
                'invoice_status' => $invoice->status
            ]);
            
            $invoice->update([
                'status' => Invoice::STATUS_PAID,
            ]);
            
            // Update order status
            $order = $invoice->order;
            \Log::info('Order ditemukan', [
                'order_id' => $order->id,
                'order_status' => $order->status
            ]);
            
            $order->update([
                'status' => Order::STATUS_PAID,
            ]);
            
            // Memastikan order items dimuat
            $order->load('items');
            
            // Activate warranty for order items
            $warrantyService = new \App\Services\WarrantyService();
            
            // Log untuk debug
            \Log::info('Memproses order items', [
                'order_id' => $order->id,
                'has_items' => $order->items !== null,
                'items_count' => $order->items ? $order->items->count() : 0
            ]);
            
            // Pastikan order->items tidak null sebelum iterasi
            if ($order->items && $order->items->count() > 0) {
                foreach ($order->items as $item) {
                    // Activate primary warranty if it has warranty months
                    if ($item->warranty_months > 0 && !$item->warranty) {
                        $warrantyService->createWarranty($item);
                    }
                    
                    // Activate warranty extensions if any
                    if ($item->warrantyExtension) {
                        $item->warrantyExtension->update([
                            'status' => WarrantyExtension::STATUS_PAID,
                        ]);
                    }
                }
            }
            
            DB::commit();
            
            return redirect()->route('admin.payments.index')
                ->with('success', 'Pembayaran berhasil diverifikasi.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error untuk debugging
            \Log::error('Error saat memverifikasi pembayaran:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memverifikasi pembayaran: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    /**
     * Admin: Reject a payment.
     */
    public function reject(Request $request, Payment $payment)
    {
        $this->authorize('verify', $payment);
        
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Update payment status
            $payment->update([
                'status' => Payment::STATUS_REJECTED,
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'notes' => $validated['rejection_reason'],
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.payments.index')
                ->with('success', 'Pembayaran berhasil ditolak.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menolak pembayaran.')
                ->withInput();
        }
    }
}
