<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;

class SmsApiSender
{
    /**
     * Wysyłka SMS przez SMSAPI (smsapi.pl) - REST
     * Zwraca zawsze spójny array do logowania i decyzji w kontrolerze.
     */
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

        $token = (string) config('smsapi.token');
        $from  = (string) config('smsapi.from');

        if ($token === '') {
            return [
                'ok' => false,
                'status' => 'config_error',
                'provider_message_id' => null,
                'error' => 'Missing SMSAPI_TOKEN',
            ];
        }

        try {
            // SMSAPI: /sms.do obsługuje form-data/x-www-form-urlencoded
            // Token OAuth: Bearer <token>
            $response = Http::timeout(10)
                ->withToken($token)
                ->asForm()
                ->post('https://api.smsapi.pl/sms.do', [
                    'to' => $phone,
                    'message' => $message,
                    // 'from' tylko jeśli ustawione — w trial czasem ograniczone
                    'from' => $from !== '' ? $from : null,
                    // format odpowiedzi: JSON jest najwygodniejszy
                    'format' => 'json',
                ]);

            $body = $response->json();

            if (!$response->successful()) {
                // SMSAPI przy błędach często zwraca: {"error":"...","message":"..."} albo coś podobnego
                $err = null;

                if (is_array($body)) {
                    $err = $body['message'] ?? $body['error'] ?? null;
                }

                $err = $err ?: ('HTTP '.$response->status());

                return [
                    'ok' => false,
                    'status' => 'failed',
                    'provider_message_id' => null,
                    'error' => $err,
                ];
            }

            // Typowe odpowiedzi SMSAPI (format=json) mają listę wysyłek.
            // Przykładowo: { "count":1, "list":[{"id":"...","points":"...","number":"...","status":"QUEUE"}] }
            $providerId = null;

            if (is_array($body)) {
                if (isset($body['list'][0]['id'])) {
                    $providerId = (string) $body['list'][0]['id'];
                } elseif (isset($body['id'])) {
                    $providerId = (string) $body['id'];
                }
            }

            return [
                'ok' => true,
                'status' => 'sent',
                'provider_message_id' => $providerId,
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
