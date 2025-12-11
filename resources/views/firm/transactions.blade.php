@extends('firm.layout.app')

@section('content')
<div class="card" style="text-align:left; max-width:1000px; margin:0 auto;">
    <h1 style="font-size: 26px; margin-bottom: 10px;">
        📘 Historia transakcji klientów
    </h1>
    <p style="color:#555; margin-bottom: 25px;">
        Poniżej znajdziesz wszystkie transakcje punktowe wykonane w Twoim programie lojalnościowym.
    </p>

    {{-- FILTR PO NUMERZE TELEFONU --}}
    <form method="GET" action="{{ route('company.transactions') }}" style="margin-bottom: 20px; display:flex; gap:10px; align-items:flex-end; flex-wrap:wrap;">
        <div style="flex:1 1 220px;">
            <label style="display:block; font-size:14px; font-weight:500; margin-bottom:6px;">
                Filtruj po numerze telefonu klienta
            </label>
            <input
                type="text"
                name="phone"
                value="{{ $filterPhone }}"
                placeholder="np. 500600700"
                style="width:100%; padding:9px 11px; border-radius:10px; border:1px solid #d0d4ff; font-size:14px;"
            >
        </div>

        <button type="submit" style="
            padding:9px 18px;
            border-radius:999px;
            border:none;
            background:linear-gradient(135deg,#4a3aff,#9b59ff);
            color:#fff;
            font-size:14px;
            font-weight:600;
            cursor:pointer;
            box-shadow:0 4px 14px rgba(74,58,255,0.35);
        ">
            🔎 Szukaj
        </button>

        @if($filterPhone)
            <a href="{{ route('company.transactions') }}" style="font-size:13px; color:#666; text-decoration:none; margin-left:4px;">
                ✖ Wyczyść filtr
            </a>
        @endif
    </form>

    {{-- PODSUMOWANIE KLIENTA --}}
    @if($filterPhone && $clientSummary && $clientSummary->total_transactions)
        <div style="
            background:#f0f4ff;
            border-radius:12px;
            padding:10px 14px;
            margin-bottom:18px;
            font-size:14px;
        ">
            <strong>Klient {{ $filterPhone }}</strong> zebrał łącznie
            <strong>{{ $clientSummary->total_points }} pkt</strong>
            w <strong>{{ $clientSummary->total_transactions }}</strong> transakcjach.
        </div>
    @elseif($filterPhone)
        <div style="
            background:#fff4e5;
            border-radius:12px;
            padding:10px 14px;
            margin-bottom:18px;
            font-size:14px;
            color:#b06800;
        ">
            Brak transakcji dla numeru <strong>{{ $filterPhone }}</strong>.
        </div>
    @endif

    {{-- WYKRES AKTYWNOŚCI --}}
    @if($chartData->count())
        <div style="margin-bottom:25px;">
            <h2 style="font-size:18px; margin-bottom:8px;">📈 Aktywność programu (punkty / dzień)</h2>
            <p style="font-size:13px; color:#777; margin-bottom:10px;">
                Suma przyznanych punktów w poszczególnych dniach (ostatnie {{ $chartData->count() }} dni).
            </p>
            <canvas id="transactionsChart" height="120"></canvas>
        </div>
    @endif

    {{-- TABELA TRANSAKCJI --}}
    @if($transactions->count())
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:14px;">
                <thead>
                    <tr style="background:#eef1ff;">
                        <th style="padding:10px 8px; text-align:left;">📅 Data</th>
                        <th style="padding:10px 8px; text-align:left;">📞 Telefon</th>
                        <th style="padding:10px 8px; text-align:left;">💰 Kwota</th>
                        <th style="padding:10px 8px; text-align:left;">⭐ Punkty</th>
                        <th style="padding:10px 8px; text-align:left;">📝 Notatka</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $tx)
                        <tr style="border-bottom:1px solid #f0f0f0;">
                            <td style="padding:8px 8px; white-space:nowrap;">
                                {{ $tx->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td style="padding:8px 8px;">
                                {{ optional($tx->client)->phone ?? '—' }}
                            </td>
                            <td style="padding:8px 8px;">
                                {{ number_format($tx->amount, 2, '.', ' ') }} zł
                            </td>
                            <td style="padding:8px 8px; color:#2f4bff; font-weight:600;">
                                +{{ $tx->points }}
                            </td>
                            <td style="padding:8px 8px;">
                                {{ $tx->note ?: '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINACJA --}}
        <div style="margin-top:15px;">
            {{ $transactions->links() }}
        </div>
    @else
        <div style="
            background:#f7f7ff;
            border-radius:12px;
            padding:20px;
            text-align:center;
            color:#666;
            margin-top:10px;
        ">
            Brak transakcji do wyświetlenia.
        </div>
    @endif
</div>

{{-- WYKRES – Chart.js --}}
@if($chartData->count())
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function () {
            const ctx = document.getElementById('transactionsChart').getContext('2d');

            const labels = @json($chartData->pluck('date'));
            const dataPoints = @json($chartData->pluck('points'));

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Punkty przyznane danego dnia',
                        data: dataPoints,
                        tension: 0.3,
                        fill: false,
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            ticks: { autoSkip: true, maxTicksLimit: 8 }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })();
    </script>
@endif
@endsection
