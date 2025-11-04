<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

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

        // FIXED: Use password_verify for hashed passwords
        if (!Hash::check($request->password, $user->password)) {
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
            'email' => 'required|email|max:255|unique:accounts,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ]);

        // Check if email already exists (redundant with unique validation, but safe)
        $existingUser = DB::table('accounts')
            ->where('email', $request->email)
            ->first();

        if ($existingUser) {
            return back()->with('error', 'An account with this email already exists.');
        }

        // FIXED: Hash the password before storing
        $userId = DB::table('accounts')->insertGetId([
            'username' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
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