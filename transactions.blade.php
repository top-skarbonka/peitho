@extends('firm.layout.app')

@section('content')

<style>
    .page-wrapper {
        max-width: 1100px;
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
        padding: 6px 10px;
        border-radius: 999px;
        background: #f4f6ff;
        color: #444;
        border: 1px solid #e0e4ff;
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

    .filter-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .filter-field {
        flex: 1 1 180px;
    }

    .filter-field label {
        display: block;
        margin-bottom: 4px;
        font-size: 13px;
        font-weight: 500;
    }

    .filter-field input {
        width: 100%;
        padding: 9px 11px;
        border-radius: 10px;
        border: 1px solid #d0d4ff;
        font-size: 14px;
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
    }

    .summary-box {
        border-radius: 12px;
        padding: 12px 16px;
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

    .table-wrapper {
        overflow-x: auto;
    }

    table.history-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
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
        cursor: pointer;
        user-select: none;
    }

    .points-badge {
        padding: 4px 8px;
        border-radius: 999px;
        background: #eef2ff;
        font-weight: 600;
        color: #2437ff;
    }

    .note-muted {
        color: #777;
        font-size: 13px;
    }

    .timeline-list {
        list-style:none;
        padding:0;
        margin:0;
    }

    .timeline-item {
        display:grid;
        grid-template-columns:24px 1fr;
        gap:10px;
        padding:8px 0;
    }

    .timeline-dot {
        width:10px;
        height:10px;
        border-radius:999px;
        background:#4a3aff;
        margin-top:6px;
        position:relative;
    }

    .timeline-dot::after {
        content:"";
        position:absolute;
        width:2px;
        height:100%;
        background:#d7dbff;
        left:4px;
        top:10px;
    }

    .timeline-item:last-child .timeline-dot::after {
        display:none;
    }

    .empty-state {
        background:#f7f7ff;
        border-radius:12px;
        padding:20px;
        text-align:center;
        color:#666;
    }
</style>

<div class="page-wrapper">

    {{-- HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-header-title">📘 Historia transakcji klientów</h1>
            <p class="page-header-subtitle">
                Przegląd wszystkich operacji punktowych w Twoim programie lojalnościowym.
            </p>
        </div>

        <div class="chips">
            <div class="chip">Transakcji: <strong>{{ $transactions->total() }}</strong></div>
            <div class="chip">Średnio / transakcję: <strong>{{ round($transactions->avg('points'),1) }}</strong></div>
            <div class="chip">Punkty na tej stronie:
                <strong>{{ number_format($transactions->sum('points'),0,',',' ') }}</strong>
            </div>
        </div>
    </div>

    {{-- FILTRY --}}
    <div class="card-section">
        <div class="card-inner">
            <form method="GET" action="{{ route('company.transactions') }}" class="filter-row">

                <div class="filter-field">
                    <label>Telefon</label>
                    <input type="text" name="phone"
                        value="{{ $filterPhone ?? '' }}"
                        placeholder="np. 500600700">
                </div>

                <div class="filter-field">
                    <label>Data od</label>
                    <input type="date" name="date_from" value="{{ $filterDateFrom ?? '' }}">
                </div>

                <div class="filter-field">
                    <label>Data do</label>
                    <input type="date" name="date_to" value="{{ $filterDateTo ?? '' }}">
                </div>

                <div class="filter-field">
                    <label>Min. punkty</label>
                    <input type="number" name="min_points" value="{{ $filterMinPoints ?? '' }}">
                </div>

                <div class="filter-field">
                    <label>Maks. punkty</label>
                    <input type="number" name="max_points" value="{{ $filterMaxPoints ?? '' }}">
                </div>

                <button class="btn-primary">🔎 Filtruj</button>

                <a href="{{ route('company.transactions') }}" class="btn-link">Wyczyść filtry</a>
            </form>

            {{-- PODSUMOWANIE DLA KONKRETNEGO KLIENTA --}}
            @if($filterPhone && $clientSummary && $clientSummary->total_transactions)
                <div class="summary-box info">
                    Klient <strong>{{ $filterPhone }}</strong> zebrał
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

        {{-- WYKRES --}}
        <div class="card-inner">
            <h3>📈 Aktywność dzienna</h3>
            <canvas id="transactionsChart" height="130"></canvas>
        </div>

        {{-- TIMELINE --}}
        <div class="card-inner">
            <h3>⏱ Ostatnie transakcje</h3>

            @if($transactions->count())
                <ul class="timeline-list">
                    @foreach($transactions->take(6) as $tx)
                        <li class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div>
                                <strong>{{ $tx->client->phone ?? 'Klient' }}</strong> —
                                <span class="points-badge">+{{ $tx->points }} pkt</span>
                                <div class="note-muted">
                                    {{ $tx->created_at->format('Y-m-d H:i') }}
                                    @if($tx->amount) • {{ number_format($tx->amount,2,'.',' ') }} zł @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="note-muted">Brak danych.</p>
            @endif
        </div>
    </div>

    {{-- TABELA --}}
    <div class="card-section">
        <div class="card-inner">
            @if($transactions->count())
                <div class="table-wrapper">
                    <table class="history-table" id="transactionsTable">
                        <thead>
                            <tr>
                                <th data-sort="date">📅 Data</th>
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
                                    <td>{{ $tx->client->phone ?? '—' }}</td>
                                    <td data-amount="{{ $tx->amount }}">
                                        {{ number_format($tx->amount,2,'.',' ') }} zł
                                    </td>
                                    <td data-points="{{ $tx->points }}">
                                        <span class="points-badge">+{{ $tx->points }}</span>
                                    </td>
                                    <td>
                                        {{ $tx->note ?: '—' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $transactions->links() }}

            @else
                <div class="empty-state">Brak transakcji.</div>
            @endif
        </div>
    </div>
</div>

{{-- SCRIPTY – WYKRES + SORTOWANIE --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // WYKRES
    new Chart(document.getElementById("transactionsChart").getContext("2d"), {
        type: "line",
        data: {
            labels: @json($chartData->pluck('date')),
            datasets: [{
                label: "Punkty / dzień",
                data: @json($chartData->pluck('points')),
                borderWidth: 2,
                tension: 0.3
            }]
        }
    });

    // SORTOWANIE
    const table = document.getElementById('transactionsTable');
    if (table) {
        const getValue = (tr, idx) => {
            const td = tr.children[idx];
            return td.dataset.date || td.dataset.amount || td.dataset.points || td.innerText;
        };

        table.querySelectorAll('th[data-sort]').forEach((th, idx) => {
            th.addEventListener('click', () => {
                const rows = Array.from(table.tBodies[0].querySelectorAll('tr'));
                const asc = th.classList.toggle('asc');

                rows.sort((a, b) => {
                    const v1 = getValue(asc ? a : b, idx);
                    const v2 = getValue(asc ? b : a, idx);
                    return v1 > v2 ? 1 : v1 < v2 ? -1 : 0;
                });

                rows.forEach(r => table.tBodies[0].appendChild(r));
            });
        });
    }
</script>

@endsection
