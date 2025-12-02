<?php

namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Get all reviews (API endpoint)
     */
    public function getAllReviews()
    {
        $reviews = Review::with('user')
            ->select('review_id', 'product_id', 'user_id', 'rating', 'comment', 'created_at')
            ->get()
            ->map(function ($review) {
                return [
                    'review_id' => $review->review_id,
                    'product_id' => $review->product_id,
                    'user_id' => $review->user_id,
                    'user_name' => $review->user->name ?? 'Anonymous', 
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at
                ];
            });

        return response()->json($reviews);
    }

    /**
     * Store a review for a product (API endpoint)
     */
    public function storeApi(Request $request, $productId)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to review'
            ], 401);
        }

        // Validasi 
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Create review dengan user yang login
        $review = Review::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        // Load relasi user
        $review->load('user');

        return response()->json([
            'success' => true,
            'message' => 'Review added successfully',
            'review' => [
                'review_id' => $review->review_id,
                'product_id' => $review->product_id,
                'user_id' => $review->user_id,
                'user_name' => $review->user->name ?? 'Anonymous', // ✅ Perbaiki
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at,
            ],
        ]);
    }

    /**
     * Store review from form submission (legacy)
     */
    public function store(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        Review::create([
            'product_id' => $productId,
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('products.show', $productId)
                         ->with('success', 'Review submitted successfully!');
    }
}