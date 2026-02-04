<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSubscriptionIsActive
{
    public function handle(Request $request, Closure $next)
    {
        $firm = auth('company')->user();

        if (!$firm) {
            return redirect()->route('company.login');
        }

        /**
         * 🔴 HARD BLOCK
         */
        if ($firm->subscription_forced_status === 'blocked') {
            abort(403, 'Firma została zablokowana przez administratora.');
        }

        /**
         * 🔴 SYSTEM BLOCK
         */
        if ($firm->subscription_status === 'blocked') {
            abort(403, 'Abonament wygasł.');
        }

        return $next($request);
    }
}
