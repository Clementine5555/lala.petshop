<?php
/**
 * Quick test script to verify reviews API and controller logic
 * Tests: GET /api/products/reviews returns reviews with proper structure
 */

require_once __DIR__ . '/../bootstrap/app.php';

use Illuminate\Support\Facades\App;

$app = App::getInstance();
$app->make('Illuminate\Contracts\Http\Kernel')->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Product;
use App\Models\Review;
use App\Models\User;

echo "=== Testing Reviews Flow ===\n\n";

// 1. Check if products exist
echo "1. Checking products in DB:\n";
$products = Product::all();
echo "Total products: " . $products->count() . "\n";
foreach ($products as $product) {
    echo "  - {$product->name} (ID: {$product->product_id}), Price: {$product->price}\n";
}

echo "\n2. Checking reviews in DB:\n";
$reviews = Review::with('user')->get();
echo "Total reviews: " . $reviews->count() . "\n";
foreach ($reviews as $review) {
    echo "  - Product ID {$review->product_id}: {$review->comment} (Rating: {$review->rating})\n";
}

echo "\n3. Testing Product model with average_rating & reviews_count:\n";
foreach ($products->take(3) as $product) {
    $avgRating = $product->getAverageRatingAttribute();
    $reviewCount = $product->getReviewsCountAttribute();
    echo "  - {$product->name}: Avg Rating = $avgRating, Review Count = $reviewCount\n";
}

echo "\n4. Simulating ReviewController::getAllReviews() response:\n";
$allReviews = Review::with(['product', 'user'])->get()->map(function ($review) {
    return [
        'review_id' => $review->review_id,
        'product_id' => $review->product_id,
        'user_id' => $review->user_id,
        'rating' => $review->rating,
        'comment' => $review->comment,
        'user_name' => $review->user?->name ?? 'Anonymous',
        'created_at' => $review->created_at,
    ];
})->toArray();

echo json_encode($allReviews, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

echo "\n\n=== Test Complete ===\n";
?>
