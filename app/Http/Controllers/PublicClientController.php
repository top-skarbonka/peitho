<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PublicClientController extends Controller
{
    /**
     * ============================
     * GET /join/{slug}
     * STAŁY LINK REJESTRACJI
     * ============================
     */
    public function showRegisterFormByFirm(string $slug)
    {
        $firm = Firm::where('slug', $slug)->firstOrFail();

        return view('client.register', [
            'firm' => $firm,
            'token' => null, // jawnie – brak tokenu
        ]);
    }

    /**
     * ============================
     * POST /join/{firm}
     * REJESTRACJA KLIENTA
     * ============================
     */
    public function registerByFirm(Request $request, int $firm)
    {
        $firm = Firm::findOrFail($firm);

        $request->validate([
            'phone'    => 'required|min:6',
            'password' => 'required|min:4',
        ]);

        // 🔒 1 numer = 1 karta w tej firmie
        if (
            Client::where('phone', $request->phone)
                ->where('firm_id', $firm->id)
                ->exists()
        ) {
            return back()
                ->withErrors([
                    'phone' => 'Ten numer telefonu ma już kartę w tej firmie.',
                ])
                ->withInput();
        }

        // ✅ KLIENT
        $client = Client::create([
            'firm_id'               => $firm->id,
            'program_id'            => $firm->program_id,
            'name'                  => $request->name,
            'phone'                 => $request->phone,
            'postal_code'           => $request->postal_code,
            'password'              => Hash::make($request->password),
            'sms_marketing_consent' => $request->boolean('sms_marketing_consent'),
        ]);

        // ✅ KARTA LOJALNOŚCIOWA
        LoyaltyCard::create([
            'client_id' => $client->id,
            'firm_id'   => $firm->id,
            'program_id'=> $firm->program_id,
            'stamps'    => $firm->start_stamps ?? 0,
        ]);

        // 🔐 logowanie klienta
        auth('client')->login($client);

        return redirect()->route('client.loyalty.card');
    }

    /**
     * ============================
     * WIDOK KARTY KLIENTA
     * TU JEST KLUCZ DO SZABLONÓW
     * ============================
     */
    public function loyaltyCard()
    {
        $client = auth('client')->user();

        $firm = Firm::findOrFail($client->firm_id);

        $card = LoyaltyCard::where('client_id', $client->id)
            ->where('firm_id', $firm->id)
            ->firstOrFail();

        // 🔥 WYBÓR SZABLONU
        $template = $firm->card_template ?? 'classic';

        return view('client.cards.' . $template, [
            'client' => $client,
            'firm'   => $firm,
            'card'   => $card,
        ]);
    }
}
