<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});
Route::middleware('auth')->group(function () {
    Route::get('getItems',[CartController::class,'getItems']);
    Route::post('addItem',[CartController::class,'addItem']);
    Route::put('editItem',[CartController::class,'editItem']);
    Route::delete('removeItem',[CartController::class,'removeItem']);
    Route::post('checkout',[CartController::class,'checkout']);
    Route::put('success',[CartController::class,'success']);
    Route::get('getOrders',[OrderController::class,'getOrders']);
    Route::get('getOrder',[OrderController::class,'getOrder']);
});
Route::get('getProducts',[ProductController::class,'getProducts']);
Route::get('getMonthlyNewProducts',[ProductController::class,'getMonthlyNewProducts']);
Route::get('getPopularProducts',[ProductController::class,'getPopularProducts']);
Route::get('getProduct',[ProductController::class,'getProduct']);


require __DIR__.'/auth.php';
