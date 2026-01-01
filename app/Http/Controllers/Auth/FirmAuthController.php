<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirmAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('firm.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'firm_id'  => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        // UWAGA: logujemy NA GUARDZIE "company" i po polu firm_id
        $ok = Auth::guard('company')->attempt([
            'firm_id'  => $data['firm_id'],
            'password' => $data['password'],
        ]);

        if (!$ok) {
            return back()
                ->withInput($request->only('firm_id'))
                ->withErrors(['firm_id' => 'Błędne ID firmy lub hasło.']);
        }

        // Bezpieczna sesja
        $request->session()->regenerate();

        return redirect()->route('company.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('company')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('company.login');
    }
}
