<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
// Tambahan: Import ContactController agar tidak error "Class not found"
use App\Http\Controllers\ContactController;

// halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authentication & Email Verification
require __DIR__.'/auth.php';
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// email verifikasi
Route::get('/email/verify/{id}/{hash}', function () {
    // ...
})->middleware(['auth', 'signed'])->name('verification.verify');

// dashboard route untuk user yang sudah terverifikasi
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// shop routes
use App\Http\Controllers\Shop\ProductController as ShopProductController;

Route::get('/shop', [ShopProductController::class, 'index'])->name('products.index');
Route::get('/products', [ShopProductController::class, 'index'])->name('products.shop');
Route::get('/products/{product}', [ShopProductController::class, 'show'])->name('products.show');

// profile (Mengizinkan user untuk mengedit profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// product routes
Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
Route::get('/admin/products/{id}', [ProductController::class, 'show'])->name('admin.products.show');

// cart routes
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
});

// transaction routes
Route::middleware('auth')->group(function () {

    // checkout route
    Route::post('/checkout', [TransactionController::class, 'checkout'])
        ->name('checkout');

    // riwayat transaksi
    Route::get('/transactions', [TransactionController::class, 'history'])
        ->name('transactions.history');

    // deatil transaksi
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])
        ->name('transactions.show');

    Route::get('/appointment/create', [AppointmentController::class, 'create'])
        ->name('appointment.create');
});

// review routes
Route::middleware('auth')->group(function () {
    Route::post('/products/{productId}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
});

// CONTACT
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
