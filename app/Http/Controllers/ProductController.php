<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductWarrantyPrice;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the products.
     */
    public function index(Request $request): View
    {
        $query = Product::where('is_active', true);
        
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('description', 'like', $searchTerm)
                  ->orWhere('category', 'like', $searchTerm);
            });
        }
        
        // Apply category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }
        
        // Apply price filter
        if ($request->has('min_price') && is_numeric($request->min_price)) {
            $query->where('base_price', '>=', $request->min_price);
        }
        
        if ($request->has('max_price') && is_numeric($request->max_price)) {
            $query->where('base_price', '<=', $request->max_price);
        }
        
        // Apply sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('base_price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('base_price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'rating':
                    // Order by average rating if you have a rating field, or by a computed property
                    $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
                    break;
                case 'popularity':
                    // Since there's no reviews_count column, we'll use a combination of featured and then newest
                    $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }
        
        $products = $query->with(['variants', 'warrantyPrices'])
            ->paginate(12)
            ->withQueryString(); // Preserves query parameters in pagination links
            
        // Get unique categories for filter sidebar
        $categories = Product::where('is_active', true)
            ->distinct('category')
            ->pluck('category')
            ->toArray();
            
        return view('products.index', compact('products', 'categories'));
    }
    
    /**
     * Display the specified product.
     */
    public function show(string $slug): View
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['variants', 'warrantyPrices'])
            ->firstOrFail();
            
        // Get product warranties
        $warranties = Warranty::all();
            
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();
        
        // Initialize empty array for recently viewed products
        $recentlyViewed = collect();
        
        // Check if session exists and add recently viewed product logic
        if (session()->has('recently_viewed')) {
            $recentIds = session('recently_viewed');
            
            // Remove current product from recently viewed if present
            $recentIds = array_diff($recentIds, [$product->id]);
            
            // Get recently viewed products
            if (!empty($recentIds)) {
                $recentlyViewed = Product::whereIn('id', $recentIds)
                    ->where('is_active', true)
                    ->limit(4)
                    ->get();
            }
        }
        
        // Update recently viewed products in session
        $recentIds = session()->get('recently_viewed', []);
        if (!in_array($product->id, $recentIds)) {
            // Add current product to the beginning of the array
            array_unshift($recentIds, $product->id);
            // Keep only the last 6 products
            $recentIds = array_slice($recentIds, 0, 6);
        }
        session(['recently_viewed' => $recentIds]);
            
        return view('products.show', compact('product', 'warranties', 'relatedProducts', 'recentlyViewed'));
    }
    
    /**
     * Show the form for creating a new product (admin only).
     */
    public function create(): View
    {
        $this->authorize('create', Product::class);
        
        return view('admin.products.create');
    }
    
    /**
     * Store a newly created product in storage (admin only).
     */
    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products',
            'description' => 'required|string',
            'features' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:50',
            'image' => 'nullable|image|max:2048',
            'demo_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            
            // Variant data
            'variants' => 'nullable|array',
            'variants.*.name' => 'required|string|max:100',
            'variants.*.description' => 'required|string',
            'variants.*.price' => 'required|numeric|min:0',
            
            // Warranty data
            'warranties' => 'nullable|array',
            'warranties.*.warranty_id' => 'required|exists:warranties,id',
            'warranties.*.price' => 'required|numeric|min:0',
        ]);
        
        // Upload image if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }
        
        // Create product
        $product = Product::create($validated);
        
        // Create variants if provided
        if (!empty($validated['variants'])) {
            foreach ($validated['variants'] as $variantData) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => $variantData['name'],
                    'description' => $variantData['description'],
                    'price' => $variantData['price'],
                ]);
            }
        }
        
        // Create warranty prices if provided
        if (!empty($validated['warranties'])) {
            foreach ($validated['warranties'] as $warrantyData) {
                ProductWarrantyPrice::create([
                    'product_id' => $product->id,
                    'warranty_id' => $warrantyData['warranty_id'],
                    'price' => $warrantyData['price'],
                ]);
            }
        }
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dibuat.');
    }
    
    /**
     * Show the form for editing the specified product (admin only).
     */
    public function edit(Product $product): View
    {
        $this->authorize('update', $product);
        
        $product->load(['variants', 'warrantyPrices']);
        
        return view('admin.products.edit', compact('product'));
    }
    
    /**
     * Update the specified product in storage (admin only).
     */
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'features' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:50',
            'image' => 'nullable|image|max:2048',
            'demo_url' => 'nullable|url|max:255',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            
            // Variant data (existing and new)
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.name' => 'required|string|max:100',
            'variants.*.description' => 'required|string',
            'variants.*.price' => 'required|numeric|min:0',
            
            // Warranty data (existing and new)
            'warranties' => 'nullable|array',
            'warranties.*.id' => 'nullable|exists:product_warranty_prices,id',
            'warranties.*.warranty_id' => 'required|exists:warranties,id',
            'warranties.*.price' => 'required|numeric|min:0',
        ]);
        
        // Upload image if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }
        
        // Update product
        $product->update($validated);
        
        // Update variants if provided
        if (!empty($validated['variants'])) {
            $existingVariantIds = [];
            
            foreach ($validated['variants'] as $variantData) {
                if (!empty($variantData['id'])) {
                    // Update existing variant
                    $variant = ProductVariant::find($variantData['id']);
                    if ($variant && $variant->product_id === $product->id) {
                        $variant->update([
                            'name' => $variantData['name'],
                            'description' => $variantData['description'],
                            'price' => $variantData['price'],
                        ]);
                        $existingVariantIds[] = $variant->id;
                    }
                } else {
                    // Create new variant
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'name' => $variantData['name'],
                        'description' => $variantData['description'],
                        'price' => $variantData['price'],
                    ]);
                    $existingVariantIds[] = $variant->id;
                }
            }
            
            // Delete variants that were not included in the request
            ProductVariant::where('product_id', $product->id)
                ->whereNotIn('id', $existingVariantIds)
                ->delete();
        } else {
            // Delete all variants if none provided
            ProductVariant::where('product_id', $product->id)->delete();
        }
        
        // Update warranty prices if provided
        if (!empty($validated['warranties'])) {
            $existingWarrantyIds = [];
            
            foreach ($validated['warranties'] as $warrantyData) {
                if (!empty($warrantyData['id'])) {
                    // Update existing warranty price
                    $warrantyPrice = ProductWarrantyPrice::find($warrantyData['id']);
                    if ($warrantyPrice && $warrantyPrice->product_id === $product->id) {
                        $warrantyPrice->update([
                            'warranty_id' => $warrantyData['warranty_id'],
                            'price' => $warrantyData['price'],
                        ]);
                        $existingWarrantyIds[] = $warrantyPrice->id;
                    }
                } else {
                    // Create new warranty price
                    $warrantyPrice = ProductWarrantyPrice::create([
                        'product_id' => $product->id,
                        'warranty_id' => $warrantyData['warranty_id'],
                        'price' => $warrantyData['price'],
                    ]);
                    $existingWarrantyIds[] = $warrantyPrice->id;
                }
            }
            
            // Delete warranty prices that were not included in the request
            ProductWarrantyPrice::where('product_id', $product->id)
                ->whereNotIn('id', $existingWarrantyIds)
                ->delete();
        } else {
            // Delete all warranty prices if none provided
            ProductWarrantyPrice::where('product_id', $product->id)->delete();
        }
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }
    
    /**
     * Remove the specified product from storage (admin only).
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        // Check if product has related orders
        if ($product->orderItems()->exists()) {
            // Soft delete by marking as inactive
            $product->update(['is_active' => false]);
            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dinonaktifkan.');
        }
        
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        // Delete variants and warranty prices
        ProductVariant::where('product_id', $product->id)->delete();
        ProductWarrantyPrice::where('product_id', $product->id)->delete();
        
        // Delete product
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
