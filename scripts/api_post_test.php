<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ReviewController;

$user = DB::select('SELECT user_id FROM users LIMIT 1');
$product = DB::select('SELECT product_id FROM products LIMIT 1');

if (empty($user) || empty($product)) {
    echo "Missing user or product for API POST test\n";
    exit(1);
}

$userId = $user[0]->user_id;
$productId = $product[0]->product_id;

// Log in the user for Auth facade
Auth::loginUsingId($userId);

$payload = ['rating' => 4, 'comment' => 'API test review'];

$request = Request::create('/api/products/'.$productId.'/review', 'POST', $payload);

$controller = new ReviewController();
$response = $controller->storeApi($request, $productId);

// Print JSON response
echo (string) $response->getContent();

// Show the last inserted review for this user+product
$last = DB::select('SELECT * FROM reviews WHERE user_id = ? AND product_id = ? ORDER BY review_id DESC LIMIT 1', [$userId, $productId]);
print_r($last);
