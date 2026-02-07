<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAuthController extends Controller
{
    /**
     * Formularz logowania klienta
     */
    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    /**
     * Logowanie klienta (PHONE + PASSWORD)
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'phone'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $ok = Auth::guard('client')->attempt([
            'phone'    => $data['phone'],
            'password' => $data['password'],
        ]);

        if (! $ok) {
            return back()->withErrors([
                'phone' => 'Nieprawidłowy numer telefonu lub hasło',
            ]);
        }

        // Bezpieczna sesja
        $request->session()->regenerate();

        // ✅ PO LOGOWANIU → PORTFEL KART (DASHBOARD)
        return redirect()->route('client.dashboard');
    }

    /**
     * Wylogowanie klienta
     */
    public function logout(Request $request)
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login');
    }
}
