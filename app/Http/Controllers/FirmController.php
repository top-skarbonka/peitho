<?php

namespace App\Http\Controllers;

use App\Models\Firm;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use App\Models\RegistrationToken;
use App\Models\Transaction;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FirmController extends Controller
{
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

        $dailyLabels = [];
        $dailyValues = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = now()->subDays($i);
            $dailyLabels[] = $day->format('d.m');
            $dailyValues[] = LoyaltyStamp::where('firm_id', $firm->id)
                ->whereDate('created_at', $day)
                ->count();
        }

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

        // ✅ OSTATNIE 10 WEJŚĆ Z KARNETÓW
        $entryLogs = DB::table('pass_entry_logs')
            ->where('firm_id', $firm->id)
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        // 🔐 NOWE – LICZNIK SMS OTP DZIŚ
        $smsToday = DB::table('sms_logs')
            ->where('firm_id', $firm->id)
            ->where('type', 'otp')
            ->whereDate('created_at', today())
            ->count();

        return view('firm.dashboard', [
            'totalClients'      => $totalClients,
            'totalTransactions' => $totalTransactions,
            'totalPoints'       => $totalPoints,
            'avgPoints'         => $avgPoints,
            'chartLabels'       => $dailyLabels,
            'chartValues'       => $dailyValues,
            'monthlyLabels'     => $monthlyLabels,
            'monthlyValues'     => $monthlyValues,
            'entryLogs'         => $entryLogs,
            'smsToday'          => $smsToday, // 🔐 dodane
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | POZOSTAŁE METODY BEZ ZMIAN
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

    // 🔽 Cała reszta pliku pozostaje identyczna jak wcześniej
}
