<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use Illuminate\Support\Str;

class ClientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('client.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'phone'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $normalizedPhone = preg_replace('/\D+/', '', $data['phone']);

        if (str_starts_with($normalizedPhone, '48') && strlen($normalizedPhone) === 11) {
            $normalizedPhone = substr($normalizedPhone, 2);
        }

        $ok = Auth::guard('client')->attempt([
            'phone'    => $normalizedPhone,
            'password' => $data['password'],
        ]);

        if (! $ok) {
            return back()->withErrors([
                'phone' => 'Nieprawidłowy numer telefonu lub hasło',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('client.dashboard');
    }

    /**
     * 🔥 FINALNY RESET HASŁA
     */
    public function sendResetLink(Request $request)
    {
        $data = $request->validate([
            'phone' => ['required', 'string'],
        ]);

        $normalizedPhone = preg_replace('/\D+/', '', $data['phone']);

        if (str_starts_with($normalizedPhone, '48') && strlen($normalizedPhone) === 11) {
            $normalizedPhone = substr($normalizedPhone, 2);
        }

        $client = Client::where('phone', $normalizedPhone)->first();

        if (! $client) {
            return back()->withErrors([
                'phone' => 'Nie znaleziono konta z tym numerem telefonu',
            ]);
        }

        // 🔥 GENERUJ TOKEN
        $token = Str::random(64);

        $client->password_reset_token = $token;
        $client->save();

        // 🔥 KLUCZOWE — przekierowanie
        return redirect('/client/set-password/' . $token);
    }

    public function logout(Request $request)
    {
        Auth::guard('client')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('client.login');
    }
}
