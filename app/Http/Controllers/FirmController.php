<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FirmController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        $firm = Firm::findOrFail($firmId);
        $programId = $firm->program_id;

        $totalClients      = Client::where('program_id', $programId)->count();
        $totalTransactions = Transaction::where('program_id', $programId)->count();
        $totalPoints       = Transaction::where('program_id', $programId)->sum('points');
        $avgPoints         = Transaction::where('program_id', $programId)->avg('points') ?? 0;

        // 📆 Najaktywniejszy dzień (po sumie punktów)
        $bestDay = Transaction::where('program_id', $programId)
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('SUM(points) as total'))
            ->groupBy('day')
            ->orderByDesc('total')
            ->value('day');

        // 📊 Wykres dzienny (ostatnie 14 dni)
        $daily = Transaction::where('program_id', $programId)
            ->where('created_at', '>=', now()->subDays(14))
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('SUM(points) as total'))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $chartLabels = $daily->pluck('day')->map(fn ($d) => Carbon::parse($d)->format('Y-m-d'))->values();
        $chartValues = $daily->pluck('total')->values();

        // 📊 Wykres miesięczny
        $monthly = Transaction::where('program_id', $programId)
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('SUM(points) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyLabels = $monthly->pluck('month')->values();
        $monthlyValues = $monthly->pluck('total')->values();

        // ⏰ Heatmapa godzin
        $hoursHeatmap = Transaction::where('program_id', $programId)
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('SUM(points) as total'))
            ->groupBy('hour')
            ->pluck('total', 'hour')
            ->toArray();

        // 🏅 TOP klienci
        $topClients = Client::where('program_id', $programId)
            ->orderByDesc('points')
            ->limit(10)
            ->get();

        return view('firm.dashboard', compact(
            'totalClients',
            'totalTransactions',
            'totalPoints',
            'avgPoints',
            'bestDay',
            'chartLabels',
            'chartValues',
            'monthlyLabels',
            'monthlyValues',
            'hoursHeatmap',
            'topClients'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | HISTORIA TRANSAKCJI (z filtrami + wykres + timeline)
    |--------------------------------------------------------------------------
    */
    public function transactions(Request $request)
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        $firm = Firm::findOrFail($firmId);
        $programId = $firm->program_id;

        // Filtry do widoku (MUSZĄ być zawsze zdefiniowane)
        $filterPhone    = $request->get('phone');
        $filterDateFrom = $request->get('date_from');
        $filterDateTo   = $request->get('date_to');
        $filterType     = $request->get('type');

        // Bazowy query (na listę)
        $query = Transaction::with('client')
            ->where('program_id', $programId);

        if ($filterPhone) {
            $query->whereHas('client', function ($q) use ($filterPhone) {
                $q->where('phone', 'like', '%' . $filterPhone . '%');
            });
        }

        if ($filterType) {
            $query->where('type', $filterType);
        }

        if ($filterDateFrom) {
            $query->whereDate('created_at', '>=', $filterDateFrom);
        }

        if ($filterDateTo) {
            $query->whereDate('created_at', '<=', $filterDateTo);
        }

        $transactions = $query
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        // Statystyki globalne (kafelki)
        $totalClients      = Client::where('program_id', $programId)->count();
        $totalTransactions = Transaction::where('program_id', $programId)->count();
        $totalPoints       = Transaction::where('program_id', $programId)->sum('points');
        $avgPoints         = Transaction::where('program_id', $programId)->avg('points') ?? 0;

        $bestDay = Transaction::where('program_id', $programId)
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('COUNT(*) as cnt'))
            ->groupBy('day')
            ->orderByDesc('cnt')
            ->value('day');

        // Podsumowanie klienta (jeśli filtr telefonu)
        $clientSummary = null;
        if ($filterPhone) {
            $clientSummary = Transaction::where('program_id', $programId)
                ->whereHas('client', function ($q) use ($filterPhone) {
                    $q->where('phone', 'like', '%' . $filterPhone . '%');
                })
                ->selectRaw('COUNT(*) as total_transactions, COALESCE(SUM(points),0) as total_points')
                ->first();
        }

        // Wykres (aktywność punktów w czasie) – bierzemy ten sam filtr co lista
        $chartQuery = Transaction::where('program_id', $programId);

        if ($filterPhone) {
            $chartQuery->whereHas('client', function ($q) use ($filterPhone) {
                $q->where('phone', 'like', '%' . $filterPhone . '%');
            });
        }
        if ($filterType) {
            $chartQuery->where('type', $filterType);
        }
        if ($filterDateFrom) {
            $chartQuery->whereDate('created_at', '>=', $filterDateFrom);
        }
        if ($filterDateTo) {
            $chartQuery->whereDate('created_at', '<=', $filterDateTo);
        }

        // domyślnie: ostatnie 14 dni, jeśli nie ma zakresu
        if (! $filterDateFrom && ! $filterDateTo) {
            $chartQuery->where('created_at', '>=', now()->subDays(14));
        }

        $chartData = $chartQuery
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(points) as points'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('firm.transactions', compact(
            'transactions',
            'filterPhone',
            'filterDateFrom',
            'filterDateTo',
            'filterType',
            'totalClients',
            'totalTransactions',
            'totalPoints',
            'avgPoints',
            'bestDay',
            'clientSummary',
            'chartData'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | LISTA KART LOJALNOŚCIOWYCH (PANEL FIRMY)
    |--------------------------------------------------------------------------
    */
public function loyaltyCards(Request $request)
{
    $user = auth()->user();

    if (!$user || !$user->firm) {
        abort(403, 'Brak przypisanej firmy do konta');
    }

    $firm = $user->firm;

    $query = \App\Models\LoyaltyCard::where('firm_id', $firm->id)
        ->withCount('stamps');

    if ($request->filled('phone')) {
        $query->where('phone', 'like', '%' . $request->phone . '%');
    }

    $cards = $query->orderBy('created_at', 'desc')->get();

    $stats = [
        'cards'    => $cards->count(),
        'stamps'   => $cards->sum('stamps_count'),
        'full'     => $cards->where('stamps_count', '>=', 10)->count(),
        'active30' => $cards->where('created_at', '>=', now()->subDays(30))->count(),
    ];

    return view('firm.loyalty-cards.index', compact('cards', 'stats'));
}
    /*
    |--------------------------------------------------------------------------
    | DODANIE NAKLEJKI
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
            'firm_id'         => $firmId,
            'description'     => 'Dodano naklejkę',
        ]);

        if ($card->current_stamps >= $card->max_stamps) {
            $card->update(['status' => 'completed']);
        }

        return back()->with('success', 'Naklejka dodana.');
    }

    /*
    |--------------------------------------------------------------------------
    | RESET KARTY (NOWY CYKL)
    |--------------------------------------------------------------------------
    */
    public function resetCard($cardId)
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        $card = LoyaltyCard::findOrFail($cardId);

        $card->update([
            'current_stamps' => 0,
            'status'         => 'active',
        ]);

        return back()->with('success', 'Karta została zresetowana.');
    }

    /*
    |--------------------------------------------------------------------------
    | PUNKTY
    |--------------------------------------------------------------------------
    */
    public function showPointsForm()
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        return view('firm.points');
    }

    public function addPoints(Request $request)
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        $request->validate([
            'phone'  => 'required',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $programId = Firm::findOrFail($firmId)->program_id;

        $client = Client::where('phone', $request->phone)
            ->where('program_id', $programId)
            ->firstOrFail();

        $points = (int) round(((float) $request->amount) * 0.5);

        $client->increment('points', $points);

Transaction::create([
    'client_id'  => $client->id,
    'firm_id'    => $firmId,
    'program_id' => $programId,
    'points'     => $points,
    'amount'     => (float) $request->amount,
    'type'       => 'manual',
    'note'       => $request->note ?: 'Ręczne naliczenie punktów',
]);
        return back()->with('success', 'Punkty dodane.');
    }
}
