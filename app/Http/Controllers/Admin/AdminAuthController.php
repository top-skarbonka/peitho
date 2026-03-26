<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $adminPassword = env('ADMIN_PASSWORD');

        if (!$adminPassword) {
            return back()->withErrors([
                'password' => 'Brak ADMIN_PASSWORD w .env',
            ]);
        }

        if ($request->password !== $adminPassword) {
            return back()->withErrors([
                'password' => 'Nieprawidłowe hasło administratora',
            ]);
        }

        $request->session()->put('admin_ok', true);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_ok');

        return redirect()->route('admin.login');
    }
}
