<?php

namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //menyimpan review produk
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5', // Rating antara 1 sampai 5
            'comment' => 'nullable|string|max:1000', // Komentar opsional
        ]);

        Review::create([
            'product_id' => $productId,
            'user_id' => auth()->id(),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('products.show', $productId)
                         ->with('success', 'Review submitted successfully!');
    }
}
