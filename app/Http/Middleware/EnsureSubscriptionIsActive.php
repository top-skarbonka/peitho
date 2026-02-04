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
         * 🔥 ADMIN OVERRIDE
         * jeśli admin ręcznie odblokuje firmę
         */
        if (isset($firm->subscription_manual_block) 
            && $firm->subscription_manual_block == false) {
            return $next($request);
        }

        /**
         * brak daty = traktujemy jako aktywną
         * (ważne na start SaaS żeby nie zablokować wszystkich)
         */
        if (!$firm->subscription_ends_at) {
            return $next($request);
        }

        $endsAt = Carbon::parse($firm->subscription_ends_at);

        /**
         * ✅ abonament aktywny
         */
        if ($endsAt->isFuture()) {
            return $next($request);
        }

        /**
         * 🔥 GRACE PERIOD — 3 dni
         */
        if ($endsAt->copy()->addDays(3)->isFuture()) {

            session()->flash(
                'subscription_warning',
                '⚠️ Twój abonament wygasł. Masz 3 dni na opłacenie zanim konto zostanie zablokowane.'
            );

            return $next($request);
        }

        /**
         * 🔴 PO GRACE — BLOKADA
         */
        return response()->view('firm.subscription-blocked');
    }
}
