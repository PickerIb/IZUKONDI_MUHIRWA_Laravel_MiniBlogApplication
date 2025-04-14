<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Register User
    public function register(Request $request)
    {
        // Validate user input
        $fields = $request->validate([
            'username' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        // Hash the password and create user
        $fields['password'] = bcrypt($fields['password']);
        User::create($fields);

        // Redirect to login with success message
        return redirect()->route('login')->with('success', 'Account registered successfully! Please log in.');
    }

    // Login User
    public function login(Request $request)
    {
        // Validate login credentials
        $fields = $request->validate([
            'email' => ['required', 'max:255', 'email'],
            'password' => ['required'],
        ]);

        // Attempt login
        if (Auth::attempt($fields, $request->remember)) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'failed' => 'The provided credentials do not match our records.',
        ]);
    }

    // Logout User
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
