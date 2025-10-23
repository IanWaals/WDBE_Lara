<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PageController extends Controller
{
    // Show the homepage
    public function home()
    {
        return view('homepage'); // looks for resources/views/index.blade.php
    }

    // Show the products page
    public function products()
    {
        return view('products'); // looks for resources/views/products.blade.php
    }

    public function about()
    {
        return view('about'); // looks for resources/views/about.blade.php
    }

    public function loginregister()
    {
        return view('loginregister'); // looks for resources/views/contact.blade.php
    }

    public function admin()
    {
        // Fetch all products from database
        $products = DB::table('products')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin', compact('products'));
    }

    public function contact()
    {
        return view('contact'); // looks for resources/views/contact.blade.php
    }
}