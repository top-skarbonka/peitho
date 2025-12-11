<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Firm;
use App\Models\Program;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use App\Models\GiftVoucher;

class FirmController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SKANOWANIE QR – karta / voucher
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
    | KARTY LOJALNOŚCIOWE – naklejki
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
            'firm_id'         => 1, // później: auth firmy
            'description'     => "Dodano naklejkę",
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
    | DASHBOARD
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
    | LOGIKA DODANIA PUNKTÓW ZA KWOTĘ
    |--------------------------------------------------------------------------
    */
    public function addPoints(Request $request)
    {
        // 1. Walidacja
        $data = $request->validate([
            'phone'  => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'note'   => 'nullable|string|max:255',
        ]);

        // 2. Identyfikacja programu lojalnościowego firmy
        $programId = 1; // fallback

        if (session('firm_id')) {
            $firm = Firm::find(session('firm_id'));

            if ($firm && $firm->program_id) {
                $programId = $firm->program_id;
            }
        }

        // 3. Szukamy klienta w programie
        $client = Client::where('phone', $data['phone'])
                        ->where('program_id', $programId)
                        ->first();

        if (! $client) {
            return back()
                ->withInput()
                ->withErrors(['phone' => 'Nie znaleziono klienta w tym programie.']);
        }

        // 4. Pobieramy ustawienia programu
        $program = Program::find($programId);
        $ratio   = $program?->point_ratio ?? 1;
        $name    = $program?->points_name ?? 'punktów';

        // 5. Przeliczamy punkty
        $pointsToAdd = (int) round($data['amount'] * $ratio);

        if ($pointsToAdd <= 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'amount' => "Kwota jest zbyt mała, aby naliczyć choć 1 {$name}."
                ]);
        }

        // 6. Zapisanie punktów
        $client->points += $pointsToAdd;
        $client->save();

        $msg = "Dodano {$pointsToAdd} {$name} klientowi o numerze {$client->phone}.";
        if (!empty($data['note'])) {
            $msg .= " Notatka: {$data['note']}.";
        }

        return back()->with('success', $msg);
    }
}
