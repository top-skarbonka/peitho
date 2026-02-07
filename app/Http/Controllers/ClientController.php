<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyCard;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ClientController extends Controller
{
    /**
     * 📊 DASHBOARD KLIENTA
     * - pokazuje tylko kategorie, w których klient ma karty
     * - w środku listy firm (kart)
     */
    public function dashboard()
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        $cards = LoyaltyCard::with(['firm', 'stamps'])
            ->where('client_id', $client->id)
            ->get();

        $grouped = $cards
            ->groupBy(function ($card) {
                return $card->firm->card_template ?? 'classic';
            })
            ->map(function ($cards) {
                return $cards->map(function ($card) {
                    $max = (int) ($card->firm->stamps_required ?? 10);
                    if ($max < 1) {
                        $max = 10;
                    }

                    $current = min($card->stamps->count(), $max);

                    return [
                        'card'        => $card,
                        'current'     => $current,
                        'max'         => $max,
                        'rewardReady' => $current >= $max,
                    ];
                });
            });

        return view('client.dashboard', [
            'client'  => $client,
            'grouped' => $grouped,
        ]);
    }

    /**
     * 🎫 POJEDYNCZA KARTA (klikana z dashboardu)
     */
    public function showCard(LoyaltyCard $card)
    {
        $client = Auth::guard('client')->user();

        if (! $client || $card->client_id !== $client->id) {
            abort(403);
        }

        $maxStamps = (int) ($card->firm->stamps_required ?? 10);
        if ($maxStamps < 1) {
            $maxStamps = 10;
        }

        $current = min($card->stamps->count(), $maxStamps);

        $displayCode = str_pad((string) $card->id, 8, '0', STR_PAD_LEFT);

        $qrPayload = $card->qr_code ?: ('CARD:' . $card->id);

        $qr = QrCode::format('svg')
            ->size(170)
            ->margin(0)
            ->generate($qrPayload);

        $template = $card->firm->card_template ?? 'classic';

        $allowed = [
            'classic',
            'florist',
            'hair_salon',
            'pizzeria',
            'kebab',
            'cafe',
        ];

        if (! in_array($template, $allowed, true)) {
            $template = 'classic';
        }

        return view("client.cards.$template", [
            'card'        => $card,
            'client'      => $client,
            'firm'        => $card->firm,
            'maxStamps'   => $maxStamps,
            'current'     => $current,
            'displayCode' => $displayCode,
            'qr'          => $qr,
        ]);
    }

    /**
     * 🎫 STARA LOGIKA – zachowana (np. link bez dashboardu)
     */
    public function loyaltyCard()
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        $card = LoyaltyCard::with(['firm', 'stamps'])
            ->where('client_id', $client->id)
            ->latest()
            ->first();

        if (! $card) {
            abort(404, 'Brak przypisanej karty lojalnościowej');
        }

        return $this->showCard($card);
    }
}
