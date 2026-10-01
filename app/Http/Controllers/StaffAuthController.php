<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffAuthController extends Controller
{
    /**
     * Show staff registration page.
     */
    public function showRegister()
    {
        return view('staff.register');
    }

    /**
     * Register staff application.
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

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
            'staff_status' => 'pending',
        ]);

        return redirect()
            ->route('staff.login')
            ->with(
                'success',
                'Staff application submitted successfully. Please wait for administrator approval.'
            );
    }

    /**
     * Show staff login page.
     */
    public function showLogin()
    {
        return view('staff.login');
    }

    /**
     * Staff login.
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

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()
                ->withErrors([
                    'email' => 'No staff account was found with this email.',
                ])
                ->withInput(
                    $request->only('email')
                );
        }

        if ($user->role !== 'staff') {
            return back()
                ->withErrors([
                    'email' => 'This account is not registered as staff.',
                ])
                ->withInput(
                    $request->only('email')
                );
        }

        if ($user->staff_status !== 'approved') {

            if ($user->staff_status === 'pending') {
                $message = 'Your staff application is still pending administrator approval.';
            } elseif ($user->staff_status === 'rejected') {
                $message = 'Your staff application has been rejected.';
            } elseif ($user->staff_status === 'suspended') {
                $message = 'Your staff account has been suspended.';
            } else {
                $message = 'Your staff account is not currently approved.';
            }

            return back()
                ->withErrors([
                    'email' => $message,
                ])
                ->withInput(
                    $request->only('email')
                );
        }

        if (!Hash::check(
            $credentials['password'],
            $user->password
        )) {
            return back()
                ->withErrors([
                    'email' => 'Invalid email or password.',
                ])
                ->withInput(
                    $request->only('email')
                );
        }

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('staff.dashboard');
    }

    /**
     * Staff logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('staff.login')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }
}

