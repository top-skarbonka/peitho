<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next)
    {
        $firm = Auth::guard('company')->user();

        // jeśli nie zalogowany – normalnie
        if (!$firm) {
            return $next($request);
        }

        // JEŚLI hasło nie było jeszcze zmienione
        if ($firm->password_changed_at === null) {

            // pozwalamy wejść tylko na stronę zmiany hasła
            if (
                !$request->routeIs('company.password.form') &&
                !$request->routeIs('company.password.update')
            ) {
                return redirect()->route('company.password.form');
            }
        }

        return $next($request);
    }
}
