<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * showLoginForm() — Show the login page
     * Route: GET /login
     * View:  resources/views/auth/login.blade.php
     */
    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * login() — Handle the login form submission
     * Route: POST /login
     */
    public function login(Request $request)
    {
        // Validate the input
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to log in with given credentials
        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            // Regenerate session to prevent session fixation attacks
            $request->session()->regenerate();

            // Redirect to role-based dashboard
            return redirect()->route('dashboard');
        }

        // Login failed — go back with error
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'These credentials do not match our records.',
            ]);
    }

    /**
     * logout() — Log the user out
     * Route: POST /logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
                         ->with('success', 'You have been logged out.');
    }
}