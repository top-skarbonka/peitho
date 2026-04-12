<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FirmLocation;
use App\Models\FirmPromotion;
use App\Models\FirmRecommendation;
use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

// 🔥 NOWE
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function dashboard()
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        $cards = LoyaltyCard::with(['firm', 'stamps'])
            ->where('client_id', $client->id)
            ->whereHas('firm', function ($query) {
                $query->where('program_type', 'cards')
                    ->orWhere('has_stickers', 1);
            })
            ->get();

        $grouped = $cards
            ->groupBy(function ($card) {
                return $card->firm->card_template ?? 'classic';
            })
            ->map(function ($cards) {
                return $cards->map(function ($card) {
                    $max = (int) ($card->firm->stamps_required ?? 10);
                    if ($max < 1) {
                        $max = 10;
                    }

                    $current = min($card->stamps->count(), $max);

                    return [
                        'card'        => $card,
                        'current'     => $current,
                        'max'         => $max,
                        'rewardReady' => $current >= $max,
                    ];
                });
            });

        $points = DB::table('client_points as cp')
            ->join('firms as f', 'f.id', '=', 'cp.firm_id')
            ->leftJoin('loyalty_cards as lc', function ($join) {
                $join->on('lc.firm_id', '=', 'cp.firm_id')
                    ->on('lc.client_id', '=', 'cp.client_id');
            })
            ->where('cp.client_id', $client->id)
            ->select([
                'cp.points',
                'cp.firm_id',
                'f.id as firm_id',
                'f.name as firm_name',
                'f.slug as firm_slug',
                'lc.id as linked_card_id',
            ])
            ->orderByDesc('cp.id')
            ->get();

        $passes = DB::table('user_passes as up')
            ->join('company_pass_types as pt', 'pt.id', '=', 'up.pass_type_id')
            ->join('firms as f', 'f.id', '=', 'up.firm_id')
            ->where('up.client_id', $client->id)
            ->select([
                'up.id',
                'up.total_entries',
                'up.remaining_entries',
                'up.status',
                'up.activated_at',
                'up.finished_at',
                'pt.name as pass_name',
                'f.name as firm_name',
            ])
            ->orderByDesc('up.id')
            ->get();

        return view('client.dashboard', [
            'client'  => $client,
            'grouped' => $grouped,
            'passes'  => $passes,
            'points'  => $points,
        ]);
    }

    public function consents()
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        $cards = LoyaltyCard::with('firm')
            ->where('client_id', $client->id)
            ->get()
            ->keyBy('firm_id');

        $pointFirmIds = DB::table('client_points')
            ->where('client_id', $client->id)
            ->pluck('firm_id');

        foreach ($pointFirmIds as $firmId) {
            if (! $cards->has($firmId)) {
                $card = LoyaltyCard::firstOrCreate(
                    [
                        'client_id' => $client->id,
                        'firm_id'   => $firmId,
                    ],
                    [
                        'max_stamps'     => 10,
                        'current_stamps' => 0,
                        'status'         => 'active',
                    ]
                );

                $card->load('firm');
                $cards->put($firmId, $card);
            }
        }

        $cards = $cards
            ->filter(function ($card) {
                return $card->firm !== null;
            })
            ->sortBy(function ($card) {
                return mb_strtolower((string) $card->firm->name);
            })
            ->values();

        return view('client.consents', [
            'cards' => $cards,
        ]);
    }

    public function updateConsent(Request $request, LoyaltyCard $card)
    {
        $client = Auth::guard('client')->user();

        if (! $client || $card->client_id !== $client->id) {
            abort(403);
        }

        $request->validate([
            'marketing_consent' => 'required',
        ]);

        $oldValue = (int) ((bool) $card->marketing_consent);
        $newValue = (int) ($request->boolean('marketing_consent'));

        if ($oldValue === $newValue) {
            return response()->json([
                'success' => true,
                'marketing_consent' => (bool) $newValue,
            ]);
        }

        $now = Carbon::now();

        $card->marketing_consent = $newValue;
        $card->marketing_consent_at = $newValue ? $now : null;
        $card->marketing_consent_revoked_at = $newValue ? null : $now;
        $card->save();

        DB::table('client_consents_logs')->insert([
            'client_id'     => $client->id,
            'phone'         => $client->phone,
            'firm_id'       => $card->firm_id,
            'consent_type'  => 'sms_marketing',
            'value'         => $newValue,
            'ip_address'    => request()->ip(),
            'user_agent'    => request()->userAgent(),
            'source'        => 'panel_client',
            'consent_text'  => 'Zgoda na komunikację marketingową SMS',
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        return response()->json([
            'success' => true,
            'marketing_consent' => (bool) $newValue,
        ]);
    }

    // 🔥 NOWA METODA — WYSYŁKA RODO PDF
    public function sendRodoData(Request $request)
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            abort(403);
        }

        $request->validate([
            'email' => 'required|email',
        ]);

        $points = DB::table('client_points')
            ->join('firms', 'firms.id', '=', 'client_points.firm_id')
            ->where('client_points.client_id', $client->id)
            ->select('client_points.*', 'firms.name as firm_name')
            ->get();

        $transactions = DB::table('client_point_logs')
            ->where('client_id', $client->id)
            ->orderByDesc('created_at')
            ->get();

        $consents = DB::table('client_consents_logs')
            ->join('firms', 'firms.id', '=', 'client_consents_logs.firm_id')
            ->where('client_consents_logs.client_id', $client->id)
            ->select('client_consents_logs.*', 'firms.name as firm_name')
            ->orderByDesc('client_consents_logs.created_at')
            ->get();

        $pdf = Pdf::loadView('admin.pdf.client-export', [
            'client' => $client,
            'points' => $points,
            'transactions' => $transactions,
            'consents' => $consents,
        ]);

        Mail::raw('Twoje dane z systemu Looply w załączniku.', function ($message) use ($request, $pdf) {
            $message->to($request->email)
                ->subject('Twoje dane (RODO) - Looply')
                ->attachData($pdf->output(), 'dane-klienta.pdf');
        });

        return back()->with('success', 'Dane zostały wysłane na email.');
    }

    public function showCard(LoyaltyCard $card)
    {
        $client = Auth::guard('client')->user();

        if (! $client || $card->client_id !== $client->id) {
            abort(403);
        }

        $maxStamps = (int) ($card->firm->stamps_required ?? 10);
        if ($maxStamps < 1) {
            $maxStamps = 10;
        }

        $current = min($card->stamps->count(), $maxStamps);

        $displayCode = $client->phone;

        $qrPayload = url('/company/points/add-client?phone=' . $client->phone);

        $qr = QrCode::format('svg')
            ->size(170)
            ->margin(0)
            ->generate($qrPayload);

        $promotions = FirmPromotion::where('firm_id', $card->firm->id)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $locations = FirmLocation::where('firm_id', $card->firm->id)
            ->where('is_active', 1)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $recommendations = FirmRecommendation::with(['recommendedFirm', 'category'])
            ->where('firm_id', $card->firm->id)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $clientPoints = (int) (
            DB::table('client_points')
                ->where('client_id', $client->id)
                ->where('firm_id', $card->firm->id)
                ->value('points') ?? 0
        );

        $programSettings = DB::table('program_settings')
            ->where('firm_id', $card->firm->id)
            ->first();

        $pointsPerCurrency = (int) ($programSettings->points_per_currency ?? 10);
        if ($pointsPerCurrency < 1) {
            $pointsPerCurrency = 10;
        }

        $rewards = DB::table('point_rewards')
            ->where('firm_id', $card->firm->id)
            ->orderBy('points_required')
            ->get()
            ->values();

        $availableReward = $rewards->filter(function ($reward) use ($clientPoints) {
            return (int) $reward->points_required <= $clientPoints;
        })->last();

        $nextReward = $rewards->first(function ($reward) use ($clientPoints) {
            return (int) $reward->points_required > $clientPoints;
        });

        $pointsToNextReward = $nextReward
            ? max(0, (int) $nextReward->points_required - $clientPoints)
            : 0;

        $estimatedDiscount = round($clientPoints / $pointsPerCurrency, 2);

        $card->firm->setRelation('promotions', $promotions);
        $card->firm->setRelation('locations', $locations);
        $card->firm->setRelation('recommendations', $recommendations);

        $template = (int) $card->firm->id === 43
            ? 'company_profile'
            : ($card->firm->card_template ?? 'classic');

        return view("client.cards.$template", [
            'card'               => $card,
            'client'             => $client,
            'firm'               => $card->firm,
            'maxStamps'          => $maxStamps,
            'current'            => $current,
            'displayCode'        => $displayCode,
            'qr'                 => $qr,
            'clientPoints'       => $clientPoints,
            'pointsPerCurrency'  => $pointsPerCurrency,
            'estimatedDiscount'  => $estimatedDiscount,
            'availableReward'    => $availableReward,
            'nextReward'         => $nextReward,
            'pointsToNextReward' => $pointsToNextReward,
            'rewards'            => $rewards,
        ]);
    }
}
