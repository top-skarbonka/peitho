<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    | DASHBOARD — NIE RUSZAMY WYGLĄDU
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
    | SKAN QR — KARTA / VOUCHER
    |--------------------------------------------------------------------------
    */
    public function scan($code)
    {
        if ($card = LoyaltyCard::where('qr_code', $code)->first()) {
            return view('firm.scan.card', compact('card'));
        }

        if ($voucher = GiftVoucher::where('qr_code', $code)->first()) {
            return view('firm.scan.voucher', compact('voucher'));
        }

        abort(404);
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

        $firm = Firm::findOrFail($firmId);

        $cards = LoyaltyCard::with(['client', 'stamps'])
            ->where('program_id', $firm->program_id)
            ->orderByDesc('created_at')
            ->get();

        return view('firm.loyalty-cards.index', compact('cards'));
    }

    /*
    |--------------------------------------------------------------------------
    | KARTY LOJALNOŚCIOWE — DODAJ NAKLEJKĘ
    |--------------------------------------------------------------------------
    */
    public function addStamp($cardId)
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        $card = LoyaltyCard::findOrFail($cardId);

        $programId = Firm::findOrFail($firmId)->program_id;
        if ($card->program_id !== $programId) {
            abort(403);
        }

        if ($card->current_stamps >= $card->max_stamps) {
            return back()->with('error', 'Karta jest już pełna.');
        }

        DB::transaction(function () use ($card, $firmId) {
            $card->increment('current_stamps');

            LoyaltyStamp::create([
                'loyalty_card_id' => $card->id,
                'firm_id'         => $firmId,
                'description'     => 'Dodano naklejkę',
            ]);

            if ($card->current_stamps >= $card->max_stamps) {
                $card->update(['status' => 'completed']);
            }
        });

        return back()->with('success', 'Naklejka dodana.');
    }

    /*
    |--------------------------------------------------------------------------
    | KARTY LOJALNOŚCIOWE — RESET PO NAGRODZIE
    |--------------------------------------------------------------------------
    */
    public function resetCard($cardId)
    {
        $firmId = session('firm_id');
        if (! $firmId) {
            return redirect()->route('company.login');
        }

        $card = LoyaltyCard::findOrFail($cardId);

        $programId = Firm::findOrFail($firmId)->program_id;
        if ($card->program_id !== $programId) {
            abort(403);
        }

        DB::transaction(function () use ($card, $firmId) {
            $card->update([
                'current_stamps' => 0,
                'status'         => 'active',
            ]);

            LoyaltyStamp::create([
                'loyalty_card_id' => $card->id,
                'firm_id'         => $firmId,
                'description'     => 'Reset karty po nagrodzie',
            ]);
        });

        return back()->with('success', 'Karta została zresetowana.');
    }

    /*
    |--------------------------------------------------------------------------
    | PUNKTY — FORMULARZ
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

    /*
    |--------------------------------------------------------------------------
    | PUNKTY — DODAWANIE
    |--------------------------------------------------------------------------
    */
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

        $points = (int) round($request->amount * 0.5);

        $client->increment('points', $points);

        Transaction::create([
            'client_id'  => $client->id,
            'firm_id'    => $firmId,
            'program_id' => $programId,
            'points'     => $points,
            'type'       => 'purchase',
        ]);

        return back()->with('success', 'Punkty dodane.');
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
            return back()->with('error', 'Voucher został już użyty.');
        }

        $voucher->update(['status' => 'used']);

        return back()->with('success', 'Voucher zrealizowany.');
    }
}
