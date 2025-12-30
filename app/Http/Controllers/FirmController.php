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
    | HELPERS — sesja firm_id
    |--------------------------------------------------------------------------
    */
    private function currentFirm(): Firm
    {
        $firmId = session('firm_id');

        if (! $firmId) {
            abort(401);
        }

        return Firm::findOrFail($firmId);
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $firm   = $this->currentFirm();
        $firmId = $firm->id;

        $totalTransactions = Transaction::where('firm_id', $firmId)->count();
        $totalPoints       = (int) (Transaction::where('firm_id', $firmId)->sum('points') ?? 0);
        $avgPoints         = (float) (Transaction::where('firm_id', $firmId)->avg('points') ?? 0);

        $totalClients = Transaction::where('firm_id', $firmId)
            ->distinct('client_id')
            ->count('client_id');

        $bestDay = Transaction::where('firm_id', $firmId)
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('SUM(points) as total'))
            ->groupBy('day')
            ->orderByDesc('total')
            ->value('day');

        // Dzienny wykres (ostatnie 14 dni)
        $daily = Transaction::where('firm_id', $firmId)
            ->where('created_at', '>=', now()->subDays(14))
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('SUM(points) as total'))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $chartLabels = $daily->pluck('day')->map(fn ($d) => Carbon::parse($d)->format('Y-m-d'))->values();
        $chartValues = $daily->pluck('total')->values();

        // Miesięczny wykres
        $monthly = Transaction::where('firm_id', $firmId)
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('SUM(points) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyLabels = $monthly->pluck('month')->values();
        $monthlyValues = $monthly->pluck('total')->values();

        // HEATMAPA godzin — ZAWSZE 0..23 (żeby max() i foreach nigdy nie padły)
        $hoursHeatmap = array_fill(0, 24, 0);

        $rawHours = Transaction::where('firm_id', $firmId)
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('SUM(points) as total'))
            ->groupBy('hour')
            ->pluck('total', 'hour')
            ->toArray();

        foreach ($rawHours as $h => $sum) {
            $h = (int) $h;
            if ($h >= 0 && $h <= 23) {
                $hoursHeatmap[$h] = (int) $sum;
            }
        }

        // TOP klienci (punkty w tej firmie)
        $topClients = Client::select(
                'clients.id',
                'clients.phone',
                'clients.points',
                DB::raw('SUM(transactions.points) as firm_points')
            )
            ->join('transactions', 'transactions.client_id', '=', 'clients.id')
            ->where('transactions.firm_id', $firmId)
            ->groupBy('clients.id', 'clients.phone', 'clients.points')
            ->orderByDesc('firm_points')
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
    | HISTORIA TRANSAKCJI
    |--------------------------------------------------------------------------
    */
    public function transactions(Request $request)
    {
        $firmId = $this->currentFirm()->id;

        $q = Transaction::where('firm_id', $firmId)
            ->orderByDesc('created_at');

        // jeśli masz w transactions tabeli pole client_id, to to działa:
        // (jeśli nie masz relacji, nadal pokaże transakcje bez klienta)
        $transactions = $q->paginate(20);

        return view('firm.transactions', compact('transactions'));
    }

    /*
    |--------------------------------------------------------------------------
    | DODAJ PUNKTY — FORM
    |--------------------------------------------------------------------------
    */
    public function showPointsForm()
    {
        $this->currentFirm(); // kontrola sesji
        return view('firm.points');
    }

    /*
    |--------------------------------------------------------------------------
    | DODAJ PUNKTY — SUBMIT
    |--------------------------------------------------------------------------
    */
    public function addPoints(Request $request)
    {
        $firmId = $this->currentFirm()->id;

        $data = $request->validate([
            'phone'  => ['required', 'string', 'min:5', 'max:32'],
            'points' => ['required', 'numeric', 'min:0.01'],
        ]);

        // znajdź lub utwórz klienta po telefonie
        $client = Client::firstOrCreate(
            ['phone' => $data['phone']],
            ['points' => 0]
        );

        // dodaj transakcję
        Transaction::create([
            'firm_id'   => $firmId,
            'client_id' => $client->id,
            'points'    => $data['points'],
        ]);

        // aktualizuj punkty klienta (jeśli przechowujesz je na kliencie)
        $client->increment('points', $data['points']);

        return redirect()->route('company.dashboard')->with('success', 'Dodano punkty ✅');
    }

    /*
    |--------------------------------------------------------------------------
    | KARTY LOJALNOŚCIOWE
    |--------------------------------------------------------------------------
    */
    public function loyaltyCards()
    {
        $firmId = $this->currentFirm()->id;

        $cards = LoyaltyCard::where('firm_id', $firmId)
            ->withCount('stamps')
            ->get();

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
        $firmId = $this->currentFirm()->id;

        $card = LoyaltyCard::where('id', $cardId)
            ->where('firm_id', $firmId)
            ->firstOrFail();

        $card->increment('current_stamps');

        LoyaltyStamp::create([
            'loyalty_card_id' => $card->id,
            'firm_id'         => $firmId,
            'description'     => 'Dodano naklejkę',
        ]);

        return back()->with('success', 'Naklejka dodana ✅');
    }

    /*
    |--------------------------------------------------------------------------
    | RESET KARTY
    |--------------------------------------------------------------------------
    */
    public function resetCard($cardId)
    {
        $firmId = $this->currentFirm()->id;

        $card = LoyaltyCard::where('id', $cardId)
            ->where('firm_id', $firmId)
            ->firstOrFail();

        $card->update(['current_stamps' => 0]);

        return back()->with('success', 'Karta zresetowana ✅');
    }

    /*
    |--------------------------------------------------------------------------
    | REDEEM (wymiana nagrody)
    |--------------------------------------------------------------------------
    */
    public function redeemCard($cardId)
    {
        $firmId = $this->currentFirm()->id;

        $card = LoyaltyCard::where('id', $cardId)
            ->where('firm_id', $firmId)
            ->firstOrFail();

        // prosta logika: jeśli masz >= 10 naklejek, zerujemy
        if ((int) $card->current_stamps >= 10) {
            $card->update(['current_stamps' => 0]);
            return back()->with('success', 'Nagroda wydana ✅ Karta wyzerowana.');
        }

        return back()->with('error', 'Za mało naklejek na nagrodę.');
    }
}

