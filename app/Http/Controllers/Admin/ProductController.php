<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Menampilkan Daftar Produk
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('category', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    // Form Tambah Produk
    public function create()
    {
        return view('admin.products.create');
    }

    // Proses Simpan Produk Baru (SUDAH DIPERBAIKI)
    public function store(Request $request)
    {
        // 1. Validasi & Ambil Data Bersih (Tanpa _token)
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        // 2. Upload Gambar jika ada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // 3. Simpan (Sekarang aman karena $data tidak mengandung _token)
        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Form Edit Produk
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    // Proses Update Produk (SUDAH DIPERBAIKI)
    public function update(Request $request, Product $product)
    {
        // 1. Validasi & Ambil Data Bersih
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // 2. Cek jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // 3. Update Data
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus Produk
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function show(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }
}
