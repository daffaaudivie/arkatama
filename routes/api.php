<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\Admin\ProductAdminController;
use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;

// ----------------------
// PUBLIC ROUTES - USER
// ----------------------

Route::get('/test', function() {
    return response()->json(['status' => 'API working!', 'timestamp' => now()]);
});

Route::post('/user/register', [AuthController::class, 'registerUser']);
Route::post('/user/login', [AuthController::class, 'loginUser']);
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/transaction', [TransactionController::class, 'index']);
Route::get('/transaction/{id}', [TransactionController::class, 'show']);

// ----------------------
// PROTECTED ROUTES - USER
// ----------------------
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/user/logout', [AuthController::class, 'logout']);
    Route::get('/user/profile', [AuthController::class, 'profile']);
    Route::put('/user/profile', [AuthController::class, 'updateProfile']);
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
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::get('/profile', [AdminAuthController::class, 'profile']); 
    Route::post('/product', [ProductAdminController::class, 'store']);
    Route::put('/product/{id}', [ProductAdminController::class, 'update']);
    Route::delete('/product/{id}', [ProductAdminController::class, 'destroy']);
});