<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FirmCreatedMail;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminFirmController extends Controller
{

    /**
     * 📋 Lista firm
     */
    public function index()
    {
        $firms = Firm::orderByDesc('id')->get();
        return view('admin.firms.index', compact('firms'));
    }


    /**
     * ➕ Dodanie firmy
     */
    public function create()
    {
        return view('admin.firms.create');
    }


    /**
     * 💾 Store
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email',
            'city'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'postal_code'   => 'required|string|max:20',
            'phone'         => 'nullable|string|max:20',
            'card_template' => 'required|string',
        ]);

        $plainPassword = Str::random(10);
        $slug = Str::slug($request->name) . '-' . rand(1000, 9999);

        $firm = Firm::create([
            'firm_id'       => $slug,
            'slug'          => $slug,
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($plainPassword),
            'password_changed_at' => null,

            'city'          => $request->city,
            'address'       => $request->address,
            'postal_code'   => $request->postal_code,
            'phone'         => $request->phone,
            'program_id'    => 1,
            'card_template' => $request->card_template,

            // 🔥 SUBSKRYPCJA
            'subscription_status' => 'trial',
            'subscription_ends_at' => now()->addDays(14),
            'subscription_forced_status' => null,
            'plan' => 'starter',
            'billing_period' => 'monthly',
        ]);

        Mail::to($firm->email)->send(
            new FirmCreatedMail($firm, $plainPassword)
        );

        return redirect()
            ->route('admin.firms.index')
            ->with('success', 'Firma została dodana ✅');
    }



    /**
     * ✏️ Edycja + statystyki
     */
    public function edit(Firm $firm)
    {
        $totalStamps = LoyaltyStamp::where('firm_id', $firm->id)->count();

        $monthStamps = LoyaltyStamp::where('firm_id', $firm->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $clientsCount = LoyaltyCard::where('firm_id', $firm->id)
            ->distinct('client_id')
            ->count('client_id');

        $cardsCount = LoyaltyCard::where('firm_id', $firm->id)->count();

        $from = Carbon::now()->startOfMonth();
        $to   = Carbon::now()->endOfMonth();

        $stampsByDay = LoyaltyStamp::select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('COUNT(*) as total')
            )
            ->where('firm_id', $firm->id)
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('admin.firms.edit', compact(
            'firm',
            'totalStamps',
            'monthStamps',
            'clientsCount',
            'cardsCount',
            'stampsByDay'
        ));
    }



    /**
     * 📊 Aktywność
     */
    public function activity(Firm $firm)
    {
        return $this->edit($firm);
    }



    /**
     * 🔄 Update
     */
    public function update(Request $request, Firm $firm)
    {
        $request->validate([
            'password' => 'nullable|min:8|confirmed',
        ]);

        $firm->update(
            $request->only([
                'name',
                'city',
                'address',
                'phone',
                'card_template',
                'google_url',
                'subscription_status',
                'subscription_ends_at',
                'plan',
                'billing_period',
            ])
        );

        if ($request->filled('password')) {

            $firm->update([
                'password' => Hash::make($request->password),
                'password_changed_at' => null
            ]);
        }

        return back()->with('success', 'Zapisano zmiany ✅');
    }



    /**
     * 🔴 FORCE BLOCK
     */
    public function forceBlock(Firm $firm)
    {
        $firm->update([
            'subscription_forced_status' => 'blocked',
            'subscription_status' => 'blocked'
        ]);

        return back()->with('success', 'Firma została ZABLOKOWANA 🔴');
    }



    /**
     * 🟢 FORCE UNBLOCK
     */
    public function forceUnblock(Firm $firm)
    {
        // jeśli data w przyszłości → active
        $status = optional($firm->subscription_ends_at)->isFuture()
            ? 'active'
            : 'grace';

        $firm->update([
            'subscription_forced_status' => null,
            'subscription_status' => $status
        ]);

        return back()->with('success', 'Firma została ODBLOKOWANA 🟢');
    }



    /**
     * ➕ +30 dni
     */
    public function extend30(Firm $firm)
    {
        $date = $firm->subscription_ends_at && $firm->subscription_ends_at->isFuture()
            ? $firm->subscription_ends_at->copy()
            : now();

        $firm->update([
            'subscription_ends_at' => $date->addDays(30),

            // 🔥 AUTO UNBLOCK
            'subscription_status' => 'active',
            'subscription_forced_status' => null,

            // 🔥 RESET MAILI
            'subscription_reminder_sent_at' => null,
            'subscription_expired_sent_at' => null,
            'subscription_blocked_sent_at' => null,
        ]);

        return back()->with('success', 'Abonament +30 dni ✅');
    }



    /**
     * 👑 +365 dni
     */
    public function extend365(Firm $firm)
    {
        $date = $firm->subscription_ends_at && $firm->subscription_ends_at->isFuture()
            ? $firm->subscription_ends_at->copy()
            : now();

        $firm->update([
            'subscription_ends_at' => $date->addDays(365),

            // 🔥 AUTO UNBLOCK
            'subscription_status' => 'active',
            'subscription_forced_status' => null,

            // 🔥 RESET MAILI
            'subscription_reminder_sent_at' => null,
            'subscription_expired_sent_at' => null,
            'subscription_blocked_sent_at' => null,
        ]);

        return back()->with('success', 'Abonament +365 dni 👑');
    }

}
