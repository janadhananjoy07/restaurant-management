<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show user registration page.
     */
    public function showRegister()
    {
        return view('auth.register');
    }


    /**
     * Register a new customer.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);


        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);


        return redirect()
            ->route('login')
            ->with(
                'success',
                'Registration successful! Please login.'
            );
    }


    /**
     * Show user login page.
     */
    public function showLogin()
    {
        return view('auth.login');
    }


    /**
     * Login normal customer only.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Check credentials
        |--------------------------------------------------------------------------
        */

        if (!Auth::attempt($credentials)) {

            return back()
                ->withErrors([
                    'email' => 'Invalid email or password.',
                ])
                ->withInput(
                    $request->only('email')
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Regenerate session
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();


        /*
        |--------------------------------------------------------------------------
        | Allow ONLY normal users
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();


        if ($user->role !== 'user') {

            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'email' =>
                        'This login is for customers only. Please use the correct login panel.',
                ])
                ->withInput(
                    $request->only('email')
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Normal Customer Dashboard
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('user.dashboard');
    }


    /**
     * Logout authenticated user.
     */
    public function logout(Request $request)
    {
        Auth::logout();


        $request->session()->invalidate();

        $request->session()->regenerateToken();


        return redirect()
            ->route('login');
    }
}

