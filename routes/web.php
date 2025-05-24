<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookIssueController;
use App\Http\Controllers\BookReturnController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('authors',    AuthorController::class);
Route::resource('books',      BookController::class);
Route::resource('readers',    ReaderController::class);
Route::resource('issues',     BookIssueController::class);
Route::resource('returns',    BookReturnController::class);


Route::prefix('api')->middleware('api')->group(function() {
    Route::post('login',   [AuthController::class, 'login']);
    Route::post('logout',  [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::post('me',      [AuthController::class, 'me'])->middleware('auth:api');

    Route::middleware('auth:api')->group(function() {
        Route::apiResource('authors',    AuthorController::class);
        Route::apiResource('books',      BookController::class);
        Route::apiResource('readers',    ReaderController::class);
        Route::apiResource('issues',     BookIssueController::class);
        Route::apiResource('returns',    BookReturnController::class);
    });
});
