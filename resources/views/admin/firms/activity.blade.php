@extends('layouts.public')

@section('content')
<div style="max-width:1000px;margin:60px auto;padding:40px;background:#fff;border-radius:20px">

    {{-- ================= HEADER ================= --}}
    <h1 style="font-size:28px;margin-bottom:10px">🕒 Aktywność firmy</h1>

    <p><strong>Nazwa:</strong> {{ $firm->name }}</p>
    <p><strong>Slug:</strong> {{ $firm->slug }}</p>

    <hr style="margin:25px 0">

    {{-- ================= STATUS ================= --}}
    <div style="background:#f8fafc;padding:20px;border-radius:14px;margin-bottom:20px">
        <h3>📊 Status aktywności</h3>

        <p>
            <strong>Status:</strong>
            <span style="color:green;font-weight:700">AKTYWNA</span>
        </p>

        <p>
            <strong>Ostatnia aktywność:</strong>
            {{ optional($firm->last_activity_at)->format('d.m.Y H:i') ?? 'brak' }}
        </p>
    </div>

    {{-- ================= NAKLEJKI 30 DNI ================= --}}
    <div style="background:#f8fafc;padding:20px;border-radius:14px;margin-bottom:20px">
        <h3>🏷️ Naklejki (ostatnie 30 dni)</h3>

        @php
            $total30 = isset($stamps) ? $stamps->sum('actions') : 0;
        @endphp

        <p><strong>Łącznie:</strong> {{ $total30 }}</p>

        @if($total30 === 0)
            <p style="color:#666">Brak aktywności w ostatnich 30 dniach.</p>
        @endif
    </div>

    {{-- ================= WYKRES ================= --}}
    @php
        $labels = $chartLabels ?? [];
        $values = $chartValues ?? [];
    @endphp

    <div style="background:#fff;padding:20px;border-radius:14px;margin-top:30px">
        <h3>📈 Aktywność dzienna (ostatnie 30 dni)</h3>

        @if(count($labels) === 0)
            <p style="color:#666;margin-top:10px">Brak danych do wyświetlenia wykresu.</p>
        @else
            <canvas id="stampsChart" height="120"></canvas>
        @endif
    </div>

    <a href="{{ route('admin.firms.index') }}"
       style="
            display:inline-block;
            margin-top:30px;
            padding:12px 20px;
            border-radius:12px;
            background:#111827;
            color:#fff;
            font-weight:700;
            text-decoration:none;
       ">
        ← Wróć do listy firm
    </a>
</div>

{{-- ================= CHART.JS ================= --}}
@if(count($labels) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('stampsChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($labels) !!},
        datasets: [{
            data: {!! json_encode($values) !!},
            backgroundColor: '#6366f1',
            borderRadius: 6
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 } }
        }
    }
});
</script>
@endif
@endsection
