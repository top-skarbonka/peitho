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

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">Klienci</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalClients ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">Transakcje</p>
            <p class="text-3xl font-bold text-indigo-600">{{ $totalTransactions ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">Suma punktów</p>
            <p class="text-3xl font-bold text-indigo-600">{{ number_format($totalPoints ?? 0, 2, ',', ' ') }}</p>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <p class="text-slate-500 text-sm">Średnio / transakcję</p>
            <p class="text-3xl font-bold text-indigo-600">{{ number_format($avgPoints ?? 0, 2, ',', ' ') }}</p>
        </div>

    </div>

    {{-- 🔥 KAFELKI --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-sm text-slate-500">🟢 Nowi klienci</p>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $newClients ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-sm text-slate-500">🔁 Powracający</p>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $returningClients ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-sm text-slate-500">💰 Transakcje nowych</p>
            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $newTransactions ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow">
            <p class="text-sm text-slate-500">💰 Transakcje powracających</p>
            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $returningTransactions ?? 0 }}</p>
        </div>

    </div>

    {{-- PUSH PREMIUM --}}
    @if($firm && $firm->push_enabled)
        <div class="bg-white rounded-2xl p-6 shadow border border-indigo-100">
            <h2 class="text-xl font-bold mb-2">📢 Push premium</h2>
            <p class="text-slate-600">
                Funkcja powiadomień push jest aktywna dla Twojej firmy.
            </p>
            <p class="text-sm text-slate-500 mt-2">
                W kolejnym kroku pojawi się tutaj panel do zarządzania powiadomieniami push.
            </p>
        </div>
    @endif

    {{-- WYKRESY --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl p-6 shadow">
            <h2 class="text-lg font-bold mb-4">📈 Nowi klienci</h2>
            <div style="height:300px;">
                <canvas id="clientsChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 shadow">
            <h2 class="text-lg font-bold mb-4">📊 Punkty</h2>
            <div style="height:300px;">
                <canvas id="pointsChart"></canvas>
            </div>
        </div>

    </div>

    {{-- WYSZUKIWARKA --}}
    <div class="bg-white rounded-2xl p-6 shadow">
        <h2 class="text-xl font-bold mb-4">🔍 Sprawdź klienta</h2>

        <div class="flex gap-3">
            <input
                type="text"
                id="searchPhone"
                placeholder="Wpisz numer telefonu..."
                class="border p-3 rounded-xl w-full max-w-md"
            >

            <button
                onclick="searchClient()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl">
                Sprawdź
            </button>
        </div>
    </div>

    {{-- HISTORIA --}}
    <div id="clientHistoryBox" class="bg-white rounded-2xl p-6 shadow hidden">
        <h2 class="text-xl font-bold mb-4">📱 Historia klienta</h2>
        <div id="clientHistoryContent"></div>
    </div>

    {{-- LOGI --}}
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
                    <td class="py-2">
                        {{ substr($log->phone,0,3) . '***' . substr($log->phone,-3) }}
                    </td>

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
    },
    options: { responsive: true, maintainAspectRatio: false }
});

new Chart(document.getElementById('pointsChart'), {
    type: 'bar',
    data: {
        labels: pointsData.map(i => i.date),
        datasets: [{
            label: 'Punkty',
            data: pointsData.map(i => i.total)
        }]
    },
    options: { responsive: true, maintainAspectRatio: false }
});

function searchClient() {
    const phone = document.getElementById('searchPhone').value;
    loadClientHistory(phone);
}

/* 🔥 JEDYNA DODANA CZĘŚĆ */
function loadClientHistory(phone) {

    if (!phone) {
        alert('Wpisz numer telefonu');
        return;
    }

    fetch('/company/api/client-history?phone=' + phone)
        .then(res => res.json())
        .then(logs => {

            let html = `<h3 class="mb-4">Klient: ${phone}</h3>`;

            if (!logs.length) {
                html += `<p>Brak historii dla tego klienta</p>`;
            } else {

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
            }

            document.getElementById('clientHistoryBox').classList.remove('hidden');
            document.getElementById('clientHistoryContent').innerHTML = html;

        })
        .catch(() => {
            alert('Błąd pobierania danych');
        });
}
</script>

@endsection
