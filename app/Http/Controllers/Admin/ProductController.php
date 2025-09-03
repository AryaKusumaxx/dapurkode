<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductWarrantyPrice;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of the products.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Product::class);
        
        $products = Product::with(['variants', 'warrantyPrices'])
            ->latest()
            ->paginate(10);
            
        return view('admin.products.index', compact('products'));
    }
    
    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $this->authorize('create', Product::class);
        
        return view('admin.products.create');
    }
    
    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products',
            'description' => 'required|string',
            'about_product' => 'nullable|string',
            'advantages' => 'nullable|string',
            'ideal_for' => 'nullable|string',
            'system_requirements' => 'nullable|string',
            'features' => 'nullable|string',
            'specifications' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'warranty_months' => 'nullable|integer|min:0',
            'has_warranty' => 'sometimes',
            'is_active' => 'sometimes',
            'is_featured' => 'sometimes',
            'image' => 'required|image|max:2048', // Max 2MB
            'status' => 'required|string|in:published,draft,archived',
            'type' => 'required|string',
            'category' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);
        
        // Process features from textarea to array
        $features = null;
        if (!empty($validated['features'])) {
            $features = array_filter(explode("\n", $validated['features']), fn($value) => !empty(trim($value)));
            $features = array_map('trim', $features);
        }

        // Process specifications from textarea to array
        $specifications = null;
        if (!empty($validated['specifications'])) {
            $specifications = array_filter(explode("\n", $validated['specifications']), fn($value) => !empty(trim($value)));
            $specifications = array_map('trim', $specifications);
        }
        
        // Upload product image
        $imagePath = $request->file('image')->store('products', 'public');
        
        // Try direct DB insert
        try {
            // Create debug log file in storage/logs
            $debugLogPath = storage_path('logs/product_create.log');
            file_put_contents($debugLogPath, "\n\n====== CREATE START: " . date('Y-m-d H:i:s') . " ======\n", FILE_APPEND);
            
            $insertData = [
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'],
                'about_product' => $validated['about_product'] ?? null,
                'advantages' => $validated['advantages'] ?? null,
                'ideal_for' => $validated['ideal_for'] ?? null,
                'system_requirements' => $validated['system_requirements'] ?? null,
                'features' => !empty($features) ? json_encode($features) : null,
                'specifications' => !empty($specifications) ? json_encode($specifications) : null,
                'base_price' => $validated['base_price'],
                'discount_price' => $validated['discount_price'] ?? null,
                'warranty_months' => $validated['warranty_months'] ?? 0,
                'has_warranty' => $request->has('has_warranty') ? 1 : 0,
                'is_active' => $validated['status'] === 'published' ? 1 : 0,
                'is_featured' => $request->has('is_featured') ? 1 : 0,
                'image' => $imagePath,
                'type' => $validated['type'],
                'category' => $validated['category'],
                'created_at' => now(),
                'updated_at' => now()
            ];
            
            file_put_contents($debugLogPath, "Insert data: " . json_encode($insertData, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
            
            $productId = \DB::table('products')->insertGetId($insertData);
            
            file_put_contents($debugLogPath, "Created product ID: " . $productId . "\n", FILE_APPEND);
            file_put_contents($debugLogPath, "====== CREATE END ======\n", FILE_APPEND);
            
            // Load product model for redirect
            $product = Product::find($productId);
            
        } catch (\Exception $e) {
            file_put_contents($debugLogPath, "EXCEPTION: " . $e->getMessage() . "\n", FILE_APPEND);
            file_put_contents($debugLogPath, "====== CREATE FAILED ======\n", FILE_APPEND);
            
            return redirect()->back()->with('error', 'Error creating product: ' . $e->getMessage())->withInput();
        }
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dibuat.');
    }
    
    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        $this->authorize('view', $product);
        
        $product->load(['variants', 'warrantyPrices']);
        
        return view('admin.products.show', compact('product'));
    }
    
    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $this->authorize('update', $product);
        
        $product->load(['variants', 'warrantyPrices']);
        
        return view('admin.products.edit', compact('product'));
    }
    
    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        
        // Create debug log file in storage/logs
        $debugLogPath = storage_path('logs/product_update.log');
        file_put_contents($debugLogPath, "\n\n====== UPDATE START: " . date('Y-m-d H:i:s') . " ======\n", FILE_APPEND);
        file_put_contents($debugLogPath, "Product ID: {$product->id}, Name: {$product->name}\n", FILE_APPEND);
        file_put_contents($debugLogPath, "Request data: " . json_encode($request->all(), JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'about_product' => 'nullable|string',
            'advantages' => 'nullable|string',
            'ideal_for' => 'nullable|string',
            'system_requirements' => 'nullable|string',
            'features' => 'nullable|string',
            'specifications' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'warranty_months' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048', // Max 2MB
            'status' => 'required|string|in:published,draft,archived',
            'type' => 'required|string',
            'category' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);
        
        // Process features from textarea to array
        $features = [];
        if (!empty($validated['features'])) {
            $features = array_filter(explode("\n", $validated['features']), fn($value) => !empty(trim($value)));
            $features = array_map('trim', $features);
        }

        // Process specifications from textarea to array
        $specifications = [];
        if (!empty($validated['specifications'])) {
            $specifications = array_filter(explode("\n", $validated['specifications']), fn($value) => !empty(trim($value)));
            $specifications = array_map('trim', $specifications);
        }
        
        // Image handling
        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                \Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
        }
        
        // Use direct database query to bypass any model issues
        $updateData = [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'],
            'about_product' => $validated['about_product'] ?? null,
            'advantages' => $validated['advantages'] ?? null,
            'ideal_for' => $validated['ideal_for'] ?? null,
            'system_requirements' => $validated['system_requirements'] ?? null,
            'features' => !empty($features) ? json_encode($features) : null,
            'specifications' => !empty($specifications) ? json_encode($specifications) : null,
            'base_price' => $validated['base_price'],
            'discount_price' => $validated['discount_price'] ?? null,
            'warranty_months' => $validated['warranty_months'] ?? 0,
            'has_warranty' => $request->has('has_warranty') ? 1 : 0,
            'is_active' => $validated['status'] === 'published' ? 1 : 0,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'type' => $validated['type'],
            'category' => $validated['category'],
            'image' => $imagePath,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'updated_at' => now()
        ];
        
        file_put_contents($debugLogPath, "Update data: " . json_encode($updateData, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
        
        // Try direct DB update
        try {
            $updateResult = \DB::table('products')
                ->where('id', $product->id)
                ->update($updateData);
            
            file_put_contents($debugLogPath, "Update result: " . ($updateResult ? 'SUCCESS' : 'FAILED') . "\n", FILE_APPEND);
            file_put_contents($debugLogPath, "Affected rows: " . $updateResult . "\n", FILE_APPEND);
            
            // Get current data after update
            $freshProduct = \DB::table('products')->where('id', $product->id)->first();
            file_put_contents($debugLogPath, "Fresh product data: " . json_encode($freshProduct, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
            file_put_contents($debugLogPath, "====== UPDATE END ======\n", FILE_APPEND);
            
            if ($updateResult) {
                return redirect()->route('admin.products.edit', $product->id)
                    ->with('success', 'Produk berhasil diperbarui.');
            } else {
                return redirect()->route('admin.products.edit', $product->id)
                    ->with('error', 'Tidak ada perubahan disimpan. Periksa detail produk.');
            }
            
        } catch (\Exception $e) {
            file_put_contents($debugLogPath, "EXCEPTION: " . $e->getMessage() . "\n", FILE_APPEND);
            file_put_contents($debugLogPath, "====== UPDATE FAILED ======\n", FILE_APPEND);
            
            return redirect()->back()->with('error', 'Error updating product: ' . $e->getMessage());
        }
    }
    
    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        // Check if product has been ordered
        if ($product->orderItems()->exists()) {
            // Just deactivate instead of delete
            $product->update(['is_active' => false]);
            
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dinonaktifkan karena sudah pernah dipesan.');
        }
        
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Delete product
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
    
    /**
     * Toggle product active status.
     */
    public function toggleStatus(Product $product)
    {
        $this->authorize('update', $product);
        
        $product->update([
            'is_active' => !$product->is_active,
        ]);
        
        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('admin.products.index')
            ->with('success', "Produk berhasil {$status}.");
    }
    
    // Product variant management methods would go here
    
    // Product warranty price management methods would go here
}
