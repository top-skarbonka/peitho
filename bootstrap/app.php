<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;

return Application::configure(basePath: dirname(__DIR__))
->withRouting(
    web: [
        __DIR__.'/../routes/web.php',
        __DIR__.'/../routes/public.php',
    ],
    api: __DIR__.'/../routes/api.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
)
->withMiddleware(function (Middleware $middleware) {

    // ===== ALIASY MIDDLEWARE =====
    $middleware->alias([
        'admin.simple' => \App\Http\Middleware\AdminSimple::class,
    ]);

})

->withExceptions(function (Exceptions $exceptions) {

    $exceptions->render(function (AuthenticationException $e, $request) {

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // 🔥 PANEL KLIENTA (PORTFEL)
        if ($request->is('client') || $request->is('client/*')) {
            return redirect()
                ->route('client.login')
                ->with('session_expired', true);
        }

        // 🔥 PANEL ADMINA
        if ($request->is('admin') || $request->is('admin/*')) {
            return redirect()
                ->route('admin.login')
                ->with('session_expired', true);
        }

        // 🔥 PANEL FIRMY
        if ($request->is('company') || $request->is('company/*')) {
            return redirect()
                ->route('company.login')
                ->with('session_expired', true);
        }

        return redirect()
            ->route('company.login')
            ->with('session_expired', true);
    });

})

->create();
