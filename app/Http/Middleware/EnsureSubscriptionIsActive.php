<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EnsureSubscriptionIsActive
{
    public function handle(Request $request, Closure $next)
    {
        $firm = Auth::guard('company')->user();

        // brak firmy → przepuszczamy
        if (!$firm) {
            return $next($request);
        }

        /**
         * 🔥 ADMIN FORCE BLOCK — NADPISUJE WSZYSTKO
         */
        if ($firm->subscription_forced_status === 'blocked') {
            return response()->view('firm.subscription-blocked');
        }

        /**
         * brak daty = traktujemy jako aktywną
         */
        if (!$firm->subscription_ends_at) {
            return $next($request);
        }

        $endsAt = Carbon::parse($firm->subscription_ends_at);

        /**
         * ✅ ABONAMENT AKTYWNY
         */
        if ($endsAt->isFuture()) {
            return $next($request);
        }

        /**
         * 🔥 GRACE — 3 DNI
         */
        $graceEnds = $endsAt->copy()->addDays(3);

        if ($graceEnds->isFuture()) {

            session()->flash(
                'subscription_warning',
                '⚠️ Abonament wygasł — masz 3 dni na opłacenie, aby uniknąć blokady.'
            );

            return $next($request);
        }

        /**
         * 🔴 PO GRACE — BLOKADA
         */
        return response()->view('firm.subscription-blocked');
    }
}
