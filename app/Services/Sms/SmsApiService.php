<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class SmsApiService
{
    public function send(string $phone, string $message, int $firmId, ?int $clientId = null): array
    {
        if (!config('sms.enabled')) {
            return [
                'success' => false,
                'error' => 'SMS disabled in config.'
            ];
        }

        $token  = config('sms.smsapi.token');
        $sender = config('sms.smsapi.sender');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type'  => 'application/json'
            ])->post('https://api.smsapi.pl/sms.do', [
                'to'      => $phone,
                'message' => $message,
                'from'    => $sender,
                'format'  => 'json'
            ]);

            $body = $response->json();

            if ($response->successful()) {

                $providerMessageId = $body['list'][0]['id'] ?? null;

                DB::table('sms_logs')->insert([
                    'firm_id'            => $firmId,
                    'client_id'          => $clientId,
                    'phone'              => $phone,
                    'purpose'            => 'otp_pass_entry',
                    'provider'           => 'smsapi',
                    'provider_message_id'=> $providerMessageId,
                    'status'             => 'sent',
                    'cost_gross_cents'   => null,
                    'error_code'         => null,
                    'error_message'      => null,
                    'created_at'         => now(),
                    'updated_at'         => now(),
                ]);

                return [
                    'success' => true,
                    'provider_message_id' => $providerMessageId
                ];
            }

            DB::table('sms_logs')->insert([
                'firm_id'            => $firmId,
                'client_id'          => $clientId,
                'phone'              => $phone,
                'purpose'            => 'otp_pass_entry',
                'provider'           => 'smsapi',
                'provider_message_id'=> null,
                'status'             => 'failed',
                'cost_gross_cents'   => null,
                'error_code'         => $response->status(),
                'error_message'      => json_encode($body),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            return [
                'success' => false,
                'error'   => 'SMS API error'
            ];

        } catch (\Exception $e) {

            DB::table('sms_logs')->insert([
                'firm_id'            => $firmId,
                'client_id'          => $clientId,
                'phone'              => $phone,
                'purpose'            => 'otp_pass_entry',
                'provider'           => 'smsapi',
                'provider_message_id'=> null,
                'status'             => 'error',
                'cost_gross_cents'   => null,
                'error_code'         => null,
                'error_message'      => $e->getMessage(),
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            return [
                'success' => false,
                'error'   => $e->getMessage()
            ];
        }
    }
}
