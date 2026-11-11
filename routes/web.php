<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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