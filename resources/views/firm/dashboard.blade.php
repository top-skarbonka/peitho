@extends('layouts.firm')

@section('content')

@php
    $firm = auth()->guard('company')->user();
@endphp

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-2xl shadow-lg">
        <h1 class="text-3xl font-bold flex items-center gap-2">
            📊 Statystyki programu lojalnościowego
        </h1>
        <p class="opacity-90 mt-1">
            Podgląd kondycji programu: klienci, punkty, aktywność.
        </p>
    </div>

    {{-- KPI --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
            <p class="text-slate-500 text-sm">Klienci</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalClients ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
            <p class="text-slate-500 text-sm">Transakcje</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalTransactions ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
            <p class="text-slate-500 text-sm">Suma punktów</p>
            <p class="text-3xl font-bold text-indigo-600">{{ number_format($totalPoints ?? 0, 2, ',', ' ') }}</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
            <p class="text-slate-500 text-sm">Średnio / transakcję</p>
            <p class="text-3xl font-bold text-indigo-600">{{ number_format($avgPoints ?? 0, 2, ',', ' ') }}</p>
        </div>

    </div>

    {{-- 🔥 NOWE — TREND 7 DNI --}}
    <div class="bg-white rounded-2xl p-6 shadow hover:shadow-lg transition">
        <p class="text-slate-500 text-sm">Trend 7 dni</p>

        <p class="text-3xl font-bold {{ ($trend ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
            {{ ($trend ?? 0) >= 0 ? '+' : '' }}{{ number_format($trend ?? 0, 1, ',', ' ') }}%
        </p>

        <p class="text-sm text-slate-500 mt-1">
            {{ number_format($currentPoints ?? 0, 0, ',', ' ') }} pkt vs {{ number_format($previousPoints ?? 0, 0, ',', ' ') }} pkt
        </p>
    </div>

    {{-- 🔥 WYKRESY --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl p-6 shadow">
            <h2 class="text-lg font-bold mb-4">📈 Nowi klienci</h2>
            <canvas id="clientsChart"></canvas>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <h2 class="text-lg font-bold mb-4">📊 Punkty</h2>
            <canvas id="pointsChart"></canvas>
        </div>

    </div>

    {{-- 🔥 RANKING TOP KLIENTÓW --}}
    @php
        $topClients = \Illuminate\Support\Facades\DB::table('client_points as cp')
            ->join('clients as c', 'c.id', '=', 'cp.client_id')
            ->where('cp.firm_id', $firm->id)
            ->orderByDesc('cp.points')
            ->limit(5)
            ->get(['c.phone', 'cp.points']);
    @endphp

    <div class="bg-white rounded-2xl p-6 shadow">
        <h2 class="text-xl font-bold mb-4">🏆 TOP klienci</h2>

        <div class="space-y-2">
            @foreach($topClients as $index => $c)
                <div class="flex justify-between bg-gradient-to-r from-slate-50 to-indigo-50 p-3 rounded-xl">
                    <span>#{{ $index+1 }} — {{ $c->phone }}</span>
                    <span class="font-bold text-indigo-600">{{ $c->points }} pkt</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- 🔍 FILTR --}}
    <div class="bg-white rounded-2xl p-6 shadow">
        <h2 class="text-xl font-bold mb-4">🔍 Szukaj klienta</h2>

        <input
            type="text"
            id="searchPhone"
            placeholder="Wpisz numer telefonu..."
            onkeyup="filterClients()"
            class="border p-3 rounded-xl w-full max-w-md focus:ring-2 focus:ring-indigo-400 outline-none"
        >
    </div>

    {{-- 🔥 LISTA KLIENTÓW --}}
    @php
        $clients = \Illuminate\Support\Facades\DB::table('client_point_logs as l')
            ->join('clients as c', 'c.id', '=', 'l.client_id')
            ->where('l.firm_id', $firm->id)
            ->select('c.phone')
            ->distinct()
            ->orderBy('c.phone')
            ->get();
    @endphp

    <div class="bg-white rounded-2xl p-6 shadow">
        <h2 class="text-xl font-bold mb-4">👥 Klienci</h2>

        <div id="clientsList" class="flex flex-wrap gap-2">
            @foreach($clients as $c)
                <button 
                    data-phone="{{ $c->phone }}"
                    onclick="loadClientHistory('{{ $c->phone }}')"
                    class="client-btn px-4 py-2 bg-slate-100 hover:bg-indigo-500 hover:text-white transition rounded-xl">
                    {{ $c->phone }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- 🔥 HISTORIA WYBRANEGO KLIENTA --}}
    <div id="clientHistoryBox" class="bg-white rounded-2xl p-6 shadow hidden">
        <h2 class="text-xl font-bold mb-4">📱 Historia klienta</h2>

        <div id="clientHistoryContent"></div>
    </div>

    {{-- 🔥 OGÓLNA HISTORIA --}}
    @php
        $logs = \Illuminate\Support\Facades\DB::table('client_point_logs as l')
            ->join('clients as c', 'c.id', '=', 'l.client_id')
            ->where('l.firm_id', $firm->id)
            ->orderByDesc('l.created_at')
            ->limit(20)
            ->get([
                'c.phone',
                'l.points',
                'l.amount',
                'l.created_at'
            ]);
    @endphp

    <div class="bg-white rounded-2xl p-6 shadow">
        <h2 class="text-xl font-bold mb-4">📜 Ostatnie operacje</h2>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-slate-500 border-b">
                    <th class="py-2">Telefon</th>
                    <th class="py-2">Punkty</th>
                    <th class="py-2">Kwota</th>
                    <th class="py-2">Data</th>
                </tr>
            </thead>
            <tbody>

            @foreach($logs as $log)
                <tr class="border-b hover:bg-slate-50">
                    <td class="py-2">{{ $log->phone }}</td>

                    <td class="py-2 font-semibold {{ $log->points > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $log->points > 0 ? '+' : '' }}{{ $log->points }}
                    </td>

                    <td class="py-2">
                        {{ $log->amount ? $log->amount . ' zł' : '-' }}
                    </td>

                    <td class="py-2 text-slate-500">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('d.m.Y H:i') }}
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const clientsData = @json($clientsPerDay ?? []);
const pointsData = @json($pointsPerDay ?? []);

new Chart(document.getElementById('clientsChart'), {
    type: 'line',
    data: {
        labels: clientsData.map(i => i.date),
        datasets: [{
            label: 'Klienci',
            data: clientsData.map(i => i.count)
        }]
    }
});

new Chart(document.getElementById('pointsChart'), {
    type: 'bar',
    data: {
        labels: pointsData.map(i => i.date),
        datasets: [{
            label: 'Punkty',
            data: pointsData.map(i => i.total)
        }]
    }
});
</script>

{{-- JS zostaje --}}
<script>
function loadClientHistory(phone) {
    fetch('/api/client-points?phone=' + phone)
        .then(res => res.json())
        .then(data => {

            let html = `<h3 class="mb-4">Klient: ${phone}</h3>`;

            fetch('/company/api/client-history?phone=' + phone)
                .then(res => res.json())
                .then(logs => {

                    html += '<table class="w-full text-sm">';
                    html += `
                        <tr class="text-left border-b">
                            <th>Punkty</th>
                            <th>Kwota</th>
                            <th>Data</th>
                        </tr>
                    `;

                    logs.forEach(l => {
                        html += `
                        <tr class="border-b">
                            <td class="${l.points > 0 ? 'text-green-600' : 'text-red-600'}">
                                ${l.points > 0 ? '+' : ''}${l.points}
                            </td>
                            <td>${l.amount ? l.amount + ' zł' : '-'}</td>
                            <td>${l.created_at}</td>
                        </tr>
                        `;
                    });

                    html += '</table>';

                    document.getElementById('clientHistoryBox').classList.remove('hidden');
                    document.getElementById('clientHistoryContent').innerHTML = html;

                });

        });
}

function filterClients() {
    const input = document.getElementById('searchPhone').value;

    document.querySelectorAll('.client-btn').forEach(btn => {
        const phone = btn.dataset.phone;

        if (phone.includes(input)) {
            btn.style.display = 'inline-block';
        } else {
            btn.style.display = 'none';
        }
    });
}
</script>

@endsection
