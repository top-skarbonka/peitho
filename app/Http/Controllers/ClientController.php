<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoyaltyCard;
use App\Models\Transaction;

class ClientController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HISTORIA TRANSAKCJI — PANEL KLIENTA
    |--------------------------------------------------------------------------
    */
    public function transactions()
    {
        $clientId = session('client_id');

        if (! $clientId) {
            return redirect('/');
        }

        $transactions = Transaction::where('client_id', $clientId)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('client.transactions', compact('transactions'));
    }

    /*
    |--------------------------------------------------------------------------
    | KARTA LOJALNOŚCIOWA — PANEL KLIENTA (API / JSON)
    |--------------------------------------------------------------------------
    */
    public function loyaltyCard()
    {
        $clientId = session('client_id');

        if (! $clientId) {
            abort(401);
        }

        $card = LoyaltyCard::where('client_id', $clientId)
            ->where('status', '!=', 'reset')
            ->first();

        if (! $card) {
            return response()->json(null);
        }

        return response()->json([
            'max_stamps'     => $card->max_stamps,
            'current_stamps' => $card->current_stamps,
            'completed'      => $card->status === 'completed',
            'reward'         => $card->reward,
        ]);
    }
}
