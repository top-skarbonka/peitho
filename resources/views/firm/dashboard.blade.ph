@extends('firm.layout.app')

@section('content')

<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: #fff;
        padding: 25px;
        border-radius: 18px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        text-align: center;
    }

    .stat-card h3 {
        font-size: 16px;
        color: #666;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .stat-card .value {
        font-size: 32px;
        font-weight: 700;
        color: #2b35d1;
    }

    canvas {
        max-width: 100%;
        margin-top: 30px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
    }

    table th, table td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    table th {
        background: #f4f6ff;
        font-weight: 600;
    }
</style>

<div class="card">

    <h1 style="font-size:30px; margin-bottom:25px; text-align:center;">
        📊 Statystyki programu lojalnościowego
    </h1>

    {{-- KARTY STATYSTYK --}}
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Łączna liczba klientów</h3>
            <div class="value">{{ $totalClients }}</div>
        </div>

        <div class="stat-card">
            <h3>Wszystkie transakcje</h3>
            <div class="value">{{ $totalTransactions }}</div>
        </div>

        <div class="stat-card">
            <h3>Suma punktów</h3>
            <div class="value">{{ $totalPoints }}</div>
        </div>

        <div class="stat-card">
            <h3>Średnio punktów / transakcję</h3>
            <div class="value">{{ $avgPoints }}</div>
        </div>

        <div class="stat-card">
            <h3>Najaktywniejszy dzień</h3>
            <div class="value">{{ $bestDay ?? '–' }}</div>
        </div>
    </div>

    {{-- WYKRES 1: Ostatnie 60 dni --}}
    <h2 style="margin-top:40px; font-size:22px;">📈 Ostatnie 60 dni — suma punktów</h2>
    <canvas id="pointsChart"></canvas>

    {{-- WYKRES 2: Punkty / miesiąc --}}
    <h2 style="margin-top:40px; font-size:22px;">📅 Wykres miesięczny — punkty / miesiąc</h2>
    <canvas id="monthlyChart"></canvas>

    {{-- TOP KLIENCI --}}
    <h2 style="margin-top:40px; font-size:22px;">🏅 TOP klienci</h2>

    <table>
        <tr>
            <th>#</th>
            <th>Numer telefonu</th>
            <th>Suma punktów</th>
        </tr>

        @foreach($topClients as $i => $client)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->points }}</td>
            </tr>
        @endforeach
    </table>

</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // WYKRES DZIENNY (ostatnie 60 dni)
    const chartLabels  = {!! json_encode($chartLabels) !!};
    const chartValues  = {!! json_encode($chartValues) !!};

    new Chart(document.getElementById('pointsChart'), {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Punkty na dzień',
                data: chartValues,
                borderWidth: 3,
                borderColor: '#4a3aff',
                backgroundColor: 'rgba(74,58,255,0.15)',
                tension: 0.3,
                fill: true
            }]
        }
    });

    // WYKRES MIESIĘCZNY
    const monthlyLabels = {!! json_encode($monthlyLabels) !!};
    const monthlyValues = {!! json_encode($monthlyValues) !!};

    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Punkty / miesiąc',
                data: monthlyValues,
                backgroundColor: 'rgba(54,162,235,0.4)',
                borderColor: '#3080f0',
                borderWidth: 2
            }]
        }
    });
</script>

@endsection
