<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;

Route::prefix('user')->as('user.')->group(function () {
   Route::post('/register', [AuthController::class, 'register'])->name('register');
   Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('basket')->as('basket.')->group(function () {
        Route::patch('/update', [BasketController::class, 'update'])->name('update');
    });
    Route::prefix('product')->as('product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/show/{product:id}', [ProductController::class, 'show'])->name('show');
    });
    Route::prefix('order')->as('order.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/show/{order:id}', [OrderController::class, 'show'])->name('show');
        Route::post('/create', [OrderController::class, 'create'])->name('create');
        Route::get('/payment/{payment:id}/{order:id}', [OrderController::class, 'update'])->name('pay');
    });
});
