<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

#temp route to obtain the csrf token
if(app()->islocal()){
    Route::get('/dev/csrf-token', function (Request $request){
        return response()->json([
            'token' => $request->session()->token(),
        ]);
    });
}


#login
Route::view('/', 'login')->name('login');

Route::post('/', [UserController::class, 'authenticate'])
->name('user.authenticate');

#register
Route::view('/register', 'register')->name('register');

Route::post('/register', [UserController::class, 'store'])
->name('user.store');

#logout
Route::post('/logout', [UserController::class, 'logout'])
->name('logout');


#home
Route::view('/home', 'home')
->middleware('auth')
->name('home');


//Product Routes
Route::get('/products', [ProductController::class, 'index'])
->middleware('auth')
->name('products.index');

Route::post('/products', [ProductController::class, 'store'])
->middleware('auth')
->name('products.store');

Route::delete('/products/{id}', [ProductController::class, 'destroy'])
->middleware('auth')
->name('products.delete');


Route::put('/products/{id}', [ProductController::class, 'update'])
->middleware('auth')
->name('products.update');

//Category Routes

Route::get('/categories', [CategoryController::class, 'index'])
->middleware('auth')
->name('categories.index');

Route::post('/categories', [CategoryController::class, 'store'])
->middleware('auth')
->name('categories.store');

Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])
->middleware('auth')
->name('categories.delete');

Route::put('/categories/{id}', [CategoryController::class, 'update'])
->middleware('auth')
->name('categories.update');
