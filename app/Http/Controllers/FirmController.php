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
    | DASHBOARD
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

        // AUTO-COMPLETED
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
        return view('firm.points');
    }

    public function addPoints(Request $request)
    {
        $request->validate([
            'phone'  => 'required',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $firmId = session('firm_id');
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
}
