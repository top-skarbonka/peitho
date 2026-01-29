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

        $adminPassword = env('ADMIN_PASSWORD');

        if (!$adminPassword) {
            return back()->withErrors([
                'password' => 'Brak ADMIN_PASSWORD w .env'
            ]);
        }

        if ($request->password !== $adminPassword) {
            return back()->withErrors([
                'password' => 'Nieprawidłowe hasło administratora'
            ]);
        }

        // ✅ Logujemy admina w sesji
        Session::put('admin_logged_in', true);

        // ✅ KLUCZOWA LINIA — redirect do ISTNIEJĄCEJ trasy
        return redirect()->route('admin.firms.index');
    }

    public function logout()
    {
        Session::forget('admin_logged_in');

        return redirect()->route('admin.login');
    }
}
