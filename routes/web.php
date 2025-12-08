<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Shop\CourierController;
use App\Http\Controllers\Shop\GroomerController;
use App\Http\Controllers\Shop\PaymentController;
use App\Http\Controllers\Shop\RefundDetailController;
use App\Http\Controllers\Shop\RefundHeaderController;
use App\Http\Controllers\Shop\ServiceController;
use App\Http\Controllers\Shop\supplierController;
use App\Http\Controllers\Shop\TransactionDetailController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\Shop\ServiceController as ShopServiceController;
use App\Http\Controllers\ContactController;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Models\Product;

// halaman utama
Route::get('/', function () {
    $products = Product::latest()->get();

    return view('welcome', compact('products'));
})->name('welcome');

// Authentication & Email Verification
require __DIR__.'/auth.php';
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// email verifikasi
Route::get('/email/verify/{id}/{hash}', function () {
})->middleware(['auth', 'signed'])->name('verification.verify');

// dashboard route untuk user yang sudah terverifikasi
Route::get('/dashboard', function () {
    // pass latest products so dashboard sections can render dynamic product info
    $products = Product::latest()->get();

    return view('dashboard', compact('products'));
})->middleware(['auth', 'verified'])->name('dashboard');

// shop routes
Route::get('/products', [ShopProductController::class, 'index'])->name('products.index');
Route::get('/shop', [ShopProductController::class, 'index'])->name('products.shop');
Route::get('/products/{product_id}', [ShopProductController::class, 'show'])->name('products.show');

// profile (Mengizinkan user untuk mengedit profile)
Route::middleware('auth')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// product routes
Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');
Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

// transaction routes
Route::middleware('auth')->group(function () {

    // checkout route
    Route::post('/transactions/checkout', [TransactionController::class, 'processCheckout'])
    ->name('checkout.submit'); 

    // menampilkan halaman checkout
    Route::get('/checkout', [TransactionController::class, 'showCheckoutPage'])
    ->name('checkout.process');

    // halaman sukses checkout
    Route::get('/transactions/success/{id}', [TransactionController::class, 'success'])
    ->name('transactions.success');

    // riwayat transaksi
    Route::get('/transactions', [TransactionController::class, 'history'])
        ->name('transactions.history');

    // deatil transaksi
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])
        ->name('transactions.show');

    Route::get('/checkout/success', [TransactionController::class, 'success'])->name('checkout.success');
});

// Reviews API 
Route::get('/api/products/reviews', [ReviewController::class, 'getAllReviews']);
Route::post('/api/products/{productId}/review', [ReviewController::class, 'storeApi']);
Route::get('/api/products/featured', [ShopProductController::class, 'getFeaturedProducts']);

// Appointment create route
Route::middleware('auth')->group(function () {
    // menampilkan layanan yang tersedia/entry point pemesanan
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointment.create');

    // Untuk menyimpan appointment (form submit)
    Route::post('/appointments/create', [AppointmentController::class, 'store'])
        ->name('appointments.store');
    Route::get('/appointment/confirmation', [AppointmentController::class, 'confirmation'])->name('appointments.confirmation');

    Route::get('/appointments/history', [AppointmentController::class, 'history'])->name('appointments.history');
    // Route::get('appointments/edit/{id}', [AppointmentController::class, 'edit'])
        // ->name('appointments.edit');
        
    Route::redirect('/appointment', '/appointment/create');
});
// service routes
// list all services (shop) and service detail
Route::get('/services', [ShopServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ShopServiceController::class, 'show'])->name('services.show');
Route::get('/book/{service_id}', [AppointmentController::class, 'createForm'])->name('appointments.form');

// cart routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::resource('pets', PetController::class);
    // Groomer management (listing for admins and groomer profiles)
    Route::resource('groomers', \App\Http\Controllers\GroomerController::class);
});

// contact us routes
Route::post('/contact/send', [ContactController::class, 'store'])->name('contact.send');

// Quick public courier dashboard route (serves Blade view)
Route::get('/kurir', function () {
    return view('kurir.index');
})->name('kurir.index');
