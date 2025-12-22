<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminSimple
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->get('admin_ok')) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
