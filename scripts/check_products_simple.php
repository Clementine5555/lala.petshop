<?php
// Test if products render correctly
$app = require_once __DIR__ . '/../bootstrap/app.php';

use App\Models\Product;

$products = Product::with('reviews')->get();

echo "Products Found: " . $products->count() . "\n\n";

foreach ($products as $product) {
    $avgRating = $product->getAverageRatingAttribute();
    $reviewCount = $product->getReviewsCountAttribute();
    echo "✓ {$product->name}\n";
    echo "  - Price: Rp " . number_format($product->price) . "\n";
    echo "  - Stock: {$product->stock}\n";
    echo "  - Avg Rating: " . ($avgRating > 0 ? $avgRating : "No rating yet") . "\n";
    echo "  - Reviews: " . ($reviewCount > 0 ? $reviewCount : "No reviews yet") . "\n";
    echo "\n";
}
?>
