@extends('firm.layout.app')

@section('content')

<style>
    .page-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        text-align: left;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 24px;
    }

    .page-header-title {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .page-header-subtitle {
        color: #555;
        font-size: 14px;
    }

    .chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 12px;
    }

    .chip {
        padding: 6px 12px;
        border-radius: 999px;
        background: #f4f6ff;
        color: #444;
        border: 1px solid #e0e4ff;
    }

    .chip strong {
        font-weight: 600;
        color: #222;
    }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 16px;
        margin-bottom: 26px;
    }

    .stat-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
        padding: 16px 18px;
    }

    .stat-card-title {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #718096;
        margin-bottom: 6px;
    }

    .stat-card-value {
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 4px;
    }

    .stat-card-desc {
        font-size: 12px;
        color: #6b7280;
    }

    .card-section {
        margin-bottom: 26px;
    }

    .card-inner {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
        padding: 18px 20px;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(0, 1.4fr) minmax(0, 1.4fr) minmax(0, 1.4fr) auto;
        gap: 12px;
        align-items: flex-end;
    }

    @media (max-width: 960px) {
        .filters-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 640px) {
        .filters-grid {
            grid-template-columns: 1fr;
        }
    }

    .filter-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 6px;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        padding: 9px 11px;
        border-radius: 10px;
        border: 1px solid #d0d4ff;
        font-size: 14px;
        outline: none;
        transition: 0.15s border, 0.15s box-shadow, 0.15s background;
        background: #f9fafb;
    }

    .filter-input:focus,
    .filter-select:focus {
        border-color: #4a3aff;
        box-shadow: 0 0 0 2px rgba(74,58,255,0.18);
        background: #ffffff;
    }

    .btn-primary {
        padding: 10px 20px;
        border-radius: 999px;
        border: none;
        background: linear-gradient(135deg,#4a3aff,#9b59ff);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(74,58,255,0.35);
        white-space: nowrap;
    }

    .btn-link {
        font-size: 13px;
        color: #666;
        text-decoration: none;
        white-space: nowrap;
        margin-left: 8px;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    .summary-box {
        border-radius: 12px;
        padding: 10px 14px;
        margin-top: 14px;
        font-size: 14px;
    }

    .summary-box.info {
        background: #f0f4ff;
    }

    .summary-box.warning {
        background: #fff4e5;
        color: #b06800;
    }

    .summary-box strong {
        font-weight: 600;
    }

    .two-columns {
        display: grid;
        grid-template-columns: minmax(0, 1.7fr) minmax(0, 1.3fr);
        gap: 18px;
        margin-bottom: 26px;
    }

    @media (max-width: 960px) {
        .two-columns {
            grid-template-columns: 1fr;
        }
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table.history-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    table.history-table thead tr {
        background: #eef1ff;
    }

    table.history-table th,
    table.history-table td {
        padding: 10px 8px;
        text-align: left;
    }

    table.history-table th {
        font-weight: 600;
        font-size: 13px;
        color: #444;
        user-select: none;
        cursor: pointer;
    }

    table.history-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: 0.12s background, 0.12s transform;
    }

    table.history-table tbody tr:hover {
        background: #f7f7ff;
        transform: translateY(-1px);
    }

    .amount-cell {
        white-space: nowrap;
    }

    .points-badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 999px;
        background: #eef2ff;
        color: #2437ff;
        font-weight: 600;
        font-size: 13px;
    }

    .note-muted {
        color: #888;
        font-size: 13px;
    }

    .timeline-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .timeline-item {
        display: grid;
        grid-template-columns: 24px 1fr;
        gap: 8px;
        padding: 8px 0;
        position: relative;
    }

    .timeline-dot {
        width: 10px;
        height: 10px;
        border-radius: 999px;
        background: #4a3aff;
        margin-top: 4px;
        position: relative;
    }

    .timeline-dot::after {
        content: "";
        position: absolute;
        left: 4px;
        top: 12px;
        width: 2px;
        height: calc(100% - 12px);
        background: #e0e4ff;
    }

    .timeline-item:last-child .timeline-dot::after {
        display: none;
    }

    .timeline-main {
        font-size: 13px;
        font-weight: 500;
    }

    .timeline-meta {
        font-size: 12px;
        color: #777;
    }

    .badge-type {
        display: inline-block;
        border-radius: 999px;
        padding: 2px 7px;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        background: #f5f7ff;
        color: #3b4bff;
        margin-left: 6px;
    }

    .empty-state {
        background:#f7f7ff;
        border-radius:12px;
        padding:20px;
        text-align:center;
        color:#666;
        margin-top:10px;
        font-size:14px;
    }
</style>

<div class="page-wrapper">

    {{-- HEADER + CHIPY --}}
    <div class="page-header">
        <div>
            <h1 class="page-header-title">
                📘 Historia transakcji klientów
            </h1>
            <p class="page-header-subtitle">
                Podgląd wszystkich przyznanych punktów w Twoim programie lojalnościowym.
            </p>
        </div>

        <div class="chips">
            <div class="chip">
                Transakcji w tym widoku:
                <strong>{{ $transactions->total() }}</strong>
            </div>
            <div class="chip">
                Średnio punktów / transakcję (strona):
                <strong>
                    @php
                        $avgVisible = $transactions->count()
                            ? round($transactions->avg('points'), 1)
                            : 0;
                    @endphp
                    {{ $avgVisible }}
                </strong>
            </div>
            <div class="chip">
                Punkty (ta strona):
                <strong>{{ number_format($transactions->sum('points'), 0, ',', ' ') }}</strong>
            </div>
        </div>
    </div>

    {{-- KAFELKI STATYSTYK GLOBALNYCH --}}
    <div class="card-grid">
        <div class="stat-card">
            <div class="stat-card-title">👥 Łączna liczba klientów</div>
            <div class="stat-card-value">{{ $totalClients }}</div>
            <div class="stat-card-desc">
                Zapisani do Twojego programu lojalnościowego.
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-title">🧾 Wszystkie transakcje</div>
            <div class="stat-card-value">{{ $totalTransactions }}</div>
            <div class="stat-card-desc">
                Ile razy naliczono punkty w programie.
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-title">⭐ Suma przyznanych punktów</div>
            <div class="stat-card-value">
                {{ number_format($totalPoints, 0, ',', ' ') }}
            </div>
            <div class="stat-card-desc">
                Łączna liczba punktów naliczonych klientom.
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-card-title">📅 Najaktywniejszy dzień</div>
            <div class="stat-card-value">
                {{ $bestDay ? \Carbon\Carbon::parse($bestDay)->format('Y-m-d') : '—' }}
            </div>
            <div class="stat-card-desc">
                Data z największą liczbą transakcji.
            </div>
        </div>
    </div>

    {{-- FILTRY + PODSUMOWANIE --}}
    <div class="card-section">
        <div class="card-inner">

            <form method="GET"
                  action="{{ route('company.transactions') }}"
                  class="filters-grid">

                {{-- Telefon --}}
                <div>
                    <label class="filter-label">Telefon klienta</label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ $filterPhone }}"
                        class="filter-input"
                        placeholder="np. 500600700">
                </div>

                {{-- Data od --}}
                <div>
                    <label class="filter-label">Data od</label>
                    <input
                        type="date"
                        name="date_from"
                        value="{{ $filterDateFrom }}"
                        class="filter-input">
                </div>

                {{-- Data do --}}
                <div>
                    <label class="filter-label">Data do</label>
                    <input
                        type="date"
                        name="date_to"
                        value="{{ $filterDateTo }}"
                        class="filter-input">
                </div>

                {{-- Typ transakcji --}}
                <div>
                    <label class="filter-label">Rodzaj transakcji</label>
                    <select name="type" class="filter-select">
                        <option value="">Wszystkie</option>
                        <option value="purchase" {{ $filterType === 'purchase' ? 'selected' : '' }}>
                            Zakup (purchase)
                        </option>
                        <option value="manual" {{ $filterType === 'manual' ? 'selected' : '' }}>
                            Ręczne naliczenie (manual)
                        </option>
                        <option value="correction" {{ $filterType === 'correction' ? 'selected' : '' }}>
                            Korekta (correction)
                        </option>
                    </select>
                </div>

                {{-- Przycisk --}}
                <div style="display:flex; align-items:flex-end; gap:8px;">
                    <button type="submit" class="btn-primary">
                        🔍 Szukaj
                    </button>

                    @if($filterPhone || $filterDateFrom || $filterDateTo || $filterType)
                        <a href="{{ route('company.transactions') }}" class="btn-link">
                            ✖ Wyczyść filtry
                        </a>
                    @endif
                </div>
            </form>

            {{-- PODSUMOWANIE DLA KONKRETNEGO KLIENTA --}}
            @if($filterPhone && $clientSummary && $clientSummary->total_transactions)
                <div class="summary-box info">
                    <strong>Klient {{ $filterPhone }}</strong> zebrał łącznie
                    <strong>{{ $clientSummary->total_points }} pkt</strong>
                    w <strong>{{ $clientSummary->total_transactions }}</strong> transakcjach.
                </div>
            @elseif($filterPhone)
                <div class="summary-box warning">
                    Brak transakcji dla numeru <strong>{{ $filterPhone }}</strong>.
                </div>
            @endif
        </div>
    </div>

    {{-- WYKRES + TIMELINE --}}
    <div class="two-columns">

        {{-- LEWA: WYKRES --}}
        <div class="card-inner">
            @if($chartData->count())
                <h2 style="font-size:18px; margin-bottom:6px;">
                    📈 Aktywność dzienna (punkty / dzień)
                </h2>
                <p style="font-size:13px; color:#777; margin-bottom:10px;">
                    Suma przyznanych punktów w poszczególnych dniach.
                </p>
                <canvas id="transactionsChart" height="130"></canvas>
            @else
                <p style="font-size:13px; color:#777;">
                    Brak danych do wykresu.
                </p>
            @endif
        </div>

        {{-- PRAWA: TIMELINE --}}
        <div class="card-inner">
            <h2 style="font-size:18px; margin-bottom:6px;">
                ⏱ Ostatnie transakcje (timeline)
            </h2>
            <p style="font-size:13px; color:#777; margin-bottom:10px;">
                Szybki podgląd ostatnich operacji w programie.
            </p>

            @if($transactions->count())
                <ul class="timeline-list">
                    @foreach($transactions->take(6) as $tx)
                        <li class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div>
                                <div class="timeline-main">
                                    {{ optional($tx->client)->phone ?? 'Klient' }} —
                                    <span class="points-badge">
                                        +{{ $tx->points }} pkt
                                    </span>
                                    <span class="badge-type">
                                        {{ strtoupper($tx->type ?? 'purchase') }}
                                    </span>
                                </div>
                                <div class="timeline-meta">
                                    {{ $tx->created_at->format('Y-m-d H:i') }}
                                    @if($tx->amount)
                                        • {{ number_format($tx->amount, 2, '.', ' ') }} zł
                                    @endif
                                    @if($tx->note)
                                        • {{ $tx->note }}
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="note-muted">Brak transakcji do wyświetlenia.</p>
            @endif
        </div>
    </div>

    {{-- TABELA TRANSAKCJI --}}
    <div class="card-section">
        <div class="card-inner">
            @if($transactions->count())
                <div class="table-wrapper">
                    <table class="history-table" id="transactionsTable">
                        <thead>
                        <tr>
                            <th data-sort="date">📅 Data ▾</th>
                            <th data-sort="phone">📞 Telefon</th>
                            <th data-sort="amount">💰 Kwota</th>
                            <th data-sort="points">⭐ Punkty</th>
                            <th>📝 Notatka</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($transactions as $tx)
                            <tr>
                                <td data-date="{{ $tx->created_at->timestamp }}">
                                    {{ $tx->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td>
                                    {{ optional($tx->client)->phone ?? '—' }}
                                </td>
                                <td class="amount-cell" data-amount="{{ $tx->amount }}">
                                    {{ number_format($tx->amount, 2, '.', ' ') }} zł
                                </td>
                                <td data-points="{{ $tx->points }}">
                                    <span class="points-badge">+{{ $tx->points }}</span>
                                </td>
                                <td>
                                    @if($tx->note)
                                        {{ $tx->note }}
                                    @else
                                        <span class="note-muted">—</span>
                                    @endif
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
                <div class="empty-state">
                    Brak transakcji do wyświetlenia.
                </div>
            @endif
        </div>
    </div>
</div>

{{-- SCRIPTY --}}
@if($chartData->count())
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function () {
            // WYKRES
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
                        fill: true,
                        borderWidth: 2,
                        borderColor: '#4a3aff',
                        backgroundColor: 'rgba(74,58,255,0.12)'
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

            // PROSTE SORTOWANIE TABELI (tylko na tej stronie)
            const table = document.getElementById('transactionsTable');
            if (!table) return;

            const getCellValue = (tr, idx) => {
                const td = tr.children[idx];
                if (!td) return '';
                if (td.dataset.date) return Number(td.dataset.date);
                if (td.dataset.amount) return Number(td.dataset.amount);
                if (td.dataset.points) return Number(td.dataset.points);
                return td.innerText || td.textContent;
            };

            const comparer = (idx, asc) => (a, b) => {
                const v1 = getCellValue(asc ? a : b, idx);
                const v2 = getCellValue(asc ? b : a, idx);
                return v1 > v2 ? 1 : v1 < v2 ? -1 : 0;
            };

            table.querySelectorAll('th[data-sort]').forEach((th, idx) => {
                let asc = false;
                th.addEventListener('click', () => {
                    asc = !asc;
                    const tbody = table.tBodies[0];
                    Array.from(tbody.querySelectorAll('tr'))
                        .sort(comparer(idx, asc))
                        .forEach(tr => tbody.appendChild(tr));
                });
            });
        })();
    </script>
@endif

@endsection
