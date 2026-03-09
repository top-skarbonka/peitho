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
        $client = Client::where('activation_token', $token)->first();

        if (! $client) {
            return redirect()->route('client.login')
                ->with('error', 'Link jest nieprawidłowy lub wygasł.');
        }

        if ($client->activation_token_expires_at && now()->gt($client->activation_token_expires_at)) {
            return redirect()->route('client.login')
                ->with('error', 'Link wygasł. Poproś obsługę o wysłanie nowego SMS.');
        }

        return view('client.set-password', [
            'token' => $token,
            'phone' => $client->phone,
        ]);
    }

    public function store(Request $request, string $token)
    {
        $client = Client::where('activation_token', $token)->first();

        if (! $client) {
            return redirect()->route('client.login')
                ->with('error', 'Link jest nieprawidłowy lub wygasł.');
        }

        if ($client->activation_token_expires_at && now()->gt($client->activation_token_expires_at)) {
            return redirect()->route('client.login')
                ->with('error', 'Link wygasł. Poproś obsługę o wysłanie nowego SMS.');
        }

        $data = $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $client->password = Hash::make($data['password']);
        $client->password_set = 1;
        $client->activation_token = null;
        $client->activation_token_expires_at = null;
        $client->save();

        return redirect()->route('client.login')
            ->with('success', 'Hasło ustawione ✅ Możesz się zalogować numerem telefonu.');
    }
}
