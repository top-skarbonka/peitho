<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyCard;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ClientController extends Controller
{
    public function loyaltyCard()
    {
        // 👤 Zalogowany klient
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        // 🎫 Karta lojalnościowa
        $card = LoyaltyCard::with(['firm', 'stamps'])
            ->where('client_id', $client->id)
            ->latest()
            ->first();

        if (! $card) {
            abort(404, 'Brak przypisanej karty lojalnościowej');
        }

        // 🔢 LICZBA OKIENEK (ustawienia firmy)
        $maxStamps = (int) ($card->firm->stamps_required ?? 10);
        if ($maxStamps < 1) {
            $maxStamps = 10;
        }

        // 🔵 LICZBA ZEBRANYCH PIECZĄTEK (COUNT relacji!)
        $current = $card->stamps->count();

        if ($current > $maxStamps) {
            $current = $maxStamps;
        }

        // 🔢 KOD DO WYŚWIETLENIA
        $displayCode = str_pad((string) $card->id, 8, '0', STR_PAD_LEFT);

        // 📦 QR
        $qrPayload = $card->qr_code ?: ('CARD:' . $card->id);

        $qr = QrCode::format('svg')
            ->size(170)
            ->margin(0)
            ->generate($qrPayload);

        // 🎨 SZABLON
        $template = $card->firm->card_template ?? 'classic';
        $allowed = ['classic', 'elegant', 'gold', 'modern'];

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
}
