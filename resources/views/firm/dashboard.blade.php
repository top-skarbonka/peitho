@extends('firm.layout.app')

@section('content')

<style>
    .dashboard-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        text-align: left;
    }

    .page-title {
        font-size: 32px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .page-subtitle {
        color: #555;
        font-size: 15px;
        margin-bottom: 30px;
    }

    .chips-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 30px;
    }

    .chip {
        padding: 10px 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.9);
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        font-size: 14px;
    }

    .chip span.value {
        font-weight: 700;
        color: #2b35d1;
        margin-left: 6px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 18px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 20px 22px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
    }

    .stat-label {
        font-size: 14px;
        color: #777;
        margin-bottom: 6px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 800;
        color: #1e1b4b;
    }

    .stat-sub {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 2px;
    }

    .section-title {
        font-size: 18px;
        margin-bottom: 4px;
        font-weight: 600;
    }

    .section-subtitle {
        font-size: 13px;
        color: #777;
        margin-bottom: 14px;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.2fr) minmax(0, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .chart-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 18px 20px 22px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
    }

    .heatmap-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 18px 20px 22px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
        margin-bottom: 30px;
    }

    .heatmap-grid {
        display: grid;
        grid-template-columns: repeat(12, minmax(0, 1fr));
        gap: 6px;
        margin-top: 10px;
    }

    .heat-cell {
        border-radius: 8px;
        height: 32px;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #111827;
        background: #e5e7eb;
    }

    .heat-label {
        font-size: 12px;
        color: #6b7280;
        margin-top: 8px;
    }

    .top-clients-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 18px 20px 22px;
        box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06);
    }

    .top-clients-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
        margin-top: 10px;
    }

    .top-clients-table th,
    .top-clients-table td {
        padding: 8px 6px;
        border-bottom: 1px solid #f3f4f6;
        text-align: left;
    }

    .top-clients-table th {
        font-weight: 600;
        color: #6b7280;
        font-size: 12px;
    }

    .badge-rank {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        background: #eef2ff;
        color: #4f46e5;
    }

    .badge-rank.gold {
        background: #fef3c7;
        color: #b45309;
    }

    .badge-rank.silver {
        background: #e5e7eb;
        color: #4b5563;
    }

    .badge-rank.bronze {
        background: #ffedd5;
        color: #92400e;
    }

    @media (max-width: 900px) {
        .charts-grid {
            grid-template-columns: minmax(0, 1fr);
        }
    }
</style>

<div class="dashboard-wrapper">

    {{-- NAGŁÓWEK + SZYBKIE METRYKI --}}
    <h1 class="page-title">📊 Statystyki programu lojalnościowego</h1>
    <p class="page-subtitle">
        Podgląd kondycji Twojego programu: aktywność klientów, punkty, najlepsze dni i godziny.
    </p>

    <div class="chips-row">
        <div class="chip">
            Transakcji w tym widoku:
            <span class="value">{{ number_format($totalTransactions, 0, ',', ' ') }}</span>
        </div>
        <div class="chip">
            Klientów w programie:
            <span class="value">{{ number_format($totalClients, 0, ',', ' ') }}</span>
        </div>
        <div class="chip">
            Suma punktów (wszystkie transakcje):
            <span class="value">{{ number_format($totalPoints, 0, ',', ' ') }}</span>
        </div>
        <div class="chip">
            Średnio punktów / transakcję:
            <span class="value">{{ number_format($avgPoints, 2, ',', ' ') }}</span>
        </div>
        <div class="chip">
            Najaktywniejszy dzień:
            <span class="value">{{ $bestDay ?? '–' }}</span>
        </div>
    </div>

    {{-- KAFELKI STATYSTYK --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">👥 Łączna liczba klientów</div>
            <div class="stat-value">{{ number_format($totalClients, 0, ',', ' ') }}</div>
            <div class="stat-sub">Zapisani do Twojego programu lojalnościowego.</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">🧾 Wszystkie transakcje</div>
            <div class="stat-value">{{ number_format($totalTransactions, 0, ',', ' ') }}</div>
            <div class="stat-sub">Ile razy naliczono punkty w programie.</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">⭐ Suma przyznanych punktów</div>
            <div class="stat-value">{{ number_format($totalPoints, 0, ',', ' ') }}</div>
            <div class="stat-sub">Łączna liczba punktów naliczonych klientom.</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">📈 Średnio punktów / transakcję</div>
            <div class="stat-value">{{ number_format($avgPoints, 2, ',', ' ') }}</div>
            <div class="stat-sub">Wskazuje, jak „hojny” jest program.</div>
        </div>
    </div>

    {{-- WYKRESY: DZIENNY + MIESIĘCZNY --}}
    <div class="charts-grid">
        <div class="chart-card">
            <div class="section-title">📆 Aktywność dzienna</div>
            <div class="section-subtitle">
                Suma punktów naliczonych w poszczególnych dniach (ostatnie {{ count($chartLabels) }} dni).
            </div>
            <canvas id="dailyChart" height="120"></canvas>
        </div>

        <div class="chart-card">
            <div class="section-title">📅 Aktywność miesięczna</div>
            <div class="section-subtitle">
                Zbiorcza liczba punktów przyznanych w kolejnych miesiącach.
            </div>
            <canvas id="monthlyChart" height="120"></canvas>
        </div>
    </div>

    {{-- HEATMAPA GODZIN --}}
    <div class="heatmap-card">
        <div class="section-title">⏰ W jakich godzinach klienci zbierają punkty?</div>
        <div class="section-subtitle">
            Im ciemniejszy kolor, tym więcej punktów przyznano w danej godzinie doby.
        </div>

        @php
            $maxHourValue = max($hoursHeatmap ?? [0]);
        @endphp

        <div class="heatmap-grid">
            @foreach($hoursHeatmap as $hour => $value)
                @php
                    $ratio = $maxHourValue > 0 ? $value / $maxHourValue : 0;
                    $alpha = 0.08 + ($ratio * 0.85); // 0.08–0.93
                    $displayHour = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                @endphp
                <div class="heat-cell" style="background: rgba(74,58,255, {{ $alpha }});">
                    {{ $displayHour }}
                </div>
            @endforeach
        </div>

        <div class="heat-label">
            Najwięcej punktów przyznano w godzinie:
            <strong>
                @php
                    $topHour = array_keys($hoursHeatmap, max($hoursHeatmap ?? [0]))[0] ?? null;
                @endphp
                {{ $topHour !== null ? str_pad($topHour, 2, '0', STR_PAD_LEFT) . ':00' : '–' }}
            </strong>
        </div>
    </div>

    {{-- TOP KLIENCI --}}
    <div class="top-clients-card">
        <div class="section-title">🏅 TOP klienci programu</div>
        <div class="section-subtitle">
            Klienci z najwyższą liczbą zebranych punktów (na podstawie aktualnego stanu punktów).
        </div>

        @if($topClients->count())
            <div style="overflow-x:auto;">
                <table class="top-clients-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Telefon</th>
                            <th>Punkty</th>
                            <th>Miasto</th>
                            <th>Data dołączenia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topClients as $i => $client)
                            @php
                                $rankClass = $i === 0 ? 'gold' : ($i === 1 ? 'silver' : ($i === 2 ? 'bronze' : ''));
                            @endphp
                            <tr>
                                <td>
                                    <span class="badge-rank {{ $rankClass }}">{{ $i + 1 }}</span>
                                </td>
                                <td>{{ $client->phone }}</td>
                                <td style="font-weight:600; color:#4f46e5;">
                                    {{ number_format($client->points, 0, ',', ' ') }}
                                </td>
                                <td>{{ $client->city ?? '—' }}</td>
                                <td>
                                    {{ $client->created_at ? $client->created_at->format('Y-m-d') : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="font-size:14px; color:#6b7280; margin-top:10px;">
                Brak klientów z punktami do wyświetlenia.
            </p>
        @endif
    </div>

</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        // DANE Z LARAVELA
        const dailyLabels   = {!! json_encode($chartLabels) !!};
        const dailyValues   = {!! json_encode($chartValues) !!};
        const monthlyLabels = {!! json_encode($monthlyLabels) !!};
        const monthlyValues = {!! json_encode($monthlyValues) !!};

        // WYKRES DZIENNY
        const dailyCtx = document.getElementById('dailyChart').getContext('2d');
        new Chart(dailyCtx, {
            type: 'line',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Punkty w danym dniu',
                    data: dailyValues,
                    borderWidth: 2,
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79,70,229,0.12)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 3,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { ticks: { maxTicksLimit: 8 } },
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // WYKRES MIESIĘCZNY
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Punkty / miesiąc',
                    data: monthlyValues,
                    borderWidth: 2,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.35)',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: { ticks: { maxTicksLimit: 6 } },
                    y: { beginAtZero: true }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    })();
</script>

@endsection
