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

class FirmController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SKANOWANIE QR – karta lub voucher
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
    | KARTY LOJALNOŚCIOWE – dodawanie naklejki
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
            'firm_id'         => session('firm_id') ?? 1,
            'description'     => 'Dodano naklejkę',
        ]);

        return back()->with('success', 'Naklejka dodana!');
    }

    /*
    |--------------------------------------------------------------------------
    | RESET KARTY
    |--------------------------------------------------------------------------
    */
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
    | VOUCHERY – użycie
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
    | DASHBOARD FIRMY
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        return view('firm.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULARZ DODAWANIA PUNKTÓW
    |--------------------------------------------------------------------------
    */
    public function showPointsForm()
    {
        return view('firm.points');
    }

    /*
    |--------------------------------------------------------------------------
    | DODAWANIE PUNKTÓW – główna logika
    |--------------------------------------------------------------------------
    */
    public function addPoints(Request $request)
    {
        // 1. Walidacja wejścia
        $data = $request->validate([
            'phone'  => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'note'   => 'nullable|string|max:255',
        ]);

        // 2. Ustalamy program lojalnościowy firmy
        $firmId    = session('firm_id');
        $programId = 1; // fallback

        if ($firmId) {
            $firm = Firm::find($firmId);
            if ($firm && $firm->program_id) {
                $programId = $firm->program_id;
            }
        }

        // 3. Pobieramy klienta
        $client = Client::where('phone', $data['phone'])
            ->where('program_id', $programId)
            ->first();

        if (! $client) {
            return back()->withInput()->withErrors([
                'phone' => 'Nie znaleziono klienta w tym programie.',
            ]);
        }

        // 4. Pobieramy ustawienia programu
        $program = Program::find($programId);

        $ratio = $program?->point_ratio ?? 1;       // przelicznik np. 0.5
        $name  = $program?->points_name ?? 'punktów';

        // 5. Liczymy punkty
        $pointsToAdd = (int) round($data['amount'] * $ratio);

        if ($pointsToAdd <= 0) {
            return back()->withInput()->withErrors([
                'amount' => "Kwota jest zbyt mała, aby naliczyć choć 1 {$name}.",
            ]);
        }

        // 6. Aktualizacja punktów
        $client->points += $pointsToAdd;
        $client->save();

        // 7. Zapis transakcji do historii
        Transaction::create([
            'client_id'  => $client->id,
            'firm_id'    => $firmId ?? null,
            'program_id' => $programId,
            'type'       => 'purchase',
            'amount'     => $data['amount'],
            'points'     => $pointsToAdd,
            'note'       => $data['note'] ?? null,
        ]);

        // 8. Komunikat końcowy
        $msg = "Dodano {$pointsToAdd} {$name} klientowi o numerze {$client->phone}.";
        if (!empty($data['note'])) {
            $msg .= " Notatka: {$data['note']}.";
        }

        return back()->with('success', $msg);
    }

    /*
    |--------------------------------------------------------------------------
    | HISTORIA TRANSAKCJI – PANEL FIRMY (filtr + wykres)
    |--------------------------------------------------------------------------
    */
    public function transactions(Request $request)
    {
        $firmId    = session('firm_id');
        $programId = null;

        if ($firmId) {
            $firm      = Firm::find($firmId);
            $programId = $firm?->program_id;
        }

        $phone = $request->input('phone');

        // Główne zapytanie (lista transakcji)
        $query = Transaction::with('client');

        if ($programId) {
            $query->where('program_id', $programId);
        }

        if ($phone) {
            $query->whereHas('client', function ($q) use ($phone) {
                $q->where('phone', $phone);
            });
        }

        $transactions = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Podsumowanie dla konkretnego klienta
        $clientSummary = null;
        if ($phone && $programId) {
            $clientSummary = Transaction::where('program_id', $programId)
                ->whereHas('client', function ($q) use ($phone) {
                    $q->where('phone', $phone);
                })
                ->selectRaw('SUM(points) as total_points, COUNT(*) as total_transactions')
                ->first();
        }

        // Dane do wykresu (punkty per dzień)
        $chartData = Transaction::selectRaw('DATE(created_at) as date, SUM(points) as points')
            ->when($programId, function ($q) use ($programId) {
                $q->where('program_id', $programId);
            })
            ->groupBy('date')
            ->orderBy('date')
            ->limit(60) // np. ostatnie 60 dni
            ->get();

        return view('firm.transactions', [
            'transactions'   => $transactions,
            'filterPhone'    => $phone,
            'clientSummary'  => $clientSummary,
            'chartData'      => $chartData,
        ]);
    }
}
