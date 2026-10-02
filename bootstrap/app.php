<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Trust Railway's reverse proxy
        // so Laravel correctly detects HTTPS.
        $middleware->trustProxies(at: '*');

        /*
        |--------------------------------------------------------------------------
        | CSRF EXCEPTIONS
        |--------------------------------------------------------------------------
        |
        | Cashfree sends the webhook directly to Laravel.
        | It does not have Laravel's CSRF token, so this route
        | must be excluded from CSRF verification.
        |
        */

        $middleware->validateCsrfTokens(except: [
            'payment/cashfree/webhook',
        ]);

        /*
        |--------------------------------------------------------------------------
        | CUSTOM MIDDLEWARE ALIASES
        |--------------------------------------------------------------------------
        */

        $middleware->alias([
            'user.auth' => \App\Http\Middleware\AuthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
