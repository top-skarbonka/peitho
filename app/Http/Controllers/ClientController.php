<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyCard;
use Illuminate\Support\Facades\Auth;

// jeśli masz zainstalowane simplesoftwareio/simple-qrcode:
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ClientController extends Controller
{
    /**
     * MINI PANEL KLIENTA → jedna karta → mobile-first
     */
    public function loyaltyCard()
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        // Jedna (najnowsza) karta klienta
        $card = LoyaltyCard::with('firm')
            ->where('client_id', $client->id)
            ->latest()
            ->first();

        if (! $card) {
            abort(404, 'Brak przypisanej karty lojalnościowej');
        }

        // Wymuszamy 12 okienek (jak w projekcie)
        $maxStamps = 12;
        $current   = (int) ($card->current_stamps ?? 0);
        if ($current < 0) $current = 0;
        if ($current > $maxStamps) $current = $maxStamps;

        // Kod do pokazania (8 cyfr jak na wzorze)
        $displayCode = str_pad((string) $card->id, 8, '0', STR_PAD_LEFT);

        // QR – w białym kwadracie, centrowany
        // Zawartość QR: możesz tu dać np. card->qr_code jeśli masz, albo URL do weryfikacji.
        $qrPayload = $card->qr_code ?: ('CARD:' . $card->id);

        $qr = QrCode::format('svg')
            ->size(170)
            ->margin(0)
            ->generate($qrPayload);

        return view('client.card.show', [
            'card'        => $card,
            'client'      => $client,
            'maxStamps'   => $maxStamps,
            'current'     => $current,
            'displayCode' => $displayCode,
            'qr'          => $qr,
        ]);
    }
}

