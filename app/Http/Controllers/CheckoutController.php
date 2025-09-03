<?php
namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Warranty;
use App\Models\WarrantyExtension;
use App\Services\InvoiceNumberService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Services\DiscountValidatorService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected $discountValidator;
    protected $invoiceService;
    
    public function __construct(DiscountValidatorService $discountValidator, InvoiceNumberService $invoiceService)
    {
        $this->discountValidator = $discountValidator;
        $this->invoiceService = $invoiceService;
    }
    
    /**
     * Display checkout page for a product
     */
    public function checkout(Request $request)
    {
        // Basic validation
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        
        // Get product
        $product = Product::findOrFail($request->product_id);
        
        // Default values
        $variant = null;
        $warranty = null;
        $warrantyPrice = 0;
        
        // Get variant if provided
        if ($request->filled('variant_id')) {
            $variant = ProductVariant::where('product_id', $product->id)
                ->where('id', $request->variant_id)
                ->first();
        }
        
        // Get warranty if provided
        if ($request->filled('warranty_id')) {
            $warranty = Warranty::find($request->warranty_id);
            
            // Get warranty price if available
            $warrantyPriceModel = $product->warrantyPrices()
                ->where('warranty_id', $request->warranty_id)
                ->first();
                
            if ($warrantyPriceModel) {
                $warrantyPrice = $warrantyPriceModel->price;
            }
        }
        
        // Calculate prices
        $basePrice = $variant ? $variant->price : $product->price;
        $subtotal = $basePrice + $warrantyPrice;
        $tax = $subtotal * 0.11; // 11% tax
        $total = $subtotal + $tax;
        
        $data = [
            'product' => $product,
            'variant' => $variant,
            'warranty' => $warranty,
            'basePrice' => $basePrice,
            'warrantyPrice' => $warrantyPrice,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ];
        
        // Use different layout based on authentication status
        if (auth()->check()) {
            return view('shop.authenticated-checkout', $data);
        } else {
            // For guests, use a guest layout
            return view('shop.guest-checkout', $data);
        }
    }
    
    /**
     * Validate discount code and return discount info
     */
    public function checkDiscount(Request $request)
    {
        $request->validate([
            "discount_code" => "required|string|max:50",
            "product_id" => "required|exists:products,id",
            "subtotal" => "required|numeric|min:0",
        ]);
        
        $code = $request->discount_code;
        $productId = $request->product_id;
        $subtotal = $request->subtotal;
        
        // Find discount
        $discount = Discount::where("code", $code)
            ->where("is_active", true)
            ->first();
        
        if (!$discount) {
            return response()->json([
                "valid" => false,
                "message" => "Kode diskon tidak valid atau sudah tidak aktif.",
            ]);
        }
        
        // Validate discount with service
        $validationResult = $this->discountValidator->validate($discount, $productId, $subtotal);
        
        if (!$validationResult["valid"]) {
            return response()->json([
                "valid" => false,
                "message" => $validationResult["message"],
            ]);
        }
        
        // Calculate discount amount
        $discountAmount = 0;
        if ($discount->type === Discount::TYPE_PERCENTAGE) {
            $discountAmount = $subtotal * ($discount->value / 100);
        } else {
            $discountAmount = min($discount->value, $subtotal);
        }
        
        // Calculate new total
        $taxableAmount = $subtotal - $discountAmount;
        $tax = $taxableAmount * 0.11; // 11% tax
        $total = $taxableAmount + $tax;
        
        return response()->json([
            "valid" => true,
            "discount_amount" => $discountAmount,
            "taxable_amount" => $taxableAmount,
            "tax" => $tax,
            "total" => $total,
            "formatted_discount" => number_format($discountAmount, 0, ",", "."),
            "formatted_tax" => number_format($tax, 0, ",", "."),
            "formatted_total" => number_format($total, 0, ",", "."),
            "message" => "Kode diskon berhasil diterapkan!",
        ]);
    }
    
    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'warranty_id' => 'nullable|exists:warranties,id',
            'discount_code' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ]);
        
        try {
            // Get product with price information and eager load relationships
            $product = Product::where('id', $validated['product_id'])
                ->where('is_active', true)
                ->with(['variants', 'warrantyPrices'])
                ->firstOrFail();
                
            // Log product data
            \Log::info('Retrieved product for order:', [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
            ]);
            
            // Get variant if applicable
            $variant = null;
            if (!empty($validated['variant_id'])) {
                $variant = ProductVariant::where('id', $validated['variant_id'])
                    ->where('product_id', $product->id)
                    ->firstOrFail();
            }
            
            // Get warranty if applicable
            $warranty = null;
            $warrantyPrice = 0;
            if (!empty($validated['warranty_id'])) {
                $warranty = Warranty::findOrFail($validated['warranty_id']);
                $warrantyPriceModel = $product->warrantyPrices()
                    ->where('warranty_id', $validated['warranty_id'])
                    ->first();
                    
                if ($warrantyPriceModel) {
                    $warrantyPrice = $warrantyPriceModel->price;
                }
            }
            
            // Calculate base price
            $basePrice = $variant ? $variant->price : ($product->price ?? 0);
            
            // Ensure we have numeric values
            $basePrice = is_numeric($basePrice) ? $basePrice : 0;
            $warrantyPrice = is_numeric($warrantyPrice) ? $warrantyPrice : 0;
            
            // Log the price values
            \Log::info('Price calculation in process method:', [
                'product_id' => $product->id,
                'product_price' => $product->price,
                'variant_id' => $variant ? $variant->id : 'none',
                'variant_price' => $variant ? $variant->price : 'none',
                'base_price' => $basePrice,
                'warranty_price' => $warrantyPrice
            ]);
            
            // Calculate subtotal
            $subtotal = $basePrice + $warrantyPrice;
            
            // Check discount if provided
            $discount = null;
            $discountAmount = 0;
            
            if (!empty($validated['discount_code'])) {
                $discount = Discount::where('code', $validated['discount_code'])
                    ->where('is_active', true)
                    ->first();
                    
                if ($discount) {
                    // Validate discount
                    $validationResult = $this->discountValidator->validate($discount, $product->id, $subtotal);
                    
                    if ($validationResult['valid']) {
                        // Calculate discount amount
                        if ($discount->type === Discount::TYPE_PERCENTAGE) {
                            $discountAmount = $subtotal * ($discount->value / 100);
                        } else {
                            $discountAmount = min($discount->value, $subtotal);
                        }
                    }
                }
            }
            
            // Calculate tax
            $taxableAmount = $subtotal - $discountAmount;
            $tax = $taxableAmount * 0.11; // 11% tax
            
            // Calculate final total
            $total = $taxableAmount + $tax;
            
            DB::beginTransaction();
            
            try {
                // Log what we're about to do
                \Log::info('Creating order with the following data:', [
                    'user_id' => Auth::id(),
                    'discount_id' => $discount ? $discount->id : null,
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax' => $tax,
                    'total' => $total
                ]);
                
                // Generate unique order number
                $orderNumber = 'ORD-' . strtoupper(substr(md5(uniqid()), 0, 8));
                
                // Log the order data
                \Log::info('Order details before creation:', [
                    'order_number' => $orderNumber,
                    'user_id' => Auth::id(),
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax' => $tax,
                    'total' => $total
                ]);
                
                // Create order
                $order = Order::create([
                    'order_number' => $orderNumber,
                    'user_id' => Auth::id(),
                    'discount_id' => $discount ? $discount->id : null,
                    'order_date' => now(),
                    'subtotal' => $subtotal,
                    'discount_amount' => $discountAmount,
                    'tax' => $tax,
                    'total' => $total,
                    'status' => Order::STATUS_PENDING,
                    'notes' => $validated['notes'] ?? null,
                ]);
                
                // Ensure we have valid values for all fields
                $productName = $product->name ?? 'Unknown Product';
                $variantName = $variant ? ($variant->name ?? '') : '';
                $price = is_numeric($basePrice) ? $basePrice : 0;
                $subtotalValue = is_numeric($basePrice) && is_numeric($warrantyPrice) ? ($basePrice + $warrantyPrice) : 0;
                
                // Log calculated values
                \Log::info('Calculated values for order item:', [
                    'product_name' => $productName,
                    'variant_name' => $variantName,
                    'base_price' => $basePrice,
                    'warranty_price' => $warrantyPrice,
                    'subtotal' => $subtotalValue
                ]);
                
                // Prepare order item data
                $orderItemData = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_variant_id' => $variant ? $variant->id : null,
                    'product_name' => $productName,
                    'variant_name' => $variantName,
                    'quantity' => 1,
                    'price' => is_numeric($price) ? $price : 0,
                    'warranty_price' => is_numeric($warrantyPrice) ? $warrantyPrice : 0,
                    'warranty_months' => $warranty ? $warranty->duration_months : 6, // Default 6 months
                    'subtotal' => is_numeric($subtotalValue) ? $subtotalValue : 0,
                ];
                
                // Log the order item data
                \Log::info('Order item details before creation:', $orderItemData);
                
                // Create order item with required product_name
                OrderItem::create($orderItemData);
                
                // Create warranty extension if warranty was selected
                if ($warranty) {
                    $orderItem = $order->orderItems->first();
                    
                    // Log warranty extension data
                    \Log::info('Creating warranty extension with data:', [
                        'order_item_id' => $orderItem->id,
                        'warranty_duration' => $warranty->duration_months,
                        'start_date' => now(),
                        'end_date' => now()->addMonths($warranty->duration_months)
                    ]);
                    
                    WarrantyExtension::create([
                        'order_item_id' => $orderItem->id,
                        'warranty_id' => $warranty->id,
                        'start_date' => now(),
                        'end_date' => now()->addMonths($warranty->duration_months),
                        'status' => WarrantyExtension::STATUS_PENDING,
                    ]);
                }
                
                // Create invoice
                $invoice = Invoice::create([
                    'invoice_number' => $this->invoiceService->generate(),
                    'order_id' => $order->id,
                    'amount' => $total, // Hanya menggunakan field yang ada di tabel
                    'due_date' => now()->addDays(7),
                    'status' => Invoice::STATUS_UNPAID,
                    'notes' => 'Pembayaran untuk pesanan ' . $order->order_number,
                ]);
                
                // Update discount usage if applicable
                if ($discount) {
                    $discount->increment('used_count');
                }
                
                DB::commit();
                
                // Redirect to payment page
                return redirect()->route('payment.show', $invoice->id)
                    ->with('success', 'Pesanan berhasil dibuat.');
                    
            } catch (\Exception $e) {
                DB::rollBack();
                
                // Log the specific error
                \Log::error('Error processing checkout: ' . $e->getMessage(), [
                    'exception' => $e,
                    'trace' => $e->getTraceAsString()
                ]);
                
                return redirect()->back()
                    ->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage())
                    ->withInput();
            }
        } catch (\Exception $e) {
            // Log the specific error
            \Log::error('Error in checkout process: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}


