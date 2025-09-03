<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    /**
     * Show the application homepage.
     */
    public function index(): View
    {
        // Get featured products
        $featuredProducts = Product::where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->limit(6)
            ->get();
            
        // Get latest products
        $latestProducts = Product::where('is_active', true)
            ->latest()
            ->limit(8)
            ->get();
            
        // Group products by category
        $categories = Product::where('is_active', true)
            ->select('category')
            ->distinct()
            ->pluck('category');
            
        $productsByCategory = [];
        
        foreach ($categories as $category) {
            $productsByCategory[$category] = Product::where('category', $category)
                ->where('is_active', true)
                ->limit(4)
                ->get();
        }
        
        return view('welcome', compact('featuredProducts', 'latestProducts', 'productsByCategory'));
    }
}
