<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PageController extends Controller
{
    /**
     * Menampilkan halaman Products (katalog produk).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function products(Request $request): View
    {
        $products = Product::with(['variants', 'warrantyPrices'])
            ->when($request->has('category') && $request->category != 'all', function($query) use ($request) {
                $query->where('category', $request->category);
            })
            ->when($request->has('sort'), function($query) use ($request) {
                switch($request->sort) {
                    case 'price-low':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'price-high':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'rating':
                        $query->orderBy('rating', 'desc');
                        break;
                    case 'popularity':
                        $query->orderBy('reviews_count', 'desc');
                        break;
                    default:
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            })
            ->paginate(12);

        return view('products.index', [
            'products' => $products,
        ]);
    }

    /**
     * Menampilkan halaman Product Detail.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function productDetail($slug): View
    {
        $product = Product::where('slug', $slug)
            ->with(['variants', 'warrantyPrices', 'reviews'])
            ->firstOrFail();

        // Mengambil produk terkait berdasarkan kategori
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->take(4)
            ->get();

        // Menyimpan dan mengambil produk yang baru dilihat dari session
        $recentlyViewed = $this->getRecentlyViewedProducts($product->id);

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'recentlyViewed' => $recentlyViewed,
        ]);
    }

    /**
     * Menampilkan halaman About Us.
     *
     * @return \Illuminate\View\View
     */
    public function about(): View
    {
        return view('about');
    }

    /**
     * Menampilkan halaman Contact.
     *
     * @return \Illuminate\View\View
     */
    public function contact(): View
    {
        return view('contact');
    }

    /**
     * Memproses form kontak.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy' => 'required|accepted',
        ]);

        // Proses pengiriman pesan kontak
        // Dapat mengimplementasikan pengiriman email atau penyimpanan ke database

        return redirect()->back()->with('success', 'Pesan Anda telah berhasil dikirim. Tim kami akan menghubungi Anda segera.');
    }

    /**
     * Menampilkan halaman FAQ.
     *
     * @return \Illuminate\View\View
     */
    public function faq(): View
    {
        return view('faq');
    }
    
    /**
     * Menampilkan halaman Kebijakan Privasi.
     *
     * @return \Illuminate\View\View
     */
    public function privacyPolicy(): View
    {
        return view('privacy-policy');
    }

    /**
     * Menampilkan halaman Syarat & Ketentuan.
     *
     * @return \Illuminate\View\View
     */
    public function termsOfService(): View
    {
        return view('terms-of-service');
    }

    /**
     * Mendapatkan dan menyimpan produk yang baru dilihat.
     *
     * @param  int  $productId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getRecentlyViewedProducts($productId)
    {
        // Ambil produk yang baru dilihat dari session
        $recentlyViewed = session()->get('recently_viewed', []);
        
        // Hapus produk saat ini jika sudah ada dalam daftar
        if (($key = array_search($productId, $recentlyViewed)) !== false) {
            unset($recentlyViewed[$key]);
        }
        
        // Tambahkan produk saat ini ke awal array
        array_unshift($recentlyViewed, $productId);
        
        // Batasi hanya menyimpan 4 produk terakhir
        $recentlyViewed = array_slice($recentlyViewed, 0, 4);
        
        // Simpan kembali ke session
        session()->put('recently_viewed', $recentlyViewed);
        
        // Ambil produk berdasarkan ID
        return Product::whereIn('id', $recentlyViewed)
            ->where('id', '!=', $productId)
            ->get();
    }
    
    /**
     * Menampilkan halaman panduan UI Improvements
     *
     * @return \Illuminate\View\View
     */
    public function uiGuide(): View
    {
        return view('ui-improvements-guide');
    }
}
