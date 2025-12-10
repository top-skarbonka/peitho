<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use App\Models\GiftVoucher;

class FirmController extends Controller
{
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
            'firm_id' => 1,
            'description' => "Dodano naklejkę"
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

    public function useVoucher($id)
    {
        $voucher = GiftVoucher::findOrFail($id);

        if ($voucher->status === 'used') {
            return back()->with('error', 'Voucher został już wykorzystany.');
        }

        if (now()->gt($voucher->expires_at)) {
            $voucher->status = 'expired';
            $voucher->save();
            return back()->with('error', 'Voucher wygasł.');
        }

        $voucher->status = 'used';
        $voucher->save();

        return back()->with('success', 'Voucher zrealizowany!');
    }

    public function dashboard()
    {
        return view('firm.dashboard');
    }
}
