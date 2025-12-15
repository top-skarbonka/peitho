<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Firm;
use App\Models\Program;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use App\Models\GiftVoucher;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class FirmController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD — STATYSTYKI + WYKRESY + RANKING + HEATMAPA
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $firmId    = session('firm_id');
        $programId = Firm::find($firmId)?->program_id;

        // 1️⃣ PODSTAWOWE STATYSTYKI
        $totalClients      = Client::where('program_id', $programId)->count();
        $totalTransactions = Transaction::where('program_id', $programId)->count();
        $totalPoints       = Transaction::where('program_id', $programId)->sum('points');
        $avgPoints         = Transaction::where('program_id', $programId)->avg('points') ?? 0;

        $topDay = Transaction::selectRaw('DATE(created_at) AS day, COUNT(*) AS count')
            ->where('program_id', $programId)
            ->groupBy('day')
            ->orderByDesc('count')
            ->first();

        // 2️⃣ WYKRES DZIENNY — OSTATNIE 60 DNI
        $daily = Transaction::selectRaw('DATE(created_at) AS date, SUM(points) AS total')
            ->where('program_id', $programId)
            ->groupBy('date')
            ->orderBy('date')
            ->limit(60)
            ->get();

        $chartLabels = $daily->pluck('date');
        $chartValues = $daily->pluck('total');

        // 3️⃣ WYKRES MIESIĘCZNY — OSTATNIE 12 MIES.
        $monthly = Transaction::selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS month, SUM(points) AS total_points')
            ->where('program_id', $programId)
            ->groupBy('month')
            ->orderBy('month')
            ->limit(12)
            ->get();

        $monthlyLabels = $monthly->pluck('month');
        $monthlyValues = $monthly->pluck('total_points');

        // 4️⃣ TOP KLIENCI
        $topClients = Client::where('program_id', $programId)
            ->orderByDesc('points')
            ->limit(10)
            ->get();

        // 5️⃣ HEATMAPA GODZIN
        $hoursRaw = Transaction::selectRaw('HOUR(created_at) AS hour, SUM(points) AS total')
            ->where('program_id', $programId)
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->keyBy('hour');

        $hours = [];
        for ($h = 0; $h < 24; $h++) {
            $hours[$h] = $hoursRaw[$h]->total ?? 0;
        }

        return view('firm.dashboard', [
            'totalClients'      => $totalClients,
            'totalTransactions' => $totalTransactions,
            'totalPoints'       => $totalPoints,
            'avgPoints'         => round($avgPoints, 2),
            'bestDay'           => $topDay?->day,
            'chartLabels'       => $chartLabels,
            'chartValues'       => $chartValues,
            'monthlyLabels'     => $monthlyLabels,
            'monthlyValues'     => $monthlyValues,
            'topClients'        => $topClients,
            'hoursHeatmap'      => $hours,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | HISTORIA TRANSAKCJI — z filtrami (telefon, daty, typ) + statystyki do kafelków
    |--------------------------------------------------------------------------
    */
    public function transactions(Request $request)
    {
        $firmId    = session('firm_id');
        $programId = Firm::find($firmId)?->program_id;

        // ---------------- FILTRY Z FORMULARZA ----------------
        $filterPhone    = $request->input('phone');
        $filterDateFrom = $request->input('date_from');
        $filterDateTo   = $request->input('date_to');
        $filterType     = $request->input('type'); // może być null

        // ---------------- GŁÓWNE ZAPYTANIE ----------------
        $query = Transaction::with('client')
            ->where('program_id', $programId);

        if ($filterPhone) {
            $query->whereHas('client', function ($q) use ($filterPhone) {
                $q->where('phone', $filterPhone);
            });
        }

        if ($filterDateFrom) {
            $query->whereDate('created_at', '>=', $filterDateFrom);
        }

        if ($filterDateTo) {
            $query->whereDate('created_at', '<=', $filterDateTo);
        }

        if ($filterType) {
            $query->where('type', $filterType);
        }

        $transactions = $query
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        // ---------------- STATYSTYKI DLA KAFELKÓW (CAŁY PROGRAM) ----------------
        // żeby widok miał totalClients, totalTransactions, totalPoints itd.
        $totalClients      = Client::where('program_id', $programId)->count();
        $totalTransactions = Transaction::where('program_id', $programId)->count();
        $totalPoints       = Transaction::where('program_id', $programId)->sum('points');
        $avgPoints         = Transaction::where('program_id', $programId)->avg('points') ?? 0;

        $bestDay = Transaction::selectRaw('DATE(created_at) AS day, COUNT(*) AS count')
            ->where('program_id', $programId)
            ->groupBy('day')
            ->orderByDesc('count')
            ->first()
            ?->day;

        // ---------------- PODSUMOWANIE DLA KONKRETNEGO KLIENTA ----------------
        $clientSummary = null;

        if ($filterPhone) {
            $clientSummary = Transaction::where('program_id', $programId)
                ->whereHas('client', function ($q) use ($filterPhone) {
                    $q->where('phone', $filterPhone);
                })
                ->selectRaw('SUM(points) AS total_points, COUNT(*) AS total_transactions')
                ->first();
        }

        // ---------------- DANE DO WYKRESU (AKTYWNOŚĆ DZIENNA) ----------------
        $chartQuery = Transaction::selectRaw('DATE(created_at) AS date, SUM(points) AS points')
            ->where('program_id', $programId);

        if ($filterDateFrom) {
            $chartQuery->whereDate('created_at', '>=', $filterDateFrom);
        }

        if ($filterDateTo) {
            $chartQuery->whereDate('created_at', '<=', $filterDateTo);
        }

        $chartData = $chartQuery
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('firm.transactions', [
            // dane główne
            'transactions'    => $transactions,
            'filterPhone'     => $filterPhone,
            'filterDateFrom'  => $filterDateFrom,
            'filterDateTo'    => $filterDateTo,
            'filterType'      => $filterType,
            'clientSummary'   => $clientSummary,
            'chartData'       => $chartData,

            // statystyki do kafelków w widoku (tak jak na dashboardzie)
            'totalClients'      => $totalClients,
            'totalTransactions' => $totalTransactions,
            'totalPoints'       => $totalPoints,
            'avgPoints'         => round($avgPoints, 2),
            'bestDay'           => $bestDay,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SKANOWANIE QR
    |--------------------------------------------------------------------------
    */
    public function scan($code)
    {
        $card = LoyaltyCard::where('qr_code', $code)->first();
        if ($card) {
            return view('firm.scan.card', compact('card'));
        }

        $voucher = GiftVoucher::where('qr_code', $code)->first();
        if ($voucher) {
            return view('firm.scan.voucher', compact('voucher'));
        }

        return "Nie znaleziono karty ani vouchera.";
    }

    /*
    |--------------------------------------------------------------------------
    | KARTY — NAKLEJKI
    |--------------------------------------------------------------------------
    */
    public function addStamp($cardId)
    {
        $card = LoyaltyCard::findOrFail($cardId);

        if ($card->current_stamps >= $card->max_stamps) {
            return back()->with('error', 'Karta jest już pełna.');
        }

        $card->current_stamps++;
        $card->save();

        LoyaltyStamp::create([
            'loyalty_card_id' => $card->id,
            'firm_id'         => session('firm_id'),
            'description'     => 'Dodano naklejkę',
        ]);

        return back()->with('success', 'Naklejka dodana!');
    }

    public function resetCard($cardId)
    {
        $card = LoyaltyCard::findOrFail($cardId);
        $card->current_stamps = 0;
        $card->status = 'reset';
        $card->save();

        return back()->with('success', 'Karta zresetowana!');
    }

    /*
    |--------------------------------------------------------------------------
    | VOUCHERY
    |--------------------------------------------------------------------------
    */
    public function useVoucher($id)
    {
        $voucher = GiftVoucher::findOrFail($id);

        if ($voucher->status === 'used') {
            return back()->with('error', 'Voucher został już wykorzystany.');
        }

        if (now()->gt($voucher->expires_at)) {
            $voucher->update(['status' => 'expired']);
            return back()->with('error', 'Voucher wygasł.');
        }

        $voucher->update(['status' => 'used']);
        return back()->with('success', 'Voucher zrealizowany!');
    }

    /*
    |--------------------------------------------------------------------------
    | PUNKTY: FORMULARZ
    |--------------------------------------------------------------------------
    */
    public function showPointsForm()
    {
        return view('firm.points');
    }

    /*
    |--------------------------------------------------------------------------
    | PUNKTY: ZAPIS
    |--------------------------------------------------------------------------
    */
    public function addPoints(Request $request)
    {
        $data = $request->validate([
            'phone'  => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'note'   => 'nullable|string|max:255',
        ]);

        $firmId    = session('firm_id');
        $programId = Firm::find($firmId)?->program_id ?? 1;

        $client = Client::where('phone', $data['phone'])
            ->where('program_id', $programId)
            ->first();

        if (! $client) {
            return back()->withErrors(['phone' => 'Nie znaleziono klienta.']);
        }

        $program = Program::find($programId);
        $ratio   = $program?->point_ratio ?? 1;

        $pointsToAdd = (int) round($data['amount'] * $ratio);

        $client->points += $pointsToAdd;
        $client->save();

        Transaction::create([
            'client_id'  => $client->id,
            'firm_id'    => $firmId,
            'program_id' => $programId,
            'type'       => 'purchase',
            'amount'     => $data['amount'],
            'points'     => $pointsToAdd,
            'note'       => $data['note'] ?? null,
        ]);

        return back()->with('success', "Dodano {$pointsToAdd} pkt klientowi {$client->phone}");
    }
/*
|--------------------------------------------------------------------------
| KARTY LOJALNOŚCIOWE — LISTA (PANEL FIRMY)
|--------------------------------------------------------------------------
*/
public function loyaltyCards()
{
    $firmId = session('firm_id');

    if (! $firmId) {
        return redirect()->route('company.login');
    }

    $firm = \App\Models\Firm::findOrFail($firmId);

    $cards = \App\Models\LoyaltyCard::with(['client', 'stamps'])
        ->where('program_id', $firm->program_id)
        ->orderByDesc('created_at')
        ->get();

    return view('firm.loyalty-cards.index', [
        'cards' => $cards,
        'firm'  => $firm,
    ]);
}
}
