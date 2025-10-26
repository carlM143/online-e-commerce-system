<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NewsletterController;

Route::get('/products',[ProductController::class, 'index']);
Route::post('/checkout', [OrderController::class, 'store']);
Route::post('/subscribe', [NewsletterController::class, 'subscribe']);
