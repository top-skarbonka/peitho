<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyCard;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ClientController extends Controller
{
    /**
     * Widok karty lojalnościowej klienta (mobile-first)
     */
    public function loyaltyCard()
    {
        // 👤 ZALOGOWANY KLIENT
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        // 🎫 KARTA + RELACJE
        $card = LoyaltyCard::with(['firm', 'stamps'])
            ->where('client_id', $client->id)
            ->latest()
            ->first();

        if (! $card) {
            abort(404, 'Brak przypisanej karty lojalnościowej');
        }

        // 🔢 MAKS. PIECZĄTEK
        $maxStamps = (int) ($card->firm->stamps_required ?? 10);
        if ($maxStamps < 1) {
            $maxStamps = 10;
        }

        // 🔵 AKTUALNY STAN
        $current = min($card->stamps->count(), $maxStamps);

        // 📊 STATYSTYKI
        $stats = [
            'stamps'       => $current,
            'required'     => $maxStamps,
            'reward_ready' => $current >= $maxStamps,
            'last_visit'   => optional($card->stamps->last())->created_at?->format('d.m.Y'),
        ];

        // 🔢 KOD
        $displayCode = str_pad((string) $card->id, 8, '0', STR_PAD_LEFT);

        // 📦 QR
        $qrPayload = $card->qr_code ?: ('CARD:' . $card->id);

        $qr = QrCode::format('svg')
            ->size(170)
            ->margin(0)
            ->generate($qrPayload);

        // 🎨 SZABLON KARTY — TU BYŁ PROBLEM
        $template = $card->firm->card_template ?? 'classic';

        $allowed = [
            'classic',
            'modern',
            'elegant',
            'gold',
            'florist', // 🌸 KWIACIARNIA — DODANE
        ];

        if (! in_array($template, $allowed, true)) {
            $template = 'classic';
        }

        // 📤 WIDOK
        return view("client.cards.$template", [
            'card'        => $card,
            'client'      => $client,
            'firm'        => $card->firm,
            'maxStamps'   => $maxStamps,
            'current'     => $current,
            'displayCode' => $displayCode,
            'qr'          => $qr,
            'stats'       => $stats,
        ]);
    }
}
