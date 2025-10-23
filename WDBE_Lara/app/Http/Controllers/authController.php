<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check if user exists with this email
        $user = DB::table('accounts')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()->with('error', 'No account found with this email.');
        }

        // Check if password matches
        if ($user->password !== $request->password) {
            return back()->with('error', 'Incorrect password.');
        }

        // Login successful - store user info in session
        Session::put('user_id', $user->id);
        Session::put('username', $user->username);
        Session::put('email', $user->email);
        Session::put('role', $user->role);

        return redirect()->route('home')->with('success', 'Login successful!');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        // Check if email already exists
        $existingUser = DB::table('accounts')
            ->where('email', $request->email)
            ->first();

        if ($existingUser) {
            return back()->with('error', 'An account with this email already exists.');
        }

        // Insert new user into database
        $userId = DB::table('accounts')->insertGetId([
            'username' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Auto-login after registration
        Session::put('user_id', $userId);
        Session::put('username', $request->name);
        Session::put('email', $request->email);
        Session::put('role', 'user');

        return redirect()->route('home')->with('success', 'Account created successfully!');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}