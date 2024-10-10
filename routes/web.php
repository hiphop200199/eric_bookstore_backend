<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('getProducts',[ProductController::class,'getProducts']);
Route::get('getMonthlyNewProducts',[ProductController::class,'getMonthlyNewProducts']);
Route::get('getProduct',[ProductController::class,'getProduct']);
Route::get('getItems',[CartController::class,'getItems']);
Route::post('addItem',[CartController::class,'addItem']);
Route::put('editItem',[CartController::class,'editItem']);
Route::delete('removeItem',[CartController::class,'removeItem']);
Route::post('checkout',[CartController::class,'checkout']);

require __DIR__.'/auth.php';
