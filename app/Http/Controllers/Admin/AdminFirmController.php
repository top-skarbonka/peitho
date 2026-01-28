<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Firm;
use App\Models\LoyaltyStamp;
use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Mail\FirmCreatedMail;

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
     * ➕ Formularz dodania
     */
    public function create()
    {
        return view('admin.firms.create');
    }

    /**
     * 💾 Zapis nowej firmy + mail z danymi
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
            'password_changed_at' => null, // 🔴 WYMUSZENIE ZMIANY HASŁA
            'city'          => $request->city,
            'address'       => $request->address,
            'postal_code'   => $request->postal_code,
            'phone'         => $request->phone,
            'program_id'    => 1,
            'card_template' => $request->card_template,
        ]);

        // ✉️ Mail do firmy
        Mail::to($firm->email)->send(
            new FirmCreatedMail($firm, $plainPassword)
        );

        return redirect()
            ->route('admin.firms.index')
            ->with('success', 'Firma została dodana i mail wysłany');
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
            'stampsByDay'
        ));
    }

    /**
     * 🔄 Aktualizacja (DANE + OPCJONALNIE HASŁO)
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
            ])
        );

        // 🔐 JEŚLI ADMIN USTAWI HASŁO → WYMUSZAMY ZMIANĘ
        if ($request->filled('password')) {
            $firm->password = Hash::make($request->password);
            $firm->password_changed_at = null;
            $firm->save();
        }

        return back()->with('success', 'Zapisano zmiany');
    }
}
