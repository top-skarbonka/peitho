<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;

class SmsApiSender
{
    public function send(string $phone, string $message): array
    {
        if (!config('smsapi.enabled')) {
            return [
                'ok' => false,
                'status' => 'disabled',
                'provider_message_id' => null,
                'error' => 'SMS disabled',
            ];
        }

        $token = config('smsapi.token');

        if (!$token) {
            return [
                'ok' => false,
                'status' => 'config_error',
                'provider_message_id' => null,
                'error' => 'Missing SMSAPI_TOKEN',
            ];
        }

        // Normalizacja numeru
        $phone = preg_replace('/\D+/', '', $phone);

        if (strlen($phone) === 9) {
            $phone = '48' . $phone;
        }

        try {

            $response = Http::timeout(15)
                ->withToken($token)
                ->asForm()
                ->post('https://api.smsapi.pl/sms.do', [
                    'to'      => $phone,
                    'message' => $message,
'from'    => config('smsapi.sender'),
                    'format'  => 'json',
                ]);

            $body = $response->json();

            if (!$response->successful()) {
                return [
                    'ok' => false,
                    'status' => 'failed',
                    'provider_message_id' => null,
                    'error' => $body['message'] ?? $body['error'] ?? 'HTTP ' . $response->status(),
                ];
            }

            return [
                'ok' => true,
                'status' => 'sent',
                'provider_message_id' => $body['list'][0]['id'] ?? null,
                'error' => null,
            ];

        } catch (\Throwable $e) {
            return [
                'ok' => false,
                'status' => 'failed',
                'provider_message_id' => null,
                'error' => $e->getMessage(),
            ];
        }
    }
}
