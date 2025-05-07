<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', [TestController::class, 'test']);

Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('/products/{id}', [ProductController::class, 'getProductItem']);
Route::post('/products', [ProductController::class, 'createProduct'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::patch('/products/{id}', [ProductController::class, 'updateProduct'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::delete('/products/{id}', [ProductController::class, 'deleteProduct'])->withoutMiddleware([VerifyCsrfToken::class]);
