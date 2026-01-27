<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Firm;
use App\Models\SecurityLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ConsentExportController extends Controller
{
    /**
     * Eksport zgód marketingowych (RODO / UODO) – CSV
     * Filtrowane po ID firmy
     */
    public function exportCsv(Request $request)
    {
        // ✅ WALIDACJA
        $request->validate([
            'firm_id' => 'required|exists:firms,id',
        ]);

        $firm = Firm::findOrFail($request->firm_id);

        // ✅ LOG BEZPIECZEŃSTWA (AUDYT UODO)
        SecurityLog::create([
            'actor_type' => 'admin',
            'actor_id'   => Auth::id(),
            'action'     => 'export_consents',
            'target'     => 'firm_id=' . $firm->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // ✅ NAZWA PLIKU
        $filename = 'zgody_marketingowe_firma_' . $firm->id . '_' . now()->format('Y-m-d_H-i') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        // ✅ STREAM CSV (BEZ OBCIĄŻANIA PAMIĘCI)
        $callback = function () use ($firm) {
            $output = fopen('php://output', 'w');

            // BOM – Excel / UODO
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Nagłówki CSV
            fputcsv($output, [
                'ID klienta',
                'Telefon',
                'Kod pocztowy',
                'ID firmy',
                'Nazwa firmy',
                'Zgoda SMS',
                'Data wyrażenia zgody SMS',
                'Data cofnięcia zgody SMS',
                'Regulamin zaakceptowany',
                'Data akceptacji regulaminu',
                'Data utworzenia konta',
            ], ';');

            Client::where('firm_id', $firm->id)
                ->orderBy('id')
                ->chunk(500, function ($clients) use ($output, $firm) {
                    foreach ($clients as $client) {
                        fputcsv($output, [
                            $client->id,
                            $client->phone,
                            $client->postal_code,
                            $firm->id,
                            $firm->name,
                            $client->sms_marketing_consent ? 'TAK' : 'NIE',
                            optional($client->sms_marketing_consent_at)?->format('Y-m-d H:i:s'),
                            optional($client->sms_marketing_withdrawn_at)?->format('Y-m-d H:i:s'),
                            $client->terms_accepted_at ? 'TAK' : 'NIE',
                            optional($client->terms_accepted_at)?->format('Y-m-d H:i:s'),
                            $client->created_at->format('Y-m-d H:i:s'),
                        ], ';');
                    }
                });

            fclose($output);
        };

        return response()->stream($callback, Response::HTTP_OK, $headers);
    }
}
