<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Firm;
use App\Models\LoyaltyStamp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $from  = Carbon::now()->startOfMonth();
        $to    = Carbon::now()->endOfMonth();

        /* =========================
         * KPI
         * ========================= */
        $firmsTotal  = Firm::count();
        $firmsToday  = Firm::whereDate('created_at', $today)->count();
        $stampsTotal = LoyaltyStamp::count();
        $stampsToday = LoyaltyStamp::whereDate('created_at', $today)->count();

        /* =========================
         * STATUS FIRMY
         * ========================= */
        $activeCount = Firm::where('last_activity_at', '>=', now()->subDays(7))->count();

        $contactCount = Firm::whereBetween(
            'last_activity_at',
            [now()->subDays(14), now()->subDays(8)]
        )->count();

        $dangerCount = Firm::where('last_activity_at', '<=', now()->subDays(15))->count();

        /* =========================
         * FIRMY DO REAKCJI
         * ========================= */
        $needActionFirms = Firm::where('last_activity_at', '<=', now()->subDays(8))
            ->orderBy('last_activity_at')
            ->limit(10)
            ->get();

        /* =========================
         * WYKRES
         * ========================= */
        $stampsByDay = LoyaltyStamp::select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        /* =========================
         * TOP FIRMY
         * ========================= */
        $topFirms = Firm::select(
                'firms.id',
                'firms.name',
                'firms.slug',
                DB::raw('COUNT(loyalty_stamps.id) as total_stamps')
            )
            ->leftJoin('loyalty_cards', 'loyalty_cards.firm_id', '=', 'firms.id')
            ->leftJoin('loyalty_stamps', 'loyalty_stamps.loyalty_card_id', '=', 'loyalty_cards.id')
            ->groupBy('firms.id', 'firms.name', 'firms.slug')
            ->orderByDesc('total_stamps')
            ->limit(5)
            ->get();

        /* =========================
         * VIEW
         * ========================= */
        return view('admin.dashboard', compact(
            'firmsTotal',
            'firmsToday',
            'stampsTotal',
            'stampsToday',
            'activeCount',
            'contactCount',
            'dangerCount',
            'needActionFirms',
            'stampsByDay',
            'topFirms',
            'today',
            'from',
            'to'
        ));
    }
}
