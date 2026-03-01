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

    {{-- 🔥 BADGE BRAMKA ONLINE --}}
    <div class="bg-white rounded-xl p-6 shadow">
        @if(isset($entryLogs) && $entryLogs->count())
            @php
                $lastEntry = $entryLogs->first();
                $lastTime = \Carbon\Carbon::parse($lastEntry->created_at);
                $minutesAgo = $lastTime->diffInMinutes(now());
            @endphp

            @if($minutesAgo <= 10)
                <div class="flex items-center gap-3">
                    <span class="text-green-600 text-xl">🟢</span>
                    <div>
                        <p class="font-semibold text-slate-800">Bramka online</p>
                        <p class="text-slate-500 text-sm">
                            Ostatnie wejście: {{ $lastTime->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-3">
                    <span class="text-yellow-500 text-xl">🟡</span>
                    <div>
                        <p class="font-semibold text-slate-800">Bramka nieaktywna</p>
                        <p class="text-slate-500 text-sm">
                            Ostatnie wejście: {{ $lastTime->diffForHumans() }}
                        </p>
                    </div>
                </div>
            @endif
        @else
            <div class="flex items-center gap-3">
                <span class="text-red-500 text-xl">🔴</span>
                <div>
                    <p class="font-semibold text-slate-800">Brak aktywności</p>
                    <p class="text-slate-500 text-sm">
                        System nie zarejestrował jeszcze wejść.
                    </p>
                </div>
            </div>
        @endif
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
            <p class="text-3xl font-bold">{{ number_format($avgPoints, 2, ',', ' ') }}</p>
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

    {{-- NOWA SEKCJA: HISTORIA WEJŚĆ --}}
    <div class="bg-white rounded-xl p-6 shadow">
        <h3 class="font-semibold mb-4">🚪 Ostatnie wejścia z bramki</h3>

        @if(isset($entryLogs) && $entryLogs->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500 border-b">
                        <tr>
                            <th class="py-2">Telefon</th>
                            <th>Status</th>
                            <th>Pozostało</th>
                            <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entryLogs as $log)
                            <tr class="border-b">
                                <td class="py-2">{{ $log->phone }}</td>
                                <td>
                                    @if($log->status === 'success')
                                        <span class="text-green-600 font-semibold">Poprawne</span>
                                    @elseif($log->status === 'no_pass')
                                        <span class="text-red-600 font-semibold">Brak karnetu</span>
                                    @elseif($log->status === 'finished')
                                        <span class="text-orange-600 font-semibold">Wyczerpany</span>
                                    @else
                                        <span class="text-slate-600">{{ $log->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $log->remaining_after ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d.m.Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-slate-500">Brak wejść zarejestrowanych w systemie.</p>
        @endif
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
