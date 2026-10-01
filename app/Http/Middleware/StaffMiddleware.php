<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Authentication
        |--------------------------------------------------------------------------
        */

        if (!Auth::check()) {
            return redirect()->route('staff.login');
        }


        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | Staff Verification
        |--------------------------------------------------------------------------
        */

        if (
            $user->role !== 'staff' ||
            $user->staff_status !== 'approved'
        ) {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('staff.login')
                ->withErrors([
                    'email' =>
                        'Your staff account is not authorized to access the staff portal.',
                ]);
        }


        return $next($request);
    }
}

