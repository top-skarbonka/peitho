@extends('admin.layout.app')
@section('title', 'Aktywność firmy')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-800">
            📊 Aktywność firmy: {{ $firm->name }}
        </h1>
        <p class="text-slate-500 text-sm mt-1">
            Podgląd aktywności programu lojalnościowego w bieżącym miesiącu
        </p>
    </div>

    {{-- KPI --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-xl p-4 shadow">
            <p class="text-xs text-slate-500">Klienci</p>
            <p class="text-2xl font-bold text-slate-800">
                {{ $clientsCount }}
            </p>
        </div>

        <div class="bg-white rounded-xl p-4 shadow">
            <p class="text-xs text-slate-500">Karty</p>
            <p class="text-2xl font-bold text-slate-800">
                {{ $cardsCount }}
            </p>
        </div>

        <div class="bg-white rounded-xl p-4 shadow">
            <p class="text-xs text-slate-500">Naklejki (łącznie)</p>
            <p class="text-2xl font-bold text-slate-800">
                {{ $totalStamps }}
            </p>
        </div>

        <div class="bg-white rounded-xl p-4 shadow">
            <p class="text-xs text-slate-500">Naklejki (miesiąc)</p>
            <p class="text-2xl font-bold text-slate-800">
                {{ $monthStamps }}
            </p>
        </div>

    </div>

    {{-- WYKRES --}}
    <div class="bg-white rounded-xl p-6 shadow">
        <h3 class="font-semibold mb-4">📅 Aktywność dzienna (ten miesiąc)</h3>
        <canvas id="activityChart"></canvas>
    </div>

</div>

{{-- CHART --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('activityChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($stampsByDay->pluck('day')),
        datasets: [{
            label: 'Naklejki',
            data: @json($stampsByDay->pluck('total')),
            borderWidth: 3,
            tension: 0.4
        }]
    }
});
</script>
@endsection
