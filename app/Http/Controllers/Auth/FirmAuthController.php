<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Firm;
use Illuminate\Support\Facades\Hash;

class FirmAuthController extends Controller
{
    // FORMULARZ LOGOWANIA FIRMY
    public function showLoginForm()
    {
        return view('company.login');
    }

    // LOGOWANIE FIRMY
    public function login(Request $request)
    {
        $request->validate([
            'firm_id' => 'required',
            'password' => 'required',
        ]);

        $firm = Firm::where('firm_id', $request->firm_id)->first();

        if (!$firm || !Hash::check($request->password, $firm->password)) {
            return back()->withErrors([
                'error' => 'Nieprawidłowy ID firmy lub hasło.',
            ]);
        }

        // Logowanie – zapiszemy ID firmy w sesji
        session(['firm_id' => $firm->id]);

        return redirect()->route('company.dashboard');
    }

    // WYLOGOWANIE FIRMY
    public function logout()
    {
        session()->forget('firm_id');
        session()->flush();

        return redirect('/company/login')->with('success', 'Zostałeś wylogowany.');
    }
}
