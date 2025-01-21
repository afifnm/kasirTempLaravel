<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Arah jika sudah login
Route::middleware('guest')->group(function () {
    Route::get('/login',[AuthController::class,'loginForm'])->name('login');
    Route::post('/login', [AuthController::class,'login']);
});

//Arah jika belum login
Route::middleware(['auth'])->group(function (){
    Route::post('/logout', [AuthController::class,'logout'])->name('logout');
    Route::get('/',[HomeController::class, 'index'])->name('dashboard');

    //User Page
    Route::get('/user',[UserController::class,'index'])->name('user');
    Route::post('/user',[UserController::class,'store'])->name('user.store'); 
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');

    //Product Page
    Route::get('/product',[ProductController::class,'index'])->name('product');
    Route::post('/product',[ProductController::class,'store'])->name('product.store'); 
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');

    //Transaction Page
    Route::get('/transaction',[TransactionController::class, 'index'])->name('transaction');
    Route::get('/transaction/sell',[TransactionController::class, 'sell'])->name('transaction.sell');
});