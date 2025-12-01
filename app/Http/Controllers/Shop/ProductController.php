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

        $query = Product::query();

        // jika user memasukkan kata kunci pencarian
        if ($request->filled('search')) {

            // filter produk berdasarkan nama atau kategori
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
        }
        
        // mengurutkan produk berdasarkan nama
        $products = $query->orderBy('name')->paginate(12); 

        return view('shop.products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('shop.products.show', compact('product'));
    }
}
