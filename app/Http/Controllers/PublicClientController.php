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
    /**
     * ==================================
     * FLOW B — REJESTRACJA PRZEZ TOKEN
     * /register/card/{token}
     * ==================================
     */
    public function showRegisterForm(string $token)
    {
        $tokenRow = RegistrationToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $firm = Firm::findOrFail($tokenRow->firm_id);

        return view('client.register', [
            'firm'  => $firm,
            'token' => $token,
        ]);
    }

    public function register(Request $request, string $token)
    {
        $tokenRow = RegistrationToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $firm = Firm::findOrFail($tokenRow->firm_id);

        $data = $request->validate([
            'phone'    => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        $client = Client::firstOrCreate(
            ['phone' => $data['phone']],
            [
                'password'   => Hash::make($data['password']),
                'program_id' => $firm->program_id,
            ]
        );

        LoyaltyCard::firstOrCreate(
            [
                'client_id' => $client->id,
                'firm_id'   => $firm->id,
            ],
            [
                'current_stamps' => 0,
                'max_stamps'     => 10,
                'status'         => 'active',
            ]
        );

        Auth::guard('client')->login($client);

        $tokenRow->delete();

        return redirect()->route('client.loyalty.card');
    }

    /**
     * ==================================
     * FLOW A — STAŁY LINK DLA FIRMY
     * /join/{firm}
     * ==================================
     */
    public function showRegisterFormByFirm(Firm $firm)
    {
        return view('client.register', [
            'firm'  => $firm,
            'token' => null,
        ]);
    }

    public function registerByFirm(Request $request, Firm $firm)
    {
        $data = $request->validate([
            'phone'       => ['required', 'string', 'max:20'],
            'password'    => ['required', 'string', 'min:4'],
            'name'        => ['nullable', 'string', 'max:120'],
            'postal_code' => ['nullable', 'string', 'max:20'],
        ]);

        $client = Client::firstOrCreate(
            ['phone' => $data['phone']],
            [
                'password'    => Hash::make($data['password']),
                'program_id'  => $firm->program_id,
                'name'        => $data['name'] ?? null,
                'postal_code' => $data['postal_code'] ?? null,
            ]
        );

        LoyaltyCard::firstOrCreate(
            [
                'client_id' => $client->id,
                'firm_id'   => $firm->id,
            ],
            [
                'current_stamps' => 0,
                'max_stamps'     => 10,
                'status'         => 'active',
            ]
        );

        Auth::guard('client')->login($client);

        return redirect()->route('client.loyalty.card');
    }
}
