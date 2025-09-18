<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Use PostController for homepage to show posts and handle form
Route::get('/', [PostController::class, 'index'])->name('homepage');

// Show all posts (GET request to /posts) - now redirects to homepage
Route::get('/posts', function () {
    return redirect('/');
});

// Handle form submission to add a post (POST request to /posts)
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');