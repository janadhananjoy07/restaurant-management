<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    // ADMIN REGISTER PAGE
    public function showRegister()
    {
        return view('admin.auth.register');
    }

   // ADMIN REGISTER
public function register(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = new User();

    $user->name = $data['name'];
    $user->email = $data['email'];
    $user->password = Hash::make($data['password']);

    // ALWAYS ADMIN
    $user->role = 'admin';

    $user->save();

    return redirect()
        ->route('admin.login')
        ->with('success', 'Admin account created successfully. Please login.');
}


    // ADMIN LOGIN PAGE
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    // ADMIN LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();

            return back()->withErrors([
                'email' => 'You do not have administrator access.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Invalid admin email or password.',
        ])->withInput();
    }

    // ADMIN LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
