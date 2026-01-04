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
     * REJESTRACJA PRZEZ TOKEN (KAMPANIE / PROMOCJE)
     */
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

        $firm = Firm::findOrFail($tokenRow->firm_id);
        $programId = $firm->program_id;

        $data = $request->validate([
            'phone'    => ['required', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        $existingClient = Client::where('phone', $data['phone'])->first();

        if ($existingClient) {
            $alreadyHasCard = LoyaltyCard::where('client_id', $existingClient->id)
                ->where('firm_id', $firm->id)
                ->exists();

            if ($alreadyHasCard) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'phone' => 'Ten numer telefonu ma już kartę w tej firmie. Zaloguj się.',
                    ]);
            }
        }

        $client = Client::firstOrCreate(
            ['phone' => $data['phone']],
            [
                'password'   => Hash::make($data['password']),
                'program_id' => $programId,
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
     * STAŁY LINK / QR – BEZ TOKENA (NA ZAWSZE)
     * /join/{firm}
     */
    public function showRegisterFormByFirm(Firm $firm)
    {
        return view('client.register', [
            'firm'  => $firm,
            'token' => null,
        ]);
    }
}
