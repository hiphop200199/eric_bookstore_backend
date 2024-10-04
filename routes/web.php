<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('getProducts',[ProductController::class,'getProducts']);
Route::get('getMonthlyNewProducts',[ProductController::class,'getMonthlyNewProducts']);
Route::get('getProduct',[ProductController::class,'getProduct']);
require __DIR__.'/auth.php';
