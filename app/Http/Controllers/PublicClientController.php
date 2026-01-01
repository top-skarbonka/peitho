<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use App\Models\RegistrationToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PublicClientController extends Controller
{
    public function showRegisterForm(string $token)
    {
        $tokenRow = RegistrationToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $firm = Firm::findOrFail($tokenRow->firm_id);

        return view('client.register', [
            'token' => $token,
            'firm'  => $firm,
        ]);
    }

    public function register(Request $request, string $token)
    {
        $tokenRow = RegistrationToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $data = $request->validate([
            'phone'    => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        // 1️⃣ Klient
        $client = Client::firstOrCreate(
            ['phone' => $data['phone']],
            ['password' => Hash::make($data['password'])]
        );

        // 2️⃣ Karta stałego klienta
        LoyaltyCard::firstOrCreate(
            [
                'client_id' => $client->id,
                'firm_id'   => $tokenRow->firm_id,
            ],
            [
                'current_stamps' => 0,
                'max_stamps'     => 10,
                'status'         => 'active',
            ]
        );

        // 3️⃣ AUTO-LOGIN KLIENTA ✅
        Auth::guard('client')->login($client);
        $request->session()->regenerate();

        // 4️⃣ PROSTO DO KARTY
        return redirect()->route('client.loyalty.card');
    }
}
