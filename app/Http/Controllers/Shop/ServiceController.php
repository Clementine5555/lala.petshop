<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    // Menampilkan daftar layanan (Halaman Depan)
    public function index(Request $request)
    {
        $query = Service::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('service_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        $services = $query->orderBy('service_name')->paginate(12);

        return view('shop.services.index', compact('services'));
    }

    // Menampilkan detail ;ayanan (halaman detail)
    public function show($id)
    {
        // Cari service berdasarkan ID, kalau tidak ada tampilkan 404
        $service = Service::findOrFail($id); 

        return view('shop.services.show', compact('service')); 
    }
}