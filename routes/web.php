<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

//Product Routes
Route::get('/products', [ProductController::class, 'index'])
->name('products.index');

Route::post('/products', [ProductController::class, 'store'])
->name('products.store');

Route::delete('/products/{id}', [ProductController::class, 'destroy'])
->name('products.delete');


Route::put('/products/{id}', [ProductController::class, 'update'])
->name('products.update');

//Category Routes

Route::get('/categories', [CategoryController::class, 'index'])
->name('categories.index');

Route::post('/categories', [CategoryController::class, 'store'])
->name('categories.store');

Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])
->name('categories.delete');

Route::put('/categories/{id}', [CategoryController::class, 'update'])
->name('categories.update');