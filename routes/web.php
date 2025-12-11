<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Shop\ServiceController as ShopServiceController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

// --- HALAMAN PUBLIC (Bisa diakses tanpa login) ---

Route::get('/', function () {
    $products = Product::latest()->get();
    return view('welcome', compact('products'));
})->name('welcome');

// Shop / Katalog Produk
Route::get('/products', [ShopProductController::class, 'index'])->name('products.index');
Route::get('/shop', [ShopProductController::class, 'index'])->name('products.shop');
Route::get('/products/{product_id}', [ShopProductController::class, 'show'])->name('products.show');

// Services
Route::get('/services', [ShopServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ShopServiceController::class, 'show'])->name('services.show');
Route::get('/book/{service_id}', [AppointmentController::class, 'createForm'])->name('appointments.form');

// Reviews API
Route::get('/api/products/reviews', [ReviewController::class, 'getAllReviews']);
Route::post('/api/products/{productId}/review', [ReviewController::class, 'storeApi']);
Route::get('/api/products/featured', [ShopProductController::class, 'getFeaturedProducts']);

// Contact Us
Route::post('/contact/send', [ContactController::class, 'store'])->name('contact.send');

// Halaman Kurir (Public Quick View)
Route::get('/kurir', function () {
    return view('kurir.index');
})->name('kurir.index');


// --- AUTHENTICATION ROUTES ---
require __DIR__.'/auth.php';


// --- HALAMAN YANG BUTUH LOGIN (AUTH) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard User
    Route::get('/dashboard', function () {
        $products = Product::latest()->get();
        return view('dashboard', compact('products'));
    })->name('dashboard');

    // 1. PROFILE ROUTES
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. CART ROUTES
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

    // 3. TRANSACTION & CHECKOUT ROUTES
    Route::get('/checkout', [TransactionController::class, 'showCheckoutPage'])->name('checkout');
    Route::post('/checkout', [TransactionController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success/{id}', [TransactionController::class, 'success'])->name('checkout.success');
    Route::get('/transactions', [TransactionController::class, 'history'])->name('transactions.history');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');

    // 4. PAYMENT ROUTES
    Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{id}', [PaymentController::class, 'process'])->name('payment.process');

    // 5. APPOINTMENT ROUTES
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::post('/appointments/create', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointment/confirmation', [AppointmentController::class, 'confirmation'])->name('appointments.confirmation');
    Route::get('/appointments/history', [AppointmentController::class, 'history'])->name('appointments.history');

    // 6. PETS & GROOMERS RESOURCE
    Route::resource('pets', PetController::class);
    Route::resource('groomers', \App\Http\Controllers\GroomerController::class);
});


// --- HALAMAN KHUSUS ADMIN (Middleware Role:Admin) ---
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // SEMUA ROUTE ADMIN DI SINI
    Route::prefix('admin')->name('admin.')->group(function() {

        // Staff Management
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

        // Product Management
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });
});
