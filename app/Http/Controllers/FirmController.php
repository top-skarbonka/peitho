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
    | DASHBOARD (ROZSZERZONY O LOGI WEJŚĆ KARNETÓW)
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

        // ✅ NOWE – OSTATNIE 10 WEJŚĆ Z KARNETÓW
        $entryLogs = DB::table('pass_entry_logs')
            ->where('firm_id', $firm->id)
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return view('firm.dashboard', [
            'totalClients'      => $totalClients,
            'totalTransactions' => $totalTransactions,
            'totalPoints'       => $totalPoints,
            'avgPoints'         => $avgPoints,
            'chartLabels'       => $dailyLabels,
            'chartValues'       => $dailyValues,
            'monthlyLabels'     => $monthlyLabels,
            'monthlyValues'     => $monthlyValues,
            'entryLogs'         => $entryLogs, // ✅ tylko to dodane
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

        if ($card->client) {
            $card->client->touchActivity();
        }

        $card->increment('current_stamps');

        LoyaltyStamp::create([
            'loyalty_card_id' => $card->id,
            'firm_id'         => $firm->id,
            'description'     => 'Naklejka (ręcznie)',
        ]);

        AuditLogger::log(
            'add_stamp_manual',
            'firm',
            $firm->id,
            $card->client_id,
            ['loyalty_card_id' => $card->id]
        );

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

        $lockKey = "qr_lock:{$firm->id}:{$card->id}";

        if (Cache::has($lockKey)) {
            return back()->with('lock_seconds', 120);
        }

        Cache::put($lockKey, true, now()->addSeconds(120));

        if ($card->current_stamps >= $card->max_stamps) {
            return back()->with('error', 'Karta jest już pełna');
        }

        if ($card->client) {
            $card->client->touchActivity();
        }

        $card->increment('current_stamps');

        LoyaltyStamp::create([
            'loyalty_card_id' => $card->id,
            'firm_id'         => $firm->id,
            'description'     => 'Naklejka (QR)',
        ]);

        AuditLogger::log(
            'add_stamp_qr',
            'firm',
            $firm->id,
            $card->client_id,
            ['loyalty_card_id' => $card->id]
        );

        if ($card->current_stamps >= $card->max_stamps) {
            $card->update(['status' => 'completed']);
        }

        return back()->with('success', '✅ Naklejka dodana');
    }

    /*
    |--------------------------------------------------------------------------
    | 🎫 TYPY KARNETÓW (MVP)
    |--------------------------------------------------------------------------
    */
    public function passTypes()
    {
        $firm = $this->firm();

        $passTypes = DB::table('company_pass_types')
            ->where('firm_id', $firm->id)
            ->orderByDesc('id')
            ->get();

        return view('firm.pass-types.index', compact('passTypes'));
    }

    public function storePassType(Request $request)
    {
        $firm = $this->firm();

        $request->validate([
            'name' => 'required|string|max:100',
            'entries' => 'required|integer|min:1|max:1000',
            'price_gross_cents' => 'nullable|integer|min:0',
        ]);

        DB::table('company_pass_types')->insert([
            'firm_id' => $firm->id,
            'name' => $request->name,
            'entries' => $request->entries,
            'price_gross_cents' => $request->price_gross_cents,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Dodano typ karnetu');
    }

    /*
    |--------------------------------------------------------------------------
    | 🎫 WYDANIE KARNETU
    |--------------------------------------------------------------------------
    */
    public function issuePassForm()
    {
        $firm = $this->firm();

        $passTypes = DB::table('company_pass_types')
            ->where('firm_id', $firm->id)
            ->where('is_active', 1)
            ->get();

        return view('firm.passes.issue', compact('passTypes'));
    }

    public function issuePass(Request $request)
    {
        $firm = $this->firm();

        $request->validate([
            'phone' => 'required|string|min:6|max:32',
            'pass_type_id' => 'required|integer',
        ]);

        DB::transaction(function () use ($request, $firm) {

            $client = DB::table('clients')
                ->where('phone', $request->phone)
                ->first();

            if (! $client) {
                $clientId = DB::table('clients')->insertGetId([
                    'program_id' => 1,
                    'phone' => $request->phone,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $clientId = $client->id;
            }

            $passType = DB::table('company_pass_types')
                ->where('id', $request->pass_type_id)
                ->where('firm_id', $firm->id)
                ->first();

            if (! $passType) {
                abort(403, 'Nieprawidłowy typ karnetu');
            }

            DB::table('user_passes')->insert([
                'client_id' => $clientId,
                'firm_id' => $firm->id,
                'pass_type_id' => $passType->id,
                'total_entries' => $passType->entries,
                'remaining_entries' => $passType->entries,
                'status' => 'active',
                'activated_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return back()->with('success', 'Karnet został wydany');
    }

    /*
    |--------------------------------------------------------------------------
    | 🎫 LISTA WYDANYCH KARNETÓW
    |--------------------------------------------------------------------------
    */
    public function issuedPasses(Request $request)
    {
        $firm = $this->firm();

        $q = trim((string) $request->query('q', ''));

        $passesQuery = DB::table('user_passes as up')
            ->join('clients as c', 'c.id', '=', 'up.client_id')
            ->join('company_pass_types as pt', 'pt.id', '=', 'up.pass_type_id')
            ->where('up.firm_id', $firm->id)
            ->select([
                'up.id',
                'c.phone',
                'pt.name as pass_type_name',
                'up.total_entries',
                'up.remaining_entries',
                'up.status',
                'up.activated_at',
                'up.finished_at',
                'up.created_at',
            ])
            ->orderByDesc('up.id');

        if ($q !== '') {
            $passesQuery->where('c.phone', 'like', '%' . $q . '%');
        }

        $passes = $passesQuery->paginate(30)->withQueryString();

        return view('firm.passes.index', compact('passes', 'q'));
    }
}
