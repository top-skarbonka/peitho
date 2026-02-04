<?php

namespace App\Http\Controllers;

use App\Models\Firm;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use App\Models\RegistrationToken;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class FirmController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | POMOCNICZE
    |--------------------------------------------------------------------------
    */
    private function firm(): Firm
    {
        $firm = Auth::guard('company')->user();

        if (! $firm) {
            abort(403, 'Brak zalogowanej firmy');
        }

        return $firm;
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD (FIX 500 + STABILNY)
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $firm = $this->firm();

        $totalClients = LoyaltyCard::where('firm_id', $firm->id)
            ->distinct('client_id')
            ->count('client_id');

        $totalTransactions = Transaction::where('firm_id', $firm->id)->count();
        $totalPoints = LoyaltyStamp::where('firm_id', $firm->id)->count();

        $avgPoints = $totalTransactions > 0
            ? round($totalPoints / $totalTransactions, 2)
            : 0;

        // 📊 DZIENNE (7 DNI)
        $dailyLabels = [];
        $dailyValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $dailyLabels[] = $day->format('d.m');
            $dailyValues[] = LoyaltyStamp::where('firm_id', $firm->id)
                ->whereDate('created_at', $day)
                ->count();
        }

        // 📊 MIESIĘCZNE (12 MIESIĘCY)
        $monthlyLabels = [];
        $monthlyValues = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthlyLabels[] = $month->format('m.Y');
            $monthlyValues[] = LoyaltyStamp::where('firm_id', $firm->id)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        // ⬇⬇⬇ KLUCZOWY FIX (ALIASY DLA WIDOKU)
        return view('firm.dashboard', [
            'totalClients'      => $totalClients,
            'totalTransactions' => $totalTransactions,
            'totalPoints'       => $totalPoints,
            'avgPoints'         => $avgPoints,

            // ❗ widok oczekuje Tych nazw
            'chartLabels'       => $dailyLabels,
            'chartValues'       => $dailyValues,

            'monthlyLabels'     => $monthlyLabels,
            'monthlyValues'     => $monthlyValues,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | KARTY STAŁEGO KLIENTA
    |--------------------------------------------------------------------------
    */
    public function loyaltyCards()
    {
        $firm = $this->firm();

        $cards = LoyaltyCard::with('client')
            ->where('firm_id', $firm->id)
            ->latest()
            ->get();

        return view('firm.loyalty-cards.index', compact('cards'));
    }

    /*
    |--------------------------------------------------------------------------
    | LINK REJESTRACYJNY
    |--------------------------------------------------------------------------
    */
    public function generateRegistrationLink()
    {
        $firm = $this->firm();

        RegistrationToken::where('firm_id', $firm->id)->delete();

        $token = RegistrationToken::create([
            'firm_id'    => $firm->id,
            'token'      => Str::uuid(),
            'expires_at' => now()->addDays(30),
        ]);

        return back()->with(
            'registration_link',
            url('/register/card/' . $token->token)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RĘCZNE NAKLEJKI
    |--------------------------------------------------------------------------
    */
    public function addStamp(LoyaltyCard $card)
    {
        $firm = $this->firm();

        if ($card->firm_id !== $firm->id) {
            abort(403);
        }

        if ($card->current_stamps >= $card->max_stamps) {
            return back()->with('error', 'Karta jest już pełna');
        }

        $card->increment('current_stamps');

        LoyaltyStamp::create([
            'loyalty_card_id' => $card->id,
            'firm_id'         => $firm->id,
            'description'     => 'Naklejka (ręcznie)',
        ]);

        if ($card->current_stamps >= $card->max_stamps) {
            $card->update(['status' => 'completed']);
        }

        return back()->with('success', 'Dodano naklejkę');
    }

    /*
    |--------------------------------------------------------------------------
    | 📷 SKAN QR (120 SEKUND BLOKADY)
    |--------------------------------------------------------------------------
    */
    public function scanQr(Request $request)
    {
        $firm = $this->firm();

        $request->validate([
            'code' => 'required|string',
        ]);

        $raw = trim($request->code);

        if (! str_starts_with($raw, 'CARD:')) {
            return back()->with('error', 'Nieznany kod');
        }

        $cardId = (int) str_replace('CARD:', '', $raw);

        $card = LoyaltyCard::where('id', $cardId)
            ->where('firm_id', $firm->id)
            ->first();

        if (! $card) {
            return back()->with('error', 'Karta nie należy do tej firmy');
        }

        // 🔒 BLOKADA 120 SEKUND
        $lockKey = "qr_lock:{$firm->id}:{$card->id}";

        if (Cache::has($lockKey)) {
            return back()->with('lock_seconds', 120);
        }

        Cache::put($lockKey, true, now()->addSeconds(120));

        if ($card->current_stamps >= $card->max_stamps) {
            return back()->with('error', 'Karta jest już pełna');
        }

        $card->increment('current_stamps');

        LoyaltyStamp::create([
            'loyalty_card_id' => $card->id,
            'firm_id'         => $firm->id,
            'description'     => 'Naklejka (QR)',
        ]);

        if ($card->current_stamps >= $card->max_stamps) {
            $card->update(['status' => 'completed']);
        }

        return back()->with('success', '✅ Naklejka dodana');
    }
}
