<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PublicClientController extends Controller
{
    /**
     * PUBLICZNY FORMULARZ REJESTRACJI KARTY
     * /register/card/{firm}
     */
    public function showForm(Firm $firm)
    {
        return view('public.join', compact('firm'));
    }

    /**
     * ZAPIS KLIENTA + KARTY STAŁEGO KLIENTA
     */
    public function submitForm(Request $request, Firm $firm)
    {
        $data = $request->validate([
            'phone'       => ['required', 'string', 'min:5', 'max:32'],
            'name'        => ['required', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:12'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | KLIENT — MUSI MIEĆ program_id (bo kolumna NOT NULL)
        |--------------------------------------------------------------------------
        */
        $client = Client::firstOrCreate(
            [
                'phone'      => $data['phone'],
                'program_id' => $firm->program_id,
            ],
            [
                'name'        => $data['name'],
                'postal_code' => $data['postal_code'] ?? null,
                'points'      => 0,
                'qr_code'     => (string) Str::uuid(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | KARTA STAŁEGO KLIENTA — POWIĄZANA Z TĄ FIRMĄ
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
                'qr_code'        => (string) Str::uuid(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | QR KOD KARTY
        |--------------------------------------------------------------------------
        */
        $qrSvg = QrCode::size(220)->generate(json_encode([
            'firm_id'   => $firm->id,
            'client_id' => $client->id,
            'card_id'   => $card->id,
        ]));

        return view('public.card', compact('firm', 'client', 'card', 'qrSvg'));
    }
}
