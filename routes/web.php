<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\GroomerController;
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

// --- 1. HALAMAN PUBLIC ---
Route::get('/', function () {
    $products = Product::latest()->get();
    return view('welcome', compact('products'));
})->name('welcome');

// Shop & Services
Route::get('/products', [ShopProductController::class, 'index'])->name('products.index');
Route::get('/shop', [ShopProductController::class, 'index'])->name('products.shop');
Route::get('/products/{product_id}', [ShopProductController::class, 'show'])->name('products.show');
Route::get('/services', [ShopServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ShopServiceController::class, 'show'])->name('services.show');
Route::get('/book/{service_id}', [AppointmentController::class, 'createForm'])->name('appointments.form');

// Reviews & Contact
Route::get('/api/products/reviews', [ReviewController::class, 'getAllReviews']);
Route::post('/api/products/{productId}/review', [ReviewController::class, 'storeApi']);
Route::get('/api/products/featured', [ShopProductController::class, 'getFeaturedProducts']);
Route::post('/contact/send', [ContactController::class, 'store'])->name('contact.send');


// --- 2. AUTHENTICATION ROUTES ---
require __DIR__.'/auth.php';


// --- 3. HALAMAN USER BIASA (LOGIN DIPERLUKAN) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard User
    Route::get('/dashboard', function () {
        $products = Product::latest()->get();
        return view('dashboard', compact('products'));
    })->name('dashboard');

    // Profile & Cart
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.add');
    Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

    // Transaction & Payment
    Route::get('/checkout', [TransactionController::class, 'showCheckoutPage'])->name('checkout');
    Route::post('/checkout', [TransactionController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/checkout/success/{id}', [TransactionController::class, 'success'])->name('checkout.success');
    Route::get('/transactions', [TransactionController::class, 'history'])->name('transactions.history');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{id}', [PaymentController::class, 'process'])->name('payment.process');

    // Appointment
    Route::get('/appointment/create', [AppointmentController::class, 'create'])->name('appointment.create'); // Form Booking
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store'); // Proses Simpan

    // [FIX] INI RUTE YANG HILANG (Halaman Sukses/Konfirmasi)
    Route::get('/appointment/success', [AppointmentController::class, 'index'])->name('appointment.index');

    Route::get('/appointment/history', [AppointmentController::class, 'history'])->name('appointments.history');

    Route::get('/my-orders', [TransactionController::class, 'index'])->name('user.orders');

    Route::get('/my-appointments', [AppointmentController::class, 'myAppointments'])->name('user.appointments');

    // Resources
    Route::resource('pets', PetController::class);
    Route::resource('groomers', GroomerController::class);

}); // Penutup Grup Auth


// --- 4. HALAMAN KHUSUS KURIR ---
Route::middleware(['auth', 'role:courier'])->group(function () {
    Route::get('/courier', [CourierController::class, 'index'])->name('courier.index');
    Route::post('/courier/delivery/{id}/update', [CourierController::class, 'updateStatus'])->name('courier.updateStatus');
});


// --- 5. HALAMAN KHUSUS GROOMER ---
Route::middleware(['auth', 'role:groomer'])->group(function () {
    Route::get('/groomer', [GroomerController::class, 'index'])->name('groomer.index');
    Route::post('/groomer/appointment/{id}/update', [GroomerController::class, 'updateStatus'])->name('groomer.updateStatus');
});


// --- 6. HALAMAN KHUSUS ADMIN ---
Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('admin')->name('admin.')->group(function() {
        // Staff Management
        Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
        Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
        Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
        Route::delete('/staff/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
        Route::post('/orders/{id}/approve', [AdminController::class, 'approveOrder'])->name('orders.approve');

        // Product Management
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Appointment Management
        Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments.index');
        Route::post('/appointments/{id}/update', [AdminController::class, 'updateAppointmentStatus'])->name('appointments.update');

        Route::get('/messages', [AdminController::class, 'messages'])->name('messages.index');
        Route::delete('/messages/{id}', [AdminController::class, 'deleteMessage'])->name('messages.destroy');

        Route::get('/reports', [AdminController::class, 'reports'])->name('reports.index');
        Route::get('/reports/export', [AdminController::class, 'exportPdf'])->name('reports.export');
    });
});
