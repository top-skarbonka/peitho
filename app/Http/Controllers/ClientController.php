<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyCard;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ClientController extends Controller
{
    /**
     * Widok karty lojalnościowej klienta (mobile-first)
     * Szablon wybierany z firms.card_template (classic/elegant/gold/modern)
     */
    public function loyaltyCard()
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        $card = LoyaltyCard::with('firm')
            ->where('client_id', $client->id)
            ->latest()
            ->first();

        if (! $card) {
            abort(404, 'Brak przypisanej karty lojalnościowej');
        }

        // 🔢 LICZBA OKIENEK (ZGODNIE Z PROJEKTEM)
        $maxStamps = 12;

        // 🔵 ILE JUŻ ZEBRANE
        $current = (int) ($card->current_stamps ?? 0);
        if ($current < 0) $current = 0;
        if ($current > $maxStamps) $current = $maxStamps;

        // 🔢 KOD DO POKAZANIA (8 CYFR)
        $displayCode = str_pad((string) $card->id, 8, '0', STR_PAD_LEFT);

        // 📦 QR (SVG)
        $qrPayload = $card->qr_code ?: ('CARD:' . $card->id);

        $qr = QrCode::format('svg')
            ->size(170)
            ->margin(0)
            ->generate($qrPayload);

        // ✅ WYBÓR SZABLONU (zabezpieczony allow-listą)
        $template = $card->firm->card_template ?? 'gold';

        $allowed = ['classic', 'elegant', 'gold', 'modern', 'show'];
        if (! in_array($template, $allowed, true)) {
            $template = 'gold';
        }

        // Widok:
        // resources/views/client/card/{template}.blade.php
        return view("client.card.$template", [
            'card'        => $card,
            'client'      => $client,
            'maxStamps'   => $maxStamps,
            'current'     => $current,
            'displayCode' => $displayCode,
            'qr'          => $qr,

            // Dodatkowo: dane firmy do ikon/stopki (jeśli są w DB)
            'firm'        => $card->firm,
        ]);
    }
}
