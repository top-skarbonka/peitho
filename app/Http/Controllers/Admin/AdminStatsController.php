<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Firm;
use App\Models\LoyaltyStamp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminStatsController extends Controller
{
    public function index()
    {
        // 📊 podstawowe liczby
        $firmsCount = Firm::count();
        $stampsTotal = LoyaltyStamp::count();

        // 📅 bieżący miesiąc
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        $stampsThisMonth = LoyaltyStamp::whereBetween('created_at', [
            $startOfMonth,
            $endOfMonth
        ])->count();

        // 📈 dziennie w bieżącym miesiącu (pod wykres)
        $stampsPerDay = LoyaltyStamp::select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('admin.stats.index', [
            'firmsCount'      => $firmsCount,
            'stampsTotal'     => $stampsTotal,
            'stampsThisMonth' => $stampsThisMonth,
            'stampsPerDay'    => $stampsPerDay,
        ]);
    }
}
