@extends('firm.layout.app')

@section('content')
<div style="max-width: 1100px; margin: 0 auto; padding: 24px;">
    <div style="display:flex; justify-content:space-between; align-items:center; gap:16px;">
        <div>
            <h1 style="margin:0; font-size: 26px;">⭐ Karty lojalnościowe</h1>
            <p style="margin:6px 0 0; color:#666;">
                Karta stałego klienta (wizyty / naklejki). Punkty Peitho działają osobno.
            </p>
        </div>

        <button disabled
            style="padding:10px 14px; border-radius:10px; border:1px solid #ddd; background:#f2f2f2; color:#777; cursor:not-allowed;">
            Dodaj naklejkę (ETAP 2)
        </button>
    </div>

    <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 18px;">
        <div style="border:1px solid #eee; border-radius:14px; padding:14px; background:#fff;">
            <div style="color:#777; font-size:13px;">Karty</div>
            <div style="font-size:28px; font-weight:700;">{{ $stats['cards'] ?? 0 }}</div>
        </div>
        <div style="border:1px solid #eee; border-radius:14px; padding:14px; background:#fff;">
            <div style="color:#777; font-size:13px;">Naklejki łącznie</div>
            <div style="font-size:28px; font-weight:700;">{{ $stats['stamps'] ?? 0 }}</div>
        </div>
        <div style="border:1px solid #eee; border-radius:14px; padding:14px; background:#fff;">
            <div style="color:#777; font-size:13px;">Pełne karty</div>
            <div style="font-size:28px; font-weight:700;">{{ $stats['full'] ?? 0 }}</div>
        </div>
        <div style="border:1px solid #eee; border-radius:14px; padding:14px; background:#fff;">
            <div style="color:#777; font-size:13px;">Aktywne (30 dni)</div>
            <div style="font-size:28px; font-weight:700;">{{ $stats['active_30'] ?? 0 }}</div>
        </div>
    </div>

    <div style="margin-top:18px; border:1px solid #eee; border-radius:14px; background:#fff; overflow:hidden;">
        <div style="padding:14px; border-bottom:1px solid #eee; font-weight:700;">
            Lista kart
        </div>

        <div style="overflow:auto;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#fafafa; text-align:left;">
                        <th style="padding:12px; border-bottom:1px solid #eee;">Klient</th>
                        <th style="padding:12px; border-bottom:1px solid #eee;">Postęp</th>
                        <th style="padding:12px; border-bottom:1px solid #eee;">Status</th>
                        <th style="padding:12px; border-bottom:1px solid #eee;">Utworzono</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cards as $card)
                        <tr>
                            <td style="padding:12px; border-bottom:1px solid #f1f1f1;">
                                {{ $card->client->phone ?? ('ID klienta: '.$card->client_id) }}
                            </td>
                            <td style="padding:12px; border-bottom:1px solid #f1f1f1;">
                                {{ $card->current_stamps }} / {{ $card->max_stamps }}
                            </td>
                            <td style="padding:12px; border-bottom:1px solid #f1f1f1;">
                                {{ $card->status ?? 'active' }}
                            </td>
                            <td style="padding:12px; border-bottom:1px solid #f1f1f1; color:#666;">
                                {{ $card->created_at }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding:14px; color:#666;">
                                Brak kart lojalnościowych w tym programie.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div style="margin-top:12px; color:#777; font-size:12px;">
        ETAP 2: podpinamy przycisk „Dodaj naklejkę” + QR / wyszukiwanie po telefonie.
    </div>
</div>
@endsection
