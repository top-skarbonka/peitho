<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\FirmCreatedMail;
use App\Mail\FirmWelcomeGuideMail;
use App\Models\Firm;
use App\Models\FirmPromotion;
use App\Models\FirmLocation;
use App\Models\FirmRecommendation;
use App\Models\LoyaltyCard;
use App\Models\LoyaltyStamp;
use App\Models\RecommendationCategory;
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

        $smsToday = \DB::table('sms_logs')
            ->select('firm_id', \DB::raw('COUNT(*) as total'))
            ->where('type', 'otp')
            ->whereDate('created_at', today())
            ->groupBy('firm_id')
            ->pluck('total', 'firm_id');

        $lastSmsStatus = \DB::table('sms_logs')
            ->select('firm_id', 'status')
            ->where('type', 'otp')
            ->orderByDesc('id')
            ->get()
            ->groupBy('firm_id')
            ->map(function ($rows) {
                return $rows->first()->status ?? null;
            });

        $firms->transform(function ($firm) use ($smsToday, $lastSmsStatus) {

            $firm->sms_today = $smsToday[$firm->id] ?? 0;

            $status = $lastSmsStatus[$firm->id] ?? null;

            if (! $status) {
                $firm->otp_status = 'none';
            } elseif ($status === 'success') {
                $firm->otp_status = 'ok';
            } else {
                $firm->otp_status = 'error';
            }

            return $firm;
        });

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
            'program_type'  => 'required|in:points,cards,passes',
            'card_template' => 'required|in:classic,florist,hair_salon,pizzeria,kebab,cafe,workshop',
        ]);

        $plainPassword = Str::random(10);
        $slug = Str::slug($request->name) . '-' . rand(1000, 9999);

        // 🔥 LOGIKA PROGRAMU
        $hasPoints = $request->program_type === 'points';
        $hasStickers = $request->program_type === 'cards';
        $hasPasses = $request->program_type === 'passes';

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

            // ✅ KLUCZOWE
            'has_points'   => $hasPoints,
            'has_stickers' => $hasStickers,
            'has_passes'   => $hasPasses,
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

        $promotions = FirmPromotion::where('firm_id', $firm->id)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $locations = FirmLocation::where('firm_id', $firm->id)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $recommendations = FirmRecommendation::with(['recommendedFirm', 'category'])
            ->where('firm_id', $firm->id)
            ->orderBy('category_id')
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $recommendationCategories = RecommendationCategory::where('is_active', 1)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $allFirms = Firm::orderBy('name')->get(['id', 'name']);

        return view('admin.firms.edit', compact(
            'firm',
            'totalStamps',
            'monthStamps',
            'clientsCount',
            'cardsCount',
            'promotions',
            'locations',
            'recommendations',
            'recommendationCategories',
            'allFirms'
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

        $data['has_stickers'] = $request->has('has_stickers');
        $data['has_points']   = $request->has('has_points');
        $data['has_passes']   = $request->has('has_passes');
        $data['push_enabled'] = $request->has('push_enabled');

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

    public function storePromotion(Request $request, Firm $firm)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'promo_text' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'firm_id' => $firm->id,
            'title' => $validated['title'],
            'promo_text' => $validated['promo_text'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('firm-promotions', 'public');
        }

        FirmPromotion::create($data);

        return back()->with('success', 'Promocja została dodana ✅');
    }

    public function storeLocation(Request $request, Firm $firm)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'google_maps_url' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        FirmLocation::create([
            'firm_id' => $firm->id,
            'name' => $validated['name'] ?? null,
            'address' => $validated['address'],
            'city' => $validated['city'] ?? null,
            'postal_code' => $validated['postal_code'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'google_maps_url' => $validated['google_maps_url'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Lokalizacja została dodana ✅');
    }

    public function storeRecommendation(Request $request, Firm $firm)
    {
        $validated = $request->validate([
            'recommended_firm_id' => 'required|integer|different:firm_id',
            'category_id' => 'required|integer',
            'promo_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        FirmRecommendation::create([
            'firm_id' => $firm->id,
            'recommended_firm_id' => $validated['recommended_firm_id'],
            'category_id' => $validated['category_id'],
            'promo_text' => $validated['promo_text'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return back()->with('success', 'Polecana firma została dodana ✅');
    }

    public function destroyPromotion(Firm $firm, FirmPromotion $promotion)
    {
        if ($promotion->firm_id !== $firm->id) {
            abort(404);
        }

        $promotion->delete();

        return back()->with('success', 'Promocja została usunięta ✅');
    }

    public function destroyLocation(Firm $firm, FirmLocation $location)
    {
        if ($location->firm_id !== $firm->id) {
            abort(404);
        }

        $location->delete();

        return back()->with('success', 'Lokalizacja została usunięta ✅');
    }

    public function destroyRecommendation(Firm $firm, FirmRecommendation $recommendation)
    {
        if ($recommendation->firm_id !== $firm->id) {
            abort(404);
        }

        $recommendation->delete();

        return back()->with('success', 'Polecana firma została usunięta ✅');
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

    public function activity(Firm $firm)
    {
        return view('admin.firms.activity', compact('firm'));
    }
}
