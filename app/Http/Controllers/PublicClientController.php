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
        // 🔐 Token
        $tokenRow = RegistrationToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        $firm = Firm::findOrFail($tokenRow->firm_id);
        $programId = $firm->program_id; // ✅ KLUCZOWE

        // ✅ Walidacja
        $data = $request->validate([
            'phone'    => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        // 🚫 OPCJA A — blokada duplikatu karty w tej firmie
        $existingClient = Client::where('phone', $data['phone'])->first();

        if ($existingClient) {
            $alreadyHasCard = LoyaltyCard::where('client_id', $existingClient->id)
                ->where('firm_id', $firm->id)
                ->exists();

            if ($alreadyHasCard) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'phone' => 'Ten numer telefonu ma już kartę w tej firmie. Zaloguj się.',
                    ]);
            }
        }

        // 1️⃣ Klient (ZAWSZE z program_id)
        $client = Client::firstOrCreate(
            ['phone' => $data['phone']],
            [
                'password'   => Hash::make($data['password']),
                'program_id' => $programId,
            ]
        );

        // 2️⃣ Karta stałego klienta
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

        // 3️⃣ AUTO-LOGIN KLIENTA (przygotowanie pod OPCJĘ B)
        Auth::guard('client')->login($client);

        // 4️⃣ Usuwamy token
        $tokenRow->delete();

        return redirect()->route('client.loyalty.card');
    }
}
