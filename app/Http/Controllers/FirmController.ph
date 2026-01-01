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
    | POMOCNICZE – FIRMA
    |--------------------------------------------------------------------------
    */

    private function currentFirm(): ?Firm
    {
        return Auth::guard('company')->user();
    }

    private function requireFirm(): Firm
    {
        $firm = $this->currentFirm();

        if (!$firm) {
            abort(403, 'Brak zalogowanej firmy (guard: company)');
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
        $firm = $this->requireFirm();

        // KLIENCI (unikalni po kartach)
        $totalClients = LoyaltyCard::where('firm_id', $firm->id)
            ->whereNotNull('client_id')
            ->distinct('client_id')
            ->count('client_id');

        // TRANSAKCJE
        $totalTransactions = Transaction::where('firm_id', $firm->id)->count();

        // PUNKTY
        $totalPoints = Transaction::where('firm_id', $firm->id)->sum('points');

        // ŚREDNIA PUNKTÓW / TRANSAKCJĘ (bez dzielenia przez 0)
        $avgPoints = $totalTransactions > 0
            ? $totalPoints / $totalTransactions
            : 0;

        return view('firm.dashboard', [
            'totalClients'      => $totalClients,
            'totalTransactions' => $totalTransactions,
            'totalPoints'       => $totalPoints,
            'avgPoints'         => $avgPoints,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | KARTY STAŁEGO KLIENTA
    |--------------------------------------------------------------------------
    */

    public function loyaltyCards()
    {
        $firm = $this->requireFirm();

        $cards = LoyaltyCard::with('client')
            ->where('firm_id', $firm->id)
            ->latest()
            ->get();

        // STATYSTYKI – ZAWSZE ZDEFINIOWANE
        $stats = [
            'cards'    => $cards->count(),
            'stamps'   => $cards->sum('current_stamps'),
            'full'     => $cards->where('current_stamps', '>=', 10)->count(),
            'active30' => $cards->where('updated_at', '>=', now()->subDays(30))->count(),
        ];

        return view('firm.loyalty-cards.index', [
            'cards' => $cards,
            'stats' => $stats,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | GENEROWANIE LINKU REJESTRACJI (TOKEN)
    |--------------------------------------------------------------------------
    */

    public function generateRegistrationLink()
    {
        $firm = $this->requireFirm();

        // Usuwamy stare tokeny (porządek)
        RegistrationToken::where('firm_id', $firm->id)->delete();

        $token = RegistrationToken::create([
            'firm_id'    => $firm->id,
            'token'      => (string) Str::uuid(),
            'expires_at' => now()->addDays(30),
        ]);

        return redirect()
            ->route('company.loyalty.cards')
            ->with('registration_link', url('/register/card/' . $token->token));
    }

    /*
    |--------------------------------------------------------------------------
    | TRANSAKCJE
    |--------------------------------------------------------------------------
    */

    public function transactions()
    {
        $firm = $this->requireFirm();

        $transactions = Transaction::where('firm_id', $firm->id)
            ->latest()
            ->paginate(20);

        return view('firm.transactions.index', [
            'transactions' => $transactions,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PUNKTY – DODAWANIE
    |--------------------------------------------------------------------------
    */

    public function showPointsForm()
    {
        $this->requireFirm();
        return view('firm.points.add');
    }

    public function addPoints(Request $request)
    {
        $firm = $this->requireFirm();

        $data = $request->validate([
            'client_id' => ['required', 'integer'],
            'points'    => ['required', 'integer', 'min:1'],
        ]);

        Transaction::create([
            'firm_id'   => $firm->id,
            'client_id' => $data['client_id'],
            'points'    => $data['points'],
        ]);

        return back()->with('success', 'Punkty dodane.');
    }
}
