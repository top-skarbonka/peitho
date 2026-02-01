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
        // ===============================
        // ZAKRES: ostatnie 30 dni
        // ===============================
        $from = Carbon::now()->subDays(29)->startOfDay();
        $to   = Carbon::now()->endOfDay();

        // ===============================
        // WSZYSTKIE NAKLEJKI (GLOBALNIE)
        // ⚠️ bo firm_id w stampsach jest źle
        // ===============================
        $allStamps = LoyaltyStamp::where('firm_id', $firm->id);

        // ===============================
        // OSTATNIA REALNA AKTYWNOŚĆ
        // ===============================
        $lastStampAt = $allStamps
            ->orderByDesc('created_at')
            ->value('created_at');

        // ===============================
        // STATUS AKTYWNOŚCI
        // ===============================
        $isActive = false;

        if ($lastStampAt) {
            $isActive = Carbon::parse($lastStampAt)
                ->greaterThanOrEqualTo(Carbon::now()->subDays(30));
        }

        // ===============================
        // STATYSTYKI
        // ===============================
        $totalAll = $allStamps->count();

        $stamps30 = LoyaltyStamp::where('firm_id', $firm->id)
            ->whereBetween('created_at', [$from, $to]);

        $total30 = $stamps30->count();

        // ===============================
        // WYKRES (dzień → ilość)
        // ===============================
        $daily = $stamps30
            ->selectRaw('DATE(created_at) as day, COUNT(*) as actions')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $chartLabels = [];
        $chartValues = [];

        for ($i = 0; $i < 30; $i++) {
            $day = $from->copy()->addDays($i)->format('Y-m-d');

            $found = $daily->firstWhere('day', $day);

            $chartLabels[] = Carbon::parse($day)->format('d.m');
            $chartValues[] = $found ? (int) $found->actions : 0;
        }

        return view('admin.firms.activity', [
            'firm'           => $firm,

            // status
            'isActive'       => $isActive,
            'lastActivityAt' => $lastStampAt ? Carbon::parse($lastStampAt) : null,

            // statystyki
            'totalAll'       => $totalAll,
            'total30'        => $total30,

            // wykres
            'chartLabels'    => $chartLabels,
            'chartValues'    => $chartValues,
        ]);
    }
}
