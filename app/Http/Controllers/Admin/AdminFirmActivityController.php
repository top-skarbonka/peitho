<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Firm;
use App\Models\LoyaltyStamp;
use Carbon\Carbon;

class AdminFirmActivityController extends Controller
{
    public function show(Firm $firm)
    {
        $from = Carbon::now()->subDays(29)->startOfDay();
        $to   = Carbon::now()->endOfDay();

        $cardIds = $firm->loyaltyCards()->pluck('id');

        $stamps = LoyaltyStamp::whereIn('loyalty_card_id', $cardIds)
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as day, COUNT(*) as actions')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('admin.firms.activity', [
            'firm'         => $firm,
            'stamps'       => $stamps,
            'from'         => $from,
            'to'           => $to,
            'lastActivity' => $firm->last_activity_at,
        ]);
    }
}
