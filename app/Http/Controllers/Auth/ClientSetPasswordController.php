<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClientSetPasswordController extends Controller
{
    public function show(string $token)
    {
        // 🔥 ZMIANA — password_reset_token zamiast activation_token
        $client = Client::where('password_reset_token', $token)->first();

        if (! $client) {
            return redirect()->route('client.login')
                ->with('error', 'Link jest nieprawidłowy lub wygasł.');
        }

        return view('client.set-password', [
            'token' => $token,
            'phone' => $client->phone,
        ]);
    }

    public function store(Request $request, string $token)
    {
        // 🔥 ZMIANA — password_reset_token
        $client = Client::where('password_reset_token', $token)->first();

        if (! $client) {
            return redirect()->route('client.login')
                ->with('error', 'Link jest nieprawidłowy lub wygasł.');
        }

        $data = $request->validate([
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        $client->password = Hash::make($data['password']);
        $client->password_set = 1;

        // 🔥 czyścimy token
        $client->password_reset_token = null;

        $client->save();

        return redirect()->route('client.login')
            ->with('success', 'Hasło zmienione ✅ Możesz się zalogować.');
    }
}
