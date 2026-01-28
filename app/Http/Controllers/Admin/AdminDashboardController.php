<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Firm;
use App\Models\Client;
use App\Models\LoyaltyStamp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $from = Carbon::now()->startOfMonth();
        $to   = Carbon::now()->endOfMonth();

        // 🔢 liczniki globalne
        $firmsCount   = Firm::count();
        $clientsCount = Client::count();
        $stampsCount  = LoyaltyStamp::count();

        $firmsThisMonth   = Firm::whereBetween('created_at', [$from, $to])->count();
        $clientsThisMonth = Client::whereBetween('created_at', [$from, $to])->count();

        // 📊 wykres
        $stampsByDay = LoyaltyStamp::select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('created_at', [$from, $to])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('day')
            ->get();

        // 🏆 TOP FIRMY (POPRAWNE GROUP BY)
        $topFirms = Firm::select(
                'firms.id',
                'firms.name',
                'firms.slug',
                DB::raw('COUNT(DISTINCT loyalty_stamps.id) as total_stamps'),
                DB::raw('SUM(CASE WHEN loyalty_stamps.created_at BETWEEN "'.$from.'" AND "'.$to.'" THEN 1 ELSE 0 END) as month_stamps'),
                DB::raw('COUNT(DISTINCT clients.id) as total_clients'),
                DB::raw('SUM(CASE WHEN clients.created_at BETWEEN "'.$from.'" AND "'.$to.'" THEN 1 ELSE 0 END) as month_clients')
            )
            ->leftJoin('loyalty_stamps', 'loyalty_stamps.firm_id', '=', 'firms.id')
            ->leftJoin('clients', 'clients.firm_id', '=', 'firms.id')
            ->groupBy('firms.id', 'firms.name', 'firms.slug')
            ->orderByDesc('total_stamps')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'firmsCount',
            'clientsCount',
            'stampsCount',
            'firmsThisMonth',
            'clientsThisMonth',
            'stampsByDay',
            'topFirms'
        ));
    }
}
