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
    public function showForm(Firm $firm)
    {
        return view('public.join', compact('firm'));
    }

    public function submitForm(Request $request, Firm $firm)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'phone'       => 'required|string|max:20',
            'email'       => 'required|email',
            'postal_code' => 'required|string|max:10',
            'birthday'    => 'nullable|date',
            'terms'       => 'accepted',
            'privacy'     => 'accepted',
            'marketing'   => 'nullable',
        ]);

        // ===== KLIENT =====
        $client = Client::firstOrCreate(
            [
                'phone'      => $data['phone'],
                'program_id' => $firm->program_id,
            ],
            [
                'email'       => $data['email'],
                'postal_code' => $data['postal_code'],
                'city'        => null,
                'points'      => 0,
                'qr_code'     => (string) Str::uuid(),
            ]
        );

        // ===== KARTA LOJALNOŚCIOWA (10 NAKLEJEK) =====
        $card = LoyaltyCard::firstOrCreate(
            [
                'client_id'  => $client->id,
                'program_id' => $firm->program_id,
            ],
            [
                'max_stamps'     => 10,
                'current_stamps' => 0,
                'status'         => 'active',
                'qr_code'        => (string) Str::uuid(),
            ]
        );

        $qrSvg = QrCode::size(220)->generate(json_encode([
            'client_id' => $client->id,
            'card_id'   => $card->id,
        ]));

        return view('public.card', compact('firm', 'client', 'card', 'qrSvg'));
    }
}
