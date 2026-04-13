<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\FirmLocation;
use App\Models\FirmPromotion;
use App\Models\FirmRecommendation;
use App\Models\LoyaltyCard;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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

        $points = DB::table('loyalty_cards as lc')
            ->join('firms as f', 'f.id', '=', 'lc.firm_id')
            ->leftJoin('client_points as cp', function ($join) {
                $join->on('cp.firm_id', '=', 'lc.firm_id')
                    ->on('cp.client_id', '=', 'lc.client_id');
            })
            ->where('lc.client_id', $client->id)
            ->where(function ($query) {
                $query->where('f.program_type', 'points')
                    ->orWhere('f.has_points', 1);
            })
            ->select([
                DB::raw('COALESCE(cp.points, 0) as points'),
                'lc.firm_id',
                'f.id as firm_id',
                'f.name as firm_name',
                'f.slug as firm_slug',
                'lc.id as linked_card_id',
            ])
            ->orderBy('f.name')
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

    public function sendRodoData(Request $request)
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        $validated = $request->validate([
            'email' => ['required', 'email'],
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
            'client'       => $client,
            'points'       => $points,
            'transactions' => $transactions,
            'consents'     => $consents,
        ]);

        $pdfContent = $pdf->output();
        $fileName = 'dane-klienta-' . preg_replace('/\D+/', '', (string) $client->phone) . '.pdf';

        Mail::raw('W załączniku znajdziesz wygenerowany raport danych klienta (RODO) z systemu Looply.', function ($message) use ($validated, $pdfContent, $fileName, $client) {
            $message->to($validated['email'])
                ->subject('Looply – Twoje dane (RODO) – klient #' . $client->id)
                ->attachData($pdfContent, $fileName, [
                    'mime' => 'application/pdf',
                ]);
        });

        return redirect()
            ->route('client.dashboard')
            ->with('success', 'Twoje dane zostały wysłane na podany adres e-mail ✅');
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

        $validated = $request->validate([
            'consent_type' => 'required|in:sms_marketing,email_marketing',
            'value'        => 'required|boolean',
        ]);

        $now = Carbon::now();
        $newValue = (bool) $validated['value'];
        $consentType = $validated['consent_type'];

        if ($consentType === 'sms_marketing') {
            $oldValue = (bool) $card->sms_marketing_consent;

            if ($oldValue === $newValue) {
                return response()->json([
                    'success' => true,
                    'consent_type' => $consentType,
                    'value' => $newValue,
                ]);
            }

            $card->sms_marketing_consent = $newValue;
            $card->sms_marketing_consent_at = $newValue ? ($card->sms_marketing_consent_at ?? $now) : null;
            $card->sms_marketing_consent_revoked_at = $newValue ? null : $now;
        } else {
            $oldValue = (bool) $card->email_marketing_consent;

            if ($oldValue === $newValue) {
                return response()->json([
                    'success' => true,
                    'consent_type' => $consentType,
                    'value' => $newValue,
                ]);
            }

            $card->email_marketing_consent = $newValue;
            $card->email_marketing_consent_at = $newValue ? ($card->email_marketing_consent_at ?? $now) : null;
            $card->email_marketing_consent_revoked_at = $newValue ? null : $now;
        }

        $card->marketing_consent = (bool) ($card->sms_marketing_consent || $card->email_marketing_consent);
        $card->marketing_consent_at = $card->marketing_consent
            ? ($card->marketing_consent_at ?? $now)
            : null;
        $card->marketing_consent_revoked_at = $card->marketing_consent ? null : $now;
        $card->save();

        DB::table('client_consents_logs')->insert([
            'client_id'    => $client->id,
            'phone'        => $client->phone,
            'firm_id'      => $card->firm_id,
            'consent_type' => $consentType,
            'value'        => $newValue ? 1 : 0,
            'ip_address'   => request()->ip(),
            'user_agent'   => substr((string) request()->userAgent(), 0, 500),
            'source'       => 'client_consents_panel',
            'consent_text' => $consentType === 'sms_marketing'
                ? 'Zgoda na otrzymywanie informacji marketingowych drogą SMS.'
                : 'Zgoda na otrzymywanie informacji marketingowych drogą e-mail.',
            'created_at'   => $now,
            'updated_at'   => $now,
        ]);

        if ($consentType === 'sms_marketing') {
            $client->sms_marketing_consent = $newValue;
            $client->sms_marketing_consent_at = $newValue ? ($client->sms_marketing_consent_at ?? $now) : null;
            $client->sms_marketing_withdrawn_at = $newValue ? null : $now;
        } else {
            $client->email_marketing_consent = $newValue;
            $client->email_marketing_consent_at = $newValue ? ($client->email_marketing_consent_at ?? $now) : null;
            $client->email_marketing_withdrawn_at = $newValue ? null : $now;
        }

        $client->save();

        return response()->json([
            'success'      => true,
            'consent_type' => $consentType,
            'value'        => $newValue,
        ]);
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

        $qrPayload = route('company.points.client.form', ['phone' => $client->phone]);
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

        if ($rewards->isEmpty() && (int) $card->firm->id === 43) {
            $rewards = collect([
                ['points_required' => 200,  'reward_name' => '10 zł rabatu'],
                ['points_required' => 300,  'reward_name' => '15 zł rabatu'],
                ['points_required' => 400,  'reward_name' => '20 zł rabatu'],
                ['points_required' => 500,  'reward_name' => '25 zł rabatu'],
                ['points_required' => 600,  'reward_name' => '30 zł rabatu'],
                ['points_required' => 700,  'reward_name' => '35 zł rabatu'],
                ['points_required' => 800,  'reward_name' => '40 zł rabatu'],
                ['points_required' => 900,  'reward_name' => '45 zł rabatu'],
                ['points_required' => 1000, 'reward_name' => '50 zł rabatu'],
            ])->map(function ($reward) {
                return (object) $reward;
            })->values();
        }

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

    public function loyaltyCard()
    {
        $client = Auth::guard('client')->user();

        if (! $client) {
            return redirect()->route('client.login');
        }

        $card = LoyaltyCard::with(['firm', 'stamps'])
            ->where('client_id', $client->id)
            ->whereHas('firm', function ($query) {
                $query->where('program_type', 'cards')
                    ->orWhere('has_stickers', 1);
            })
            ->latest()
            ->first();

        if (! $card) {
            abort(404, 'Brak przypisanej karty lojalnościowej');
        }

        return $this->showCard($card);
    }

    public function activateForm(string $token)
    {
        $client = Client::where('activation_token', $token)->first();

        if (! $client) {
            abort(404, 'Nieprawidłowy token.');
        }

        if ($client->activation_token_expires_at && now()->greaterThan($client->activation_token_expires_at)) {
            abort(410, 'Token wygasł.');
        }

        return view('client.activate', [
            'token' => $token,
            'phone' => $client->phone,
        ]);
    }

    public function activateSubmit(Request $request, string $token)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $client = Client::where('activation_token', $token)->first();

        if (! $client) {
            abort(404, 'Nieprawidłowy token.');
        }

        if ($client->activation_token_expires_at && now()->greaterThan($client->activation_token_expires_at)) {
            abort(410, 'Token wygasł.');
        }

        DB::transaction(function () use ($client, $request) {
            $client->password = Hash::make((string) $request->input('password'));
            $client->password_set = 1;
            $client->activation_token = null;
            $client->activation_token_expires_at = null;
            $client->save();
        });

        Auth::guard('client')->login($client);

        return redirect()
            ->route('client.dashboard')
            ->with('success', 'Hasło ustawione ✅ Możesz się teraz logować numerem telefonu.');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required'
        ]);

        $client = Client::where('phone', $request->phone)->first();

        if (! $client) {
            return back()->withErrors([
                'phone' => 'Nie znaleziono konta z tym numerem.'
            ]);
        }

        $token = Str::random(32);

        $client->update([
            'password_reset_token' => $token
        ]);

        return redirect()->route('client.set_password.show', ['token' => $token]);
    }
}
