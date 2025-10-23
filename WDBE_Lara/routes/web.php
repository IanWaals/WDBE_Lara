<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Page routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/homepage', [PageController::class, 'home']);
Route::get('/products', [PageController::class, 'products']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/admin', [PageController::class, 'admin']);
Route::get('/contact', [PageController::class, 'contact']);
Route::get('/loginregister', [PageController::class, 'loginregister']);

// Authentication routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::post('/admin/products', [AdminController::class, 'store'])->name('admin.products.store');
Route::put('/admin/products/{id}', [AdminController::class, 'update'])->name('admin.products.update');
Route::delete('/admin/products/{id}', [AdminController::class, 'destroy'])->name('admin.products.destroy');