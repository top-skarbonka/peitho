<?php

namespace App\Http\Controllers;

use App\Models\Firm;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use App\Models\RegistrationToken;
use App\Models\Transaction;
use App\Services\AuditLogger;
use App\Services\Sms\SmsApiSender;
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

        $entryLogs = DB::table('pass_entry_logs')
            ->where('firm_id', $firm->id)
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $smsToday = DB::table('sms_logs')
            ->where('firm_id', $firm->id)
            ->where('type', 'otp')
            ->whereDate('created_at', today())
            ->count();

        return view('firm.dashboard', [
            'totalClients' => $totalClients,
            'totalTransactions' => $totalTransactions,
            'totalPoints' => $totalPoints,
            'avgPoints' => $avgPoints,
            'chartLabels' => $dailyLabels,
            'chartValues' => $dailyValues,
            'monthlyLabels' => $monthlyLabels,
            'monthlyValues' => $monthlyValues,
            'entryLogs' => $entryLogs,
            'smsToday' => $smsToday,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | PUNKTY ZA ZAKUPY
    |--------------------------------------------------------------------------
    */
    public function showPointsForm()
    {
        $firm = $this->firm();

        $settings = DB::table('program_settings')
            ->where('firm_id', $firm->id)
            ->first();

        return view('firm.points.index', [
            'settings' => $settings,
        ]);
    }

    public function savePointsSettings(Request $request)
    {
        $firm = $this->firm();

        $request->validate([
            'points_per_currency' => 'required|integer|min:1|max:10000',
        ]);

        DB::table('program_settings')->updateOrInsert(
            ['firm_id' => $firm->id],
            [
                'points_per_currency' => $request->points_per_currency,
                'updated_at' => now(),
            ]
        );

        return back()->with('success', 'Zapisano ustawienia punktów');
    }

    public function addPoints(Request $request)
    {
        return $this->savePointsSettings($request);
    }

    /*
    |--------------------------------------------------------------------------
    | DODAWANIE PUNKTÓW KLIENTOWI
    |--------------------------------------------------------------------------
    */
    public function showAddClientPointsForm()
    {
        return view('firm.points.add-client');
    }

    public function storeClientPoints(Request $request)
    {
        $firm = $this->firm();

        $request->validate([
            'phone' => 'required|string',
            'amount' => 'required|integer|min:1',
        ]);

        $phone = preg_replace('/\D+/', '', $request->phone);

        if (strlen($phone) === 11 && str_starts_with($phone, '48')) {
            $phone = substr($phone, 2);
        }

        $client = DB::table('clients')->where('phone', $phone)->first();

        if (!$client) {
            $clientId = DB::table('clients')->insertGetId([
                'program_id' => 1,
                'phone' => $phone,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $clientId = $client->id;
        }

        $settings = DB::table('program_settings')
            ->where('firm_id', $firm->id)
            ->first();

        $divider = $settings->points_per_currency ?? 10;
        $points = (int) floor($request->amount / $divider);

        DB::table('client_points')->updateOrInsert(
            [
                'client_id' => $clientId,
                'firm_id' => $firm->id,
            ],
            [
                'points' => DB::raw("points + {$points}"),
                'updated_at' => now(),
            ]
        );

        DB::table('client_point_logs')->insert([
            'client_id' => $clientId,
            'firm_id' => $firm->id,
            'points' => $points,
            'amount' => $request->amount,
            'created_at' => now(),
        ]);

        return back()->with('success', "Dodano {$points} punktów");
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
            'firm_id' => $firm->id,
            'token' => Str::uuid(),
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
            'firm_id' => $firm->id,
            'description' => 'Naklejka (ręcznie)',
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
    | KARNETY
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
        ]);

        DB::table('company_pass_types')->insert([
            'firm_id' => $firm->id,
            'name' => $request->name,
            'entries' => $request->entries,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Dodano typ karnetu');
    }

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
            'phone' => 'required|string',
            'pass_type_id' => 'required|integer'
        ]);

        $phone = preg_replace('/\D+/', '', $request->phone);

        $client = DB::table('clients')->where('phone', $phone)->first();

        if (!$client) {
            $clientId = DB::table('clients')->insertGetId([
                'program_id' => 1,
                'phone' => $phone,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        } else {
            $clientId = $client->id;
        }

        $passType = DB::table('company_pass_types')->where('id', $request->pass_type_id)->first();

        DB::table('user_passes')->insert([
            'client_id' => $clientId,
            'firm_id' => $firm->id,
            'pass_type_id' => $passType->id,
            'total_entries' => $passType->entries,
            'remaining_entries' => $passType->entries,
            'status' => 'active',
            'activated_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Karnet został wydany');
    }

    public function issuedPasses()
    {
        $firm = $this->firm();

        $passes = DB::table('user_passes as up')
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
                'up.created_at'
            ])
            ->orderByDesc('up.id')
            ->get();

        return view('firm.passes.index', compact('passes'));
    }
}
