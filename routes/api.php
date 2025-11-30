<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Admin\ProductAdminController;
use App\Http\Controllers\Api\Admin\CategoryAdminController;
use App\Http\Controllers\Api\Admin\TransactionAdminController;
use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;

// ----------------------
// PUBLIC ROUTES - USER
// ----------------------

Route::get('/test', function() {
    return response()->json(['status' => 'API working!', 'timestamp' => now()]);
});

Route::post('/user/register', [AuthController::class, 'registerUser']);
Route::post('/user/login', [AuthController::class, 'loginUser']);

// Public Product & Category Routes
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{id}', [CategoryController::class, 'show']);

// ----------------------
// PROTECTED ROUTES - USER
// ----------------------
Route::middleware('auth:sanctum')->group(function () {
    // User Auth Routes
    Route::post('/user/logout', [AuthController::class, 'logout']);
    Route::get('/user/profile', [AuthController::class, 'profile']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
    
    // Transaction Routes (menggunakan prefix untuk menghindari konflik)
    Route::prefix('transactions')->group(function () {
        Route::post('/', [TransactionController::class, 'store']);          // POST /api/Transactions
        Route::get('/my', [TransactionController::class, 'myTransactions']); // GET /api/transactions/my
    });
});

// ----------------------
// PUBLIC ROUTES - ADMIN
// ----------------------
Route::prefix('admin')->group(function () {
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// ----------------------
// PROTECTED ROUTES - ADMIN
// ----------------------
Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    // Admin Auth Routes
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::get('/profile', [AdminAuthController::class, 'profile']); 
    
    // Admin Product Management
    Route::post('/product', [ProductAdminController::class, 'store']);
    Route::put('/product/{id}', [ProductAdminController::class, 'update']);
    Route::delete('/product/{id}', [ProductAdminController::class, 'destroy']);
    
    // Admin Category Management
    Route::post('/category', [CategoryAdminController::class, 'store']);
    Route::put('/category/{id}', [CategoryAdminController::class, 'update']);
    Route::delete('/category/{id}', [CategoryAdminController::class, 'destroy']);

    Route::prefix('transactions')->group(function () {
    Route::get('/', [TransactionAdminController::class, 'index']);           // GET /api/Transactions
    Route::get('/status/{status}', [TransactionAdminController::class, 'getByStatus']); // GET /api/transactions/status/{status}
    Route::get('/user/{userId}', [TransactionAdminController::class, 'getByUser']); // GET /api/transactions/user/{userId}
    Route::get('/{id}', [TransactionAdminController::class, 'show']);        // GET /api/transactions/{id}
    Route::put('/{id}', [TransactionAdminController::class, 'update']);      // PUT /api/transactions/{id}
    Route::delete('/{id}', [TransactionAdminController::class, 'destroy']);  // DELETE /api/transactions/{id}
    Route::patch('/{id}/status', [TransactionAdminController::class, 'updateStatus']); // PATCH /api/transactions/{id}/status
    });
});