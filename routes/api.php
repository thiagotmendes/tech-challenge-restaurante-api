<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrderStepController;
use App\Http\Controllers\KitchenOrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/**
 * Client
 */
Route::post('/clients', [ClientController::class, 'store']);
Route::get('/clients', [ClientController::class, 'index']);

/**
 * Products
 */
Route::get('/products', [ProductsController::class, 'index']);
Route::post('/products', [ProductsController::class, 'store']);
Route::put('/products/{id}', [ProductsController::class, 'update']);
Route::delete('/products/{id}', [ProductsController::class, 'destroy']);
Route::get('/products/{id}', [ProductsController::class, 'show']);
Route::get('/products/category/{categoryId}', [ProductsController::class, 'findByCategory']);

/** Order (checkout) */
Route::post('/orders/step', [OrderStepController::class, 'step']);
Route::post('/orders/confirm', [OrderStepController::class, 'confirm']);

/** Cozinha */
Route::prefix('kitchen')->group(function () {
    Route::get('orders', [KitchenOrderController::class, 'index']);
    Route::patch('orders/{id}/status', [KitchenOrderController::class, 'updateStatus']);
});

Route::get('/orders/{token}/track', [\App\Http\Controllers\OrderTrackingController::class, 'track']);
