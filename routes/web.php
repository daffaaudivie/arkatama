<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;

// Homepage
Route::get('/', function () {
    return redirect()->route('login');
});

// ----------------------------
// USER ROUTES (frontend)
// ----------------------------
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    // Products for user
    Route::resource('products', ProductController::class)
        ->only(['index', 'show']);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/payment', [CheckoutController::class, 'paymentPage'])->name('payment.page');

    // Tombol checkout untuk menyimpan transaksi
    Route::post('/payment/checkout', [CheckoutController::class, 'checkoutConfirm'])->name('checkout.confirm');
    Route::get('/checkout/confirm_payment/{transaction}', [CheckoutController::class, 'confirmPayment'])->name('checkout.confirm_payment');
    Route::post('/payment/upload/{transaction}', [CheckoutController::class, 'uploadPayment'])->name('checkout.pay');
    Route::post('/checkout/upload-payment/{transaction}', [CheckoutController::class, 'uploadPayment'])->name('checkout.upload_payment');
}); 

// ----------------------------
// ADMIN ROUTES (backend)
// ----------------------------
Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // CRUD resources
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('users', UserController::class);
    Route::resource('transaction-details', TransactionDetailController::class);
});

// Auth routes
require __DIR__.'/auth.php';
