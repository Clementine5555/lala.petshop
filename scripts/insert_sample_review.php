<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Review;

$user = DB::select('SELECT user_id FROM users LIMIT 1');
$product = DB::select('SELECT product_id FROM products LIMIT 1');

if (empty($user) || empty($product)) {
    echo "Missing user or product to create a sample review.\n";
    echo "Users found: "; print_r($user);
    echo "Products found: "; print_r($product);
    exit(1);
}

$userId = $user[0]->user_id;
$productId = $product[0]->product_id;

$review = Review::create([
    'product_id' => $productId,
    'user_id' => $userId,
    'rating' => 5,
    'comment' => 'Automated test review from script',
]);

print_r($review->toArray());
echo "\nInserted review_id: " . ($review->review_id ?? 'n/a') . "\n";
