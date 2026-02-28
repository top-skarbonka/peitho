<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FirmCreatedMail;
use App\Mail\FirmWelcomeGuideMail;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class AdminFirmController extends Controller
{
    public function index()
    {
        $firms = Firm::orderByDesc('id')->get();
        return view('admin.firms.index', compact('firms'));
    }

    public function create()
    {
        return view('admin.firms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email',
            'city'          => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'postal_code'   => 'required|string|max:20',
            'phone'         => 'nullable|string|max:20',
            'program_type'  => 'required|in:cards,passes',
            'card_template' => 'required|in:classic,florist,hair_salon,pizzeria,kebab,cafe,workshop',
        ]);

        $plainPassword = Str::random(10);
        $slug = Str::slug($request->name) . '-' . rand(1000, 9999);

        $firm = Firm::create([
            'firm_id'       => $slug,
            'slug'          => $slug,
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($plainPassword),
            'city'          => $request->city,
            'address'       => $request->address,
            'postal_code'   => $request->postal_code,
            'phone'         => $request->phone,
            'program_type'  => $request->program_type,
            'program_id'    => 1,
            'card_template' => $request->card_template,
            'subscription_status' => 'trial',
            'subscription_ends_at' => now()->addDays(14),
            'plan' => 'starter',
            'billing_period' => 'monthly',
        ]);

        Mail::to($firm->email)->send(
            new FirmCreatedMail($firm, $plainPassword)
        );

        Mail::to($firm->email)->send(
            new FirmWelcomeGuideMail($firm)
        );

        return redirect()
            ->route('admin.firms.index')
            ->with('success', 'Firma została dodana ✅');
    }

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

        return view('admin.firms.edit', compact(
            'firm',
            'totalStamps',
            'monthStamps',
            'clientsCount',
            'cardsCount'
        ));
    }

    public function update(Request $request, Firm $firm)
    {
        $request->validate([
            'password'        => 'nullable|min:8|confirmed',
            'google_url'      => 'nullable|string',
            'facebook_url'    => 'nullable|string',
            'instagram_url'   => 'nullable|string',
            'youtube_url'     => 'nullable|string',
            'promotion_text'  => 'nullable|string',
            'opening_hours'   => 'nullable|string',
            'card_template'   => 'nullable|in:classic,florist,hair_salon,pizzeria,kebab,cafe,workshop',
            'logo'            => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'name',
            'city',
            'address',
            'phone',
            'google_url',
            'facebook_url',
            'instagram_url',
            'youtube_url',
            'promotion_text',
            'opening_hours',
            'subscription_status',
            'subscription_ends_at',
            'plan',
            'billing_period',
        ]);

        if ($request->filled('card_template')) {
            $data['card_template'] = $request->card_template;
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo_path'] = $path;
        }

        $firm->update($data);

        if ($request->filled('password')) {
            $firm->update([
                'password' => Hash::make($request->password),
                'password_changed_at' => null,
            ]);
        }

        return back()->with('success', 'Zapisano zmiany ✅');
    }

    public function extend30(Firm $firm)
    {
        $firm->subscription_ends_at = Carbon::parse($firm->subscription_ends_at ?? now())
            ->addDays(30);

        $firm->subscription_status = 'active';
        $firm->save();

        return back()->with('success', 'Abonament przedłużony o 30 dni ✅');
    }

    public function extend365(Firm $firm)
    {
        $firm->subscription_ends_at = Carbon::parse($firm->subscription_ends_at ?? now())
            ->addDays(365);

        $firm->subscription_status = 'active';
        $firm->save();

        return back()->with('success', 'Abonament przedłużony o 365 dni ✅');
    }
}
