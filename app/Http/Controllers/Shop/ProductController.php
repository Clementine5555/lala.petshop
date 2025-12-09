<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman Shop untuk Customer
     * Logika FILTER ada di sini karena route mengarah ke 'index'
     */
    public function index(Request $request)
    {
        // 1. Mulai Query dasar
        $query = Product::with('reviews');

        // 2. LOGIKA FILTER (Server-Side)
        // Cek apakah ada parameter 'category' di URL
        if ($request->has('category') && $request->category != 'all') {
            // Gunakan LIKE agar pencarian fleksibel
            // Contoh: ?category=Cat Food akan cocok dengan data "Cat Food" di database
            $query->where('category', 'LIKE', '%' . $request->category . '%');
        }

        // 3. Ambil data yang sudah difilter dari database
        $products = $query->get();

        // 4. Mapping Data (Format ulang agar sesuai dengan View HTML kamu)
        $productsData = $products->map(function ($product) {
            return [
                'product_id'       => $product->product_id,
                'name'             => $product->name,
                'description'      => $product->description,
                'price'            => $product->price,
                'stock'            => $product->stock,
                'category'         => $product->category, // Pastikan kolom ini ada di database
                'average_rating'   => $product->getAverageRatingAttribute(),
                'reviews_count'    => $product->getReviewsCountAttribute(),
                'image_url'        => $product->image
                    ? asset('images/' . $product->image)
                    : asset('images/default.png'),
            ];
        })->toArray();

        // 5. Kirim data ke View
        // Kita kirim $currentCategory supaya tombol di HTML bisa menyala (active)
        $currentCategory = $request->category ?? 'all';

        // Pastikan view mengarah ke file: resources/views/shop/products/index.blade.php
        return view('shop.products.index', [
            'products' => $productsData,
            'currentCategory' => $currentCategory
        ]);
    }

    /**
     * Menampilkan Detail Produk
     */
    public function show($product_id)
    {
        $product = Product::findOrFail($product_id);
        return view('shop.products.show', compact('product'));
    }

    /**
     * API Featured Products
     */
    public function getFeaturedProducts()
    {
        $products = Product::with('reviews')->latest()->take(4)->get();

        $data = $products->map(function ($product) {
            return [
                'product_id'       => $product->product_id,
                'name'             => $product->name,
                'price'            => $product->price,
                'image_url'        => $product->image
                    ? asset('images/' . $product->image)
                    : asset('images/default.png'),
                'average_rating'   => $product->getAverageRatingAttribute(),
            ];
        });

        return response()->json($data);
    }
}
