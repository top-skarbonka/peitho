<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Firm;
use App\Models\LoyaltyCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class PublicClientController extends Controller
{
    public function showRegisterFormByFirm(string $slug)
    {
        $firm = Firm::where('slug', $slug)->firstOrFail();

        return view('client.register', [
            'firm' => $firm,
        ]);
    }

    public function registerByFirm(Request $request, string $slug)
    {
        $firm = Firm::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'phone'                    => 'required|min:6',
            'password'                 => 'required|min:4',
            'name'                     => 'nullable|string|max:255',
            'email'                    => 'nullable|email|max:255',
            'postal_code'              => 'nullable|string|max:20',
            'sms_marketing_consent'    => 'nullable|in:1',
            'email_marketing_consent'  => 'nullable|in:1',
            'terms_accepted'           => 'required|in:1',
        ]);

        $now = Carbon::now();

        $phone = preg_replace('/\D+/', '', $validated['phone']);

        if (str_starts_with($phone, '48') && strlen($phone) === 11) {
            $phone = substr($phone, 2);
        }

        $client = Client::where('phone', $phone)->first();

        $smsConsent = isset($validated['sms_marketing_consent']);
        $emailConsent = isset($validated['email_marketing_consent']);

        if (! $client) {
            $client = Client::create([
                'firm_id'                     => $firm->id,
                'program_id'                  => $firm->program_id,
                'name'                        => $validated['name'] ?? null,
                'email'                       => $validated['email'] ?? null,
                'phone'                       => $phone,
                'postal_code'                 => $validated['postal_code'] ?? null,
                'password'                    => Hash::make($validated['password']),
                'sms_marketing_consent'       => $smsConsent,
                'sms_marketing_consent_at'    => $smsConsent ? $now : null,
                'email_marketing_consent'     => $emailConsent,
                'email_marketing_consent_at'  => $emailConsent ? $now : null,
                'terms_accepted_at'           => $now,
            ]);
        } else {
            if (is_null($client->password)) {
                $client->update([
                    'password' => Hash::make($validated['password']),
                ]);
            } else {
                if (! Hash::check($validated['password'], $client->password)) {
                    return back()
                        ->withErrors([
                            'password' => 'Nieprawidłowe hasło do istniejącego portfela.',
                        ])
                        ->withInput();
                }
            }

            $updateData = [
                'firm_id'            => $firm->id,
                'program_id'         => $firm->program_id,
                'name'               => $validated['name'] ?? $client->name,
                'email'              => $validated['email'] ?? $client->email,
                'postal_code'        => $validated['postal_code'] ?? $client->postal_code,
                'terms_accepted_at'  => $client->terms_accepted_at ?? $now,
            ];

            if ($smsConsent && ! $client->sms_marketing_consent) {
                $updateData['sms_marketing_consent'] = true;
                $updateData['sms_marketing_consent_at'] = $now;
                $updateData['sms_marketing_withdrawn_at'] = null;
            }

            if ($emailConsent && ! $client->email_marketing_consent) {
                $updateData['email_marketing_consent'] = true;
                $updateData['email_marketing_consent_at'] = $now;
                $updateData['email_marketing_withdrawn_at'] = null;
            }

            $client->update($updateData);
        }

        $existingCard = LoyaltyCard::where('client_id', $client->id)
            ->where('firm_id', $firm->id)
            ->first();

        if (! $existingCard) {
            $card = LoyaltyCard::create([
                'client_id'            => $client->id,
                'firm_id'              => $firm->id,
                'program_id'           => $firm->program_id,
                'stamps'               => $firm->start_stamps ?? 0,
                'marketing_consent'    => $smsConsent || $emailConsent,
                'marketing_consent_at' => ($smsConsent || $emailConsent) ? $now : null,
            ]);
        } else {
            $card = $existingCard;
        }

        DB::table('client_consents_logs')->insert([
            [
                'client_id'     => $client->id,
                'phone'         => $client->phone,
                'firm_id'       => $firm->id,
                'consent_type'  => 'sms_marketing',
                'value'         => $smsConsent ? 1 : 0,
                'ip_address'    => $request->ip(),
                'user_agent'    => substr((string) $request->userAgent(), 0, 500),
                'source'        => 'client_register',
                'consent_text'  => 'Zgoda na otrzymywanie informacji marketingowych drogą SMS.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'client_id'     => $client->id,
                'phone'         => $client->phone,
                'firm_id'       => $firm->id,
                'consent_type'  => 'email_marketing',
                'value'         => $emailConsent ? 1 : 0,
                'ip_address'    => $request->ip(),
                'user_agent'    => substr((string) $request->userAgent(), 0, 500),
                'source'        => 'client_register',
                'consent_text'  => 'Zgoda na otrzymywanie informacji marketingowych drogą e-mail.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'client_id'     => $client->id,
                'phone'         => $client->phone,
                'firm_id'       => $firm->id,
                'consent_type'  => 'terms_acceptance',
                'value'         => 1,
                'ip_address'    => $request->ip(),
                'user_agent'    => substr((string) $request->userAgent(), 0, 500),
                'source'        => 'client_register',
                'consent_text'  => 'Akceptacja regulaminu i polityki prywatności.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ]);

        auth('client')->login($client);

        session()->flash('first_time_wallet', true);

        return redirect()->route('client.dashboard');
    }

    public function loyaltyCard()
    {
        $client = auth('client')->user();

        $firm = Firm::findOrFail($client->firm_id);

        $card = LoyaltyCard::where('client_id', $client->id)
            ->where('firm_id', $firm->id)
            ->firstOrFail();

        $template = $firm->card_template ?? 'classic';

        return view('client.cards.' . $template, [
            'client' => $client,
            'firm'   => $firm,
            'card'   => $card,
        ]);
    }
}
