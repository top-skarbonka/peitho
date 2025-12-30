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

        // Statystyki główne
        $totalClients      = Client::where('program_id', $programId)->count();
        $totalTransactions = Transaction::where('program_id', $programId)->count();
        $totalPoints       = Transaction::where('program_id', $programId)->sum('points');
        $avgPoints         = Transaction::where('program_id', $programId)->avg('points') ?? 0;

        $topDay = Transaction::selectRaw('DATE(created_at) AS day, COUNT(*) AS count')
            ->where('program_id', $programId)
            ->groupBy('day')
            ->orderByDesc('count')
            ->first();

        // Wykres dzienny
        $daily = Transaction::selectRaw('DATE(created_at) AS date, SUM(points) AS total')
            ->where('program_id', $programId)
            ->groupBy('date')
            ->orderBy('date')
            ->limit(60)
            ->get();

        $chartLabels = $daily->pluck('date');
        $chartValues = $daily->pluck('total');

        // Wykres miesięczny
        $monthly = Transaction::selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS month, SUM(points) AS total_points')
            ->where('program_id', $programId)
            ->groupBy('month')
            ->orderBy('month')
            ->limit(12)
            ->get();

        $monthlyLabels = $monthly->pluck('month');
        $monthlyValues = $monthly->pluck('total_points');

        // TOP klienci
        $topClients = Client::where('program_id', $programId)
            ->orderByDesc('points')
            ->limit(10)
            ->get();

        // Heatmapa godzin
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
public function dashboard()
{
    return view('firm.dashboard', [
        'test' => 'DASHBOARD DZIAŁA 🎉'
    ]);
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
    | HISTORIA TRANSAKCJI — PEŁNE FILTRY: telefon, daty, punkty, kwoty
    |--------------------------------------------------------------------------
    */
    public function transactions(Request $request)
    {
        $firmId    = session('firm_id');
        $programId = Firm::find($firmId)?->program_id;

        // FILTRY
        $phone       = $request->input('phone');
        $dateFrom    = $request->input('date_from');
        $dateTo      = $request->input('date_to');
        $minPoints   = $request->input('min_points');
        $maxPoints   = $request->input('max_points');
        $minAmount   = $request->input('min_amount');
        $maxAmount   = $request->input('max_amount');

        // QUERY główne
        $query = Transaction::with('client')
            ->where('program_id', $programId);

        if ($phone) {
            $query->whereHas('client', fn($q) => $q->where('phone', $phone));
        }
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        if ($minPoints !== null && $minPoints !== '') {
            $query->where('points', '>=', (int)$minPoints);
        }
        if ($maxPoints !== null && $maxPoints !== '') {
            $query->where('points', '<=', (int)$maxPoints);
        }
        if ($minAmount !== null && $minAmount !== '') {
            $query->where('amount', '>=', (float)$minAmount);
        }
        if ($maxAmount !== null && $maxAmount !== '') {
            $query->where('amount', '<=', (float)$maxAmount);
        }

        $transactions = $query
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        // Podsumowanie klienta
        $clientSummary = null;
        if ($phone) {
            $clientSummary = Transaction::where('program_id', $programId)
                ->whereHas('client', fn($q) => $q->where('phone', $phone))
                ->selectRaw('SUM(points) AS total_points, COUNT(*) AS total_transactions')
                ->first();
        }

        // Wykres (uwzględnia wszystkie filtry)
        $chartQuery = Transaction::selectRaw('DATE(created_at) AS date, SUM(points) AS points')
            ->where('program_id', $programId);

        if ($phone) {
            $chartQuery->whereHas('client', fn($q) => $q->where('phone', $phone));
        }
        if ($dateFrom) $chartQuery->whereDate('created_at', '>=', $dateFrom);
        if ($dateTo)   $chartQuery->whereDate('created_at', '<=', $dateTo);
        if ($minPoints !== null && $minPoints !== '') $chartQuery->where('points', '>=', $minPoints);
        if ($maxPoints !== null && $maxPoints !== '') $chartQuery->where('points', '<=', $maxPoints);
        if ($minAmount !== null && $minAmount !== '') $chartQuery->where('amount', '>=', $minAmount);
        if ($maxAmount !== null && $maxAmount !== '') $chartQuery->where('amount', '<=', $maxAmount);

        $chartData = $chartQuery
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('firm.transactions', [
            'transactions'    => $transactions,
            'filterPhone'     => $phone,
            'filterDateFrom'  => $dateFrom,
            'filterDateTo'    => $dateTo,
            'filterMinPoints' => $minPoints,
            'filterMaxPoints' => $maxPoints,
            'filterMinAmount' => $minAmount,
            'filterMaxAmount' => $maxAmount,
            'clientSummary'   => $clientSummary,
            'chartData'       => $chartData,
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
        if ($card) return view('firm.scan.card', compact('card'));

        $voucher = GiftVoucher::where('qr_code', $code)->first();
        if ($voucher) return view('firm.scan.voucher', compact('voucher'));

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
    | VOUCHERY — REALIZACJA
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
    | PUNKTY – FORMULARZ + ZAPIS
    |--------------------------------------------------------------------------
    */
    public function showPointsForm()
    {
        return view('firm.points');
    }

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

        if (!$client) {
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
}
