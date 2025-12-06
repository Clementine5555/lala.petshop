<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // menampilkan daftar produk untuk pelanggan
    // memiliki fitur pencarian (berdasarkan nama dan kategori) dan 
    // pagination (menampilkan 12 produk per halaman)

    public function index(Request $request)
    {   
        $query = Product::with('reviews');

        // jika user memasukkan kata kunci pencarian
        if ($request->filled('search')) {

            // filter produk berdasarkan nama atau kategori
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }
        
        // mengurutkan produk berdasarkan nama
        $productsRaw = $query->orderBy('name')->get(); 
        
        // Map products dengan calculated average_rating dan reviews_count
        $products = $productsRaw->map(function ($product) {
            return [
                'product_id'       => $product->product_id,
                'name'             => $product->name,
                'description'      => $product->description,
                'price'            => $product->price,
                'stock'            => $product->stock,
                'category'         => $product->category,
                'average_rating'   => $product->getAverageRatingAttribute(),
                'reviews_count'    => $product->getReviewsCountAttribute(),
                'image_url'        => $product->image 
                                        ? asset('images/' . $product->image)
                                        : asset('images/default.png'),

            ];
        });
        
        return view('shop.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('shop.products.show', compact('product'));
    }
    
    public function getFeaturedProducts()
{
    try {
        // Ambil 1 produk untuk ditampilkan di landing page
        $product = Product::with('reviews')
            ->where('stock', '>', 0) // Hanya produk yang ada stoknya
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'No products available'
            ]);
        }

        return response()->json([
            'success' => true,
            'products' => [[
                'product_id'     => $product->product_id,
                'name'           => $product->name,
                'description'    => $product->description,
                'price'          => $product->price,
                'stock'          => $product->stock,
                'category'       => $product->category,
                'average_rating' => $product->getAverageRatingAttribute(),
                'reviews_count'  => $product->getReviewsCountAttribute(),
                'image_url'      => $product->image 
                                    ? asset('images/' . $product->image)
                                    : asset('images/default.png'),
            ]]
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error loading products'
        ], 500);
    }
}

}
