<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


Route::get('/', [HomeController::class, 'index']);
Route::get('login', [AuthController::class, 'showFormLogin'])->name('form-login');;
Route::post('login', [AuthController::class, 'login'])->name('login');


Route::group(['middleware' => 'auth'], function () {    

    Route::resource('products', ProductController::class)->except(['show', 'create']);
    Route::get('data-products', [ProductController::class, 'data'])->name('products.data');

    Route::resource('categories', CategoryController::class)->except(['show', 'create']);
    Route::get('data-categories', [CategoryController::class, 'data'])->name('categories.data');

 
    Route::get('/logout', function() {
        Auth::logout();
        return redirect('/login');
    })->name('logout');    
 
});


