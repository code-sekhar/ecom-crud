<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'create']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}',[ProductController::class, 'destroy']);

//Cart
Route::post('/carts', [CartController::class, 'store']);
Route::get('/carts', [CartController::class, 'index']);
Route::get('/carts/{id}', [CartController::class, 'show']);
Route::delete('/carts/{id}', [CartController::class, 'destroy']);
Route::put('/carts/{id}', [CartController::class, 'update']);

//Order
Route::post('/orders', [OrderController::class, 'buy']);
