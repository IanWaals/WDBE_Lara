<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('admin'); // looks for resources/views/admin.blade.php
    }

    public function contact()
    {
        return view('contact'); // looks for resources/views/contact.blade.php
    }
}