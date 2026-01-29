<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function show()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        if ($request->password !== env('ADMIN_PASSWORD')) {
            return back()->withErrors([
                'password' => 'Nieprawidłowe hasło administratora'
            ]);
        }

        // 🔐 ZAPIS SESJI ADMINA
        Session::put('admin_logged', true);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Session::forget('admin_logged');
        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('admin.login');
    }
}

