<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Firm;
use App\Models\SecurityLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsentExportController extends Controller
{
    /**
     * Eksport zgód marketingowych (RODO / UODO) – CSV
     */
    public function exportCsv(Request $request)
    {
        $request->validate([
            'firm_id' => 'required|exists:firms,id',
        ]);

        $firm = Firm::findOrFail($request->firm_id);

        SecurityLog::create([
            'actor_type' => 'admin',
            'actor_id'   => Auth::id(),
            'action'     => 'export_consents',
            'target'     => 'firm_id=' . $firm->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $filename = 'zgody_marketingowe_firma_' . $firm->id . '_' . now()->format('Y-m-d_H-i') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($firm) {

            $output = fopen('php://output', 'w');

            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($output, [
                'ID karty',
                'ID klienta',
                'Telefon',
                'ID firmy',
                'Nazwa firmy',
                'Zgoda SMS (aktualna)',
                'Data wyrażenia zgody',
                'Data cofnięcia zgody',
                'Źródło zgody',
                'IP ostatniej operacji',
                'User Agent',
                'Data utworzenia karty',
            ], ';');

            DB::table('loyalty_cards')
                ->where('firm_id', $firm->id)
                ->orderBy('id')
                ->chunk(500, function ($cards) use ($output, $firm) {

                    foreach ($cards as $card) {

                        $lastLog = DB::table('consent_logs')
                            ->where('loyalty_card_id', $card->id)
                            ->latest('id')
                            ->first();

                        fputcsv($output, [
                            $card->id,
                            $card->client_id,
                            $card->phone ?? '',
                            $firm->id,
                            $firm->name,
                            $card->marketing_consent ? 'TAK' : 'NIE',
                            optional($card->marketing_consent_at)?->format('Y-m-d H:i:s'),
                            optional($card->marketing_consent_revoked_at)?->format('Y-m-d H:i:s'),
                            $lastLog->source ?? '',
                            $lastLog->ip_address ?? '',
                            $lastLog->user_agent ?? '',
                            optional($card->created_at)?->format('Y-m-d H:i:s'),
                        ], ';');
                    }
                });

            fclose($output);
        };

        return response()->stream($callback, Response::HTTP_OK, $headers);
    }

    /**
     * 🔥 NOWE — EXPORT PEŁNYCH DANYCH KLIENTA (RODO)
     */
    public function exportClientData(Request $request)
    {
        $request->validate([
            'phone' => 'required',
        ]);

        $phone = preg_replace('/\D+/', '', $request->phone);

        $client = DB::table('clients')->where('phone', $phone)->first();

        if (!$client) {
            return response()->json(['error' => 'Klient nie istnieje'], 404);
        }

        // 🔐 LOG ADMINA
        SecurityLog::create([
            'actor_type' => 'admin',
            'actor_id'   => Auth::id(),
            'action'     => 'export_client_full_data',
            'target'     => 'client_id=' . $client->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $points = DB::table('client_points')
            ->where('client_id', $client->id)
            ->get();

        $transactions = DB::table('client_point_logs')
            ->where('client_id', $client->id)
            ->orderByDesc('created_at')
            ->get();

        $consents = DB::table('client_consents_logs')
            ->where('client_id', $client->id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'client'       => $client,
            'points'       => $points,
            'transactions' => $transactions,
            'consents'     => $consents,
        ]);
    }
}
