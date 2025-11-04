<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('user_id')) {
            return redirect()->route('home')->with('error', 'Please login to access this page.');
        }

        return $next($request);
    }
}