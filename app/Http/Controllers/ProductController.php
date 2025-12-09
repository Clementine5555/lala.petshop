<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products for the shop (with reviews & ratings from DB)
     */
    public function shop()
    {
        $products = Product::with('reviews')->get();

        // Add average_rating and reviews_count as attributes for the view
        $productsData = $products->map(function ($product) {
            return [
                'product_id'       => $product->product_id,
                'name'             => $product->name,
                'description'      => $product->description,
                'price'            => $product->price,
                'stock'            => $product->stock,
                'average_rating'   => $product->getAverageRatingAttribute(),
                'reviews_count'    => $product->getReviewsCountAttribute(),
                'image_url'        => $product->image
                                        ? asset('images/' . $product->image)
                                        : asset('images/default.png'),
            ];        })->toArray();

        return view('shop.products.index', ['products' => $productsData]);
    }

    /**
     * Admin: Show all products for editing
     */
    public function adminIndex()
    {
        $products = Product::all();
        return view('admin.products.index', ['products' => $products]);
    }

    /**
     * Admin: Show edit form for a product
     */
    public function adminEdit($productId)
    {
        $product = Product::findOrFail($productId, ['product_id']);
        return view('admin.products.edit', ['product' => $product]);
    }

    /**
     * Admin: Update product (harga & stok)
     */
    public function adminUpdate(Request $request, $productId)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'name'  => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($productId, ['product_id']);
        $product->update($request->only(['name', 'description', 'price', 'stock']));

        return redirect()->route('admin.products.index')
            ->with('success', "Produk '{$product->name}' berhasil diupdate!");
    }

    /**
     * Shop: Get products data as JSON (for potential AJAX usage)
     */
    public function getProductsJson()
    {
        $products = Product::with('reviews')->get();

        $data = $products->map(function ($product) {
            return [
                'product_id'       => $product->product_id,
                'name'             => $product->name,
                'description'      => $product->description,
                'price'            => $product->price,
                'stock'            => $product->stock,
                'average_rating'   => $product->getAverageRatingAttribute(),
                'reviews_count'    => $product->getReviewsCountAttribute(),
                'image_url'        => $product->image
                                        ? asset('images/' . $product->image)
                                        : asset('images/default.png'),

            ];
        });

        return response()->json($data);
    }
}
