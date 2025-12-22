<?php

namespace App\Http\Controllers\Firm;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyCard;
use Illuminate\Http\Request;

class LoyaltyCardController extends Controller
{
    public function addStamp(Request $request, LoyaltyCard $card)
    {
        if ($card->status !== 'active') {
            return back();
        }

        $card->current_stamps++;

        if ($card->current_stamps >= $card->max_stamps) {
            $card->status = 'redeemed';
        }

        $card->save();

        return back();
    }
}
