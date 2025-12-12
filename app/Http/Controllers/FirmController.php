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
<<<<<<< HEAD
    | DASHBOARD
=======
    | DASHBOARD — STATYSTYKI + WYKRESY + RANKING + HEATMAPA
    |--------------------------------------------------------------------------
    */
public function dashboard()
{
    $firmId = session('firm_id');
    if (! $firmId) {
        return redirect()->route('company.login');
    }

    $programId = Firm::findOrFail($firmId)->program_id;

    $transactions = Transaction::where('program_id', $programId)->get();

    $totalTransactions = $transactions->count();
    $totalPoints       = $transactions->sum('points');
    $avgPoints         = $totalTransactions ? $totalPoints / $totalTransactions : 0;

    $totalClients = Client::where('program_id', $programId)->count();

    // 📅 dzienne punkty (ostatnie 14 dni)
    $daily = $transactions
        ->groupBy(fn ($t) => $t->created_at->format('Y-m-d'))
        ->sortKeys();

    $chartLabels = $daily->keys()->values();
    $chartValues = $daily->map(fn ($g) => $g->sum('points'))->values();

    // 📆 miesięczne punkty
    $monthly = $transactions
        ->groupBy(fn ($t) => $t->created_at->format('Y-m'))
        ->sortKeys();

    $monthlyLabels = $monthly->keys()->values();
    $monthlyValues = $monthly->map(fn ($g) => $g->sum('points'))->values();

    // 🔥 heatmapa godzin
    $hoursHeatmap = array_fill(0, 24, 0);
    foreach ($transactions as $t) {
        $h = (int) $t->created_at->format('H');
        $hoursHeatmap[$h] += $t->points;
    }

    // 🏆 top klienci
    $topClients = Client::where('program_id', $programId)
        ->orderByDesc('points')
        ->limit(10)
        ->get();

    // ⭐ najlepszy dzień
    $bestDay = $daily->sortByDesc(fn ($g) => $g->sum('points'))->keys()->first();

    return view('firm.dashboard', compact(
        'totalClients',
        'totalTransactions',
        'totalPoints',
        'avgPoints',
        'chartLabels',
        'chartValues',
        'monthlyLabels',
        'monthlyValues',
        'hoursHeatmap',
        'topClients',
        'bestDay'
    ));
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
>>>>>>> c976efb (UX Update: Nowoczesny widok historii transakcji + filtry + statystyki + wykres + timeline)
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        $programId = Firm::findOrFail($firmId)->program_id;

        $totalClients      = Client::where('program_id', $programId)->count();
        $totalTransactions = Transaction::where('program_id', $programId)->count();
        $totalPoints       = Transaction::where('program_id', $programId)->sum('points');
        $avgPoints         = Transaction::where('program_id', $programId)->avg('points') ?? 0;

        return view('firm.dashboard', compact(
            'totalClients',
            'totalTransactions',
            'totalPoints',
            'avgPoints'
        ));
    }

    /*
    |--------------------------------------------------------------------------
<<<<<<< HEAD
    | HISTORIA TRANSAKCJI
    |--------------------------------------------------------------------------
    */
    public function transactions(Request $request)
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        $programId = Firm::findOrFail($firmId)->program_id;

        $query = Transaction::with('client')
            ->where('program_id', $programId);

        if ($request->phone) {
            $query->whereHas('client', fn ($q) =>
                $q->where('phone', $request->phone)
            );
        }

        $transactions = $query
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('firm.transactions', compact('transactions'));
    }

    /*
    |--------------------------------------------------------------------------
    | LISTA KART LOJALNOŚCIOWYCH (PANEL FIRMY)
    |--------------------------------------------------------------------------
    */
    public function loyaltyCards()
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        $firm = Firm::findOrFail($firmId);

        $cards = LoyaltyCard::with(['client'])
            ->where('program_id', $firm->program_id)
            ->orderByDesc('created_at')
            ->get();

        // 🔥 HISTORIA NAKLEJEK (ETAP 2B.1)
        $stamps = LoyaltyStamp::with(['card.client'])
            ->where('firm_id', $firmId)
            ->orderByDesc('created_at')
            ->limit(200)
            ->get();

        return view('firm.loyalty-cards.index', [
            'cards'  => $cards,
            'stamps' => $stamps,
            'firm'   => $firm,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DODANIE NAKLEJKI
=======
    | KARTY — NAKLEJKI
>>>>>>> c976efb (UX Update: Nowoczesny widok historii transakcji + filtry + statystyki + wykres + timeline)
    |--------------------------------------------------------------------------
    */
    public function addStamp($cardId)
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        $card = LoyaltyCard::findOrFail($cardId);

        if ($card->current_stamps >= $card->max_stamps) {
            return back()->with('error', 'Karta jest już pełna.');
        }

        $card->increment('current_stamps');

        LoyaltyStamp::create([
            'loyalty_card_id' => $card->id,
<<<<<<< HEAD
            'firm_id'         => $firmId,
=======
            'firm_id'         => session('firm_id'),
>>>>>>> c976efb (UX Update: Nowoczesny widok historii transakcji + filtry + statystyki + wykres + timeline)
            'description'     => 'Dodano naklejkę',
        ]);

        // AUTO-COMPLETED
        if ($card->current_stamps >= $card->max_stamps) {
            $card->update(['status' => 'completed']);
        }

        return back()->with('success', 'Naklejka dodana.');
    }

<<<<<<< HEAD
    /*
    |--------------------------------------------------------------------------
    | RESET KARTY (NOWY CYKL)
    |--------------------------------------------------------------------------
    */
=======
>>>>>>> c976efb (UX Update: Nowoczesny widok historii transakcji + filtry + statystyki + wykres + timeline)
    public function resetCard($cardId)
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        $card = LoyaltyCard::findOrFail($cardId);
<<<<<<< HEAD

        $card->update([
            'current_stamps' => 0,
            'status'         => 'active',
        ]);
=======
        $card->current_stamps = 0;
        $card->status = 'reset';
        $card->save();
>>>>>>> c976efb (UX Update: Nowoczesny widok historii transakcji + filtry + statystyki + wykres + timeline)

        return back()->with('success', 'Karta została zresetowana.');
    }

    /*
    |--------------------------------------------------------------------------
<<<<<<< HEAD
    | PUNKTY
=======
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
>>>>>>> c976efb (UX Update: Nowoczesny widok historii transakcji + filtry + statystyki + wykres + timeline)
    |--------------------------------------------------------------------------
    */
    public function showPointsForm()
    {
        return view('firm.points');
    }

<<<<<<< HEAD
    public function addPoints(Request $request)
    {
        $request->validate([
            'phone'  => 'required',
=======
    /*
    |--------------------------------------------------------------------------
    | PUNKTY: ZAPIS
    |--------------------------------------------------------------------------
    */
    public function addPoints(Request $request)
    {
        $data = $request->validate([
            'phone'  => 'required|string',
>>>>>>> c976efb (UX Update: Nowoczesny widok historii transakcji + filtry + statystyki + wykres + timeline)
            'amount' => 'required|numeric|min:0.01',
        ]);

<<<<<<< HEAD
        $firmId = session('firm_id');
        $programId = Firm::findOrFail($firmId)->program_id;

        $client = Client::where('phone', $request->phone)
=======
        $firmId    = session('firm_id');
        $programId = Firm::find($firmId)?->program_id ?? 1;

        $client = Client::where('phone', $data['phone'])
>>>>>>> c976efb (UX Update: Nowoczesny widok historii transakcji + filtry + statystyki + wykres + timeline)
            ->where('program_id', $programId)
            ->firstOrFail();

<<<<<<< HEAD
        $points = (int) round($request->amount * 0.5);

        $client->increment('points', $points);

=======
        if (! $client) {
            return back()->withErrors(['phone' => 'Nie znaleziono klienta.']);
        }

        $program = Program::find($programId);
        $ratio   = $program?->point_ratio ?? 1;

        $pointsToAdd = (int) round($data['amount'] * $ratio);

        $client->points += $pointsToAdd;
        $client->save();

>>>>>>> c976efb (UX Update: Nowoczesny widok historii transakcji + filtry + statystyki + wykres + timeline)
        Transaction::create([
            'client_id'  => $client->id,
            'firm_id'    => $firmId,
            'program_id' => $programId,
            'points'     => $points,
            'type'       => 'purchase',
        ]);

<<<<<<< HEAD
        return back()->with('success', 'Punkty dodane.');
=======
        return back()->with('success', "Dodano {$pointsToAdd} pkt klientowi {$client->phone}");
>>>>>>> c976efb (UX Update: Nowoczesny widok historii transakcji + filtry + statystyki + wykres + timeline)
    }
}
