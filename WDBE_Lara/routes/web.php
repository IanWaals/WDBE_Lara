<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public page routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/homepage', [PageController::class, 'home']);
Route::get('/products', [PageController::class, 'products']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/contact', [PageController::class, 'contact']);
Route::get('/loginregister', [PageController::class, 'loginregister']);

// Authentication routes (public)
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes - require authentication
Route::middleware(['checkAuth'])->group(function () {
    
    // Admin routes - require admin role
    Route::middleware(['checkAdmin'])->group(function () {
        Route::get('/admin', [PageController::class, 'admin'])->name('admin');
        
        // Product CRUD
        Route::post('/admin/products', [AdminController::class, 'store'])->name('admin.products.store');
        Route::put('/admin/products/{id}', [AdminController::class, 'update'])->name('admin.products.update');
        Route::delete('/admin/products/{id}', [AdminController::class, 'destroy'])->name('admin.products.destroy');
        
        // Category CRUD
        Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories');
        Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::put('/admin/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
    });
});