<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warranty;
use App\Models\WarrantyExtension;
use App\Models\AuditLog;
use App\Services\WarrantyService;
use App\Services\WarrantyAuditService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WarrantyController extends Controller
{
    protected $warrantyService;
    protected $warrantyAuditService;
    
    /**
     * Create a new controller instance.
     *
     * @param WarrantyService $warrantyService
     * @param WarrantyAuditService $warrantyAuditService
     * @return void
     */
    public function __construct(WarrantyService $warrantyService, WarrantyAuditService $warrantyAuditService)
    {
        $this->warrantyService = $warrantyService;
        $this->warrantyAuditService = $warrantyAuditService;
    }
    
    /**
     * Display a listing of the warranties.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = Warranty::with(['orderItem.product', 'orderItem.order.user']);
        
        // Filter by status if provided
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true)
                     ->where('end_date', '>=', now());
            } elseif ($request->status === 'expired') {
                $query->where(function ($q) {
                    $q->where('is_active', false)
                      ->orWhere('end_date', '<', now());
                });
            }
        }
        
        // Filter by product if provided
        if ($request->has('product') && $request->product) {
            $query->whereHas('orderItem', function ($q) use ($request) {
                $q->where('product_id', $request->product);
            });
        }
        
        $warranties = $query->latest()->paginate(15);
        
        // Get statistics for dashboard cards
        $totalWarranties = Warranty::count();
        $activeWarranties = Warranty::where('is_active', true)
            ->where('end_date', '>=', now())
            ->count();
        $expiredWarranties = Warranty::where(function ($query) {
            $query->where('is_active', false)
                ->orWhere('end_date', '<', now());
        })->count();
        $warrantyExtensions = \App\Models\WarrantyExtension::count();
        
        return view('admin.warranties.index', compact('warranties', 'totalWarranties', 'activeWarranties', 'expiredWarranties', 'warrantyExtensions'));
    }
    
    /**
     * Display the specified warranty.
     *
     * @param Warranty $warranty
     * @return View
     */
    public function show(Warranty $warranty): View
    {
        // Eager load related models
        $warranty->load([
            'orderItem.product', 
            'orderItem.order.user', 
            'extensions.user'
        ]);
        
        // Calculate remaining days
        $remainingDays = $this->warrantyService->getRemainingDays($warranty);
        
        return view('admin.warranties.show', compact('warranty', 'remainingDays'));
    }
    
    /**
     * Update the warranty status.
     *
     * @param Request $request
     * @param Warranty $warranty
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Warranty $warranty)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);
        
        $oldStatus = $warranty->is_active ? 'aktif' : 'non-aktif';
        $newStatus = $validated['is_active'] ? 'aktif' : 'non-aktif';
        
        $warranty->update([
            'is_active' => $validated['is_active'],
            'notes' => $warranty->notes ? $warranty->notes . "\nStatus diubah oleh admin pada " . now()->format('Y-m-d H:i:s') : "Status diubah oleh admin pada " . now()->format('Y-m-d H:i:s'),
        ]);
        
        // Log this action
        $this->warrantyAuditService->logWarrantyAction(
            $warranty,
            'update_status',
            "Status garansi #" . $warranty->id . " diubah dari {$oldStatus} menjadi {$newStatus}"
        );
        
        return redirect()->route('admin.warranties.show', $warranty)
            ->with('success', 'Status garansi berhasil diperbarui.');
    }
    
    /**
     * Add a note to the warranty.
     *
     * @param Request $request
     * @param Warranty $warranty
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addNote(Request $request, Warranty $warranty)
    {
        $validated = $request->validate([
            'note' => 'required|string|max:1000',
        ]);
        
        $existingNotes = $warranty->notes ? $warranty->notes . "\n\n" : '';
        $datePrefix = Carbon::now()->format('d M Y H:i') . " - ";
        
        $warranty->update([
            'notes' => $existingNotes . $datePrefix . $validated['note']
        ]);
        
        // Log this action
        $this->warrantyAuditService->logWarrantyAction(
            $warranty,
            'add_note',
            "Catatan baru ditambahkan ke garansi #" . $warranty->id
        );
        
        return redirect()->route('admin.warranties.show', $warranty)
            ->with('success', 'Catatan berhasil ditambahkan!');
    }
    
    /**
     * Extend a warranty.
     *
     * @param Request $request
     * @param Warranty $warranty
     * @return \Illuminate\Http\RedirectResponse
     */
    public function extend(Request $request, Warranty $warranty)
    {
        $validated = $request->validate([
            'months' => 'required|integer|min:1|max:60',
            'price' => 'required|numeric|min:0',
        ]);
        
        $oldEndDate = Carbon::parse($warranty->end_date); // Use Carbon::parse instead of ->copy()
        
        // Use the warranty service to extend the warranty
        $extension = $this->warrantyService->extendWarranty(
            $warranty, 
            $validated['months'], 
            $validated['price'], 
            Auth::id()
        );
        
        // Activate the extension directly (because it's done by admin)
        $this->warrantyService->activateExtension($extension);
        
        // Reload warranty to get updated end_date
        $warranty->refresh();
        
        // Log this action
        $this->warrantyAuditService->logWarrantyAction(
            $warranty,
            'extend',
            "Garansi #" . $warranty->id . " diperpanjang oleh admin selama " . $validated['months'] . " bulan dari " . 
            $oldEndDate->format('d M Y') . " hingga " . Carbon::parse($warranty->end_date)->format('d M Y')
        );
        
        return redirect()->route('admin.warranties.show', $warranty)
            ->with('success', 'Garansi berhasil diperpanjang!');
    }
    
    /**
     * Download warranty certificate.
     *
     * @param Warranty $warranty
     * @return \Illuminate\Http\Response
     */
    public function download(Warranty $warranty)
    {
        // Log this action
        $this->warrantyAuditService->logWarrantyAction(
            $warranty,
            'download_certificate',
            "Sertifikat garansi #" . $warranty->id . " diunduh"
        );
        
        return $this->warrantyService->generateWarrantyCertificate($warranty);
    }
}
