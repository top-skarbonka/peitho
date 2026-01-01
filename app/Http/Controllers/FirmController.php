<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use App\Models\RegistrationToken;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        if (!$firm) {
            abort(403, 'Brak zalogowanej firmy');
        }

        return $firm;
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
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

        // wykres dzienny (7 dni)
        $dailyLabels = [];
        $dailyValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $dailyLabels[] = $day->format('d.m');
            $dailyValues[] = LoyaltyStamp::where('firm_id', $firm->id)
                ->whereDate('created_at', $day)
                ->count();
        }

        // wykres miesięczny (12 miesięcy)
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

        return view('firm.dashboard', [
            'totalClients'      => $totalClients,
            'totalTransactions' => $totalTransactions,
            'totalPoints'       => $totalPoints,
            'avgPoints'         => $avgPoints,
            'chartLabels'       => $dailyLabels,
            'chartValues'       => $dailyValues,
            'monthlyLabels'     => $monthlyLabels,
            'monthlyValues'     => $monthlyValues,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LISTA KART STAŁEGO KLIENTA
    |--------------------------------------------------------------------------
    */

    public function loyaltyCards()
    {
        $firm = $this->firm();

        $cards = LoyaltyCard::with('client')
            ->where('firm_id', $firm->id)
            ->latest()
            ->get();

        return view('firm.loyalty-cards.index', [
            'cards' => $cards,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GENEROWANIE LINKU REJESTRACJI
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

        return redirect()
            ->route('company.loyalty.cards')
            ->with('registration_link', url('/register/card/' . $token->token));
    }

    /*
    |--------------------------------------------------------------------------
    | NAKLEJKI
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
            'description'     => 'Naklejka',
        ]);

        if ($card->current_stamps >= $card->max_stamps) {
            $card->update(['status' => 'completed']);
        }

        return back()->with('success', 'Dodano naklejkę');
    }

    public function resetCard(LoyaltyCard $card)
    {
        $firm = $this->firm();

        if ($card->firm_id !== $firm->id) {
            abort(403);
        }

        $card->update([
            'current_stamps' => 0,
            'status'         => 'active',
        ]);

        return back()->with('success', 'Karta zresetowana');
    }

    public function redeemCard(LoyaltyCard $card)
    {
        $firm = $this->firm();

        if ($card->firm_id !== $firm->id) {
            abort(403);
        }

        if ($card->status !== 'completed') {
            return back()->with('error', 'Karta nie jest pełna');
        }

        $card->update([
            'current_stamps' => 0,
            'status'         => 'active',
        ]);

        return back()->with('success', 'Nagroda odebrana');
    }

    /*
    |--------------------------------------------------------------------------
    | TRANSAKCJE + PUNKTY (jeśli używasz)
    |--------------------------------------------------------------------------
    */

    public function transactions()
    {
        $firm = $this->firm();

        $transactions = Transaction::where('firm_id', $firm->id)
            ->latest()
            ->get();

        return view('firm.transactions', compact('transactions'));
    }

    public function showPointsForm()
    {
        return view('firm.points');
    }

    public function addPoints(Request $request)
    {
        return back()->with('success', 'Dodano punkty');
    }
}
