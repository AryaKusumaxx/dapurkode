<?php

namespace App\Http\Controllers;

use App\Models\Warranty;
use App\Models\WarrantyExtension;
use App\Services\WarrantyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WarrantyController extends Controller
{
    protected $warrantyService;
    
    /**
     * Create a new controller instance.
     *
     * @param WarrantyService $warrantyService
     * @return void
     */
    public function __construct(WarrantyService $warrantyService)
    {
        $this->warrantyService = $warrantyService;
    }
    
    /**
     * Display warranty details.
     *
     * @param Warranty $warranty
     * @return View
     */
    public function show(Warranty $warranty): View
    {
        // Use Gate facade instead of $this->authorize
        \Illuminate\Support\Facades\Gate::authorize('view', $warranty);
        
        // Eager load related models
        $warranty->load(['orderItem.product', 'orderItem.order', 'extensions']);
        
        // Calculate remaining days
        $remainingDays = $this->warrantyService->getRemainingDays($warranty);
        
        return view('user.warranty-detail', compact('warranty', 'remainingDays'));
    }
    
    /**
     * Show warranty extension form.
     *
     * @param Warranty $warranty
     * @return View
     */
    public function showExtendForm(Warranty $warranty): View
    {
        \Illuminate\Support\Facades\Gate::authorize('extend', $warranty);
        
        // Check if warranty is active and not expired
        if (!$warranty->isActive() || $warranty->isExpired()) {
            return redirect()->route('user.warranties')
                ->with('error', 'Hanya garansi aktif yang dapat diperpanjang.');
        }
        
        // Get available warranty extension options
        $options = [
            3 => [
                'months' => 3,
                'days' => 90,
                'price' => 100000
            ],
            6 => [
                'months' => 6,
                'days' => 180,
                'price' => 180000
            ],
            12 => [
                'months' => 12,
                'days' => 360,
                'price' => 300000
            ]
        ];
        
        $product = $warranty->getProduct();
        
        return view('user.warranty-extend', compact('warranty', 'options', 'product'));
    }
    
    /**
     * Process warranty extension request.
     *
     * @param Request $request
     * @param Warranty $warranty
     * @return \Illuminate\Http\RedirectResponse
     */
    public function extend(Request $request, Warranty $warranty)
    {
        \Illuminate\Support\Facades\Gate::authorize('extend', $warranty);
        
        // Validate request
        $validated = $request->validate([
            'months' => 'required|integer|in:3,6,12',
        ]);
        
        // Set price based on selected months
        $priceMap = [
            3 => 100000,
            6 => 180000,
            12 => 300000
        ];
        
        $months = $validated['months'];
        $price = $priceMap[$months];
        
        // Create warranty extension
        $extension = $this->warrantyService->extendWarranty(
            $warranty, 
            $months, 
            $price, 
            Auth::id()
        );
        
        // Redirect to payment page
        return redirect()->route('user.warranty.extension.payment', $extension)
            ->with('success', 'Perpanjangan garansi berhasil dibuat. Silakan lakukan pembayaran.');
    }
    
    /**
     * Show payment page for warranty extension.
     *
     * @param WarrantyExtension $extension
     * @return View
     */
    public function showExtensionPayment(WarrantyExtension $extension): View
    {
        \Illuminate\Support\Facades\Gate::authorize('pay', $extension);
        
        $warranty = $extension->warranty;
        
        return view('user.warranty-extension-payment', compact('extension', 'warranty'));
    }
    
    /**
     * Process extension payment (placeholder, actual payment integration would go here)
     *
     * @param Request $request
     * @param WarrantyExtension $extension
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processExtensionPayment(Request $request, WarrantyExtension $extension)
    {
        \Illuminate\Support\Facades\Gate::authorize('pay', $extension);
        
        // Activate the extension
        $this->warrantyService->activateExtension($extension);
        
        return redirect()->route('user.warranties')
            ->with('success', 'Pembayaran berhasil. Garansi telah diperpanjang.');
    }
    
    /**
     * Download warranty document.
     *
     * @param Warranty $warranty
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function download(Warranty $warranty)
    {
        \Illuminate\Support\Facades\Gate::authorize('download', $warranty);
        
        // Check if download is allowed
        if (!$this->warrantyService->isDownloadAllowed($warranty)) {
            return redirect()->route('user.warranties')
                ->with('error', 'Unduh dokumen hanya tersedia untuk garansi yang aktif.');
        }
        
        // Generate or fetch warranty document (placeholder)
        // In a real implementation, you might generate a PDF or fetch a stored file
        $content = $this->generateWarrantyDocument($warranty);
        
        $filename = 'garansi-' . $warranty->id . '.pdf';
        
        return Response::make($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    
    /**
     * Generate warranty document (placeholder).
     *
     * @param Warranty $warranty
     * @return string
     */
    private function generateWarrantyDocument(Warranty $warranty): string
    {
        // This is a placeholder - in a real implementation, you would generate a PDF
        // using a library like DOMPDF, TCPDF, etc.
        // For now, we'll just return a fake PDF content
        return '%PDF-1.4
1 0 obj
<</Title (Warranty Certificate)>>
endobj
2 0 obj
<</Type /Catalog>>
endobj
3 0 obj
<</Type /Page
/Contents 4 0 R>>
endobj
4 0 obj
<</Length 22>>
stream
BT /F1 12 Tf (Warranty Certificate for Product: ' . $warranty->getProduct()->name . ') Tj ET
endstream
endobj
xref
0 5
trailer
<</Size 5>>
startxref
0
%%EOF';
    }
}
