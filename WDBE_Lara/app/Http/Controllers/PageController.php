<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // Show the homepage
    public function home()
    {
        return view('homepage'); // looks for resources/views/homepage.blade.php
    }
}
