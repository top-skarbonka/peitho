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
        $now = Carbon::now();

        // 🏷️ wszystkie naklejki tej firmy
        $stampsQuery = LoyaltyStamp::where('firm_id', $firm->id);

        // 🕒 ostatnia aktywność
        $lastStamp = (clone $stampsQuery)->latest()->first();
        $lastActivityAt = $lastStamp?->created_at;

        // 🟢 aktywna jeśli coś było w 7 dni
        $isActive = $lastActivityAt && $lastActivityAt->gt($now->copy()->subDays(7));

        // 📊 suma naklejek z 30 dni
        $stamps30 = (clone $stampsQuery)
            ->where('created_at', '>=', $now->copy()->subDays(30))
            ->count();

        return view('admin.firms.activity', [
            'firm'           => $firm,
            'isActive'       => $isActive,
            'lastActivityAt' => $lastActivityAt,
            'stamps30'       => $stamps30,
        ]);
    }
}
