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

        $ok = Auth::guard('company')->attempt([
            'firm_id'  => $data['firm_id'],
            'password' => $data['password'],
        ]);

        if (!$ok) {
            return back()
                ->withInput($request->only('firm_id'))
                ->withErrors(['firm_id' => 'Błędne ID firmy lub hasło.']);
        }

        $request->session()->regenerate();

        $firm = Auth::guard('company')->user();

        // 🔥 poprawiony warunek
        if ($firm->program_type === 'passes') {
            return redirect()->route('company.passes.index');
        }

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
