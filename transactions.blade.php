@extends('firm.layout.app')

@section('content')

<style>
.page-wrapper {
    max-width: 1200px;
    margin: 0 auto;
}

.chart-card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 26px rgba(15, 23, 42, 0.06);
    padding: 18px 20px;
    margin-bottom: 26px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 6px;
}
</style>

<div class="page-wrapper">

    {{-- HEADER --}}
    <h1 style="font-size:26px;font-weight:700;margin-bottom:6px;">
        📘 Historia transakcji klientów
    </h1>
    <p style="color:#555;font-size:14px;margin-bottom:20px;">
        Podgląd wszystkich przyznanych punktów w programie.
    </p>

    {{-- FILTRY --}}
    <form method="GET" action="{{ route('company.transactions') }}"
          style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto;gap:12px;margin-bottom:24px;align-items:end;">

        <div>
            <label class="filter-label">Telefon</label>
            <input type="text" name="phone" value="{{ $filterPhone }}" class="filter-input">
        </div>

        <div>
            <label class="filter-label">Data od</label>
            <input type="date" name="date_from" value="{{ $filterDateFrom }}" class="filter-input">
        </div>

        <div>
            <label class="filter-label">Data do</label>
            <input type="date" name="date_to" value="{{ $filterDateTo }}" class="filter-input">
        </div>

        <div>
            <label class="filter-label">Typ</label>
            <select name="type" class="filter-select">
                <option value="">Wszystkie</option>
                <option value="purchase" {{ $filterType === 'purchase' ? 'selected' : '' }}>Zakup</option>
                <option value="manual" {{ $filterType === 'manual' ? 'selected' : '' }}>Manual</option>
                <option value="correction" {{ $filterType === 'correction' ? 'selected' : '' }}>Korekta</option>
            </select>
        </div>

        <button class="btn-primary">🔍 Szukaj</button>
    </form>

    {{-- WYKRES --}}
    <div class="chart-card">
        <div class="section-title">📈 Aktywność transakcji</div>

        @if($chartData->count())
            <canvas id="transactionsChart" height="120"></canvas>
        @else
            <p style="color:#6b7280;font-size:14px;">
                Brak danych do wykresu.
            </p>
        @endif
    </div>

    {{-- TIMELINE --}}
    <div class="chart-card">
        <div class="section-title">⏱ Ostatnie transakcje</div>

        @forelse($transactions->take(6) as $tx)
            <div style="font-size:14px;margin-bottom:6px;">
                {{ optional($tx->client)->phone ?? 'Klient' }}
                — <strong>+{{ $tx->points }} pkt</strong>
                <span style="color:#777;font-size:12px;">
                    {{ $tx->created_at->format('Y-m-d H:i') }}
                </span>
            </div>
        @empty
            <p style="color:#777;">Brak transakcji.</p>
        @endforelse
    </div>

    {{-- TABELA --}}
    <div class="chart-card">
        @if($transactions->count())
            <table class="history-table" style="width:100%;">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Telefon</th>
                        <th>Kwota</th>
                        <th>Punkty</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($transactions as $tx)
                    <tr>
                        <td>{{ $tx->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ optional($tx->client)->phone ?? '—' }}</td>
                        <td>{{ number_format($tx->amount, 2, '.', ' ') }} zł</td>
                        <td>+{{ $tx->points }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div style="margin-top:15px;">
                {{ $transactions->links() }}
            </div>
        @else
            <p>Brak transakcji.</p>
        @endif
    </div>

</div>

{{-- WYKRES JS --}}
@if($chartData->count())
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('transactionsChart').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chartData->pluck('label')),
        datasets: [{
            label: 'Punkty dziennie',
            data: @json($chartData->pluck('value')),
            borderColor: '#4a3aff',
            backgroundColor: 'rgba(74,58,255,0.15)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endif

@endsection
