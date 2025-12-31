<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use Illuminate\Http\Request;

class PublicClientController extends Controller
{
    /**
     * PUBLICZNY FORMULARZ REJESTRACJI
     * /register/card/{firm}
     */
    public function showForm(Firm $firm)
    {
        return view('public.register-card', compact('firm'));
    }

    /**
     * ZAPIS KLIENTA + UTWORZENIE KARTY STAŁEGO KLIENTA
     */
    public function submitForm(Request $request, Firm $firm)
    {
        $data = $request->validate([
            'phone'       => ['required', 'string', 'min:5', 'max:32'],
            'name'        => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | KLIENT (globalny – po telefonie)
        |--------------------------------------------------------------------------
        */
        $client = Client::firstOrCreate(
            ['phone' => $data['phone']],
            [
                'name'        => $data['name'] ?? null,
                'postal_code' => $data['postal_code'] ?? null,
                'points'      => 0,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | KARTA STAŁEGO KLIENTA (TYLKO DLA TEJ FIRMY)
        |--------------------------------------------------------------------------
        */
        $card = LoyaltyCard::firstOrCreate(
            [
                'client_id' => $client->id,
                'firm_id'   => $firm->id,
            ],
            [
                'max_stamps'     => 10,
                'current_stamps' => 0,
                'status'         => 'active',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | POTWIERDZENIE
        |--------------------------------------------------------------------------
        */
        return view('public.register-success', compact(
            'firm',
            'client',
            'card'
        ));
    }
}
