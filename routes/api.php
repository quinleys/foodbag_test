<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('v1')->middleware('auth:api')->group(function () {
    Route::controller(\App\Http\Controllers\AllergyController::class)->group(function () {
        Route::get('/allergies', 'index');
        Route::get('/allergies/{allergy:external_id}', 'show');
    });

    Route::controller(\App\Http\Controllers\ProductController::class)->group(function () {
        Route::get('/products', 'index');
        Route::post('/products/auto-complete', 'autoComplete');
        Route::get('/products/filters', 'filters');
        Route::get('/products/{product:external_id}', 'show');
    });

    Route::controller(\App\Http\Controllers\ProductCategoryController::class)->group(function () {
        Route::get('/product-categories', 'index');
        Route::get('/product-categories/{productCategory:external_id}', 'show');
    });

    Route::get('/heartbeat', \App\Http\Controllers\HeartbeatController::class);
});



