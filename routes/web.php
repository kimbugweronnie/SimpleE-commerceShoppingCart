<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('register', [RegisterUserController::class, 'register'])
    ->middleware('guest')
    ->name('register');


Route::get('login', [LoginController::class, 'login'])
    ->middleware('guest')
    ->name('login');

Route::view('cart', 'cart')
    ->middleware(['auth'])
    ->name('cart');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');
    
Route::get('product/{product}', [ProductController::class, 'show'])
    ->middleware(['auth'])
    ->name('product.show');

require __DIR__.'/settings.php';
