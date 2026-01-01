<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * MINI PANEL KLIENTA
     * → jedna karta
     * → fullscreen
     * → mobile-first
     */
    public function loyaltyCard()
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        // Jedna karta przypisana do klienta
        $card = LoyaltyCard::with('firm')
            ->where('client_id', $client->id)
            ->latest()
            ->first();

        if (! $card) {
            abort(404, 'Brak przypisanej karty lojalnościowej');
        }

        return view('client.card.show', [
            'card'   => $card,
            'client' => $client,
        ]);
    }
}
