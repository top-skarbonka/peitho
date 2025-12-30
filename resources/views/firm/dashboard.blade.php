@extends('firm.layout.app')

@section('content')
<div class="space-y-8">

    {{-- HEADER --}}
    <div>
        <h1 class="text-3xl font-bold text-slate-800 flex items-center gap-2">
            📊 Statystyki programu lojalnościowego
        </h1>
        <p class="text-slate-500 mt-1">
            Podgląd kondycji programu: klienci, punkty, aktywność.
        </p>
    </div>

    {{-- KPI --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl p-6 shadow">
            <p class="text-slate-500 text-sm">Klienci</p>
            <p class="text-3xl font-bold">{{ $totalClients }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow">
            <p class="text-slate-500 text-sm">Transakcje</p>
            <p class="text-3xl font-bold">{{ $totalTransactions }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow">
            <p class="text-slate-500 text-sm">Suma punktów</p>
            <p class="text-3xl font-bold">{{ number_format($totalPoints,0,' ',' ') }}</p>
        </div>

        <div class="bg-white rounded-xl p-6 shadow">
            <p class="text-slate-500 text-sm">Średnio / transakcję</p>
            <p class="text-3xl font-bold">{{ number_format($avgPoints,2,',',' ') }}</p>
        </div>
    </div>

    {{-- INFO --}}
    <div class="bg-white rounded-xl p-6 shadow">
        <p class="text-slate-600">
            🔥 Najaktywniejszy dzień:
            <strong>{{ $bestDay ?? 'Brak danych' }}</strong>
        </p>
    </div>

    {{-- WYKRESY --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 shadow">
            <h3 class="font-semibold mb-4">📆 Aktywność dzienna</h3>
            <canvas id="dailyChart"></canvas>
        </div>

        <div class="bg-white rounded-xl p-6 shadow">
            <h3 class="font-semibold mb-4">📅 Aktywność miesięczna</h3>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

</div>

{{-- CHARTS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const dailyCtx = document.getElementById('dailyChart');
new Chart(dailyCtx, {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Punkty',
            data: @json($chartValues),
            borderWidth: 3,
            tension: 0.4
        }]
    }
});

const monthlyCtx = document.getElementById('monthlyChart');
new Chart(monthlyCtx, {
    type: 'bar',
    data: {
        labels: @json($monthlyLabels),
        datasets: [{
            label: 'Punkty',
            data: @json($monthlyValues)
        }]
    }
});
</script>
@endsection
